<!DOCTYPE html>
<html>
<head>
    <title>Strnk</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <ul id="nav-button-wrapper">
            <li class="nav-button"><a href="{{ route('login') }}"><img src="{{ asset('strnk_logo.png') }}"></a></li>
            <li class="nav-button"><a>Home</a></li>
            <li class="nav-button"><a>Allenamenti</a></li>
            <li class="nav-button"><a>Contatti</a></li>
            <li class="nav-button"><a href="{{ route('login') }}">Login</a></li>
            <li class="nav-button"><a href="{{ url('/register') }}">Registrazione</a></li>
        </ul>
    </nav>

    <section>
        <div id="citazione">
            <h1>STRNK - "Just lift it!"</h1>
            <p>L'app pensata per persone che come te <br> vogliono mettersi in gioco nel proprio allenamento!</p>
        </div>

        <div id="login_window">
            <h4>Login</h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label for="username">Username:</label><br>
                <input type="text" name="username" id="username" required><br>

                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" required><br>

                <input type="submit" value="Login" class="submit_button">
                <a href="{{ route('password.forgot') }}">Credenziali dimenticate?</a>
            </form>

            @error('login_error')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>
    </section>
</body>
</html>
