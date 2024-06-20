@extends('penyewa.layouts.mainPenyewa')

@section('containPenyewa')
    <div class="container-fluid mt-4">
        <!-- Judul -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container mx-2">
                    <h4>Daftar Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- href ui -->
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="container my-2 mx-2">
                    <h6 href="" style="color: red;font-size:12px;">Daftar Ruangan<h4>
                </div>
            </div>
        </div>

        <!-- Card Room-->
        <div class="container">
            <div class="row justify-content-sm-center text-center text-dark">
                @foreach ($dataRuangan as $ruangan)
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="card my-3 mx-2 shadow card-fixed" style="height:22rem; width:18rem;">
                            @foreach ($ruangan->gambar as $gambar)
                                <img src="{{ asset('assets/' . $gambar->url) }}" class="card-img-top" style=""
                                    alt="Gambar Ruangan">
                            @endforeach
                            <div class="card-body">
                                <h5 class="card-title">{{ $ruangan->nama_ruangan }}</h5>
                                <p class="card-text">
                                    @if (
                                        $ruangan->nama_ruangan == 'Rent Office (Private Space)' ||
                                            $ruangan->nama_ruangan == 'Coworking Space (Shared Space)' ||
                                            $ruangan->nama_ruangan == 'Coworking Space (Private Room)')
                                        Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }} Seat / Bulan
                                    @elseif ($ruangan->nama_ruangan == 'Virtual Office')
                                        Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }} Perusahaan / Bulan
                                    @elseif (
                                        $ruangan->nama_ruangan == 'Multimedia' ||
                                            $ruangan->nama_ruangan == 'Aula' ||
                                            $ruangan->nama_ruangan == 'R. Meeting' ||
                                            $ruangan->nama_ruangan == 'Training Room')
                                        Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }} Halfday / 4 Jam
                                    @else
                                        Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }} / Jam
                                    @endif
                                </p>
                                <div class="status-group">
                                    @if ($ruangan->tersedia == '1')
                                        <span class="status-available">Tersedia</span>
                                    @else
                                        <span class="status-not-available">Digunakan</span>
                                    @endif
                                    <a href="{{ route('detailRuanganPenyewa', $ruangan->id_ruangan) }}"
                                        class="btn btn-dark shadow-none status-detail">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Style bro -->
    <style>
        .card h5 {
            font-size: 18px;
            margin-top: -1rem;
            margin-bottom: 0.5rem;
        }

        .card img {
            margin-bottom: 0.5rem;
            /* Mengurangi jarak bawah gambar */
        }

        .status-detail {
            background-color: green;
            margin-bottom: 8px;
            /* Adjusted margin for spacing between the elements */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0;
            border-radius: 10px;
            height: 36px;
            width: 60%;
        }

        .status-detail {
            background-color: #000;
            margin-bottom: 0;
            /* Remove bottom margin for the last element */
        }

        .status-group {
            display: flex;
            flex-direction: column;
            /* Changed to column to stack elements vertically */
            align-items: center;
            margin-top: 0.5rem;
        }

        .status-available {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #071FF2;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 14px;
        }

        .status-not-available {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #717171;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 14px;
        }
    </style>
@endsection
