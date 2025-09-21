**Introduction**

This document provides a comprehensive, evidence‑backed security audit for SSP Web (Laravel/PHP 8.x + MySQL + Sanctum + Jetstream/Fortify + Livewire). Scope analyzed: `app/**`, `routes/**`, `resources/views/**`, `config/**`, `public/**`, `database/**`, `.env*`, `composer.*`.

Strengths and current posture
- Uses Fortify/Jetstream for auth, email verification, password rules, and optional 2FA.
- Eloquent/Query Builder parameter binding; no concatenated SQL with user input found.
- RBAC enforced via custom `role` middleware, route groups, and Policies (Product/Order) with Gate::before for admins.
- Core web protections implemented: CSRF, HTTPS enforcement, security headers, CSP (Report‑Only), secure sessions & cookies.
- Input validation across controllers; storage outside webroot for private files; sessions in DB.
- Logging of unauthorized access attempts.
 - Server-side HTML sanitization for rich text (terms/policy) via `App\Support\Sanitizer`.



**2.1. SQL injections**

Summary: No user input concatenated into SQL was found. Eloquent and Query Builder are used with parameter binding; limited `whereRaw` usage properly binds values.

Evidence (safe patterns)
- Bound raw LIKE in Livewire search: `app/Livewire/Products/Index.php:L42-L50`
```
$query = Product::query()
    ->when($this->search, function ($q, $term) {
        $q->where(function ($w) use ($term) {
            $w->whereRaw('LOWER(name) like ?', [$term])
              ->orWhereRaw('LOWER(sku) like ?', [$term]);
        });
    });
```
- Controller search with values bound (wildcards assembled in PHP): `app/Http/Controllers/ProductController.php:L12-L21`
```
if ($search = $request->query('q')) {
    $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('sku', 'like', "%{$search}%");
    });
}
```
- Static DDL in migration (no user input): `database/migrations/2025_09_05_100100_alter_products_user_nullable.php:L17-L19`
```
DB::statement('ALTER TABLE products MODIFY user_id BIGINT UNSIGNED NULL');
```

Guidance
```
- $users = DB::select("SELECT * FROM users WHERE email = '$email'");
+ $users = DB::select('SELECT * FROM users WHERE email = ?', [$email]);
```


**2.2. Unsolicited Logins**

Finding 1: CSRF protection (fixed)
- Evidence: `app/Http/Kernel.php:L26-L33`
```
'web' => [
    \Illuminate\Cookie\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

Finding 2: Session fixation at API login (fixed)
- Evidence: `app/Http/Controllers/Api/AuthController.php:L20-L31`
```
if (!Auth::attempt($credentials)) {
    return response()->json(['message' => 'Invalid credentials'], 401);
}
$request->session()->regenerate();
```

Finding 3: Brute‑force on API login (fixed)
- Evidence: `routes/api.php:L28-L29`
```
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
```


**Additional Security Measures Implemented**

**3.1. CSRF Protection**

- Middleware active in `web` group (see V‑001 evidence).
- Forms include tokens (example admin product edit): `resources/views/admin/products/edit.blade.php:L19-L26`
```
<form ... method="POST" ...>
    @csrf
    @method('PUT')
    ...
</form>
```
- Livewire forms (framework‑managed): `resources/views/livewire/checkout/form.blade.php:L1-L5`
```
<form wire:submit.prevent="placeOrder" class="...">
    ...
