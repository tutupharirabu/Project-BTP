@extends('loginsys.layouts.mainLoginSys')
@section('containLoginSys')
    <div class="bg-image">
        <div class="login-container">
            {{-- Alert sukses (OTP terkirim) --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Alert error (OTP tidak valid) --}}
            @if ($errors->has('otp'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('otp') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="text-center pb-3">
                <a href="/dashboardPenyewa">
                    <img src="{{ asset('assets/img/logo_nav.png') }}" alt="Logo" style="max-width: 150px;">
                </a>
            </div>

            <h3 class="text-center pb-3">Kode OTP</h3>
            <p class="text-center">Silakan masukkan kode OTP yang dikirim ke email Anda</p>

            <form class="row g-3 needs-validation" action="{{ route('posts.otp') }}" method="POST" novalidate>
                @csrf
                <div class="col-md-12">
                    <label for="otp" class="form-label thicker">Kode OTP</label>
                    <div class="input-group">
                        <input type="text" name="otp" id="otp" class="form-control @error('otp') is-invalid @enderror"
                               required style="border-radius: 5px;" placeholder="Masukkan 6 digit OTP">
                        <div class="invalid-feedback">
                            @error('otp') {{ $message }} @else Kode OTP wajib diisi. @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-center">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btnlog mx-auto">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

    <script>
        (function () {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
        })();
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/8d372c01bd.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/showPassDaftar.js') }}"></script>
@endsection

{{-- 
                <div class="col-md-12">
                    <label for="password" class="form-label thicker">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="inputpassword" placeholder="Masukkan Password"
                            name="password" required>
                        <span class="input-group-text icon" id="password_toggle" style="border-top-right-radius:5px; border-bottom-right-radius:5px"><i class="fa-regular fa-eye"
                                id="password_icon"></i></span>
                        <div class="invalid-feedback">
                            Masukkan Password Anda!
                        </div>
                    </div>
                </div>
 --}}