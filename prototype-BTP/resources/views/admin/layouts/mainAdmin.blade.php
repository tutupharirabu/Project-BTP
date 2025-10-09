<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('assets/img/logoHead.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @PwaHead
    <title>Admin Bandung Techno Park</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- untuk logo check, cancel dan wait di status ruangan admin -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/dragndrop.css') }}">

    <script defer src="https://umami-web-traffic-analysis.tutupharirabu.cloud/script.js"
        data-website-id="e379e174-3600-4866-9ed9-a33d3750d016"></script>

    <style>
        body {
            padding-top: 50px;
            overflow-x: hidden;
        }

        .footerstyle {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50px;
            background-color: #f8f9fa;
            text-align: center;
            padding: 8px;
        }
    </style>
</head>

<body>
    @include('admin.partials.navigationAdmin')
    <div class="row g-0 min-vh-100">
        <div class="col-sm-12 col-md-2 col-xl-2 col-lg-2">
            @include('admin.partials.sidebarAdmin')
        </div>
        <div class="col-sm-12 col-md-10 col-xl-10 d-flex flex-column px-0">
            <div class="flex-grow-1 px-4 px-md-5 py-4">
                @yield('containAdmin')
            </div>
            @include('admin.partials.footerAdmin')
        </div>
    </div>

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    {{-- jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    @RegisterServiceWorkerScript
</body>

<!-- drag drop zone -->
<style>
    /* Overrides the default styling for file previews */
    .dropzone .dz-preview .dz-image {
        background: transparent !important;
        /* Remove any background color */
        border-radius: 10px;
        /* Optional: adds rounded corners to the thumbnail */
    }

    .dropzone .dz-preview .dz-details img {
        width: 100%;
        /* Ensures the thumbnail image uses all available space */
        height: auto;
        /* Maintains aspect ratio */
        border-radius: 10px;
        /* Rounded corners for the image */
    }

    .dropzone .dz-preview .dz-progress {
        display: none;
        /* Hide the progress bar */
    }

    /* .footerstyle {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background-color: #f8f9fa;
        text-align: center;
        padding: 8px;
    } */
</style>

</html>

{{-- Calendar JS --}}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var calendarEl = document.getElementById('calendar');
    var events = [];
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialView: 'dayGridMonth',
        timeZone: 'UTC',
        events: '/events',
        editable: true,
    });

    calendar.render();
</script>
