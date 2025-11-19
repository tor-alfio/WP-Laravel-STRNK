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
        <div id="login_window">
            <h2>Reimposta la password</h2>

            <form method="POST" action="<?php echo e(route('password.update')); ?>">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="token" value="<?php echo e($token); ?>">

                <label>Nuova password:</label>
                <input type="password" name="password" required>

                <label>Conferma password:</label>
                <input type="password" name="password_confirmation" required>

                <button type="submit">Aggiorna password</button>

                <?php $__errorArgs = ['token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p style="color:red"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </form>

        </div>
    </section>
</body>
</html>
<?php /**PATH C:\Users\darkf\Desktop\strnk\resources\views/reset-password.blade.php ENDPATH**/ ?>