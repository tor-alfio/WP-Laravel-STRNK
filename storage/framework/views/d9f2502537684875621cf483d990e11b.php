<!DOCTYPE html>
<html>
<head>
    <title>Strnk</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('style.css')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <ul id="nav-button-wrapper">
            <li class="nav-button"><a href="<?php echo e(route('login')); ?>"><img src="<?php echo e(asset('strnk_logo.png')); ?>"></a></li>
            <li class="nav-button"><a>Home</a></li>
            <li class="nav-button"><a>Allenamenti</a></li>
            <li class="nav-button"><a>Contatti</a></li>
            <li class="nav-button"><a href="<?php echo e(route('login')); ?>">Login</a></li>
            <li class="nav-button"><a href="<?php echo e(url('/register')); ?>">Registrazione</a></li>
        </ul>
    </nav>

    <section>
        <div id="citazione">
            <h1>STRNK - "Just lift it!"</h1>
            <p>L'app pensata per persone che come te <br> vogliono mettersi in gioco nel proprio allenamento!</p>
        </div>

        <div id="login_window">
            <h4>Login</h4>
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <label for="username">Username:</label><br>
                <input type="text" name="username" id="username" required><br>

                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" required><br>

                <input type="submit" value="Login" class="submit_button">
                <a href="<?php echo e(route('password.forgot')); ?>">Credenziali dimenticate?</a>
            </form>

            <?php $__errorArgs = ['login_error'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color:red;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </section>
</body>
</html>
<?php /**PATH C:\Users\darkf\Desktop\strnk\resources\views/login.blade.php ENDPATH**/ ?>