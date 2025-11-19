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
            <h3>Registrazione</h3>

            <form method="POST" action="{{ route('register') }}" id="register-form">
                @csrf

                <label for="name">Nome :</label><br>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required><br>

                <label for="surname">Cognome :</label><br>
                <input type="text" id="surname" name="surname" value="{{ old('surname') }}" required><br>

                <label for="birthday">Data Nascita :</label><br>
                <input type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" required><br>

                <label for="sex">Identificazione di genere :</label><br>
                <input type="text" id="sex" name="sex" value="{{ old('sex') }}" required><br>

                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required><br>

                <label for="username">Username :</label><br>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required><br>

                <label for="password">Password :</label><br>
                <input type="password" id="password" name="password" required><br>

                <input type="hidden" name="profile_image" id="profile_image">

                <div style="text-align:center; margin-top:15px;">
                    <button type="button" id="generate-cat" class="submit_button" onclick="generateCatImage()">
                        Genera immagine profilo
                    </button>
                    <br><br>
                    <img id="cat-preview" src="" width="120" style="border-radius:10px; display:none;">
                </div>

                <input type="submit" value="Register" class="submit_button" style="margin-top:20px;">
            </form>

            {{-- Errori di validazione --}}
            @if ($errors->any())
                <ul style="color:red; margin-top:10px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
</body>
</html>
