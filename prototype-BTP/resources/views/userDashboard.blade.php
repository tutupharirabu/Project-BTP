@extends('penyewa.layouts.mainPenyewa')
@section('containPenyewa')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Weekly Schedule</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .event {
                background-color: #f0f8ff;
                border-left: 4px solid #4682b4;
                margin-bottom: 5px;
                padding: 5px;
                font-size: 0.9em;
            }

            .day-column {
                min-height: 300px;
                background-color: #f9f9f9;
                border: 1px solid #ddd;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid mt-4">
            <!-- Judul -->
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="container mx-2">
                        <h4>Dashboard</h4>
                    </div>
                </div>
            </div>

            <!-- href ui -->
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="container my-2 mx-2">
                        <h6 href="" style="color: red;font-size:12px;">Dashboard</h4>
                    </div>
                </div>
            </div>

            <div class="p-3 border mb-2"
                style="border: 6px solid #61677A; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                <h2 class="mb-4">Peminjaman</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Ruangan</th>
                            <th>Barang</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPeminjaman as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->nama_peminjam }}</td>
                                <td>{{ $peminjaman->ruangan ? $peminjaman->ruangan->nama_ruangan : '-' }}</td>
                                <td>{{ $peminjaman->barang ? $peminjaman->barang->nama_barang : '-' }}</td>
                                <td>{{ $peminjaman->tanggal_mulai }}</td>
                                <td>{{ $peminjaman->tanggal_selesai }}</td>
                                <td>{{ $peminjaman->jumlah }}</td>
                                <td>{{ $peminjaman->status }}</td>
                                <td>{{ $peminjaman->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>

    </html>
@endsection
