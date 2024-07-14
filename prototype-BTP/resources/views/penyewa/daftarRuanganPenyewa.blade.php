@extends('penyewa.layouts.mainPenyewa')

@section('containPenyewa')

    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/penyewa/daftarRuangan.css') }}">
    </head>
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
                    <h6 href="" style="color: #028391;font-size:12px;">Daftar Ruangan<h4>
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
                                <img src="{{ asset('assets/' . $gambar->url) }}" class="card-img-top custom-img"
                                    alt="Gambar Ruangan">
                            @endforeach
                            <div class="card-body">
                                <h5 class="card-title">{{ $ruangan->nama_ruangan }}</h5>
                                <p class="card-text">
                                    @if (
                                        $ruangan->nama_ruangan == 'Rent Office (Private Space)' ||
                                            $ruangan->nama_ruangan == 'Coworking Space (Shared Space)' ||
                                            $ruangan->nama_ruangan == 'Coworking Space (Private Room)')
                                        Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }}
                                        {{ $ruangan->satuan }}
                                    @elseif ($ruangan->nama_ruangan == 'Virtual Office')
                                        Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }}
                                        {{ $ruangan->satuan }}
                                    @elseif (
                                        $ruangan->nama_ruangan == 'Multimedia' ||
                                            $ruangan->nama_ruangan == 'Aula' ||
                                            $ruangan->nama_ruangan == 'R. Meeting' ||
                                            $ruangan->nama_ruangan == 'Training Room')
                                        Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }}
                                        {{ $ruangan->satuan }}
                                    @else
                                        Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }}
                                        {{ $ruangan->satuan }}
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

    <style>
        .custom-img {
            max-height: 200px;
            width: auto;
        }
    </style>
@endsection
