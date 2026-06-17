# Getting Started — Login & Database

This guide explains how to authenticate against the API and documents the database
schema. For the interactive endpoint reference see
[API_DOCUMENTATION.md](API_DOCUMENTATION.md).

---

## 1. Seeded login accounts

Running the seeders creates three users (all share the password **`password`**):

| Name  | Email             | Password   | Role         |
| ----- | ----------------- | ---------- | ------------ |
| Admin | `admin@mail.com`  | `password` | `Admin`      |
| John  | `john@mail.com`   | `password` | `Instructor` |
| Marry | `marry@mail.com`  | `password` | `Student`    |

Seed them with:

```bash
php artisan migrate --seed
# or, if the DB already exists:
php artisan db:seed
```

> Credentials live in `database/seeders/AdminSeeder.php`. Change them before deploying
> to any shared or production environment.

---

## 2. Logging in

Authentication uses **JWT**. Send credentials to the login endpoint and you receive a
token to put in the `Authorization` header on every subsequent request.

### Request

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"admin@mail.com","password":"password"}'
```

### Response

```json
{
  "code": 200,
  "success": true,
  "data": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "message": "User Login Successfully"
}
```

The `data` field is your JWT.

### Calling a protected endpoint

Send the token as a Bearer token:

```bash
curl http://localhost:8000/api/categories \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
  -H "Accept: application/json"
```

### Using it in Swagger UI

1. Open `http://localhost:8000/api/documentation`.
2. Call `POST /api/auth/login`, copy the token from `data`.
3. Click **Authorize**, paste the token (no `Bearer ` prefix needed), and use **Try it out**.

> A wrong email/password returns `401` with `"Your Email and Password is incorrect"`.

---

## 3. Roles & permissions

Access control is handled by [spatie/laravel-permission](https://spatie.be/docs/laravel-permission).
Seeded roles and what they can do:

| Role         | Permissions                                                        |
| ------------ | ----------------------------------------------------------------- |
| `Admin`      | **All** permissions (batch, category, student, instructor, user, role, permission — list/create/update/delete) |
| `Instructor` | `batchList`, `batchCreate`, `batchUpdate`, `batchDelete`          |
| `Student`    | `batchList`                                                        |

Permissions follow the naming pattern `{resource}{Action}`, e.g. `categoryCreate`,
`studentDelete`. They are defined in `database/seeders/RoleAndPermissionSeeder.php`.

---

## 4. Database schema

### Entity-relationship diagram

```mermaid
erDiagram
    USERS ||--o{ MODEL_HAS_ROLES : "assigned"
    USERS ||--o{ MODEL_HAS_PERMISSIONS : "assigned"
    ROLES ||--o{ MODEL_HAS_ROLES : "maps"
    PERMISSIONS ||--o{ MODEL_HAS_PERMISSIONS : "maps"
    ROLES ||--o{ ROLE_HAS_PERMISSIONS : "grants"
    PERMISSIONS ||--o{ ROLE_HAS_PERMISSIONS : "granted to"

    BATCHES ||--o{ STUDENTS : "enrolls"
    BATCHES ||--o{ BATCH_INSTRUCTORS : "has"
    INSTRUCTORS ||--o{ BATCH_INSTRUCTORS : "teaches"

    USERS {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        string remember_token
        timestamps created_updated
    }

    CATEGORIES {
        bigint id PK
        string name
        timestamps created_updated
    }

    BATCHES {
        bigint id PK
        string name
        text description
        date start_date
        date end_date
        enum status "upcoming|ongoing|complete"
        timestamps created_updated
    }

    INSTRUCTORS {
        bigint id PK
        string name
        string email
        string phone
        timestamps created_updated
    }

    STUDENTS {
        bigint id PK
        bigint batch_id FK "nullable, nullOnDelete"
        string name
        string email
        string phone
        text address
        date enrolled_at
        enum status "active|inactive|graduated"
        string image
        timestamps created_updated
    }

    BATCH_INSTRUCTORS {
        bigint id PK
        bigint batch_id FK
        bigint instructor_id FK
        timestamps created_updated
    }

    ROLES {
        bigint id PK
        string name
        string guard_name
    }

    PERMISSIONS {
        bigint id PK
        string name
        string guard_name
    }

    MODEL_HAS_ROLES {
        bigint role_id FK
        string model_type
        bigint model_id
    }

    MODEL_HAS_PERMISSIONS {
        bigint permission_id FK
        string model_type
        bigint model_id
    }

    ROLE_HAS_PERMISSIONS {
        bigint permission_id FK
        bigint role_id FK
    }
```

> The diagram renders automatically on GitHub/GitLab and in any Mermaid-aware Markdown
> viewer (including VS Code with the Markdown Preview Mermaid extension).

### Relationships in code

| Relationship                 | Type          | Defined in                              |
| ---------------------------- | ------------- | --------------------------------------- |
| Batch → Students             | one-to-many   | `Batch::students()` / `Student::batch()` |
| Batch ↔ Instructors          | many-to-many  | `Batch::instructors()` / `Instructor::batches()` via `batch_instructors` |
| User ↔ Roles                 | many-to-many  | spatie (`model_has_roles`)              |
| Role ↔ Permissions           | many-to-many  | spatie (`role_has_permissions`)         |

> **Note:** `categories` is currently a standalone table — there is no foreign key
> linking it to `batches` in the schema.

### Supporting tables

Laravel/infra tables also exist but are omitted from the diagram for clarity:
`password_reset_tokens`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`,
`failed_jobs`, and `personal_access_tokens`.
