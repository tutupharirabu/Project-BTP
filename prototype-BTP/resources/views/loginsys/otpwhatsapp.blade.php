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
            <p class="text-center">Silakan masukkan kode OTP yang dikirim ke Whatsapp Anda</p>

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
                <p>Kode OTP berlaku selama <span id="countdown"></span></p>
                <p class="mt-3 text-sm">
                    Tidak menerima kode? 
                    <a href="{{ route('resend.otp') }}" class="text-blue-500 hover:underline">Kirim ulang OTP</a>
                </p>
                <p class="mt-3 text-sm">
                    Kirim kode OTP dengan metode lainnya 
                    <div class="d-flex gap-2 mt-2">
                        <form action="{{ route('posts.otp') }}" method="POST">
                            @csrf
                            <button type="submit" style="background:#0c9300; color:white; border:none; border-radius:6px; padding:6px 12px; font-size:14px; cursor:pointer;">
                            Kirim Via Email
                            </button>
                        </form>
                        <form action="#" method="POST">
                            @csrf
                            <button type="submit" style="background:#0c9300; color:white; border:none; border-radius:6px; padding:6px 12px; font-size:14px; cursor:pointer;">
                            Kirim Via Telegram
                            </button>
                        </form>
                    </div>
                </p>
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

    <script>
    let expiredAt = new Date("{{ $expiredAt }}").getTime();
    let timer = setInterval(function() {
        let now = new Date().getTime();
        let distance = expiredAt - now;

        if (distance <= 0) {
            document.getElementById("countdown").innerHTML = "Expired";
            document.querySelector("button[type=submit]").disabled = true;
            clearInterval(timer);
        } else {
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("countdown").innerHTML = 
                minutes.toString().padStart(2, '0') + ":" + 
                seconds.toString().padStart(2, '0');
        }
    }, 1000);
</script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/8d372c01bd.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/showPassDaftar.js') }}"></script>
@endsection
