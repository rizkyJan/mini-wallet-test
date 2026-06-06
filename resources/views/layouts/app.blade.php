<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini Wallet</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
        }

        .main-content {
            padding-bottom: 32px;
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem;
            }

            .nav-actions {
                width: 100%;
                margin-top: 12px;
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 8px !important;
            }

            .nav-actions a,
            .nav-actions form,
            .nav-actions button {
                width: 100%;
            }

            .main-content {
                padding-left: 12px;
                padding-right: 12px;
            }

            .alert {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-between">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                Mini Wallet
            </a>

            @auth
            <div class="d-flex gap-2 nav-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">
                    Dashboard
                </a>

                <a href="{{ route('transfer.create') }}" class="btn btn-light btn-sm">
                    Transfer
                </a>

                <a href="{{ route('transactions.index') }}" class="btn btn-light btn-sm">
                    Riwayat
                </a>

                <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin logout?')">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        Logout
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </nav>

    <main class="container main-content">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        {{ $slot ?? '' }}

        @yield('content')
    </main>

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