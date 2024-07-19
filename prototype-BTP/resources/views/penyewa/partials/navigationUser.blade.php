<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />

<!-- Custom CSS -->
<style>
    @media (min-width: 768px) {
        #navbarNavAltMarkup .navbar-nav {
            display: none;
            /* Hide on md, lg, xl screens */
        }
    }

    @media (max-width: 767.98px) {
        #navbarNavAltMarkup .navbar-nav {
            display: flex;
            /* Show on small screens */
        }
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary fixed-top" style="height:56px;">
    <!-- Container wrapper -->
    <div class="container-fluid">

        <!-- Toggler button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar brand -->
        <a class="navbar-brand mt-2 mt-lg-0" href="#" style="margin-left:20px;">
            <img src="{{ asset('assets/img/logospacerentwobg.png') }}" height="34" alt="MDB Logo" loading="lazy" />
        </a>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup" style="background-color: white; width:40px;">
            <div class="navbar-nav" style="width:20px;">
                <a class="nav-link" href="/dashboardPenyewa">Dashboard</a>
                <a class="nav-link" href="/daftarRuanganPenyewa">Daftar Ruangan</a>
                <a class="nav-link" href="/meminjamRuangan">Peminjaman</a>
            </div>
        </div>
        <!-- Collapsible wrapper -->

        <!-- Right elements -->
        <div class="d-flex align-items-center pe-5">
            <!-- Avatar -->
            <div class="dropdown">
                <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                    id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">

                    @auth
                        <span class="material-symbols-outlined"
                            style="margin-right: 5px; font-weight: 600;color: #2F3645;">person</span>
                        <p>
                            <center style="color: black">{{ Auth::user()->nama_lengkap }}</center>
                        </p>
                    @else
                        <a href="/login"
                            style="text-decoration: none; display: flex; align-items: center; color: #2F3645;">
                            <span class="material-symbols-outlined"
                                style="margin-right: 5px; font-weight: 600;">person</span>
                            <p style="margin: 0; font-weight: 600;">Login Khusus Untuk Petugas</p>
                        </a>
                    @endauth
                </a>
            </div>
        </div>
        <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EQBeqOJMW/xzPnfnvvQvORpLCzabw2aFUuHTI7sC9yXs5Ddq3HrLnGSs" crossorigin="anonymous"></script>

<!-- MDB JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>
