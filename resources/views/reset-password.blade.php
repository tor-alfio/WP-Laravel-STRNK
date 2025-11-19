<!DOCTYPE html>
<html>
<head>
    <title>Strnk</title>
    <script src="{{ asset('script.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@100..900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <nav>
        <ul id="nav-button-wrapper">
            <li class="nav-button">
                <a href="{{ route('login') }}"><img src="{{ asset('strnk_logo.png') }}"></a>
            </li>
            <li class="nav-button"><a href="{{ route('login') }}">Home</a></li>
            <li class="nav-button"><a>Allenamenti</a></li>
            <li class="nav-button"><a>Contatti</a></li>
            <li class="nav-button"><a href="{{ route('login') }}">Login</a></li>
            <li class="nav-button"><a>Registrazione</a></li>
        </ul>
    </nav>

    <section>
        <div id="login_window">
            <h2>Reimposta la password</h2>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <label>Nuova password:</label>
                <input type="password" name="password" required>

                <label>Conferma password:</label>
                <input type="password" name="password_confirmation" required>

                <button type="submit">Aggiorna password</button>

                @error('token')
                    <p style="color:red">{{ $message }}</p>
                @enderror
            </form>

        </div>
    </section>
</body>
</html>
