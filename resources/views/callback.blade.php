<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Spotify Callback</title>
    <script src="{{ asset('callback.js') }}"></script> 
    <script>
        handleSpotifyRedirect("{{ $code }}");
    </script>
    <script>
        const HOME_URL = "{{ route('home') }}";
    </script>
</head>

<body>
    <p>Attendere il redirect...</p>
</body>

</html>