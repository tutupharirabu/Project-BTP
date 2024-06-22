@extends('loginsys.layouts.mainLoginSys')
@section('containLoginSys')

<div class="bg-image">
    <div class="login-container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h3 class="text-center pb-3">Masuk</h3>
        <p class="text-center">Hi! selamat datang di website peminjaman Bandung Techno Park</p>
        <form class="row g-3 needs-validation" action="{{ route('posts.login') }}" method="POST" class="form-valid"
            enctype="multipart/form-data" novalidate>
            @csrf
            <div class="col-md-12">
                <label for="email" class="form-label thicker">Email</label>
                <div class="input-group">
                    <!-- <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span> -->
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Masukkan Email Anda!" required>
                    <div class="invalid-feedback">
                        Masukkan Email Anda!
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <label for="password" class="form-label thicker">Password</label>
                <div class="input-group">
                    <!-- <span class="input-group-text"><i class="fa-solid fa-lock"></i></span> -->
                    <input type="password" class="form-control" id="inputpassword" placeholder="Masukkan Password!" name="password">
                    <div class="invalid-feedback">
                        Masukkan password anda!
                    </div>
                </div>
            </div>

            <div class="col-md-12 text-end">
                <h6><a href="" class="text-reset">Lupa kata sandi?</a></h6>
            </div>

            <div class="col-md-12 d-flex justify-content-center">
                <div class="d-grid gap-2 w-100">
                    <button type="submit" class="btn btnlog mx-auto">Masuk</button>
                </div>
            </div>
            <div class="col-md-12 text-center mt-3">
                <h6>Belum memiliki akun? <a href="/daftarPenyewa">Daftar</a></h6>
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
        .login-container{
            width: 40%;
        }
    }

    .thicker {
        font-weight: 700;
    }

    .btnlog {
        background-color: #FF0000;
        color: white;
        width: 100px;
        font-weight: 600;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/8d372c01bd.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/showPassDaftar.js') }}"></script> 

@endsection
