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
    {{-- Moment js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/es.js"></script>
    {{-- My config js --}}
    <script src="{{ asset('js/config.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500|Satisfy&display=swap" rel="stylesheet">

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
                <div class="row w-100 mx-0 justify-content-center">
                    
                    {{-- LOGO SECTION --}}
                    <div class="col-lg-4 col-md-3">
                        <a class="navbar-brand d-flex p-0 align-items-center" href="{{ url('/') }}">
                            <img src="{{ asset('images/photo.png') }}" width="30px" height="30px">
                            <div class="divider my-auto"></div>
                            <span id="brand-text">Laragram</span>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    {{-- END LOGO SECTION --}}
                    
                    
                    {{-- BUSCADOR --}}
                    <div class="col-md-4 d-none d-sm-flex align-content-center position-relative">
                        
                        {{-- If auth --}}
                        @auth()
                        
                            <input class="my-auto form-control form-control-sm text-center mx-md-auto" id="search" type="text" placeholder="Busca">
                            
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
                    <div class="p-0 col-md-3 col-lg-4">
                        
                        <!-- Right Side Of Navbar -->
                        <ul class="d-flex align-items-center justify-content-end h-100 ml-auto" id="menu">

                            <!-- Authentication Links -->
                            @guest
                                <li>
                                    <a class="" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                <li class="">
                                    <a class="" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                                @endif
                            @else
                                    
                            {{-- Home --}}
                            <li>
                                <a class="" href="{{ route('home') }}">
                                    <img src="{{ asset('images/compass.png') }}">
                                </a>
                            </li>
                            
                            {{-- Imagenes favoritas --}}
                            <li>
                                <a class="" href="{{ route('likes.user') }} {{-- {{ route('image.create') }} --}}">
                                    <img src="{{ asset('images/likers.png') }}">
                                </a>
                            </li>

                            {{-- Gente --}}
                            <li>
                                <a href="{{ route('user.index') }}">
                                    <img src="{{ asset('images/world.png') }}">
                                </a>
                            </li>

                            {{-- AVATAR --}}
                            <li>
                                <a href="{{ route('user.perfil', ['nick' => Auth::user()->nick]) }}">
                                    <img src="{{ asset('images/user.png') }}">
                                </a>
                            </li>

                            {{-- Nav drop
                            <li class=" dropdown d-none d-lg-block">
                                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                
                                
                            </li> --}}

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
