@extends('registersys.layouts.mainRegisterSys')
@section('containRegisterSys')
    <div class="bg-image">
        <div class="login-container">
            <div class="text-center pb-3">
                <img src="{{ asset('assets/img/logotelkombtp.png') }}" alt="Logo" style="max-width: 150px;">
            </div>
            <h3 class="text-center pb-3">Daftar</h3>
            <form class="row g-3 needs-validation" action="{{ route('posts.daftarPenyewa') }}" method="POST"
                class="form-valid" enctype="multipart/form-data" novalidate onsubmit="return validatePasswords()">

                @csrf
                <div class="col-md-12">
                    <label for="nama_lengkap" class="form-label thicker">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                        placeholder="Masukkan nama lengkap anda" required>
                    <div class="invalid-feedback">
                        Masukkan nama lengkap anda!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="username" class="form-label thicker">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        placeholder="Masukkan nama username anda" required>
                    <div class="invalid-feedback">
                        Masukkan username anda!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="email" class="form-labe thicker">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Masukkan email anda" required>
                    <div class="invalid-feedback">
                        Masukkan email anda!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form-label thicker">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" placeholder="Masukkan Password"
                            name="password" required>
                        <span class="input-group-text icon" id="id_icon"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="invalid-feedback">
                        Masukkan password anda!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="confirm_password" class="form-label thicker">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" placeholder="Masukkan Password"
                            name="confirm_password" required>
                        <span class="input-group-text icon" id="id_icon"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="invalid-feedback">
                        Masukkan password anda!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="role" class="form-label thicker">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option selected disabled value="">Pilih role anda</option>
                        <option value="penyewa">Penyewa</option>
                        <option value="petugas">Petugas</option>
                    </select>
                    <div class="invalid-feedback">
                        Masukkan role anda!
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                    <button type="submit" class="btn btnlog me-2">Daftar</button>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="d-flex align-items-center">
                        <h6>
                            <span>Sudah punya akun?</span>
                            <a href="/login" class="ms-2">Masuk</a>
                        </h6>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/8d372c01bd.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/showPassDaftar.js') }}"></script>

    <script>
        function validatePasswords() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert('Password dan Konfirmasi Kata Sandi harus sama!');
                return false;
            }
            return true;
        }
    </script>
@endsection
