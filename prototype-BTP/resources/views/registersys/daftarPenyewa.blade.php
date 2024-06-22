@extends('registersys.layouts.mainRegisterSys')
@section('containRegisterSys')

<div class="bg-image">
    <div class="login-container">
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
            <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                    placeholder="Masukkan nama username anda" required>
                <div class="invalid-feedback">
                    Masukkan username anda!
                </div>
            </div>
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
                    <button type="submit" class="btn btn-danger">Submit</button>
                    <a href="/" class="btn text-center btn-outline-danger">Batalkan</a>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    body, html {
        height: 100%;
        margin: 0;
    }

    .bg-image {
        background-image: url('https://sdgs.telkomuniversity.ac.id/wp-content/uploads/2024/03/DCS-Telkom-University-2-scaled.jpg');
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.8);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .login-container {
            width: 90%;
        }
    }

    @media (min-width: 769px) {
        .login-container {
            width: 40%;
        }
    }

    .thicker {
        font-weight: 700;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/8d372c01bd.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/showPassDaftar.js') }}"></script>
@endsection
