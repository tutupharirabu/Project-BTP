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

            <div class="text-center pb-3">
                <a href="/dashboardPenyewa">
                    <img src="{{ asset('assets/img/logo_nav.png') }}" alt="Logo" style="max-width: 150px;">
                </a>
            </div>

            <h3 class="text-center pb-3">Masuk</h3>
            <p class="text-center">Halo! selamat datang di website peminjaman Bandung Techno Park</p>
            <form id="loginForm" class="row g-3 needs-validation" action="{{ route('posts.login') }}" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf
                <div class="col-md-12">
                    <label for="email" class="form-label thicker">Email</label>
                    <div class="input-group">
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Masukkan Email Anda" required style="border-radius: 5px;">
                        <div class="invalid-feedback">
                            Masukkan Email Anda!
                        </div>
                    </div>
                </div>

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

                <div class="col-md-12 d-flex justify-content-center">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btnlog mx-auto">Masuk</button>
                    </div>
                </div>
                {{-- <div class="col-md-12 text-center mt-3">
                    <h6>Belum memiliki akun? <a href="/daftarPenyewa">Daftar</a></h6>
                </div> --}}
            </form>
        </div>
    </div>

    <!--pilihan otp-->

    <div class="modal fade" id="otpMethod" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">   
                    <h5 class="modal-title">Pilih Metode Untuk Mendapatkan Kode OTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>   
                <div class="modal-body text-center">
                    <button id="email" class="btn btn-outline-primary m-2">Kirim Via Email</button>
                    <button id="whatsapp" class="btn btn-outline-primary m-2">Kirim Via Whatsapp</button>
                    <button id="telegram" class="btn btn-outline-primary m-2">Kirim Via Telegram</button>
                </div>
            </div>
        </div>
    </div>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

    <script>
        document.getElementById('password_toggle').addEventListener('click', function() {
            const passwordField = document.getElementById('inputpassword');
            const passwordIcon = document.getElementById('password_icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });
    </script>

    <script>
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function(e){
            e.preventDefault();
            let formData={
                email: document.getElementById("email").value,
                password: document.getElementById("inputpassword").value,
                _token: '{{ csrf_token() }}'
            };

            fetch("{{ route('posts.login') }}",{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify(formData)
            })
            .then(async res => {
                if (!res.ok) {
                    let text = await res.text();
                    throw new Error("Login error " + res.status + ": " + text);
                }
                return res.json();
            })
            .then(data => {
                if (data.success){
                    var otpModal = new bootstrap.Modal(document.getElementById('otpMethod'));
                    otpModal.show();
                } else {
                    alert(data.message || "Login error");
                }
            })
            .catch(err => console.error("Error: ", err));
        });

        function sendOTP(method) {
             let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('send.otp') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
            body: JSON.stringify({ method: method })
        })
        .then(async res => {
                if (!res.ok) {
                    let text = await res.text();
                    throw new Error("Login error " + res.status + ": " + text);
                }
                return res.json();
            })
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect; // Redirect ke halaman input OTP
            } else {
                alert(data.message);
            }
        })
        .catch(err => console.error(err));
    }
    document.getElementById('email').addEventListener('click', () => sendOTP('email'));
    document.getElementById('whatsapp').addEventListener('click', () => sendOTP('whatsapp'));
    document.getElementById('telegram').addEventListener('click', () => sendOTP('telegram'));
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/8d372c01bd.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/showPassDaftar.js') }}"></script>
@endsection
