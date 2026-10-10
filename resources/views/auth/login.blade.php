<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Siklus</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        .card {
            width: 100%;
            max-width: 400px;
            padding: 32px;
            border-radius: 16px;
            background: white;
            box-shadow: 0 10px 35px #0f172a12;
        }
        h1 { margin: 0 0 8px; font-size: 24px; }
        .muted { color: #64748b; margin-bottom: 24px; }
        label { display: block; margin: 16px 0 8px; }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }
        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            border: 0;
            border-radius: 8px;
            background: #15803d;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .error { color: #b91c1c; font-size: 14px; }
        .status { color: #15803d; font-size: 14px; }
        .remember { display: flex; align-items: center; gap: 8px; margin-top: 16px; }
    </style>
</head>
<body>
    <main class="card">
        <h1>Siklus</h1>
        <p class="muted">Masuk ke akun Siklus.</p>

        @if (session('status'))
            <p class="status">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="username"
                required
                autofocus
            >

            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <label class="remember">
                <input type="checkbox" name="remember" value="1">
                Ingat saya
            </label>

            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>
