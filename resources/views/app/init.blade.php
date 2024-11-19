<html lang="en" data-mdb-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/mdb/css/mdb.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/app/loader.css') }}">
    <script src="{{ asset('assets/jquery/external/jquery.js') }}"></script>
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

        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1096;
            overflow: hidden !important;
        }

        .loader-overlay .loader-text {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24pt;
            text-align: center;
            margin-top: 20px;
            animation: blink 2s infinite;
            animation-timing-function: ease-in-out;
            color: #fff;
            position: absolute;
            bottom: 35%;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @media print {
            table tr th {
                text-transform: uppercase !important;
            }
        }
    </style>
    <title>APP | {{ strtoupper($page_title) ?? 'Login' }}</title>
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
    <div class="loader-overlay">
        <div class="loadingio-spinner-dual-ring-nq4q5u6dq7r">
            <div class="ldio-x2uulkbinbj">
                <div></div>
                <div>
                    <div></div>
                </div>
            </div>
        </div>
        <div class="loader-text text-white fs-2">Initializing App...</div>
    </div>
    <div class="card mt-5 login-card">
        <div class="card-body">
            <div class="card-header border-bottom-0">
                <h3 class="text-center fs-3">CREATE NEW ACCOUNT</h3>
            </div>
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            {{-- @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            <form id="user" action="{{ route('init.post') }}" method="POST">
                <div data-mdb-input-init class="form-outline mb-4">
                    <input required type="text" value="{{ @old('username') }}" id="username" name="username"
                        class="form-control form-control-lg @error('username')
                            is-invalid
                        @enderror" />
                    <label class="form-label" for="username">Username</label>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                    <input required type="password" name="password" id="password"
                        class="form-control form-control-lg @error('password')
                            is-invalid
                        @enderror" />
                    <label class="form-label" for="password">Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                    <input required type="password" name="confirm_password" id="confirm_password"
                        class="form-control form-control-lg @error('confirm_password')
                            is-invalid
                        @enderror" />
                    <label class="form-label" for="confirm_password">Confirm Password</label>
                    @error('confirm_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @csrf
                <div class="d-flex justify-content-end mb-3">
                    <button type="submit" class="btn btn-primary">continue</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('assets/mdb/js/mdb.umd.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.loader-overlay').hide();
        });
        const form = document.getElementById('user');
        form && form.addEventListener('submit', function(e) {
            e.submitter.classList.add('disabled');
            $('.loader-overlay').show().find('.loader-text').text('Processing...')
            return 1;
        });
        $('.currencyInput').inputmask({
            alias: 'currency',
            prefix: '',
            rightAlign: false,
            digits: 2,
            digitsOptional: false,
            groupSeparator: ',',
            autoGroup: true,
            removeMaskOnSubmit: true,
            unmaskAsNumber: true
        });

        $('.currencyInput').keypress(function(e) {
            var charCode = (e.which) ? e.which : event.keyCode;
            if ((charCode < 48 || charCode > 57) && charCode !== 46) {
                return false;
            }
        });

        $('input[type="date"]').datepicker({
            dateFormat: 'yy-mm-dd', // Adjust the date format as needed 
            changeMonth: true, // Allows changing the month 
            changeYear: true, // Allows changing the year 
            showButtonPanel: true // Adds buttons to clear or close the datepicker 
        });
    </script>
</body>

</html>
