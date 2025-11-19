<!DOCTYPE html>
<html>
<head>
    <title>Strnk</title>
    <script src="<?php echo e(asset('script.js')); ?>" defer></script>
    <link rel="stylesheet" href="<?php echo e(asset('style.css')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@100..900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>

<body>
    <nav>
        <ul id="nav-button-wrapper">
            <li class="nav-button">
                <a href="<?php echo e(route('login')); ?>"><img src="<?php echo e(asset('strnk_logo.png')); ?>"></a>
            </li>
            <li class="nav-button"><a href="<?php echo e(route('login')); ?>">Home</a></li>
            <li class="nav-button"><a>Allenamenti</a></li>
            <li class="nav-button"><a>Contatti</a></li>
            <li class="nav-button"><a href="<?php echo e(route('login')); ?>">Login</a></li>
            <li class="nav-button"><a>Registrazione</a></li>
        </ul>
    </nav>

    <section>
        <h2>Link di reset generato</h2>

        <p><a href="<?php echo e($resetLink); ?>">Clicca qui per aprire</a></p>

    </section>
</body>
</html>
<?php /**PATH C:\Users\darkf\Desktop\strnk\resources\views/show_link.blade.php ENDPATH**/ ?>