</form>
```

**3.2. Authorization and role-based access**

- Roles and helpers: `app/Models/User.php:L33-L49`
```
public function isAdmin() { return $this->role === 'admin'; }
public function isSeller() { return $this->role === 'seller'; }
```
- Policies (new):
  - Product: `app/Policies/ProductPolicy.php` (owner‑or‑admin for update/delete; published visibility for view)
  - Order: `app/Policies/OrderPolicy.php` (buyer/seller‑with‑items/admin can view)
- Provider and Gate: `app/Providers/AuthServiceProvider.php:L1-L29`
```
protected $policies = [ Product::class => ProductPolicy::class, Order::class => OrderPolicy::class ];
Gate::before(fn($user, $ability) => $user->isAdmin() ? true : null);
```
- Controllers now enforce policies:
  - Seller products: `app/Http/Controllers/Seller/ProductController.php` uses `$this->authorize('update'|'delete', $product)`
  - Orders (buyer): `app/Http/Controllers/OrderController.php` uses `$this->authorize('view', $order)`
  - Orders (seller): `app/Http/Controllers/Seller/OrderController.php` uses `$this->authorize('view', $order)`
- Providers registered: `bootstrap/app.php:L24-L28`
```
->withProviders([
    \App\Providers\FortifyServiceProvider::class,
    \App\Providers\AuthServiceProvider::class,
])
```
- Unauthorized access logging (middleware): `app/Http/Middleware/RoleMiddleware.php:L6-L8,L23-L41`
```
Log::warning('Authorization denied by RoleMiddleware', [...]);
Log::warning('Banned user access blocked', [...]);
```

**3.3. Validation and output encoding**

- Server-side HTML sanitization for limited rich text:
  - `app/Support/Sanitizer.php:L1-L50`
```
class Sanitizer {
    public static function clean(?string $html): string {
        $allowedTags = '<p><br><ul><ol><li><strong><em><b><i><u><blockquote><pre><code><h1><h2><h3><h4><a>';
        $stripped = strip_tags($html, $allowedTags);
        $noEvents = preg_replace('/\s*on[a-zA-Z]+\s*=\s*"[^"]*"/i', '', $stripped);
        $noStyle  = preg_replace('/\s*style\s*=\s*"[^"]*"/i', '', $noEvents);
        $noJsHref = preg_replace('/(href|src)\s*=\s*"\s*javascript:[^"]*"/i', '$1="#"', $noStyle);
        $noData   = preg_replace('/(href|src)\s*=\s*"\s*data:[^"]*"/i', '$1="#"', $noJsHref);
        return $noData ?? '';
    }
}
```
- Applied in views (replacing raw `{!! !!}` with sanitized output):
  - `resources/views/terms.blade.php:L9-L12`
```
{!! \App\Support\Sanitizer::clean($terms) !!}
```
  - `resources/views/policy.blade.php:L9-L12`
```
{!! \App\Support\Sanitizer::clean($policy) !!}
```

Further platform hardening
- HTTPS & secure cookies: `app/Providers/AppServiceProvider.php:L17-L27` forces HTTPS in prod; sets secure cookies / SameSite from config.
- Security headers & CSP (Report‑Only): `app/Http/Middleware/SecurityHeaders.php:L16-L40` adds X‑Frame‑Options, X‑Content‑Type‑Options, Referrer‑Policy, Permissions‑Policy, and a conservative CSP‑RO suitable for current assets.


**Conclusion**

Risk posture: Improved to Low‑Medium after implementing CSRF, session fixation mitigation, login throttling, HTTPS + headers + CSP (RO), Policies with controller enforcement, and unauthorized access logging. SQLi risk is low due to parameter binding and validation.

Top 3 priorities
- If terms/policy content becomes user‑managed, add server‑side HTML sanitization or switch to escaped rendering.
- Transition CSP from Report‑Only to Enforced once inline assets are addressed.
- Expand policy coverage as needed and add structured audit logs for admin‑level actions.

Two‑week plan
- Days 1–3: Monitor CSP reports; reduce inline assets; prepare enforced CSP.
- Days 4–7: Add HTML sanitization for any rich‑text inputs; add tests for policy coverage.
- Days 8–14: Enhance admin action audit logs; verify headers in prod; targeted auth/CSRF pentests.


Appendix

```mermaid
sequenceDiagram
    participant C as Client
    participant M as Middleware (web)
    participant F as Fortify Routes
    participant G as Guard (web)
    participant S as Session/Cookie

    C->>M: POST /login (credentials, CSRF token)
    M->>F: Pass request (CSRF validated)
    F->>G: Auth::attempt(credentials)
    G-->>F: Authenticated (user)
    F->>S: session()->regenerate(); set cookie
    F-->>C: 302 redirect (role‑based)
```

Pre‑deploy hardening checklist
- APP_ENV=production; APP_DEBUG=false
- SESSION_SECURE_COOKIE=true; SESSION_SAME_SITE=lax/strict; HttpOnly enabled
- Force HTTPS at edge/app; enable HSTS (server)
- CSRF middleware enabled; minimal exceptions
- Rate limiting on auth/sensitive routes
- DB least‑privilege; periodic credential rotation
- Secrets managed securely in deployment (env/secrets manager)
- Backups configured/tested; monitoring and alerting enabled
- CSP enforced (post‑Report‑Only), standard security headers present

OWASP ASVS references
- V2 Authentication: Fortify/Jetstream, email verification, 2FA (enabled); session regeneration on login (implemented)
- V3 Session Management: Secure cookies, SameSite, HTTPS, CSRF (implemented)
- V5 Validation/Encoding: Validation throughout controllers; sanitize rich text via server-side Sanitizer (implemented)
- V7 Error Handling & Logging: Debug off in prod; logs for unauthorized access (implemented)
- V14 Configuration: HTTPS enforcement; security headers; CSP (Report‑Only) (implemented)


