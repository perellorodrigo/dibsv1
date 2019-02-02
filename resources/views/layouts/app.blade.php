<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100%;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dibs') }}</title>

    <!-- Scripts -->
    
    <script src="{{  secure_asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{  secure_asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    @yield('header')
<style type="text/css">
    #app{
        display: grid;
        grid-template-rows: 55px calc(100vh - 55px);
        position: relative;
    }
    .navigation-main
    {
        display: flex;
        flex-direction : row;
        justify-content: space-between;
        border-bottom: 1px solid rgba(67,67,74,0.09);
        align-items: center;
        background: #F7F8FA;
        
    }
    .navigation-main-items{
        list-style:none;
        display: flex;
        flex-direction: row;
        margin: 0;
    }
    .navigation-main-items > li {
        display: inline-block;

    }
    .navigation-main-items > li > a{
        text-decoration: none;
        color: black;
    }
    .navigation-logo{
        width:50px;
        height: 50px;
        
    }
    .navigation-logo > img{
        max-width: 100%;
        max-height: 100%;
        padding: 5px;
    }
</style>

</head>
<body style="height: 100%;">
    <div id="app" style="height: 100%;">
        <nav class="navigation-main">
            <a style="padding: 0 1rem;" href="{{ url('/') }}">
                <div class="navigation-logo">
                   <img src="/png/dibs-logo.png">
               </div>
            </a>
            <ul class="navigation-main-items">
                <!-- Authentication Links -->
                @guest
                    <li>
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                <!-- If user is logged in: -->
                    <li class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span 
                            class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Profile Settings</a>
                            <a class="dropdown-item" href="#">Your Items</a>
                            <a class="dropdown-item" href="{{ route('post_item') }}">Post Item</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li><a class="nav-link" href="{{ route('messages') }}">Messages</a></li>
                @endguest
            </ul>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
