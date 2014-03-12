<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @section('title')
            Facturación Distrigases
        @show
    </title>

    {{--<!-- Latest compiled and minified CSS -->--}}
    {{--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">--}}
    {{ HTML::style('bootstrap/css/bootstrap.min.css') }}

    {{--<!-- Optional theme -->--}}
    {{--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">--}}
    {{ HTML::style('bootstrap/css/bootstrap-theme-united.min.css') }}

    {{--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>--}}
    {{ HTML::script('js/jquery-1.11.0.min.js') }}

    {{--<!-- Latest compiled and minified JavaScript -->--}}
    {{--<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>--}}
    {{ HTML::script('bootstrap/js/bootstrap.min.js') }}

    {{--<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->--}}
    {{--<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->--}}
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href='http://fonts.googleapis.com/css?family=Oswald|Merriweather+Sans|Open+Sans|Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css' />

    {{--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/jquery-ui.js" />--}}
    {{-- HTML::script('js/jquery-ui.js') --}}

    {{ HTML::style('css/distrigases.css') }}

    {{ HTML::script('js/distrigases.js') }}

</head>
<body>
    @include('bloques.navegacion')
    @include('bloques.alertas')

    @yield('contenido')

    @include('bloques.pie')
</body>
</html>