<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Velmie') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ asset('css/toggle-custom.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ asset('css/v1/main.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ asset('css/datepicker-custom.css') }}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/air-datepicker/css/datepicker.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        window.csrf_token = "{{ csrf_token() }}";
        const pathUrl = window.location.pathname;
    </script>
</head>
<body class="sameblock with-menu">
<div class="main-wrapper">
    <div class="mobile-btn hidden-lg hidden-md"><i class="zmdi zmdi-view-toc"></i></div>
    <!-- Header -->
    <div class="header">
        <div class="custom-container">
            <div class="logo-content">
                <div class="v-logo"></div>
                <div class="page-name-arrow"></div>
                <a class="logo" href="/"><span>PIS</span> </a>
            </div>
            <div class="hidden-xs search-container">
                @if (!empty($isShowSearchIdeaBlock))
                    <form action="" class="search" id="form-search-idea">
                        <div class="form-group" style="margin-top: 15px;">
                            <i class="zmdi zmdi-search"></i>
                            {{ Form::text('search_idea', '', ['class'=>'form-control', 'placeholder'=>trans('ideas.search'), 'id'=>'search-idea']) }}
                        </div>
                        <input type="submit" style="display: none;"/>
                    </form>
                @endif
            </div>

            <div class="text-right button-block">
                <button class="add"><a href="{{ route('add-idea') }}">+</a></button>
            </div>

            <div class="faq">
                <a href="{{ route('faq') }}">FAQ</a>
            </div>

            <div class="flex">
                <div class="dropdown user-settings">
                    @if (Auth::guest())
                        <a href="{{ config('app.auth_url') }}">Login</a>
                    @else
                        <a data-toggle="dropdown" href="#">
                            <em class="avatar user_avatar_name"
                                style="background-image: url({{Auth::user()->avatar}}); background-color: {{ Auth::user()->icon_color }};"
                            >
                                @if (!Auth::user()->avatar)
                                    {{mb_substr(Auth::user()->name, 0 ,1)}}{{mb_substr(Auth::user()->last_name, 0 ,1)}}
                                @endif
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
    <!-- End Header -->
    <!-- Container -->
    <div class="app-container" id="app" v-cloak>
        <app></app>
        @yield('content')
    </div>
    <!-- End Container -->
</div>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('vendor/air-datepicker/js/datepicker.min.js') }}"></script>
<script src="{{ asset('vendor/air-datepicker/js/datepicker.en.js') }}"></script>
<script src="{{ asset('js/libs.min.js') }}"></script>
<script src="{{ asset('js/common.js') }}?v={{ config('app.version') }}"></script>
<script src="{{ asset('js/custom.js') }}?v={{ config('app.version') }}"></script>
@yield('scripts')
@yield('inline-scripts')
</body>
</html>