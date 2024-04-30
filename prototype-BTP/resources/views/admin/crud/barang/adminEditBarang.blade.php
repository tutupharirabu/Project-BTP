@extends('admin.layouts.mainAdmin')
@section('containAdmin')
    <div class="container">
        <div class="card my-3">
            <div class="card-body">
                <a href="#" class="text-none align-middle text-dark">Assets</a><span class="text-secondary">/</span> <a href="/adminBarang" class="text-none align-middle text-dark">Barang</a><span class="text-secondary">/</span> <a href="{{ route('edit.adminBarang', $dataBarang->id_barang) }}" class="text-none align-middle text-dark">Edit Barang</a>
            </div>
        </div>

        <div class="card my-3">
            <div class="card-body">
                <form class="row g-3 needs-validation" action="{{ route('update.adminBarang', $dataBarang->id_barang) }}" method="POST" class="form-valid" enctype="multipart/form-data" novalidate>

                    @csrf
                    @method('PUT')
                    @if (isset($errors) && count($errors))

                        {{count($errors->all())}} Error(s)
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="col-md-6">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <select name="nama_barang" id="nama_barang" class="form-select">
                            <option selected value="{{ $dataBarang->nama_barang }}">{{ $dataBarang->nama_barang }}</option>
                            <option disabled value="">Pilih barang...</option>
                            <option value="Sound System">Sound System</option>
                            <option value="Kursi">Kursi</option>
                            <option value="Meja">Meja</option>
                            <option value="Proyektor">Proyektor</option>
                        </select>
                        <div class="invalid-feedback">
                            Isi nama barang!
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" value="{{ $dataBarang->jumlah_barang }}" required>
                        <div class="invalid-feedback">
                            Isi jumlah barang!
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="foto_barang" class="form-label">Foto Barang</label>
                        <input type="file" name="foto_barang" id="foto_barang" class="form-control">
                        <img src="{{ asset('storage/'.$dataBarang->foto_barang) }}" class="d-block w-50 mx-auto" alt="..." style="height: 200px">
                    </div>

                    <div class="col-12">
                        <a class="btn btn-danger" href="/adminBarang">Batalkan</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
