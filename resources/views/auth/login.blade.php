<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Mini Wallet</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
        }

        .login-wrapper {
            min-height: 100vh;
            padding: 24px 12px;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
        }

        .brand-title {
            font-size: 2rem;
        }

        @media (max-width: 576px) {
            .login-wrapper {
                align-items: flex-start !important;
                padding-top: 32px;
            }

            .brand-title {
                font-size: 1.6rem;
            }

            .brand-description {
                font-size: 0.9rem;
            }

            .card-body {
                padding: 1.25rem !important;
            }

            .demo-account {
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body class="bg-light">

    <div class="container login-wrapper d-flex align-items-center justify-content-center">
        <div class="login-card">

            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary brand-title">Mini Wallet</h2>
                <p class="text-muted mb-0 brand-description">
                    Masuk untuk melihat saldo, melakukan transfer, dan melihat riwayat transaksi.
                </p>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0">Login</h5>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email"
                                required
                                autofocus>

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password"
                                required>

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember_me"
                                class="form-check-input">

                            <label class="form-check-label" for="remember_me">
                                Ingat saya
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Masuk
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mt-3 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Akun Demo</h6>

                    <div class="small text-muted demo-account">
                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-1 border-bottom py-1">
                            <span>User A</span>
                            <span><strong>usera@mail.com</strong> / password</span>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-1 border-bottom py-1">
                            <span>User B</span>
                            <span><strong>userb@mail.com</strong> / password</span>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-1 py-1">
                            <span>User C</span>
                            <span><strong>userc@mail.com</strong> / password</span>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-center text-muted mt-4 small">
                Mini E-Wallet sederhana
            </p>

        </div>
    </div>

    <script>
        document.addEventListener('submit', function(event) {
            const button = event.target.querySelector('button[type="submit"]');

            if (button) {
                button.disabled = true;
                button.innerText = 'Memproses...';
            }
        });
    </script>

</body>

</html>