<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="aGL9mgKAjitF0e3BQVfxLGjyunp6mtfBGqik1DZZ" />
    <title>Aris Bali Explorer</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />

    <link id="gull-theme" rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="http://gull-html-laravel.ui-lib.com/assets/styles/vendor/datatables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
</head>

<body>
    <div class="not-found-wrap text-center">
        <h1 class="text-60">
            403
        </h1>
        <p class="text-36 subheading mb-3">Forbidden!</p>
        <p class="mb-5  text-muted text-18">Sorry! You dont have access to view this page.</p>
        <a class="btn btn-lg btn-primary btn-rounded" href="{{route('dashboard.index')}}">Go back to home</a>
    </div>

    <script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar.large.script.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.2.1/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="http://gull-html-laravel.ui-lib.com/assets/js/vendor/datatables.min.js"></script>
    <script src="http://gull-html-laravel.ui-lib.com/assets/js/datatables.script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>
