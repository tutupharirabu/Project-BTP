<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary font-monospace">
    <div class="container-sm">
        <main class="form-signin w-100 m-auto">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success' )}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError' )}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="/login" method="post">
                @csrf
                <h1 class="h3 mb-3 fw-normal text-center">Login Form</h1>
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
                    <input type="password" name="password" class="form-control rounded-top @error('password') is-invalid @enderror" id="password" required>
                    <label for="password">Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button class="btn btn-primary w-100 py-2 mt-3 mb-3" type="submit">Sign in</button>
                <h6 class="text-center">Not registered? <a href="/daftarPenyewa">Register Now!</a></h6>
            </form>
        </main>
    </div>
</body>
</html>
