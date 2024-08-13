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
            <table style="border: none; width: 100%; margin-bottom: 30px;">
                <tr>
                    <td style="text-align: left;">
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/LogoBTP.png'))) }}"
                            height="34" alt="MDB Logo" loading="lazy" />
                    </td>
                    <td style="text-align: center;">
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logospacerent.png'))) }}"
                            height="34" alt="MDB Logo" loading="lazy" />
                    </td>
                    <td style="text-align: right;">
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/LogoTelkom.png'))) }}"
                            height="34" alt="MDB Logo" loading="lazy" />
                    </td>
                </tr>
            </table>
            <h1>
                INVOICE
            </h1>
        </div>
        <div style="margin-bottom: 100px">
            <table style="float: right; border: 1px solid black; border-collapse: collapse;">
                <tr>
                    <td style="border: 1px solid black; padding: 5px; text-align: center">Date No.</td>
                    <td style="border: 1px solid black; padding: 5px; text-align: center">Invoice No.</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; text-align: center">
                        {{ Carbon\Carbon::parse($data->created_at)->locale('id_ID')->translatedFormat('d F Y') }}</td>
                    <td style="border: 1px solid black; padding: 5px; text-align: center">027/TNT05-07/TESTAJA/2024</td>
                </tr>
            </table>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td><strong>Nama peminjam</strong></td>
                    <td>:</td>
                    <td>{{ $data->nama_peminjam }}</td>
                </tr>
                <tr>
                    <td><strong>Ruangan yang dipinjam</strong></td>
                    <td>:</td>
                    <td>{{ $data->ruangan->nama_ruangan }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal mulai</strong></td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($data->tanggal_mulai)->format('d-m-Y | H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal selesai</strong></td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($data->tanggal_selesai)->format('d-m-Y | H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Total harga yang dibayarkan</strong></td>
                    <td>:</td>
                    <td>{{ $data->total_harga }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>:</td>
                    <td>{{ $data->status }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
