<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
<!-- logo google and friend -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<div class="col-md-2 col-lg-2 d-none d-md-block d-flex flex-column" style="background-color: #ed3c35; color: #FFFFFF;">
    <nav class="nav flex-column">
        <div class="m-1">
            <a class="text-white nav-link d-flex align-items-center menu-item" href="/dashboardPenyewa">
                <i class="material-symbols-outlined me-2">space_dashboard</i>
                <span>Dashboard</span>
            </a>
        </div>
        <div class="m-1">
            <a class="text-white nav-link d-flex align-items-center menu-item" href="/statusRuanganAdmin">
                <i class="material-symbols-outlined me-2">view_list</i>
                <span>Daftar Ruangan</span>
            </a>
        </div>
        <div class="m-1">
            <a class="text-white nav-link d-flex align-items-center menu-item" href="/statusPengajuanAdmin">
                <i class="material-symbols-outlined me-2">check_circle</i>
                <span>Status Pengajuan</span>
            </a>
        </div>
        <div class="m-1">
            <a class="text-white nav-link d-flex align-items-center menu-item" href="/daftarRuanganPenyewa">
                <i class="material-symbols-outlined me-2">view_list</i>
                <span>Daftar Ruangan (user)</span>
            </a>
        </div>
        <div class="m-1">
            <a class="text-white nav-link d-flex align-items-center menu-item" href="/logout">
                <i class="material-symbols-outlined me-2">logout</i>
                <span>Keluar</span>
            </a>
        </div>
    </nav>
</div>

<style>
    .menu-item {
        transition: background-color 0.3s, color 0.3s;
        border-radius: 5px;
    }
    .menu-item:hover {
        background-color: white !important;
        color: #000 !important;
        border-radius: 5px;
    }
    .menu-item:hover .material-symbols-outlined {
        color: #000 !important;
        border-radius: 5px;
    }
    .menu-item.active {
        background-color: white !important;
        color: #000 !important;
        border-radius: 5px;
    }
    .menu-item.active .material-symbols-outlined {
        color: #000 !important;
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EQBeqOJMW/xzPnfnvvQvORpLCzabw2aFUuHTI7sC9yXs5Ddq3HrLnGSs" crossorigin="anonymous"></script>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>


<!-- <div class="col-md-2 col-lg-2 d-none d-md-block d-flex flex-column" style="background-color: #ed3c35; color: #FFFFFF">
    <nav class="nav flex-column">
        <a class="text-white nav-link active d-flex align-items-center" href="/dashboardPenyewa">
            <i class="material-symbols-outlined">space_dashboard</i>
            <span class="ms-2">Dashboard</span>
        </a>
        <a class="text-white nav-link d-flex align-items-center" href="/statusRuanganAdmin">
            <i class="material-symbols-outlined">view_list</i>
            <span class="ms-2">Daftar Ruangan</span>
        </a>
        <a class="text-white nav-link d-flex align-items-center" href="/statusPengajuanAdmin">
            <i class="material-symbols-outlined">check_circle</i>
            <span class="ms-2">Status Pengajuan</span>
        </a>
        <a class="text-white nav-link d-flex align-items-center" href="/statusRuanganPenyewa">
            <i class="material-symbols-outlined">view_list</i>
            <span class="ms-2">Daftar Ruangan (user)</span>
        </a>
        <a class="text-white nav-link d-flex align-items-center" href="/logout">
            <i class="material-symbols-outlined">logout</i>
            <span class="ms-2">Keluar</span>
        </a>
    </nav>
</div> -->
