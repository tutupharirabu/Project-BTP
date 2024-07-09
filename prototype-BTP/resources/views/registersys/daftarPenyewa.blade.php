@extends('registersys.layouts.mainRegisterSys')
@section('containRegisterSys')
    <div class="bg-image pt-5">
        <div class="login-container mt-5">
            <div class="text-center pb-3">
                <img src="{{ asset('assets/img/logotelkombtp.png') }}" alt="Logo" style="max-width: 150px;">
            </div>
            <h3 class="text-center pb-3">Daftar</h3>
            <form class="row g-3 needs-validation" action="{{ route('posts.daftarPenyewa') }}" method="POST"
                enctype="multipart/form-data" novalidate onsubmit="return validateForm(event)">
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
                    <div class="invalid-feedback" id="usernameFeedback">
                        Masukkan username anda!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="email" class="form-label thicker">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Masukkan email anda" required>
                    <div class="invalid-feedback" id="emailFeedback">
                        Masukkan email anda!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="password" class="form-label thicker">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password"
                            placeholder="Masukkan Password (Min 8 Karakter)" name="password" required minlength="8">
                        <span class="input-group-text icon" id="password_toggle">
                            <i class="fa-regular fa-eye" id="password_icon"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback">
                        Masukkan password anda (minimal 8 karakter)!
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="confirm_password" class="form-label thicker">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" placeholder="Masuk Ulang Password"
                            name="confirm_password" required>
                        <span class="input-group-text icon" id="confirm_password_toggle">
                            <i class="fa-regular fa-eye" id="confirm_password_icon"></i>
                        </span>
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

    <script>
        document.getElementById('username').addEventListener('change', function() {
            checkUnique('username', this.value);
        });

        document.getElementById('email').addEventListener('change', function() {
            checkUnique('email', this.value);
        });

        function checkUnique(field, value) {
            fetch('{{ route('check.unique') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        field: field,
                        value: value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        if (field === 'username') {
                            document.getElementById('usernameFeedback').textContent = 'Username sudah digunakan!';
                            document.getElementById('username').classList.add('is-invalid');
                        } else if (field === 'email') {
                            document.getElementById('emailFeedback').textContent = 'Email sudah digunakan!';
                            document.getElementById('email').classList.add('is-invalid');
                        }
                    } else {
                        if (field === 'username') {
                            document.getElementById('usernameFeedback').textContent = 'Masukkan username anda!';
                            document.getElementById('username').classList.remove('is-invalid');
                        } else if (field === 'email') {
                            document.getElementById('emailFeedback').textContent = 'Masukkan email anda!';
                            document.getElementById('email').classList.remove('is-invalid');
                        }
                    }
                });
        }

        function validateForm(event) {
            const username = document.getElementById('username');
            const email = document.getElementById('email');

            if (username.classList.contains('is-invalid') || email.classList.contains('is-invalid')) {
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>

    <script>
        document.getElementById('password_toggle').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
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

        document.getElementById('confirm_password_toggle').addEventListener('click', function() {
            const confirmPasswordField = document.getElementById('confirm_password');
            const confirmPasswordIcon = document.getElementById('confirm_password_icon');
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                confirmPasswordIcon.classList.remove('fa-eye');
                confirmPasswordIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordField.type = 'password';
                confirmPasswordIcon.classList.remove('fa-eye-slash');
                confirmPasswordIcon.classList.add('fa-eye');
            }
        });
    </script>

    <script>
        // JavaScript for custom Bootstrap validation
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

        // Custom validation for password confirmation
        function validateForm(event) {
            var form = event.target;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                event.preventDefault();
                event.stopPropagation();

                var confirmPasswordField = document.getElementById('confirm_password');
                confirmPasswordField.setCustomValidity('Passwords do not match');
                confirmPasswordField.classList.add('is-invalid');
                confirmPasswordField.nextElementSibling.textContent = 'Passwords do not match';
            } else {
                var confirmPasswordField = document.getElementById('confirm_password');
                confirmPasswordField.setCustomValidity('');
                confirmPasswordField.classList.remove('is-invalid');
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
            return form.checkValidity();
        }
    </script>
@endsection
