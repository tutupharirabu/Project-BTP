<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('assets/img/logoHead.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css"
        integrity="sha384-NvKbDTEnL+A8F/AA5Tc5kmMLSJHUO868P+lDtTpJIeQdGYaUIuLr4lVGOEA1OcMy" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('assets/css/dragndrop.css') }}">

    <script defer src="https://umami.tutupharirabu.cloud/script.js"
        data-website-id="6552bf4a-7391-40fb-8e93-e35363bb72f5"></script>

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
    <div class="row d-flex">
        <div class="col-sm-12 col-md-2 col-xl-2 col-lg-2">
            @include('admin.partials.sidebarAdmin')
        </div>
        <div class="col-sm-12 col-md-10 col-xl-10">
            <div class="">
                @yield('containAdmin')
            </div>
            <div>
                @include('admin.partials.footerAdmin')
            </div>
        </div>
    </div>

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    {{-- jquery --}}

    {{--
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
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
{{--
<script type="text/javascript">
    var dropzone = new Dropzone("#my-dropzone", {
        url: "{{ route('dropzone.store') }}",
        thumbnailWidth: 200,
        maxFilesize: 2,
        acceptedFiles: ".jpeg,.jpg,.png,.svg",
        autoProcessQueue: false,
        addRemoveLinks: true,
        dictRemoveFile: 'Remove file',
        previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-image"><img data-dz-thumbnail /></div><div class="dz-details"><div class="dz-size"><span data-dz-size></span></div><div class="dz-filename"><span data-dz-name></span></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>'
    });
</script> --}}

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