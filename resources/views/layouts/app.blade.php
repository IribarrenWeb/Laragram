<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Apigram</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/config.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}
    <link href="https://fonts.googleapis.com/css?family=Fauna+One|Satisfy&display=swap" rel="stylesheet">

    {{-- Bootstrap style --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    {{-- FontAwesome --}}
    <script src="{{ asset('js/all.js') }}" type="text/javascript"></script>

</head>
<body class="primary">
    <div id="app">
        
        @auth      
        {{-- NAV INIT --}}
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel position-fixed w-100 p-0 mb-0">
            
            {{-- CONTAINER DIV --}}
            <div style="max-width: 1010px; height: 77px;" class="container px-2 py-3 mx-auto justify-content-center">
                    
                {{-- ROW INIT --}}
                <div class="row w-100 mx-0">
                    
                    {{-- LOGO SECTION --}}
                    <div class="col-md-4">
                        <a class="navbar-brand d-flex p-0" href="{{ url('/') }}">
                            <i class="fas fa-camera-retro my-auto"></i>
                            <div class="divider my-auto"></div>
                        <span id="brand-text">Laragram</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    {{-- END LOGO SECTION --}}
                    
                    
                    {{-- BUSCADOR --}}
                    <div class="col-md-4 d-flex align-content-center position-relative">
                        
                        {{-- If auth --}}
                        @auth()
                        
                            <input class="my-auto form-control form-control-sm text-center w-75 mx-auto" id="search" type="text" placeholder="Busca">
                            
                            {{-- <div class="icon d-none"> </div> --}}
                            
                            {{-- Search result DIV --}}
                            <div style="display: none;" id="search-result" class="bg-white">
                                    
                                    {{-- Loader --}}
                                    <div style="display: none" class="loader h-100">
                                    <div class="d-flex justify-content-center align-items-center h-100 ">
                                        <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                                {{-- END Loader --}}
                                
                                {{-- List result --}}
                                <ul style="display: none" id="list-result" class="list-group">
                                        <li class="d-flex align-items-center">
                                            <div class="d-flex">
                                                <div>
                                                    <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>Auth::user()->image]) }}" alt="">
                                                </div>
                                                <div class="ml-3">
                                                    <span class="d-block"><a class="list-group-item-action" href="" title="">{{ Auth::user()->nick }}</a></span>
                                                    <span class="d-block">{{ Auth::user()->name . ' ' . Auth::user()->surname }}</span>
                                                </div>
                                            </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <div>
                                                <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>Auth::user()->image]) }}" alt="">
                                            </div>
                                            <div class="ml-3">
                                                <span class="d-block">{{ Auth::user()->nick }}</span>
                                                <span class="d-block">{{ Auth::user()->name . ' ' . Auth::user()->surname }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <div>
                                                <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>Auth::user()->image]) }}" alt="">
                                            </div>
                                            <div class="ml-3">
                                                <span class="d-block">{{ Auth::user()->nick }}</span>
                                                <span class="d-block">{{ Auth::user()->name . ' ' . Auth::user()->surname }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <div>
                                                <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>Auth::user()->image]) }}" alt="">
                                            </div>
                                            <div class="ml-3">
                                                <span class="d-block">{{ Auth::user()->nick }}</span>
                                                <span class="d-block">{{ Auth::user()->name . ' ' . Auth::user()->surname }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <div>
                                                <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>Auth::user()->image]) }}" alt="">
                                            </div>
                                            <div class="ml-3">
                                                <span class="d-block">{{ Auth::user()->nick }}</span>
                                                <span class="d-block">{{ Auth::user()->name . ' ' . Auth::user()->surname }}</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                {{-- END Lis result --}}

                            </div>
                            {{-- END Search result DIV --}}
                            
                        @endauth
                        {{-- end If auth --}}

                    </div>
                    {{-- END BUSCADOR SECTION --}}
                    

                    {{-- LINKS SECTION --}}
                    <div class="collapse navbar-collapse col-md-4" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        {{-- <ul class="navbar-nav mr-auto">
                            
                        </ul> --}}
                        
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                                @endif
                            @else
                                    
                            {{-- Home --}}
                            <li class="nav-item mr-2">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="far fa-compass text-dark"></i>
                                </a>
                            </li>
                            
                            {{-- Imagenes favoritas --}}
                            <li class="nav-item mr-2">
                                <a class="nav-link" href="{{ route('likes.user') }} {{-- {{ route('image.create') }} --}}">
                                    <i class="far fa-heart text-dark"></i>
                                </a>
                            </li>

                            {{-- Gente --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">
                                    <i class="fas fa-globe-americas text-dark"></i>
                                </a>
                            </li>
                            {{-- AVATAR --}}
                            <li class="nav-item border-left border-darkblue pl-2 ml-1">
                                <img class="avatar rounded-circle my-1" src="{{ route('user.avatar', ['filename' => Auth::user()->image]) }}" alt="">
                            </li>

                            {{-- Nav drop --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user.perfil', ['nick' => Auth::user()->nick]) }}">
                                            Mi perfil
                                        </a>
                                        <a class="dropdown-item" href="{{ route('uconfig') }}">
                                        Configuracion
                                    </a>
                                    <a class="dropdown-item" href="{{ route('image.create') }}">
                                        Subir imagen
                                    </a>
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
                            @endguest
                        </ul>
                    </div>
                    {{-- END LINKS SECTION --}}
                </div>
                {{-- END ROW --}}
            </div>
            {{-- END CONTAINER DIV --}}
        </nav>
        {{-- END NAV --}}
        @endauth
            
            
        {{-- CONTENT SECTION --}}
        <main class="">
            @yield('content')
        </main>
        {{-- END CONTENT SECTION --}}
            
            
    </div>
</body>
</html>
