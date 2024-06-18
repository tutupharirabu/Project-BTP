@extends('loginsys.layouts.mainLoginSys')
@section('containLoginSys')
    <div class="d-flex align-items-center py-4 font-monospace">
        <div class="container-sm">

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

            <h1 class="text-center pb-3">Login Form</h1>
            <form class="row g-3 needs-validation" action="{{ route('posts.login') }}" method="POST" class="form-valid"
                enctype="multipart/form-data" novalidate>

                @csrf
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Masukkan Email Anda!" required>
                    <div class="invalid-feedback">
                        Masukkan Email Anda!
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="inputpassword" placeholder="Masukkan Password!"
                            name="password">
                        <span class="input-group-text icon" id="id_icon"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="invalid-feedback">
                        Masukkan password anda!
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger">Log in</button>
                        <h6 class="text-center">Not registered? <a href="/daftarPenyewa">Register Now!</a></h6>
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
