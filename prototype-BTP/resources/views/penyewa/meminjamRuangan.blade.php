{{-- @extends('penyewa.layouts.mainPenyewa')
@section('containPenyewa')
    <div class="container">
        <div class="card my-3">
            <div class="card-body">
                <a href="#" class="text-none align-middle text-dark">Daftar Meminjam Ruangan</a>
            </div>
        </div>

        <div class="card my-3">
            <div class="card-body">
                <form class="row g-3 needs-validation" action="{{ route('posts.daftarMeminjamRuangan') }}" method="POST"
                    class="form-valid" enctype="multipart/form-data" novalidate>

                    @csrf
                    @if (isset($errors) && count($errors))
                        {{ count($errors->all()) }} Error(s)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                        <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman"
                            required>
                        <div class="invalid-feedback">
                            Isi tanggal mulai meminjam anda!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai Meminjam</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                        <div class="invalid-feedback">
                            Isi tanggal selesai meminjam anda!
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="jumlah_pengguna" class="form-label">Jumlah Pengguna</label>
                        <input type="number" class="form-control" id="jumlah_pengguna" name="jumlah_pengguna" required>
                        <div class="invalid-feedback">
                            Isi jumlah pengguna yang akan meminjam ruangan anda!
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="id_penyewa" class="form-label">Nama Lengkap</label>
                        <input type="text" name="id_penyewa" id="id_penyewa" value="{{ Auth::guard('penyewa')->id() }}"
                            class="form-control" hidden>
                        <input type="text" value="{{ Auth::guard('penyewa')->user()->nama_lengkap }}"
                            class="form-control" disabled>
                    </div>
                    <div class="col-md-5">
                        <label for="id_ruangan" class="form-label">Nama Ruangan</label>
                        <select name="id_ruangan" id="id_ruangan" class="form-select">
                            @foreach ($dataRuangan as $ruangan)
                                <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->nama_ruangan }}
                                    ({{ $ruangan->kapasitas_ruangan }})</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Pilih ruangan anda!
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection --}}

@extends('penyewa.layouts.mainPenyewa')
@section('containPenyewa')
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker1').datetimepicker();
        });
    </script>
    {{-- ruangan --}}
    <div class="d-flex align-items-center py-4 font-monospace">
        <div class="container-sm">
            <h1 class="text-center pb-3">Form Sewa Ruangan</h1>
            <form class="row g-3 needs-validation" action="{{ route('posts.daftarPenyewa') }}" method="POST" class="form-valid"
                enctype="multipart/form-data" novalidate>

                @csrf
                <div class="col-md-6">
                    <label for="ruang" class="form-label">Ruangan</label>
                    <select name="ruang" id="ruang" class="form-select">
                        <option selected disabled value="">Pilih ruangan</option>
                        {{-- <option value="penyewa">Penyewa</option>
                            <option value="petugas">Petugas</option> --}}
                    </select>
                    <div class="invalid-feedback">
                        Masukkan ruangan anda!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="peserta" class="form-label">Jumlah Peserta</label>
                    <input type="number" name="peserta" id="peserta" class="date form-control" max="50"
                        min="0" placeholder="Masukkan Jumlah Peserta" required>
                    <div class="invalid-feedback">
                        Masukkan Jumlah Peserta!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" name="startDate" id="startDate" class="date form-control"
                        placeholder="Masukkan tanggal mulai" required>
                    <div class="invalid-feedback">
                        Masukkan tanggal mulai!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" name="endDate" id="endDate" class="date form-control"
                        placeholder="Masukkan tanggal selesai" required>
                    <div class="invalid-feedback">
                        Masukkan tanggal selesai!
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    @endsection
