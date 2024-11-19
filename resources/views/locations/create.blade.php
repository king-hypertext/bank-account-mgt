<html lang="en" data-mdb-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mdb/css/mdb.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/app/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/jquery/jquery-ui.min.css') }}">
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
@if ($account_types->isEmpty())
    <script>
        window.location.reload();
    </script>
@endif

<body class="container">
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
    <div class="card mt-5">
        <div class="card-body">
            @session('user')
                <div class="alert alert-success my-2" role="alert">
                    Welcome <strong>{{ strtoupper(session('user')) }}</strong>, create a new location and account to get
                    started.
                </div>
            @endsession
            <div class="card-header border-bottom-0">
                <h3 class="text-center fs-3">CREATE LOCATION WITH ACCOUNT</h3>
            </div>
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="account-form" action="{{ route('l.store') }}" method="POST">
                <div class="row mb-3">
                    <label for="location" class="col-sm-2 col-form-label text-uppercase">location</label>
                    <div class="col-sm-10">
                        <input autofocus required type="text" value="{{ @old('location') }}"
                            class="form-control @error('location') is-invalid @enderror" id="location" name="location">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="account_number" class="col-sm-2 col-form-label text-uppercase">account number</label>
                    <div class="col-sm-10">
                        <input required type="text" value="{{ @old('account_number') }}"
                            class="form-control @error('account_number') is-invalid @enderror" id="account_number"
                            name="account_number" />
                        @error('account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="bank_namme" class="col-sm-2 col-form-label text-uppercase">bank name</label>
                    <div class="col-sm-10">
                        <input required type="bank_namme" class="form-control @error('bank_namme') is-invalid @enderror"
                            id="bank_namme" name="bank_name" value="{{ @old('bank_name') }}" />
                        @error('bank_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label text-uppercase">account name</label>
                    <div class="col-sm-10">
                        <input required type="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ @old('name') }}" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}
                <div class="row mb-3">
                    <label for="account_type" class="col-sm-2 col-form-label text-uppercase">account type</label>
                    <div class="col-auto">
                        <select required name="account_type"
                            class="form-select @error('account_type') is-invalid @enderror" id="account_type">
                            @forelse ($account_types as $account_type)
                                <option value="{{ $account_type->id }}">{{ $account_type->type }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <label for="account_address" class="col-form-label text-uppercase col-sm-2 pt-0">account
                        address</label>
                    <div class="col-sm-10">
                        <input required type="account_address"
                            class="form-control @error('account_address') is-invalid @enderror" id="account_address"
                            name="account_address" value="{{ @old('account_address') }}"/>
                        @error('account_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}
                <div class="row mb-3">
                    <label for="initial_amount" class="col-form-label text-uppercase col-sm-2 pt-0">initial
                        amount</label>
                    <div class="col-sm-10">
                        <input required type="text" value="0.00" onfocus="this.select()"
                            class="currencyInput form-control @error('initial_amount') is-invalid @enderror"
                            id="initial_amount" name="initial_amount" />
                        @error('initial_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <fieldset class="row mb-3">
                    <label for="account_status" class="col-form-label text-uppercase col-sm-2 pt-0">status</label>
                    <div class="col-auto">
                        <div class="mb-3">
                            <select required class="form-select @error('account_status') is-invalid @enderror"
                                name="account_status" id="account_status">
                                @forelse ($account_statuses as $account_status)
                                    <option value="{{ $account_status->id }}">{{ $account_status->status }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                    </div>
                </fieldset>
                <fieldset class="row mb-3">
                    <label for="created_at" class="col-form-label text-uppercase col-sm-2 pt-0">date</label>
                    <div class="col-sm-10">
                        <input required type="date" value="{{ now()->format('Y-m-d') }}"
                            class="form-control @error('created_at') is-invalid @enderror" name="created_at"
                            id="created_at" placeholder="" />
                        @error('created_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>
                <div class="row mb-3">
                    <label for="account_description" class="col-form-label text-uppercase col-sm-2 pt-0">notes and
                        attachments</label>
                    <div class="col-sm-10">
                        <textarea name="account_description" class="form-control @error('account_description') is-invalid @enderror"
                            id="account_description" rows="3"></textarea>
                        @error('account_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @csrf
                <div class="d-flex justify-content-end mb-3">
                    <button type="submit" class="btn btn-primary">save</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('assets/mdb/js/mdb.umd.min.js') }}"></script>
    <script src="{{ asset('assets/jquery/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/jquery/jquery-ui.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/axios/axios.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/auth.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('.loader-overlay').hide();
        });
        const form = document.getElementById('account-form');
        form && form.addEventListener('submit', function(e) {
            e.submitter.classList.add('disabled');
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
