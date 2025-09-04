# Security Documentation

This document outlines key security measures implemented in this Laravel 11 application and how to operate them safely.

## Threat Model & Controls (OWASP-oriented)

- Input Validation: All form and API inputs are validated via Laravel Form Requests/validators (e.g., contact form and Contacts API). Prevents injection and malformed data.
- CSRF Protection: Enabled by default on web routes via Laravel's VerifyCsrfToken middleware. SPA/API flows use Laravel Sanctum.
- Authentication: Laravel Jetstream (Livewire stack) provides registration, login, password reset, and optional 2FA (via Fortify). Email verification is enforced by implementing `MustVerifyEmail` on `User`.
- Authorization: Route protection via `auth:sanctum`, Jetstream session middleware, and role-based checks using `RoleMiddleware` (`admin`, `seller`, `user`).
- API Authentication: Laravel Sanctum personal access tokens. Token abilities (scopes) are used for Contacts API: `read-contacts`, `create-contacts`.
- Rate Limiting: API routes use the default `api` throttle limiter (configurable in `RouteServiceProvider`), protecting against brute force and abusive clients.
- Password Security: Passwords are hashed (native hashed cast). Sensitive attributes are hidden from serialization.
- Session Security: `SESSION_DRIVER=database` with HTTPS recommended in production; set `SESSION_SECURE_COOKIE=true` and use secure cookies behind TLS.
- Mail & Notifications: Email verification and password reset are provided by Jetstream/Fortify. Configure mail transport for production.
- Error Handling: Generic error pages and exception handling via Laravel prevent leakage of sensitive info in production.

## Implementation Details

- Laravel 11.x, Jetstream 5 (Livewire), Sanctum 4 are installed.
- Email Verification: `User` implements `MustVerifyEmail`. Web route groups include `verified` middleware.
- Sanctum API Tokens UI: Jetstream `Features::api()` enabled to manage tokens from the profile screen. Assign abilities like `read-contacts` and `create-contacts` when issuing tokens.
- Contacts API (Sanctum-protected):
  - `GET /api/contacts` (ability: `read-contacts` or `admin`)
  - `GET /api/contacts/{id}` (ability: `read-contacts` or `admin`)
  - `POST /api/contacts` (ability: `create-contacts` or `admin`)

## Operations Checklist (Production)

- Always use HTTPS. Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://your-domain`.
- Configure secure cookies: `SESSION_SECURE_COOKIE=true`, `SANCTUM_STATEFUL_DOMAINS` to your domains, `SESSION_DRIVER=database` or `redis`.
- Configure database with least-privilege credentials. Do not commit real credentials; use environment variables.
- Rotate Sanctum tokens regularly; use fine-grained abilities and revoke when no longer needed.
- Enable 2FA in Jetstream for privileged accounts.
- Backups and monitoring: enable DB backups and application logs/alerts.

## Not Implemented / Optional

- MongoDB (NoSQL) is not integrated. If required, plan to add `jenssegers/laravel-mongodb` and isolate API resources accordingly.
- Hosting specifics are not included in this repo. CI/CD and deployment scripts can be added based on chosen provider (Forge, Vapor, Docker, etc.).

