<!DOCTYPE html>
<html>
<head>
    <title>Strnk</title>
    <link rel="stylesheet" href="<?php echo e(asset('style.css')); ?>">
    <script src="<?php echo e(asset('script.js')); ?>" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@100..900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>

<body>
<div class="big_container">
    <nav>
        <button id="mobile-menu-toggle">☰</button>
        <ul id="nav-button-wrapper">
            <li class="nav-button"><a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('strnk_logo.png')); ?>"></a></li>
            <li class="nav-button"><a href="<?php echo e(route('home')); ?>">Home</a></li>
            <li class="nav-button"><a href="<?php echo e(route('allenamenti')); ?>">Allenamenti</a></li>
            <li class="nav-button"><a href="#">Esercizi</a></li>
            <li class="nav-button"><a href="<?php echo e(route('programmazione')); ?>">Programmazione</a></li>
            <li class="nav-button"><a href="<?php echo e(route('users')); ?>">Utenti</a></li>
            <li class="nav-button"><a href="#">Profilo</a></li>
            <li class="nav-button">
                <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" style="background:none; border:none; color:inherit; cursor:pointer;">Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <section class="no-justify">
        <div class="header">
            <div class="saluto">
                <p>Ben tornato <?php echo e($user->first_Name); ?>!</p>
            </div>
            <div class="sub_header">
                <div class="position_relative">
                    <button id="notification-button" onclick="showNotifications()">
                        <img src="<?php echo e(asset('bell_notification.png')); ?>">
                    </button>
                    <div id="notifications-number"></div>
                    <div id="notifications-wrapper"></div>
                </div>
                <div>
                    <div class="profile_container">
                        <img src="<?php echo e($user->pfp); ?>" alt="profile image">
                    </div>
                </div>
            </div>
        </div>

        <div id="main_section">
            <div class="calendar-wrapper">
                <div class="calendar-header">
                    <button onclick="changeMonth(-1)">⬅</button>
                    <h2 id="month-year"></h2>
                    <button onclick="changeMonth(1)">➡</button>
                </div>
                <div class="calendar-days">
                    <div>Lun</div><div>Mar</div><div>Mer</div><div>Gio</div><div>Ven</div><div>Sab</div><div>Dom</div>
                </div>
                <div class="calendar-grid" id="calendar-grid"></div>
            </div>

            <div>
                <div id="training-of-the-day" class="calendar-wrapper"></div>
                <div class="calendar-wrapper">
                    <div>Citazione Random</div>
                    <div id="quote"></div>
                </div>
            </div>

            <div id="spotify-track" class="calendar-wrapper"></div>
        </div>
    </section>
</div>

<footer>
    <div class="footer-items-wrapper">
        <p>
            <a href="#">Termini sulla Privacy</a> | <a href="#">Contatti</a>
        </p>
        <p>
            Seguici su: <a href="#">Facebook</a> | <a href="#">Twitter</a> | <a href="#">Instagram</a>
        </p>
        <p>2025 Strnk© by Gaffio — Tutti i diritti riservati.</p>
    </div>
</footer>
</body>
</html>
<?php /**PATH C:\Users\darkf\Desktop\strnk\resources\views/home.blade.php ENDPATH**/ ?>