<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/app/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/boxicons/boxicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2-bootstrap-5-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/perfect-scroll/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/animate-css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/alert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mdb/css/mdb.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/main.css') }}" />
    <link rel="stylesheet" href="">
    <script src="{{ asset('assets/jquery/external/jquery.js') }}"></script>
    <title>ACCOUNTS MANAGER | {{ $page_title ?? 'HOME' }}</title>
</head>
<style>
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

    INPUT:-webkit-autofill,
    SELECT:-webkit-autofill,
    TEXTAREA:-webkit-autofill,
    INPUT:-webkit-autofill:hover,
    INPUT:-webkit-autofill:focus,
    INPUT:-webkit-autofill:active,
    SELECT:-webkit-autofill:hover,
    SELECT:-webkit-autofill:focus,
    SELECT:-webkit-autofill:active,
    TEXTAREA:-webkit-autofill:hover,
    TEXTAREA:-webkit-autofill:focus,
    TEXTAREA:-webkit-autofill:active {
        animation-name: onautofillstart;
        -webkit-background-clip: text;
        background-color: transparent !important;
        color: #000 !important;
        box-shadow: none !important;
        /* -webkit-text-fill-color: #000000; */
        -webkit-text-fill-color: #000 !important;
        /* -webkit-box-shadow: 0 0 20px 20px #fff inset !important; */
    }
</style>
@php
    // $account_location =
@endphp

