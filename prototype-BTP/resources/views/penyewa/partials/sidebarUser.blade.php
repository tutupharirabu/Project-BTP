<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />

<?php $nama = Auth::user()->nama_lengkap ?>

<!-- Navbar -->
{{-- <div class="col-md-2 col-lg-2 d-none d-md-block" style="background-color: #d9d9d9">
    <nav class="nav flex-column">
        <a class="nav-link active" href="#">Dashboard</a>
        <a class="nav-link" href="#">Daftar Ruangan</a>
        <a class="nav-link" href="#">Status Pengajuan</a>
        <a class="nav-link" href="#">Keluar</a>
    </nav>
</div> --}}

<div class="col-md-2 col-lg-2 d-none d-md-block d-flex flex-column " style="background-color: #ed3c35; color: #FFFFFF">
    <div class="text-center mt-3">
        <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" alt="User Avatar" class="rounded-circle mb-3"
            style="width: 100px; height: 100px;">
        <p class="h6">{{ $nama }}</p>
    </div>

    <nav class="nav flex-column mt-auto">
        <a class="text-white nav-link active" href="/dashboardPenyewa">Dashboard</a>
        <a class="text-white nav-link" href="/statusRuanganAdmin">Daftar Ruangan</a>
        <a class="text-white nav-link" href="/statusPengajuanAdmin">Status Pengajuan</a>
        <a class="text-white nav-link" href="/statusRuanganPenyewa">Daftar Ruangan (user)</a>
        <a class="text-white  nav-link" href="/logout">Keluar</a>
    </nav>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EQBeqOJMW/xzPnfnvvQvORpLCzabw2aFUuHTI7sC9yXs5Ddq3HrLnGSs" crossorigin="anonymous"></script>

<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>
