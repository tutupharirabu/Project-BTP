<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
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
        data-website-id="c5e87046-42e9-4b5f-b09e-acec20d1e4f6"></script>
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
                {{-- <div class="m-1">
                    <a class="text-white nav-link d-flex align-items-center menu-item" href="/meminjamRuangan">
                        <i class="material-symbols-outlined me-2">description</i>
                        <span>Peminjaman/Penyewaan Ruangan</span>
                    </a>
                </div> --}}
                {{-- <div class="m-1">
                    <a class="text-white nav-link d-flex align-items-center menu-item" href="/statusPengajuanPenyewa">
                        <i class="material-symbols-outlined me-2">checklist</i>
                        <span>Lihat Status Peminjaman/Penyewaan Ruangan</span>
                    </a>
                </div> --}}

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
            const href = item.getAttribute('href');
            // Check for exact match OR prefix match for Daftar Ruangan
            if (
                href === currentPath ||
                (href === '/daftarRuanganPenyewa' && (
                    currentPath.startsWith('/detailRuangan') ||
                    currentPath.startsWith('/meminjamRuangan/')
                ))
            ) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }
    document.addEventListener('DOMContentLoaded', setActiveMenu);
</script>