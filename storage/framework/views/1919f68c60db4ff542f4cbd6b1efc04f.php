<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Spotify Callback</title>
    <script src="<?php echo e(asset('callback.js')); ?>"></script> 
    <script>
        handleSpotifyRedirect("<?php echo e($code); ?>");
    </script>
    <script>
        const HOME_URL = "<?php echo e(route('home')); ?>";
    </script>
</head>

<body>
    <p>Attendere il redirect...</p>
</body>

</html><?php /**PATH C:\Users\darkf\Desktop\strnk\resources\views/callback.blade.php ENDPATH**/ ?>