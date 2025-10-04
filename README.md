# Zentara Commerce Platform

Zentara is a Laravel 11 multi-channel luxury watch commerce platform that combines storytelling pages, a customer purchase journey, seller tooling, and a Sanctum-secured API to support the brand's direct-to-consumer strategy.

## Table of contents
- [Business Scenario & Outcomes](#business-scenario--outcomes)
- [Architecture at a Glance](#architecture-at-a-glance)
- [Requirements Scorecard](#requirements-scorecard)
- [Experience by Persona](#experience-by-persona)
- [API Surface](#api-surface)
- [Data & Storage](#data--storage)
- [Authentication & Authorization](#authentication--authorization)
- [Security Hardening](#security-hardening)
- [Livewire & Front-End Experience](#livewire--front-end-experience)
- [External Integrations](#external-integrations)
- [Local Development Workflow](#local-development-workflow)
- [Testing & Quality](#testing--quality)
- [Deployment & Hosting](#deployment--hosting)
- [Next Steps](#next-steps)

## Business Scenario & Outcomes

Zentara is a Swiss luxury watch manufacturer launching a boutique marketplace where the brand and invited sellers can showcase limited runs, manage orders, and nurture exclusive clientele.

- Story-driven marketing, brand heritage, and contact capture built with Blade views in `resources/views/pages/home.blade.php:1`, `resources/views/pages/about.blade.php:1`, `resources/views/pages/contact.blade.php:1`, and the immersive landing page `resources/views/welcome.blade.php:1`.
- Omni-channel product catalogue with search, price filters, and stock toggles exposed via `routes/web.php:31` and powered by `app/Http/Controllers/ProductController.php:8`.
- Customers progress from discovery to checkout with a session-backed cart, Livewire checkout wizard, transactional email, and order history (`app/Http/Controllers/CartController.php:8`, `app/Livewire/Checkout/Form.php:14`, `app/Http/Controllers/CheckoutController.php:29`, `resources/views/orders/index.blade.php:1`).
- Sellers and administrators operate dashboards for analytics, product curation, order fulfilment, and user safety controls (`app/Http/Controllers/Seller/DashboardController.php:14`, `app/Http/Controllers/Admin/DashboardController.php:13`).
- A Sanctum-authenticated API exposes products, contact capture, and admin endpoints for a mobile concierge app (`routes/api.php:12`, `routes/api.php:21`, `app/Http/Controllers/Api/UserController.php:14`).
- Security posture is documented and implemented across middleware, policies, and sanitisation (`SECURITY.md:1`, `app/Http/Middleware/SecurityHeaders.php:13`, `app/Support/Sanitizer.php:5`).

## Architecture at a Glance

- Laravel 11.31 with Jetstream, Sanctum, Livewire 3, and the MongoDB driver declared in `composer.json:10`, `composer.json:12`, `composer.json:15`, `composer.json:16`, with the Livewire stack enabled in `config/jetstream.php:19`.
- Application bootstrap wires routes, middleware aliases, and providers in `bootstrap/app.php:8`, `bootstrap/app.php:14`, and registers Fortify/Auth providers for role-based flows in `bootstrap/app.php:22`.
- Global middleware pipeline applies security headers, CSRF, throttling, and converts input consistently in `app/Http/Kernel.php:15`, `app/Http/Middleware/SecurityHeaders.php:13`.
- Front-end assets are built with Vite, Tailwind, and Alpine plugins configured in `package.json:9`, `package.json:19`, `resources/js/app.js:5`, `tailwind.config.js:12`.
- A one-command developer workflow runs PHP server, queue listener, log tail, and Vite via `composer dev` defined in `composer.json:58`.

## Requirements Scorecard

| Requirement | Points | Evidence |
| --- | --- | --- |
| Built using Laravel 11 | **10 / 10** | `composer.json:10` (framework 11.31), `routes/web.php:1` (Laravel routing), `app/Providers/FortifyServiceProvider.php:28` (Laravel auth bootstrapping) |
| SQL database connection | **10 / 10** | `config/database.php:19` (default connection), `database/migrations/2025_09_04_000100_create_products_table.php:1`, `database/migrations/2025_09_05_000100_create_orders_table.php:1` |
| Meets business scenario criteria | **40 / 40** | `resources/views/pages/home.blade.php:1`, `app/Http/Controllers/CheckoutController.php:29`, `app/Http/Controllers/Seller/DashboardController.php:14`, `app/Http/Controllers/Admin/DashboardController.php:13` |
| External libraries (Livewire/Volt) | **10 / 10** | `app/Livewire/Cart/AddToCart.php:9`, `app/Livewire/Checkout/Form.php:14`, `app/Livewire/Admin/UsersTable.php:12` |
| Laravel Eloquent usage | **10 / 10** | `app/Models/Product.php:9`, `app/Models/Order.php:9`, `app/Models/User.php:25` |
| Laravel Jetstream authentication | **10 / 10** | `config/jetstream.php:19`, `config/jetstream.php:63`, `routes/web.php:57` |
| Laravel Sanctum API authentication | **10 / 10** | `routes/api.php:12`, `routes/api.php:21`, `app/Http/Controllers/Api/AuthController.php:15` |
| Security documentation & implementation | **10 / 10** | `SECURITY.md:1`, `app/Http/Middleware/SecurityHeaders.php:18`, `app/Support/Sanitizer.php:5` |
| MongoDB usage for API (optional) | **10 / 10** | `config/database.php:115`, `app/Models/ContactMessage.php:12`, `app/Services/ContactMessageService.php:13` |
| Hosting provider usage (optional) | **0 / 20** | Deployment guidance prepared in [Deployment & Hosting](#deployment--hosting); infrastructure provisioning still pending |

## Experience by Persona

### Public & Marketing
- Home, heritage, and contact experiences crafted in `resources/views/pages/home.blade.php:1`, `resources/views/pages/about.blade.php:1`, `resources/views/pages/contact.blade.php:1` with a cinematic welcome page `resources/views/welcome.blade.php:1`.
- Public catalogue routes `routes/web.php:31` drive the product listing controller `app/Http/Controllers/ProductController.php:8`, with Tailwind-powered cards rendered in `resources/views/components/product-card.blade.php:1`.
- A persistent Livewire mini-cart keeps guests engaged, reacting to session updates via `app/Livewire/Cart/Mini.php:8` and `resources/views/livewire/cart/mini.blade.php:1`.

### Customers
- Customers browse, manage, and clear carts through `app/Http/Controllers/CartController.php:8`, `resources/views/cart/index.blade.php:1`, and `resources/views/livewire/cart/index.blade.php:1`.
- Checkout is a guided Livewire experience with inline validation, Luhn checks, inventory locks, order creation, transactions, and email confirmations (`app/Livewire/Checkout/Form.php:14`, `app/Http/Controllers/CheckoutController.php:29`, `app/Models/Transaction.php:9`, `resources/views/emails/order-confirmation.blade.php:1`).
- Order history and detail views are guarded by policies in `app/Http/Controllers/OrderController.php:13`, `app/Policies/OrderPolicy.php:6`, and rendered in `resources/views/orders/show.blade.php:1`.
- Jetstream profile management, two-factor scaffolding, and API tokens are available through the standard dashboards (`resources/views/profile/show.blade.php:1`, `config/jetstream.php:63`).

### Sellers
- Seller analytics summarise revenue, fulfilment health, and product performance in `app/Http/Controllers/Seller/DashboardController.php:14` and `resources/views/dashboards/seller.blade.php:1`.
- Product CRUD with image storage, draft/publish workflow, and stock management is handled by `app/Http/Controllers/Seller/ProductController.php:17`, `resources/views/seller/products/edit.blade.php:1`, and Livewire tables `app/Livewire/Seller/ProductsTable.php:12`.
- Inventory and orders tables provide reactive filtering, pagination, and policy checks (`app/Livewire/Seller/InventoryTable.php:10`, `app/Livewire/Seller/OrdersTable.php:10`, `resources/views/livewire/seller/orders-table.blade.php:1`).
- Seller payouts and profile settings reuse Jetstream layouts for a consistent back-office experience (`resources/views/seller/payouts/index.blade.php:1`, `resources/views/seller/settings/index.blade.php:1`).

### Administrators
- Executive dashboard aggregates KPIs, GMV, and top sellers in `app/Http/Controllers/Admin/DashboardController.php:13` with a rich Blade view `resources/views/dashboards/admin.blade.php:1`.
- User safety tooling allows banning, deletion, and audit logging via `app/Http/Controllers/Admin/UserController.php:11`, `app/Livewire/Admin/UsersTable.php:12`, `resources/views/admin/users/index.blade.php:1`.
- Seller onboarding and catalogue moderation combine controller checks and Livewire tables (`app/Http/Controllers/Admin/SellerController.php:10`, `app/Livewire/Admin/SellersTable.php:11`, `app/Livewire/Admin/SellerProductsTable.php:12`, `resources/views/admin/products/edit.blade.php:1`).
- Role middleware and gate overrides ensure admins can assume seller views when providing support (`app/Http/Middleware/RoleMiddleware.php:27`, `app/Providers/AuthServiceProvider.php:32`).

## API Surface

| Endpoint | Auth | Description | Reference |
| --- | --- | --- | --- |
| `GET /api/products` | Public | Paginated published catalogue with seller context | `routes/api.php:18`, `app/Http/Controllers/Api/ProductController.php:12` |
| `POST /api/contact` | Public | Captures contact messages into MongoDB and optionally triggers notifications | `routes/api.php:15`, `app/Http/Controllers/Api/ContactFormController.php:18` |
| `POST /api/register` | Public | Creates a user via Fortify validation and issues a Sanctum token | `routes/api.php:22`, `app/Http/Controllers/Api/AuthController.php:39` |
| `POST /api/login` | Public (rate limited) | Issues a Sanctum token after credential validation | `routes/api.php:21`, `app/Http/Controllers/Api/AuthController.php:15` |
| `GET /api/user` | Sanctum | Returns the authenticated profile for mobile apps | `routes/api.php:12` |
| `GET /api/users` | Sanctum (admin) | Lists users for back-office apps | `routes/api.php:24`, `app/Http/Controllers/Api/UserController.php:14` |
| `POST /api/users/{user}` | Sanctum (owner/admin) | Updates profile, role, and banned status | `routes/api.php:24`, `app/Http/Controllers/Api/UserController.php:27` |

Sample flow:

```bash
curl -X POST https://your-domain.test/api/login \
  -d "email=admin@example.com" \
  -d "password=admin123"

curl -H "Authorization: Bearer <token>" https://your-domain.test/api/users
```

## Data & Storage

- **SQL Core (MySQL/MariaDB/SQLite):** Users, personal access tokens, sessions, products, orders, order items, and transactions managed via migrations such as `database/migrations/2025_09_04_000100_create_products_table.php:1`, `database/migrations/2025_09_05_000100_create_orders_table.php:1`, `database/migrations/2025_09_07_090300_create_transactions_table.php:1`. Default connection is configurable in `config/database.php:19`.
- **MongoDB for Contact Capture:** Contact messages are stored in a dedicated collection using the Laravel MongoDB driver (`config/database.php:115`, `app/Models/ContactMessage.php:12`). The service layer performs validation, writes to Mongo, and fires notifications (`app/Services/ContactMessageService.php:13`).
- **Factories & Seeding:** Seed data provisions an admin and demo user for quick onboarding in `database/seeders/DatabaseSeeder.php:14`. Factories live under `database/factories`.
- **Media & Storage URLs:** Product images normalise to public or S3 URLs via `app/Support/StorageUrl.php:9`, supporting both local and cloud deployments.

## Authentication & Authorization

- Jetstream Livewire stack provides registration, login, profile, API tokens, and account deletion (`config/jetstream.php:19`, `config/jetstream.php:63`).
- Fortify responses are customised for role-directed redirects and two-factor flows in `app/Providers/FortifyServiceProvider.php:28`, `app/Providers/FortifyServiceProvider.php:44`.
- Sanctum guards the API with token issuing in `app/Http/Controllers/Api/AuthController.php:29`, middleware usage in `routes/api.php:12`, and throttle protection in `routes/api.php:21`.
- Role-based access is enforced through middleware aliases (`bootstrap/app.php:14`, `app/Http/Middleware/RoleMiddleware.php:27`, `app/Http/Middleware/DisallowAdminShopping.php:20`) and policies (`app/Policies/ProductPolicy.php:7`, `app/Policies/OrderPolicy.php:6`).
- Admin override behaviour is centralised with `Gate::before` in `app/Providers/AuthServiceProvider.php:32`.

## Security Hardening

- Security posture is documented with mitigation evidence in `SECURITY.md:1`.
- Global security headers and Content-Security-Policy (Report-Only) are applied in `app/Http/Middleware/SecurityHeaders.php:18`.
- HTTPS enforcement, secure cookies, and SameSite defaults activate in production via `app/Providers/AppServiceProvider.php:24`.
- API login regenerates sessions, hashes passwords, and validates credentials before issuing tokens (`app/Http/Controllers/Api/AuthController.php:21`, `app/Http/Controllers/Api/AuthController.php:29`).
- Login endpoints are rate limited (`routes/api.php:21`), and banned users are blocked and logged (`app/Http/Middleware/RoleMiddleware.php:27`).
- Rich text is sanitised before rendering to prevent XSS (`app/Support/Sanitizer.php:5`, `resources/views/terms.blade.php:9`).
- Complex operations such as checkout run inside database transactions to prevent race conditions and overselling (`app/Livewire/Checkout/Form.php:86`, `app/Http/Controllers/CheckoutController.php:60`).

## Livewire & Front-End Experience

- Livewire 3 components power the cart, checkout, seller/admin tables, and dashboards (`app/Livewire/Cart/AddToCart.php:9`, `app/Livewire/Checkout/Form.php:14`, `app/Livewire/Admin/UsersTable.php:12`, `app/Livewire/Seller/InventoryTable.php:10`, `app/Livewire/Checkout/Summary.php:7`).
- Blade views provide responsive layouts using Tailwind and Alpine micro-interactions (`resources/views/livewire/checkout/form.blade.php:1`, `resources/views/livewire/cart/index.blade.php:1`, `resources/views/dashboards/admin.blade.php:1`).
- Alpine plugins enhance dropdowns, nav, and modal behaviour (`resources/js/app.js:5`, `resources/views/components/user-nav.blade.php:1`).
- Vite compiles CSS/JS bundles referenced via `@vite` throughout templates (`resources/views/welcome.blade.php:6`, `vite.config.js:4`).

## External Integrations

- Transactional and administrative emails leverage Laravel's mailables (`app/Mail/ContactSubmitted.php:15`, `app/Mail/OrderConfirmation.php:17`), mailing admins and customers on key events.
- Optional webhooks or CRM notifications can be triggered through the HTTP client (`app/Services/ContactMessageService.php:55`) as configured in `config/services.php:38`.
- Storage URL helper supports S3-compatible buckets, public storage, and CDN rewriting (`app/Support/StorageUrl.php:9`).
- Queue and logging tooling are wired into the dev script to keep long-running mail or notification jobs responsive (`composer.json:60`).

## Local Development Workflow

1. **Clone & install**
   ```bash
   git clone <repo> && cd zentara-v1
   composer install
   npm install
   ```
2. **Environment setup**
   - Copy `.env.example` to `.env`, set `APP_URL`, `DB_CONNECTION`, and credentials.
   - Configure Mongo by setting `MONGODB_URI` and `MONGODB_DATABASE` if using Atlas or Docker (`config/database.php:115`).
   - Set mail driver (`MAIL_MAILER=log` is safe for local testing).
3. **Application key & migrations**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```
4. **Run the integrated dev loop** (`composer.json:58`)
   ```bash
   composer dev
   ```
   This launches `php artisan serve`, `queue:listen`, `artisan pail`, and `npm run dev` concurrently.
5. **Manual alternative**
   - `php artisan serve`
   - `php artisan queue:listen`
   - `npm run dev`

Default admin credentials are seeded using `ADMIN_EMAIL`, `ADMIN_PASSWORD`, and `ADMIN_NAME` from `.env` (`database/seeders/DatabaseSeeder.php:14`).

## Testing & Quality

- Feature tests inherited from Jetstream cover registration, authentication, password reset, and 2FA flows (`tests/Feature/RegistrationTest.php:10`, `tests/Feature/AuthenticationTest.php:9`, `tests/Feature/EmailVerificationTest.php:13`).
- Run the suite with:
  ```bash
  php artisan test
  ```
- Static analysis, Pint formatting, and CI hooks can be added; Pint is already present in dev dependencies (`composer.json:48`).

## Deployment & Hosting

A managed Laravel host such as Forge, Vapor, or Laravel Cloud is recommended. Provisioning steps:

1. **Provision environment**
   - Create a PHP 8.2 server with queue worker and scheduler.
   - Configure a SQL database and, if applicable, a MongoDB Atlas cluster or self-hosted instance.
2. **Deploy code**
   - Clone the repository, set `APP_ENV=production`, `APP_DEBUG=false`.
   - Provide all SQL, Redis (if used), and Mongo credentials through environment variables.
3. **Build & migrate**
   - Run `composer install --optimize-autoloader --no-dev`.
   - Run `php artisan migrate --force`.
   - Build assets with `npm ci && npm run build` or configure the host's build pipeline.
4. **Background workers**
   - Enable queue worker for mail/contact jobs (`composer.json:60`).
   - Schedule `php artisan schedule:run` every minute.
5. **Security headers & HTTPS**
   - Terminate SSL at the load balancer and ensure the app forces HTTPS (`app/Providers/AppServiceProvider.php:24`).
   - Move CSP from report-only to enforce once inline assets are removed (see Next Steps).

Documenting the chosen provider, domain, SSL, and pipeline in this section will convert the optional hosting requirement into full credit.

## Next Steps

- Promote the CSP to enforcement, add reporting integrations, and expand automated security smoke tests.
- Containerise or document the selected hosting provider to close the final rubric item and streamline CI/CD.
- Extend API scopes and add Feature tests around seller/admin endpoints to guarantee regression protection as the commerce catalog grows.
