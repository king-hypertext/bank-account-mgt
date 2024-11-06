<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/boxicons/boxicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2-bootstrap-5-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/perfect-scroll/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/mdb/css/mdb.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/main.css') }}" />
    <script src="{{ asset('assets/jquery/external/jquery.js') }}"></script>
    <title>ACCOUNTS MANAGER | {{ $page_title ?? 'HOME' }}</title>
</head>
<style>
    .flex {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>

<body>
    <div class="container-fluid flex">
        <div class="row">
            <h6 class="text-center fw-bold text-uppercase">Accounts</h6>
            @forelse ($account_locations as $location)
                <div class="col-md-6 gy-2">
                    <a href="{{ route('account.home', $location->id) }}">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title fw-bold text-center">{{ $location->name }}</h4>
                                <h6 class="mb-0 fs-5">$120,900.00</h6>
                                <p class="card-start mb-0 pb-0 fw-semibold">Balance</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <script src="{{ asset('assets/mdb/js/mdb.umd.min.js') }}"></script>
    <script src="{{ asset('assets/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/perfect-scroll/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/app/color-modes.js') }}"></script>
    <script src="{{ asset('assets/app/main.js') }}"></script>
</body>

</html>
