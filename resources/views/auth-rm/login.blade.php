<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login RM RSA</title>

    <title>Login RM RSA</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}?v=99">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=99">

    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    <style>
        body {
            background: #edf1f5;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 420px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 90px;
            margin-bottom: 10px;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 300;
            margin: 0;
        }

        .logo h1 span {
            font-weight: 700;
        }

        .card {
            border: 0;
            border-radius: 3px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .12);
        }

        .card-body {
            padding: 26px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 18px;
        }

        .input-group-text {
            background: #fff;
            border-left: 0;
        }

        .form-control {
            border-right: 0;
            height: 46px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .btn-login {
            background: #0F766E;
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            border: none;
            height: 46px;
        }

        .btn-login:hover {
            background: #115E59;
            color: #fff;
        }
    </style>

</head>

<body>

    <div class="login-wrapper">

        <div class="login-box">

            <div class="logo">

                <img src="{{ asset('vendor/adminlte/dist/img/rsa.png') }}" alt="RM RSA">

                <h1><span>RM</span> RSA</h1>

            </div>

            <div class="card">

                <div class="card-body">

                    <div class="subtitle">
                        Silakan login untuk melanjutkan
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('rm.login.post') }}">

                        @csrf

                        <div class="input-group mb-3">

                            <input type="text" name="Username" class="form-control" placeholder="Username" required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>

                        </div>

                        <div class="input-group mb-4">

                            <input type="password" name="Password" class="form-control" placeholder="Password" required>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-login btn-block">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
