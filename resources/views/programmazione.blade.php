<!DOCTYPE html>
<html>

<head>
    <title>Strnk</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="{{ asset('script.js') }}" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="big_container">
        <nav>
            <button id="mobile-menu-toggle">☰</button>
            <ul id="nav-button-wrapper">
                <li class="nav-button"><a href="{{ route('home') }}"><img src="{{ asset('strnk_logo.png') }}"></a></li>
                <li class="nav-button"><a href="{{ route('home') }}">Home</a></li>
                <li class="nav-button"><a href="{{ route('allenamenti') }}">Allenamenti</a></li>
                <li class="nav-button"><a href="#">Esercizi</a></li>
                <li class="nav-button"><a href="{{ route('programmazione') }}">Programmazione</a></li>
                <li class="nav-button"><a href="{{ route('users') }}">Utenti</a></li>
                <li class="nav-button"><a href="#">Profilo</a></li>
                <li class="nav-button">
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>

        <section class="no-space-around">
            <div class="header">
                <div class="saluto">
                    <p>Allenamenti per {{ $user['first_Name'] }}!</p>
                </div>
                <div class="sub_header">
                    <div class="position_relative">
                        <button id="notification-button" onclick="showNotifications()">
                            <img src="{{ asset('bell_notification.png') }}">
                        </button>
                        <div id="notifications-number">0</div>
                        <div id="notifications-wrapper"></div>
                    </div>
                    <div>
                        <div class="profile_container">
                            <img src="{{ $user->pfp }}" alt="Profile Image">
                        </div>
                    </div>
                </div>
            </div>

            <div id="main_section">
                <div id="trainings-wrapper" class="position_relative">
                    <div id="buttons-wrapper"></div>

                    <ul id="training-headers" class="trainings-display">
                        <li class="training-headers">Nome</li>
                        <li class="training-headers">N. Weeks</li>
                        <li class="training-headers">N. Giorni</li>
                        <li class="training-headers">Dal coach</li>
                        <li class="training-headers">Data Inizio</li>
                        <li class="training-headers">Data Fine</li>
                    </ul>

                    <div id="trainings-display">
                        @foreach($allenamenti as $workout)
                            <ul class="trainings-display">
                                <li class="training-detail">
                                    <button class="workout-detail-button" onclick="displayWorkout(this)">{{ $workout->name }}</button>
                                </li>
                                <li class="training-detail">{{ $workout->weeks }}</li>
                                <li class="training-detail">{{ $workout->days }}</li>
                                <li class="training-detail">{{ $workout->coach }}</li>
                                <li class="training-detail">{{ $workout->start_date }}</li>
                                <li class="training-detail">{{ $workout->finish_date }}</li>
                            </ul>
                        @endforeach
                    </div>

                    <button class="add-workout-button" onclick="addWorkout()">+</button>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
