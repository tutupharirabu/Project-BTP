<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="container-fluid">
        <header class="p-3 mb-3 border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/userDashboard" class="d-flex mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap" viewBox="0 0 16 16">
                        <path d="M5.062 12h3.475c1.804 0 2.888-.908 2.888-2.396 0-1.102-.761-1.916-1.904-2.034v-.1c.832-.14 1.482-.93 1.482-1.816 0-1.3-.955-2.11-2.542-2.11H5.062zm1.313-4.875V4.658h1.78c.973 0 1.542.457 1.542 1.237 0 .802-.604 1.23-1.764 1.23zm0 3.762V8.162h1.822c1.236 0 1.887.463 1.887 1.348 0 .896-.627 1.377-1.811 1.377z"/>
                        <path d="M0 4a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4zm4-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V4a3 3 0 0 0-3-3z"/>
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                </form>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small" style="">
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/logout">Sign out</a></li>
                    </ul>
                </div>
                </div>
            </div>
        </header>
    </div>

    <div class="row text-center">
        <h3 class="m-3"> Database Peminjaman Ruangan </h3>
        <div class="col m-2">
            <table class="table table-bordered ">
                <thead>
                    <th scope="col"> Nama Peminjam </th>
                    <th scope="col"> Ruangan Yang Dipinjam </th>
                    <th scope="col"> Keperluan </th>
                    <th scope="col"> Jumlah Peserta + Panitia </th>
                    <th scope="col"> Tanggal Mulai </th>
                    <th scope="col"> Tanggal Berakhir </th>
                    <th scope="col"> Jam Mulai </th>
                    <th scope="col"> Jam Berakhir </th>
                    <th scope="col"> Penanggung Jawab </th>
                    <th scope="col"> Bukti </th>
                    <th scope="col"> Action </th>
                </thead>

                <tbody>
                    @foreach ($room_logs as $p)
                    <tr>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->room->title }}</td>
                        <td>{{ $p->keperluan }}</td>
                        <td>{{ $p->jumlahPesertaPanitia }}</td>
                        <td>{{ $p->borrow_date_start }}</td>
                        <td>{{ $p->borrow_date_end }}</td>
                        <td>{{ $p->jam_mulai }}</td>
                        <td>{{ $p->jam_berakhir }}</td>
                        <td>{{ $p->penanggungjawab }}</td>
                        <td>{{ $p->link }}</td>
                        <td>
                            <a href=""><button class="btn btn-success">Approve</button></a>
                            <a href=""><button class="btn btn-danger">Remove</button></a>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>
