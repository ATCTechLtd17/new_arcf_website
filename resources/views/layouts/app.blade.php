<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Acc">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <!-- Font Icon Styles -->
    <link rel="stylesheet" href="{{ asset('css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gaxon-icon/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Perfect Scrollbar stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lite-style-1.min.css') }}">
    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }
        .select2-container .select2-selection--single {
            height: 35px !important;
        }
        .select2-selection__arrow {
            height: 34px !important;
        }
        .modal-content {
            background: #1b6341;
            color: #fff;
        }
        .modal-title {
            color: #fff;
        }
        .modal-header .close span {
            color: #fff;
        }
        th {
            font-size: 11px;
        }

        td {
            font-size: 11px;
        }
        .table th, .table td{
            padding: 0.8rem!important;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number]{
            -moz-appearance: textfield;
        }
    </style>
    @stack('css')
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="dt-sidebar--fixed dt-header--fixed">

<!-- Loader -->
<div class="dt-loader-container">
    <div class="dt-loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
        </svg>
    </div>
</div>
<!-- /loader -->

<!-- Root -->
<div class="dt-root">
    <!-- Header -->
    @include('include.header')
    <!-- /header -->
    <!-- Site Main -->
    <main class="dt-main">
        <!-- Sidebar -->
        <x-sidebar />
        <!-- /sidebar -->

        <!-- Site Content Wrapper -->
        <div class="dt-content-wrapper">

            <!-- Site Content -->
            @yield('content')
            <!-- /site content -->

            <!-- Footer -->
            @include('include.footer')
            <!-- /footer -->

        </div>
        <!-- /site content wrapper -->
    </main>
</div>
<!-- /root -->

<!-- Optional JavaScript -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- Perfect Scrollbar jQuery -->
<script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
<!-- /perfect scrollbar jQuery -->
<script src="{{ asset('js/sweetalert2.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
@stack('js')
@livewireScripts
<script>
    $('.select2').select2();

    window.addEventListener('show-modal', event => {
        $("#" + event.detail.id).modal('show');
    })
    window.addEventListener('hide-modal', event => {
        $("#" + event.detail.id).modal('hide');
    })
    window.addEventListener('success', event => {
        const toast = swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000
        });

        toast({
            type: 'success',
            title: event.detail.msg
        });
    })
    window.addEventListener('error', event => {
        const toast = swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000
        });

        toast({
            type: 'error',
            title: event.detail.msg
        });
    })
</script>
</body>
</html>
