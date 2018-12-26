<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ikantam') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
{{--    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/v1/main.css') }}" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="@if(request()->route()->getAction()['as'] == 'main') sameblock with-menu @else gray-bg @endif">
<div class="main-wrapper">
    <div class="mobile-btn hidden-lg hidden-md"><i class="zmdi zmdi-view-toc"></i></div>
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-3 col-xs-2">
                    <a class="logo" href="/"><span>PIS</span>IKANTAM </a>
                </div>
                <!-- Search -->
                <div class="col-md-5 col-sm-4 hidden-xs">
                    {{--<form action="#" class="search">
                        <input type="search" name="search" placeholder="Поиск">
                        <i class="zmdi zmdi-search"></i>
                    </form>--}}
                </div>
                <!-- End Search -->
                <!-- Button Add Post -->
                <div class="col-md-2 col-sm-2 col-xs-2 text-right button-block">
                    @if(request()->route()->getAction()['as'] != 'add-idea')
                        <button class="add">+</button>
                    @endif
                </div>
                <!-- End Button Add Post -->
                <!-- User Panel -->

                <div class="col-md-3 col-sm-3 col-xs-8 text-center">
                    {{--<i class="zmdi zmdi-notifications full">
                        <span class="active"></span>
                    </i>--}}
                    <div class="dropdown pull-right">
                        @if (Auth::guest())
                            <a href="{{ config('app.auth_url') }}">Login</a>
                        @else
                            <a data-toggle="dropdown" href="#">
                                <em class="avatar">
                                    {{mb_substr(Auth::user()->name, 0 ,1)}}
                                    {{mb_substr(Auth::user()->last_name, 0 ,1)}}
                                </em>
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>
                            {!! Menu::main() !!}
                        @endif
                    </div>
                </div>
                <!-- End User Panel -->
            </div>
        </div>
    </div>
    <!-- End Header -->
    <!-- Container -->
    <div id="app">
        @yield('content')
    </div>
    <!-- End Container -->
</div>
<script src="{{ asset('js/jquery.js') }}"></script>

<script src="{{ asset('js/libs.min.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
@yield('scripts')
@yield('inline-scripts')
</body>
</html>