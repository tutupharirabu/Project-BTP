@extends('registersys.layouts.mainRegisterSys')
@section('containRegisterSys')
    <div class="d-flex align-items-center py-4 font-monospace">
        <div class="container-sm">
            <h1 class="text-center pb-3">Form Daftar Penyewa Ruangan</h1>
            <form class="row g-3 needs-validation" action="{{ route('posts.daftarPenyewa') }}" method="POST" class="form-valid"
                enctype="multipart/form-data" novalidate>

                @csrf
                <div class="col-md-12">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                        placeholder="Masukkan nama lengkap anda" required>
                    <div class="invalid-feedback">
                        Masukkan nama lengkap anda!
                    </div>
                </div>
                {{-- <div class="col-md-4">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option selected disabled value="">Pilih jenis kelamin anda...</option>
                    <option value="male">Laki-Laki</option>
                    <option value="female">Perempuan</option>
                  </select>
                  <div class="invalid-feedback">
                    Pilih jenis kelamin anda!
                  </div>
                </div> --}}
                <div class="col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        placeholder="Masukkan nama username anda" required>
                    <div class="invalid-feedback">
                        Masukkan username anda!
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <label for="status" class="form-label">Status pekerjaan</label>
                    <select name="status" id="status" class="form-select">
                        <option selected disabled value="">Pilih status pekerjaan anda...</option>
                        <option value="internal">Ditmawa</option>
                        <option value="internal">Dosen</option>
                        <option value="eksternal">Mahasiswa</option>
                        <option value="eksternal">Lainnya</option>
                    </select>
                    <div class="invalid-feedback">
                      Masukkan status pekerjaan anda!
                    </div>
                </div> --}}
                {{-- <div class="col-md-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" style="height: 100px"
                        placeholder="Masukkan alamat anda" required></textarea>
                    <div class="invalid-feedback">
                        Masukkan alamat anda!
                    </div>
                </div> --}}
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Masukkan email anda" required>
                    <div class="invalid-feedback">
                        Masukkan email anda!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="inputpassword" placeholder="Masukkan Password"
                            name="password">
                        <span class="input-group-text icon" id="id_icon"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="invalid-feedback">
                        Masukkan password anda!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select">
                        <option selected disabled value="">Pilih role anda</option>
                        <option value="penyewa">Penyewa</option>
                        <option value="petugas">Petugas</option>
                    </select>
                    <div class="invalid-feedback">
                        Masukkan role anda!
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="/" class="btn text-center btn-outline-danger">Batalkan</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/8d372c01bd.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/showPassDaftar.js') }}"></script>
@endsection