<body>
    <div class="loader-overlay">
        <div class="loadingio-spinner-dual-ring-nq4q5u6dq7r">
            <div class="ldio-x2uulkbinbj">
                <div></div>
                <div>
                    <div></div>
                </div>
            </div>
        </div>
        <div class="loader-text text-white fs-2">Loading...</div>
    </div>
    @include('layout.nav')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-2">
                @include('layout.sidebar')
            </div>
            <div class="col-md-10 main">
                <div class="container mt-auto">
                    <div class="d-flex mt-3 align-items-center justify-content-between">
                        <h3 class="h3 fs-4 fw-bold text-uppercase">
                            {{ $account_location->name }}
                        </h3>
                        <button class="btn btn-info modify-account">modify</button>
                    </div>
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
    <script src="{{ asset('assets/alert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/app/main.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.loader-overlay').hide();
            // $('button.modify-account').click(function() {

            //     const {
            //         value: location_name
            //     } = Swal.fire({
            //         title: "Modfy Account Location Name",
            //         input: "text",
            //         inputLabel: "Enter Location Name",
            //         inputValue: "{{ $account_location->name }}",
            //         showCancelButton: true,
            //         confirmButtonText: "Update",
            //         cancelButtonText: "Cancel",
            //         // showLoaderOnConfirm: true,
            //         preConfirm: (location_name) => {
            //             return new Promise((resolve) => {
            //                 if (!location_name) {
            //                     Swal.showValidationError("Location Name cannot be empty!");
            //                 } else {
            //                     resolve();
            //                 }
            //             });
            //         },
            //         allowOutsideClick: () =>!Swal.isLoading(),
            //         inputValidator: (value) => {
            //             if (!value) {
            //                 return "input field cannot be empty!";
            //             }
            //         },
            //         isConfirmed: (value) =>{
            //             return new Promise((resolve) => {
            //                 $.ajax({
            //                     url: '/locations/' + '{{ $account_location->id }}',
            //                     method: 'PUT',
            //                     data: {
            //                         location: location_name
            //                     },
            //                     success: function(response) {
            //                         showSuccessAlert.fire({
            //                             icon:'success',
            //                             text: 'Account location updated successfully!',
            //                             padding: '15px',
            //                             width: 'auto'
            //                         });
            //                         setTimeout(() => {
            //                             location.reload();
            //                         }, 1500);
            //                         resolve();
            //                     },
            //                     error: function(error) {
            //                         showSuccessAlert.fire({
            //                             icon: 'error',
            //                             text: 'Failed to update account location. Please try again later.',
            //                             padding: '15px',
            //                             width: 'auto'
            //                         });
            //                         resolve();
            //                     }
            //                 });
            //             });
            //         }
            //     });
            //     if (location_name) {
            //         console.log(location_name);

            //         $.ajax({
            //             url: "{{ route('l.update', $account_location->id) }}",
            //             method: 'PUT',
            //             data: {
            //                 name: location_name
            //             },
            //             success: function(response) {
            //                 if (response.success) {
            //                     window.open(response.url, '_self');
            //                 }
            //             },
            //             error: function(error) {
            //                 return console.log(error);

            //                 if (error.status === 422) {
            //                     const errors = JSON.parse(error.responseText);
            //                     let errorMessages = '';
            //                     for (let key in errors) {
            //                         errorMessages += errors[key][0] + '<br>';
            //                     }
            //                     showSuccessAlert.fire({
            //                         icon: 'error',
            //                         text: errorMessages,
            //                         padding: '15px',
            //                         width: 'auto'
            //                     });
            //                 }
            //             }
            //         });
            //     }
            // });
            $('button.modify-account').click(function() {
                const locationId = "{{ $account_location->id }}";
                const updateUrl = "{{ route('l.update', $account_location->id) }}";

                Swal.fire({
                    title: "Modify Account Location Name",
                    input: "text",
                    inputLabel: "Enter Location Name",
                    inputValue: "{{ $account_location->name }}",
                    showCancelButton: true,
                    confirmButtonText: "Update",
                    cancelButtonText: "Cancel",
                    inputValidator: (value) => {
                        if (!value) {
                            return "Input field cannot be empty!";
                        }
                    },
                    preConfirm: (locationName) => {
                        $.ajax({
                                url: updateUrl,
                                method: 'PUT',
                                data: {
                                    name: locationName,
                                    _token: '{{ csrf_token() }}',
                                },
                            })
                            .done((response) => {
                                if (response.success) {
                                    window.open(response.url, '_self');
                                    // showSuccessAlert.fire({
                                    //     icon: 'success',
                                    //     text: 'Account location updated successfully!',
                                    //     padding: '15px',
                                    //     width: 'auto'
                                    // });
                                    // setTimeout(() => {
                                    //     location.reload();
                                    // }, 1500);
                                }
                            })
                            .fail((error) => {
                                if (error.status === 422) {
                                    const errors = error.responseJSON.errors;
                                    // return console.log(errors);

                                    let errorMessages = '';
                                    for (let key in errors) {
                                        errorMessages += errors[key][0];
                                    }
                                    showSuccessAlert.fire({
                                        icon: 'error',
                                        text: errorMessages,
                                        padding: '15px',
                                        width: 'auto'
                                    });
                                } else {
                                    showSuccessAlert.fire({
                                        icon: 'error',
                                        text: 'Failed to update account location. Please try again later.',
                                        padding: '15px',
                                        width: 'auto'
                                    });
                                }
                            });
                    }
                });
            });
        });
        const showSuccessAlert = Swal.mixin({
            position: 'top-right',
            toast: true,
            timer: 6500,
            showCloseButton: true,
            showConfirmButton: false,
            timerProgressBar: false,
            onOpen: () => {
                setInterval(() => {
                    Swal.close()
                }, 6500);
            },
            showClass: {
                popup: `
                    animate__animated
                    animate__fadeInDown
                    animate__faster
                    `
            },
        });
    </script>
    @yield('script')
    @if (session('success'))
        <script type="text/javascript">
            showSuccessAlert.fire({
                icon: 'success',
                text: '{{ session('success') }}',
                padding: '15px',
                width: 'auto'
            });
        </script>
    @endif
    @if (session('error'))
        <script type="text/javascript">
            showSuccessAlert.fire({
                icon: 'error',
                text: '{{ session('error') }}',
                padding: '15px',
                width: 'auto'
            });
        </script>
    @endif
    @if (session('warning'))
        <script type="text/javascript">
            showSuccessAlert.fire({
                icon: 'warning',
                text: '{{ session('warning') }}',
                padding: '15px',
                width: 'auto'
            });
        </script>
    @endif
    @if (session('info'))
        <script type="text/javascript">
            showSuccessAlert.fire({
                icon: 'info',
                text: '{{ session('info') }}',
                padding: '15px',
                width: 'auto'
            });
        </script>
    @endif
</body>

</html>
