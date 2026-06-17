# API Documentation (Swagger / OpenAPI)

This project uses [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger) (a Laravel
wrapper around [swagger-php](https://github.com/zircote/swagger-php)) to generate
interactive OpenAPI 3.0 documentation for the REST API.

## Accessing the docs

| Resource          | URL                                            |
| ----------------- | ---------------------------------------------- |
| Swagger UI        | `{APP_URL}/api/documentation`                  |
| Raw OpenAPI JSON  | `{APP_URL}/docs`                               |

Locally that is:

- Swagger UI: http://localhost:8000/api/documentation
- OpenAPI JSON: http://localhost:8000/docs

## Authenticating in Swagger UI

All endpoints except `POST /api/auth/login` are protected by JWT (`auth:api`).

1. Call **`POST /api/auth/login`** with valid credentials. The token is returned in
   the `data` field.
2. Click the green **Authorize** button (top-right of the UI).
3. Paste the token (just the token — the `Bearer ` prefix is added automatically).
4. You can now call any protected endpoint via **Try it out**.

## Regenerating the docs

The documentation is generated from PHP 8 attributes (`#[OA\...]`) on the controllers
in `app/Http/Controllers/`. After changing any annotation, regenerate the spec:

```bash
php artisan l5-swagger:generate
```

This writes `storage/api-docs/api-docs.json`, which the UI reads.

> **Tip (local dev):** set `L5_SWAGGER_GENERATE_ALWAYS=true` in `.env` to auto-regenerate
> on every page load so you don't have to run the command manually. Keep this **off** in
> production.

## Configuring the server URL (per environment)

The server URL shown in the UI comes from the `L5_SWAGGER_CONST_HOST` environment
variable (wired into the `#[OA\Server]` attribute in
`app/Http/Controllers/Controller.php`). No code change is needed to switch domains.

`.env` example:

```env
# Local
L5_SWAGGER_CONST_HOST=http://localhost:8000

# Production
L5_SWAGGER_CONST_HOST=https://api.yourdomain.com
```

After changing the value you **must regenerate** the spec (the URL is baked into the
generated JSON):

```bash
php artisan config:clear
php artisan l5-swagger:generate
```

## Deployment checklist

Run these on the server as part of your deploy, **in this order**:

```bash
# 1. Make sure the production domain is set in .env
#    L5_SWAGGER_CONST_HOST=https://api.yourdomain.com

# 2. (Re)cache config so the new env value is picked up
php artisan config:cache

# 3. Regenerate the OpenAPI spec AFTER config is cached
php artisan l5-swagger:generate
```

> Regeneration is mandatory — editing `.env` alone does nothing until
> `l5-swagger:generate` runs, because the server URL is stored in
> `storage/api-docs/api-docs.json`.

## How the annotations are organised

- **Global metadata** (API title, server, JWT security scheme, tags) lives on the
  abstract base controller: `app/Http/Controllers/Controller.php`.
- **Per-endpoint docs** are PHP 8 attributes directly above each controller action in
  `app/Http/Controllers/API/*Controller.php`.

> **Why attributes instead of `@OA` docblocks?** L5-Swagger 11 (swagger-php 6) scans
> only PHP 8 attributes by default. The docblock style is ignored unless a custom
> analyser object is injected into the config, which would break
> `php artisan config:cache` in production. Attributes are the deploy-safe choice.

### Documented endpoints

| Tag         | Endpoints                                                                 |
| ----------- | ------------------------------------------------------------------------- |
| Auth        | `POST /api/auth/login`                                                     |
| Categories  | `GET/POST /api/categories`, `GET/PUT/DELETE /api/categories/{id}`          |
| Batches     | `GET/POST /api/batches`, `GET/PUT/DELETE /api/batches/{id}`                |
| Instructors | `GET/POST /api/instructors`, `GET/PUT/DELETE /api/instructors/{id}`        |
| Students    | `GET/POST /api/students`, `GET/PUT/DELETE /api/students/{id}`              |
| Users       | `GET/POST /api/users`, `GET/PUT/DELETE /api/users/{id}`                    |
| Roles       | `GET/POST /api/roles`, `GET/PUT/DELETE /api/roles/{id}`                    |
| Permissions | `GET/POST /api/permissions`, `GET/PUT/DELETE /api/permissions/{id}`        |

## Adding docs to a new endpoint

Add an attribute above the controller method, then regenerate. Example:

```php
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/example',
    tags: ['Example'],
    summary: 'List examples',
    security: [['bearerAuth' => []]],
    responses: [
        new OA\Response(response: 200, description: 'OK'),
        new OA\Response(response: 401, description: 'Unauthenticated'),
    ]
)]
public function index() { /* ... */ }
```

If you introduce a new tag, also register it on the base controller
(`app/Http/Controllers/Controller.php`) with `#[OA\Tag(...)]` so it is grouped in the UI.
