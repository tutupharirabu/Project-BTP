<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details td {
            padding: 5px;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items th,
        .items td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>
                Invoice Space Rent BTP
                <span>
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo_nav.png'))) }}"
                        height="34" alt="MDB Logo" loading="lazy" />
                </span>
            </h1>
        </div>
        <div class="details">
            <table>
                <tr>
                    <td><strong>Nomor invoice:</strong></td>
                    <td>{{ $data->invoice }}</td>
                </tr>
                <tr>
                    <td><strong>Nama peminjam:</strong></td>
                    <td>{{ $data->nama_peminjam }}</td>
                </tr>
                <tr>
                    <td><strong>Ruangan yang dipinjam:</strong></td>
                    <td>{{ $data->ruangan->nama_ruangan }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal mulai:</strong></td>
                    <td>{{ Carbon\Carbon::parse($data->tanggal_mulai)->format('d-m-Y | H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal selesai:</strong></td>
                    <td>{{ Carbon\Carbon::parse($data->tanggal_selesai)->format('d-m-Y | H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Total harga yang dibayarkan:</strong></td>
                    <td>{{ $data->harga_ppn }}</td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td>{{ $data->status }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
