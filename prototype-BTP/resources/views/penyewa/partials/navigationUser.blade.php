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
        .navbar-brand {
            display: block !important;
            /* Show brand on larger screens */
        }
        #navbarRightElements {
            position: absolute;
            right: 0;
        }
    }

    @media (max-width: 767.98px) {
        #navbarNavAltMarkup .navbar-nav {
            display: flex;
        }
        .navbar-brand {
            display: none !important;
            /* Hide brand on small screens */
        }
        #navbarRightElements {
            position: static;
        }
    }

    /* Ensure the right elements stay on top when the navbar is collapsed */
    .navbar-collapse.show ~ #navbarRightElements {
        display: block;
        width: 100%;
        text-align: right;
        background-color: white;
        padding-right: 1rem;
        z-index: 1000;
    }

    .logo-style{
        font-size:15px; color:#0B3932; font-weight: bold;
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
            <img src="{{ asset('assets/img/logo_nav.png') }}" height="34" alt="MDB Logo" loading="lazy" />
        </a>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup" style="background-color: white; width:30px;" >
            <div class="navbar-nav" style="width:20px; margin-left:20px; text-bold ">
                <a class="nav-link" href="/dashboardPenyewa" style="font-weight: 900;">Dashboard</a>
                <a class="nav-link" href="/daftarRuanganPenyewa" style="font-weight: 900;">Daftar Ruangan</a>
                <a class="nav-link" href="/meminjamRuangan" style="font-weight: 900;">Peminjaman</a>
            </div>
        </div>
        
        <!-- Right elements -->
        <div class="fixed-right d-flex align-items-center pe-5" id="navbarRightElements" style="background-color: #FFFFFF;">
            <!-- Avatar -->
            <div class="dropdown">
                <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                    id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @auth
                        <span class="material-symbols-outlined" style="margin-right: 5px; font-weight: 600;color: #2F3645;">person</span>
                        <p>
                            <center style="color: black">{{ Auth::user()->nama_lengkap }}</center>
                        </p>
                    @else
                        <a href="/login" style="text-decoration: none; display: flex; align-items: center; color: #2F3645;">
                            <span class="material-symbols-outlined" style="margin-right: 5px; font-weight: 600;">person</span>
                            <p style="margin: 0; font-weight: 600;">Login Khusus Untuk Petugas</p>
                        </a>
                    @endauth
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuAvatar">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarRightElements = document.getElementById('navbarRightElements');

        navbarToggler.addEventListener('click', function () {
            const navbarCollapse = document.getElementById('navbarNavAltMarkup');
            if (navbarCollapse.classList.contains('show')) {
                navbarRightElements.style.display = 'none';
            } else {
                navbarRightElements.style.display = 'flex';
            }
        });
    });
</script>
