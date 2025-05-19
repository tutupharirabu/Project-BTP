@extends('penyewa.layouts.mainPenyewa')
@section('containPenyewa')

    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/penyewa/daftarRuangan.css') }}">
        <script defer src="https://umami.tutupharirabu.cloud/script.js"
            data-website-id="6552bf4a-7391-40fb-8e93-e35363bb72f5"></script>
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
                            @if ($ruangan->gambars->isNotEmpty())
                                            <img src="{{ asset(
                                    $ruangan->gambars->sortBy(function ($gambar) {
                                        preg_match('/_image_(\d+)/', $gambar->url, $matches);
                                        return isset($matches[1]) ? (int) $matches[1] : 999;
                                    })->first()->url,
                                ) }}" class="card-img-top custom-img" alt="Gambar Ruangan" style="height: 300px;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $ruangan->nama_ruangan }}</h5>
                                <p class="card-text">
                                    Rp {{ number_format((int) $ruangan->harga_ruangan, 0, ',', '.') }}
                                    {{ $ruangan->satuan }}
                                </p>
                                <div class="status-group">
                                    @if ($ruangan->status == 'Tersedia')
                                        <span class="status-available">Tersedia</span>
                                    @else
                                        <span class="status-not-available">Digunakan</span>
                                    @endif
                                    <a href="{{ route('penyewa.detailRuangan', $ruangan->id_ruangan) }}"
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