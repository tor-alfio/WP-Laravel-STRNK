<!DOCTYPE html>
<html>
<head>
    <title>Strnk</title>
    <link rel="stylesheet" href="<?php echo e(asset('style.css')); ?>">
    <script src="<?php echo e(asset('script.js')); ?>" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@100..900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    <section class="no-space-around">
        <div class="header">
            <div class="saluto">
                <p>Allenamenti per <?php echo e($user->first_Name); ?>!</p>
            </div>
            <div class="sub_header">
                <div class="position_relative">
                    <button id="notification-button" onclick="showNotifications()">
                        <img src="<?php echo e(asset('bell_notification.png')); ?>">
                    </button>
                    <div id="notifications-number">0</div>
                    <div id="notifications-wrapper"></div>
                </div>
                <div>
                    <div class="profile_container">
                        <img src="<?php echo e($user->pfp); ?>" alt="Profile Image">
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
                    <?php $__currentLoopData = $allenamenti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <ul class="trainings-display">
                            <li class="training-detail">
                                <button class="workout-detail-button" onclick="displayWorkout(this)">
                                    <?php echo e($a->name); ?>

                                </button>
                            </li>
                            <li class="training-detail"><?php echo e($a->weeks); ?></li>
                            <li class="training-detail"><?php echo e($a->days); ?></li>
                            <li class="training-detail"><?php echo e($a->coach); ?></li>
                            <li class="training-detail"><?php echo e($a->start_date); ?></li>
                            <li class="training-detail"><?php echo e($a->finish_date); ?></li>
                        </ul>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <button class="add-workout-button" onclick="addWorkout()">+</button>
            </div>
        </div>
    </section>
</div>
</body>
</html>
<?php /**PATH C:\Users\darkf\Desktop\strnk\resources\views/allenamenti.blade.php ENDPATH**/ ?>