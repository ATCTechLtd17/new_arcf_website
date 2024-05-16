<!doctype html>
<html class="no-js" lang="">
<head>
    <!-- Primary Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" sizes="32x32" type="image/png">
    <title> {{ @$title }} | {{ env('app_name') }} </title>
    <link rel="image_src" href="{{ asset('logo.png') }}}" />
    <meta name="title" content="{{ env('app_name') }}">
    <meta name="description" content="{{ env('app_name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ env('app_name') }}">
    <meta itemprop="description" content="{{ env('app_name') }}">
    <meta itemprop="image" content="{{ asset('logo.png') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('css/font/flaticon.css') }}">
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @livewireStyles()
</head>
<style>
    /* Progress Like Google Bar 03*/
    .ms-bar {
        position: absolute;
        width: 100%;
        height: 4px;
        background: #ffc3e7;
        overflow: hidden;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .ms-bar div:before {
        content: "";
        position: absolute;
        top: 0px;
        left: 0px;
        bottom: 0px;
        background: #eb008b;
        animation: box-1 2100ms cubic-bezier(0.65, 0.81, 0.73, 0.4) infinite;
    }

    .ms-bar div:after {
        content: "";
        position: absolute;
        top: 0px;
        left: 0px;
        bottom: 0px;
        background: #eb008b;
        animation: box-2 2100ms cubic-bezier(0.16, 0.84, 0.44, 1) infinite;
        animation-delay: 1150ms;
    }

    @keyframes box-1 {
        0% {
            left: -35%;
            right: 100%;
        }

        60%,
        100% {
            left: 100%;
            right: -90%;
        }
    }

    @keyframes box-2 {
        0% {
            left: -200%;
            right: 100%;
        }

        60%,
        100% {
            left: 107%;
            right: -8%;
        }
    }

    /* end ms progress bar */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0;
        /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    ::-webkit-scrollbar {
        background: #e6e6e6;
        width: 5px;
        transition: 0.4s;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
        background-image: -webkit-linear-gradient(330deg, #e0c3fc 0%, #8ec5fc 100%);
        background-image: linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #0a7cf3;
        border-radius: 20px;
        margin-left: 10px;
        transition: 0.4s;
    }
</style>
@stack('css')

<body>
    <section class="fxt-template-animation fxt-template-layout7" data-bg-image="{{ @$bg }}">
        <div class="container">
            @yield('content')
            <br><br>
            <div class="footer-copyright-area">
                <div class="container custom-area">
                    <div class="row">
                        <div class="col-12 text-center col-custom">
                            @component('components.app-copyright-component')
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- jquery-->
    <script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Imagesloaded js -->
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- Validator js -->
    <script src="{{ asset('js/validator.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- Sweetalert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- ProgrammerHasan.Js --}}
    {{-- < script type="text/javascript" src="{{ asset('js/programmerhasan.js/w-protected.js') }}">
        </script> --}}

    @livewireScripts()
    @stack('js')
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        window.addEventListener('success', event => {
            toastr.success(event.detail.msg);
        })
        window.addEventListener('error', event => {
            toastr.error(event.detail.msg);
        })
    </script>
</body>
</html>
