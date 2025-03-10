<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/img/logoHead.png') }}" />
    <title>Login Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-VoVp+Y7fE9gr/mq6+dL88UJ8RxmcrnhOHKAtMtTX/AriKVIyK/Bn0pNED0oGzUg0JeA7L+CK6XXNwOjf5eFpBQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://umami-web-analytics.tutupharirabu.cloud/script.js"
        data-website-id="a0fc1451-ec3e-4c05-ab7f-cac39472a1bd"></script>
</head>

<body class="bg-body-tertiary">
    <div class="content-wrapper">
        @yield('containLoginSys')
    </div>
    @include('loginsys.partials.footerlogin')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>