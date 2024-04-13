@extends('admin.layouts.mainAdmin')
@section('containAdmin')
    <div class="container">
        <div class="card my-3">
            <div class="card-body">
                <a href="#" class="text-none align-middle text-dark">Assets</a><span class="text-secondary">/</span> <a href="/adminRuangan" class="text-none align-middle text-dark">Ruangan</a><span class="text-secondary">/</span> <a href="/adminRuangan/tambahRuangan" class="text-none align-middle text-dark">Tambah Ruangan</a>
            </div>
        </div>

        <div class="card my-3">
            <div class="card-body">
                <form class="row g-3 needs-validation" action="{{ route('update.adminRuangan', $dataRuangan->id_ruangan) }}" method="POST" class="form-valid" enctype="multipart/form-data" novalidate>

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
                      <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                      <select name="nama_ruangan" id="nama_ruangan" class="form-select">
                        <option selected value="{{$dataRuangan->nama_ruangan}}">{{$dataRuangan->nama_ruangan}}</option>
                        <option disabled value="">Pilih ruangan...</option>
                        <option value="Rent Office (Private Space)">Rent Office (Private Space)</option>
                        <option value="Coworking Space (Shared Space)">Coworking Space (Shared Space)</option>
                        <option value="Coworking Space (Private Room)">Coworking Space (Private Room)</option>
                        <option value="Virtual Room">Virtual Room</option>
                        <option value="Virtual Office">Virtual Office</option>
                        <option value="Multimedia">Multimedia</option>
                        <option value="Aula">Aula</option>
                        <option value="R. Meeting">R. Meeting</option>
                        <option value="Training Room">Training Room</option>
                        <option value="Overtime Room">Overtime Room</option>
                      </select>
                      <div class="invalid-feedback">
                        Isi nama ruangan!
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="kapasitas_ruangan" class="form-label">Kapasitas Ruangan</label>
                      <input type="number" class="form-control" id="kapasitas_ruangan" name="kapasitas_ruangan" value="{{$dataRuangan->kapasitas_ruangan}}" required>
                      <div class="invalid-feedback">
                        Isi kapasitas ruangan!
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label for="foto_ruangan" class="form-label">Foto ruangan</label>
                        <input type="file" name="foto_ruangan" id="foto_ruangan" class="form-control">
                        <img src="{{asset('storage/'. $dataRuangan->foto_ruangan)}}" alt="" style="width: 250px; height:250px;">
                    </div>
                    <div class="col-md-6">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <select name="lokasi" id="lokasi" class="form-select">
                            <option selected value="{{$dataRuangan->lokasi}}">{{$dataRuangan->lokasi}}</option>
                            <option disabled value="">Pilih lokasi...</option>
                            <option value="Gedung A">Gedung A</option>
                            <option value="Gedung B Lt. 1">Gedung B Lt. 1</option>
                            <option value="Gedung B Lt. 2">Gedung B Lt. 2</option>
                            <option value="Gedung B dan C">Gedung B dan C</option>
                            <option value="Gedung C Lt. 2'">Gedung C Lt. 2'</option>
                            <option value="Gedung D Lt. 2">Gedung D Lt. 2</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <a class="btn btn-danger" href="/adminRuangan">Batalkan</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
