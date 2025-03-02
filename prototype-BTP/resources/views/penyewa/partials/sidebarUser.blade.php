<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EQBeqOJMW/xzPnfnvvQvORpLCzabw2aFUuHTI7sC9yXs5Ddq3HrLnGSs"
        crossorigin="anonymous"></script>
    <!-- MDB -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
    <!-- logo google and friend -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script defer src="https://umami-web-analytics.tutupharirabu.cloud/script.js"
        data-website-id="7a76e24b-1d1b-4594-8a26-7fcc2765570a"></script>
</head>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-lg-2 sidebar d-none d-md-block d-flex flex-column"
            style="background-color: #419343; color: #FFFFFF;">
            <nav class="nav flex-column mt-2">
                <div class="m-1">
                    <a class="text-white nav-link d-flex align-items-center menu-item" href="/dashboardPenyewa">
                        <i class="material-symbols-outlined me-2">space_dashboard</i>
                        <span>Dashboard</span>
                    </a>
                </div>
                <div class="m-1">
                    <a class="text-white nav-link d-flex align-items-center menu-item" href="/daftarRuanganPenyewa">
                        <i class="material-symbols-outlined me-2">view_list</i>
                        <span>Daftar Ruangan</span>
                    </a>
                </div>
                <div class="m-1">
                    <a class="text-white nav-link d-flex align-items-center menu-item" href="/meminjamRuangan">
                        <i class="material-symbols-outlined me-2">description</i>
                        <span>Peminjaman/Penyewaan Ruangan</span>
                    </a>
                </div>
                <div class="m-1">
                    <a class="text-white nav-link d-flex align-items-center menu-item" href="/statusPenyewa">
                        <i class="material-symbols-outlined me-2">checklist</i>
                        <span>Lihat Status Peminjaman/Penyewaan Ruangan</span>
                    </a>
                </div>
                @auth
                    <div class="m-1">
                        <a class="text-white nav-link d-flex align-items-center menu-item" href="/logout">
                            <i class="material-symbols-outlined me-2">logout</i>
                            <span>Keluar</span>
                        </a>
                    </div>
                @endauth
            </nav>
        </div>
    </div>
</div>

<style>
    .sidebar {
        margin-top: 56px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        background-color: ;
    }

    .menu-item {
        transition: background-color 0.3s, color 0.3s;
        border-radius: 5px;
    }

    .menu-item:hover {
        background-color: white !important;
        color: #028391 !important;
        border-radius: 5px;
    }

    .menu-item:hover .material-symbols-outlined {
        color: #028391 !important;
        border-radius: 5px;
    }

    .menu-item.active {
        background-color: white !important;
        color: #028391 !important;
        border-radius: 5px;
    }

    .menu-item.active .material-symbols-outlined {
        color: #028391 !important;
        border-radius: 5px;
    }
</style>

<script>
    function setActiveMenu() {
        const menuItems = document.querySelectorAll('.menu-item');
        const currentPath = window.location.pathname;

        menuItems.forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }
    document.addEventListener('DOMContentLoaded', setActiveMenu);
</script>