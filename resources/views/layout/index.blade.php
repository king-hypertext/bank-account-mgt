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
    <link rel="stylesheet" href="">
    <script src="{{ asset('assets/jquery/external/jquery.js') }}"></script>
    <title>ACCOUNTS MANAGER | {{ $page_title ?? 'HOME' }}</title>
</head>
<style>
    .sidebar {
        background-color: #000655;
        padding: 20px;
        position: fixed;
        color: #fff;
        top: 0;
        left: 0;
        bottom: 0;
        width: 100%;
        width: 320px;
        height: 100vh;
        z-index: 1090;
        transition: all 0.3s ease-in-out;
        /* transform: translateX(-200px); */
    }

    .nav-menu {
        width: 100%;
        /* background-color: #299D91; */
        text-transform: capitalize;
    }

    .nav-menu-link {
        color: #fff;
        text-decoration: none;
        padding: 12px;
        display: flex;
        cursor: pointer;
        align-items: center;
        margin: 3px auto;
    }

    .nav-menu-link>span>i {
        margin-left: 10px;
        margin-right: 10px;
        font-size: 18pt;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);

    }

    .nav-menu-link:is(:hover, :focus),
    .nav-menu-link.active {
        color: #fff;

        background-color: #299D91;
    }
</style>

<body>
    @include('layout.nav')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-2">
                @include('layout.sidebar')
            </div>
            <div class="col-md-10 main">
                <div class="container mt-4">
                    @yield('content') 
                </div>
            </div>
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
