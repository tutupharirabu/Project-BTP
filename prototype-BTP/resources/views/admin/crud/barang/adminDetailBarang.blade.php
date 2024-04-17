@extends('admin.layouts.mainAdmin')
@section('containAdmin')
    <div class="container">
        <div class="card my-3">
            <div class="card-body">
                <a href="#" class="text-none align-middle text-dark">Assets</a><span class="text-secondary">/</span> <a href="/adminBarang" class="text-none align-middle text-dark">Barang</a><span class="text-secondary">/</span> <a href="{{ route('detail.adminBarang', $dataBarang->id_barang) }}" class="text-none align-middle text-dark">Detail Barang</a>
            </div>
        </div>

        <div class="card my-3">
            <div class="card-body">
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{ asset('storage/'.$dataBarang->foto_barang) }}" class="d-block w-50 mx-auto" alt="..." style="height: 200px">
                      </div>
                    </div>
                </div>

                <div class="pt-5">
                    <h5>Detail Barang</h5>
                    <p>
                        Nama Barang <span>:</span> {{$dataBarang->nama_barang}} <br>
                        Jumlah <span>:</span> {{$dataBarang->jumlah_barang}}
                    </p>
                    <a href="/adminBarang" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
