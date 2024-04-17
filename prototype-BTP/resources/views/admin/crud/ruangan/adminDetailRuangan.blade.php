@extends('admin.layouts.mainAdmin')
@section('containAdmin')
    <div class="container">
        <div class="card my-3">
            <div class="card-body">
                <a href="#" class="text-none align-middle text-dark">Assets</a><span class="text-secondary">/</span> <a href="/adminRuangan" class="text-none align-middle text-dark">Ruangan</a><span class="text-secondary">/</span> <a href="{{ route('detail.adminRuangan', $dataRuangan->id_ruangan) }}" class="text-none align-middle text-dark">Detail ruangan</a>
            </div>
        </div>

        <div class="card my-3">
            <div class="card-body">
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{ asset('storage/'.$dataRuangan->foto_ruangan) }}" class="d-block w-50 mx-auto" alt="..." style="height: 200px">
                      </div>
                    </div>
                </div>
                <div class="pt-5">
                    <h5>Detail Ruangan</h5>
                    <p>
                        Nama Ruangan <span>:</span> {{$dataRuangan->nama_ruangan}} <br>
                        Nama Gedung <span>:</span> {{$dataRuangan->lokasi}} <br>
                        Kapasitas <span>:</span> {{$dataRuangan->kapasitas_ruangan}}
                    </p>
                    <a href="/adminRuangan" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
