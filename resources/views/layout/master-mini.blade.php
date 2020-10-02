<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Authentication'}} - {{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

    <!-- plugin css -->
    {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
    {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
    <!-- end plugin css -->

    <!-- plugin css -->
    @stack('plugin-styles')
    <!-- end plugin css -->

    <!-- common css -->
    {!! Html::style('css/main.css') !!}
    <!-- end common css -->

    @stack('style')
</head>
<body data-base-url="{{url('/')}}">

    <div class="container-scroller" id="app">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    @stack('custom-scripts')

</body>
</html>
