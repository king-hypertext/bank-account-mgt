<html lang="en" data-mdb-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mdb/css/mdb.min.css') }}">
    <style>
        INPUT:-webkit-autofill,
        SELECT:-webkit-autofill,
        TEXTAREA:-webkit-autofill {
            animation-name: onautofillstart;
            -webkit-background-clip: text;
            box-shadow: none !important;
            ;
            /* -webkit-box-shadow: 0 0 20px 20px #fff inset !important; */
        }
    </style>
    <title> | {{ $page_title ?? 'Login' }}</title>
    <style>
        .login-card {
            width: 500px;
        }

        @media screen and (max-width: 500px) {
            .login-card {
                width: 95%;
            }
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center align-content-center">
    <div class="card login-card mt-5">
        <div class="card-body">
            <div class="card-header">
                <h3 class="text-center fs-3">ACCOUNTS MANAGEMENT</h3>
            </div>
            <h6 class="text-start my-4">Please Log in</h6>

            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <form id="login" method="POST" action="{{ route('authenticate') }}">
                <div data-mdb-input-init class="form-outline mb-4">
                    <input required autofocus type="text" name="username" id="username"
                        class="form-control @error('username') is-invalid  @enderror" value="{{ @old('username') }}" />
                    <label class="form-label" for="username">Username</label>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                    <input required type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" />
                    <label class="form-label" for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @csrf
                <button data-mdb-ripple-init data-mdb-ripple-color="light" type="submit"
                    class="btn btn-primary btn-block">
                    secure login
                </button>

            </form>
        </div>
    </div>
    <script src="{{ asset('assets/mdb/js/mdb.umd.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/axios/axios.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/auth.js') }}"></script> --}}
    <script>
        const form = document.getElementById('login');
        form && form.addEventListener('submit', function(e) {
            e.submitter.classList.add('disabled');
            return 1;
        });
    </script>
</body>

</html>
