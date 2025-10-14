<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <!-- Bootstrap CSS (gunakan CDN atau file lokal sesuai kebutuhan) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 60px;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar py-3 px-3">
                <h5>Admin Menu</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/blacklisted-words') }}">Manajemen Kata Terblokir</a>
                    </li>
                    <!-- Tambahkan menu lain di sini -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboardAdmin') }}">Kembali ke Dashboard</a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS (opsional jika perlu komponen interaktif) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
