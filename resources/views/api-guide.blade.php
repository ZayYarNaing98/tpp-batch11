<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TPP API — Login & Endpoints</title>
    <style>
        :root { color-scheme: light dark; }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: #f6f8fa;
            color: #1f2328;
            line-height: 1.5;
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
        main { max-width: 1000px; margin: 0 auto; padding: 24px; }
        section {
            background: #fff;
            border: 1px solid #d0d7de;
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 24px;
        }
        h2 { font-size: 16px; margin: 0 0 14px; }
        h3 { font-size: 14px; margin: 20px 0 8px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { text-align: left; padding: 8px 10px; border-bottom: 1px solid #eaeef2; }
        th { font-weight: 600; color: #57606a; background: #f6f8fa; }
        code, pre { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; }
        code { background: #eff1f3; padding: 1px 5px; border-radius: 4px; font-size: 13px; }
        pre {
            background: #0d1117; color: #e6edf3; padding: 14px 16px;
            border-radius: 8px; overflow-x: auto; font-size: 13px;
        }
        .pill { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .get    { background: #dafbe1; color: #116329; }
        .post   { background: #ddf4ff; color: #0550ae; }
        .put    { background: #fff1e5; color: #953800; }
        .delete { background: #ffebe9; color: #cf222e; }
        .lock { color: #9a6700; font-weight: 600; }
        .open { color: #1a7f37; font-weight: 600; }
        a { color: #0969da; }
        .links a { margin-right: 16px; }
        .note { font-size: 13px; color: #57606a; }
    </style>
</head>
<body>
    <header>
        <h1>TPP API — Login &amp; Endpoints</h1>
        <span class="meta">Quick reference</span>
    </header>

    <main>
        <section class="links">
            <strong>Related:</strong>
            <a href="/api/documentation">Swagger UI</a>
            <a href="/docs">OpenAPI JSON</a>
            <a href="{{ route('erd') }}">Database ERD</a>
        </section>

        <section>
            <h2>Seeded login credentials</h2>
            <p class="note">All accounts share the password <code>password</code>. Run
                <code>php artisan migrate --seed</code> to create them. Change these before deploying.</p>
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Password</th><th>Role</th></tr>
                </thead>
                <tbody>
                    <tr><td>Admin</td><td><code>admin@mail.com</code></td><td><code>password</code></td><td>Admin</td></tr>
                    <tr><td>John</td><td><code>john@mail.com</code></td><td><code>password</code></td><td>Instructor</td></tr>
                    <tr><td>Marry</td><td><code>marry@mail.com</code></td><td><code>password</code></td><td>Student</td></tr>
                </tbody>
            </table>
        </section>

        <section>
            <h2>How to log in</h2>
            <p class="note">Authentication is JWT. Log in, then send the returned token as a Bearer header.</p>
            <h3>1. Request a token</h3>
            <pre>curl -X POST {{ url('/api/auth/login') }} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"admin@mail.com","password":"password"}'</pre>
            <h3>2. Response</h3>
            <pre>{
  "code": 200,
  "success": true,
  "data": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
  "message": "User Login Successfully"
}</pre>
            <h3>3. Call a protected endpoint</h3>
            <pre>curl {{ url('/api/categories') }} \
  -H "Authorization: Bearer &lt;token&gt;" \
  -H "Accept: application/json"</pre>
        </section>

        <section>
            <h2>Endpoints</h2>
            <p class="note">
                <span class="open">Public</span> = no token required &nbsp;·&nbsp;
                <span class="lock">Auth</span> = requires <code>Authorization: Bearer &lt;token&gt;</code>
            </p>
            <table>
                <thead>
                    <tr><th>Method</th><th>Path</th><th>Auth</th><th>Description</th></tr>
                </thead>
                <tbody>
                    @php
                        $resources = [
                            'Auth'        => null,
                            'categories'  => 'category',
                            'batches'     => 'batch',
                            'instructors' => 'instructor',
                            'students'    => 'student',
                            'users'       => 'user',
                            'roles'       => 'role',
                            'permissions' => 'permission',
                        ];
                    @endphp

                    <tr>
                        <td><span class="pill post">POST</span></td>
                        <td><code>/api/auth/login</code></td>
                        <td><span class="open">Public</span></td>
                        <td>Authenticate and receive a JWT token</td>
                    </tr>

                    @foreach ($resources as $path => $label)
                        @continue($label === null)
                        <tr>
                            <td><span class="pill get">GET</span></td>
                            <td><code>/api/{{ $path }}</code></td>
                            <td><span class="lock">Auth</span></td>
                            <td>List all {{ $path }}</td>
                        </tr>
                        <tr>
                            <td><span class="pill post">POST</span></td>
                            <td><code>/api/{{ $path }}</code></td>
                            <td><span class="lock">Auth</span></td>
                            <td>Create a {{ $label }}</td>
                        </tr>
                        <tr>
                            <td><span class="pill get">GET</span></td>
                            <td><code>/api/{{ $path }}/{id}</code></td>
                            <td><span class="lock">Auth</span></td>
                            <td>Show a single {{ $label }}</td>
                        </tr>
                        <tr>
                            <td><span class="pill put">PUT</span></td>
                            <td><code>/api/{{ $path }}/{id}</code></td>
                            <td><span class="lock">Auth</span></td>
                            <td>Update a {{ $label }}</td>
                        </tr>
                        <tr>
                            <td><span class="pill delete">DELETE</span></td>
                            <td><code>/api/{{ $path }}/{id}</code></td>
                            <td><span class="lock">Auth</span></td>
                            <td>Delete a {{ $label }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
