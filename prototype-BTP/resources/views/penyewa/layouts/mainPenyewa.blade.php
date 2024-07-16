<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peminjaman Bandung Techno Park</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-VoVp+Y7fE9gr/mq6+dL88UJ8RxmcrnhOHKAtMtTX/AriKVIyK/Bn0pNED0oGzUg0JeA7L+CK6XXNwOjf5eFpBQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dragndrop.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/penyewa/form.css') }}">

</head>

<body>

    @include('penyewa.partials.navigationUser')
    <div class="row d-flex">
        <div class="col-sm-12 col-md-2 col-xl-2 col-lg-2">
            @include('penyewa.partials.sidebarUser')
        </div>
        <div class="col-sm-12 col-md-10 col-xl-10" >
            <div>
                @yield('containPenyewa')
            </div>
            <div>
                @include('penyewa.partials.footerUser')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-auto">
            <a href="https://wa.me/+6282127644368" target="_blank" style="text-decoration: none;">
                <div class="whatsapp-button">
                    <i class="fab fa-whatsapp"></i>
                </div>
            </a>
        </div>
    </div>

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    {{-- jquery --}}
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


</body>

<style>
    body {
        padding-top: 60px;
        overflow-x: hidden;
    }
</style>

