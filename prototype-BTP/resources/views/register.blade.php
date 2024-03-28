<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary font-monospace">
    <div class="container-sm">
        <main class="form-signin w-100 m-auto">
            <form action="/register" method="post">
                @csrf
                <h1 class="h3 mb-3 fw-normal text-center">Register Form</h1>
                <div class="form-floating m-2">
                    <input type="text" name="name" class="form-control rounded-top @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                    <label for="name">Name</label>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating m-2">
                    <input type="email" name="email" class="form-control rounded-top @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                    <label for="email">Email address</label>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating m-2">
                    <input type="text" name="telephone_number" class="form-control rounded-top @error('telephone_number') is-invalid @enderror" id="telephone_number" value="{{ old('telephone_number') }}" required>
                    <label for="telephone_number">Telephone Number</label>
                    @error('telephone_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- <select class="form-select m-2" name="kategoriStatus">
                    <option selected>Choose</option>
                    <option value="1">Tenaga Pendidik (Dosen)</option>
                    <option value="2">Tenaga Kependidikan (TPA)</option>
                    <option value="3">Mahasiswa</option>
                    <option value="4">Umum</option>
                </select> --}}

                <div class="form-floating m-2">
                    <input type="text" name="instansi" class="form-control rounded-top @error('instansi') is-invalid @enderror" id="instansi" value="{{ old('instansi') }}" required>
                    <label for="instansi">Instansi Asal</label>
                    @error('instansi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating m-2">
                    <input type="text" name="username" class="form-control rounded-top @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" required>
                    <label for="username">Username</label>
                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating m-2">
                    <input type="password" name="password" class="form-control rounded-top @error('password') is-invalid @enderror" id="password" required>
                    <label for="password">Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button class="btn btn-primary w-100 py-2 mt-3 mb-3" type="submit">Sign Up</button>
                <h6 class="text-center">Already registered? <a href="/">Login</a></h6>
            </form>
        </main>
    </div>
</body>
</html>
