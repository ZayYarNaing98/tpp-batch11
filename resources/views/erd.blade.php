<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TPP API — Database ERD</title>
    <style>
        :root { color-scheme: light dark; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f6f8fa;
            color: #1f2328;
        }
        header {
            padding: 18px 24px;
            background: #0d1117;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }
        header h1 { font-size: 18px; margin: 0; font-weight: 600; }
        header .meta { font-size: 13px; opacity: .75; }
        .toolbar { padding: 12px 24px; }
        .toolbar button {
            cursor: pointer;
            border: 1px solid #d0d7de;
            background: #fff;
            color: #1f2328;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
        }
        .toolbar button:hover { background: #eaeef2; }
        .diagram-wrap {
            margin: 0 24px 32px;
            padding: 16px;
            background: #fff;
            border: 1px solid #d0d7de;
            border-radius: 8px;
            overflow: auto;
        }
        .mermaid { display: flex; justify-content: center; }
        footer { padding: 0 24px 28px; font-size: 12px; color: #57606a; }
        a { color: #0969da; }
    </style>
</head>
<body>
    <header>
        <h1>TPP API — Database ERD</h1>
        <span class="meta">Generated from the application schema</span>
    </header>

    <div class="toolbar">
        <button onclick="window.print()">Print / Save as PDF</button>
    </div>

    <div class="diagram-wrap">
        <pre class="mermaid">
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
        </pre>
    </div>

    <footer>
        <strong>categories</strong> is a standalone table (no FK to batches). Infra tables
        (sessions, cache, jobs, personal_access_tokens, …) are omitted for clarity.
    </footer>

    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.esm.min.mjs';
        mermaid.initialize({
            startOnLoad: true,
            theme: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'default',
        });
    </script>
</body>
</html>
