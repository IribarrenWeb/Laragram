<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laragram</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500|Satisfy&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>
<body class="primary">
    <div id="app">
        
        @auth      
        {{-- NAV INIT --}}
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel position-fixed w-100 p-0 mb-0">
            
            {{-- CONTAINER DIV --}}
            <div style="max-width: 1010px; height: 77px;" class="container px-md-2 py-md-3  mx-auto justify-content-center">
                
                {{-- ROW INIT --}}
                <div class="row w-100 mx-0 justify-content-center">
                    
                    {{-- LOGO SECTION --}}
                    <div class="col-lg-4 col-6 col-md-3">
                        <a class="navbar-brand d-flex p-0 align-items-center" href="{{ url('/') }}">
                            <img src="{{ asset('images/photo.png') }}" width="30px" height="30px">
                            <div class="divider my-auto"></div>
                            <span id="brand-text">Laragram</span>
                        </a>
                    </div>
                    {{-- END LOGO SECTION --}}
                    
                    
                    <search-component></search-component>
                    
                    
                    {{-- LINKS SECTION --}}
                    <div class="pl-0 pr-1 col-6 col-md-3 col-lg-4">
                        
                        <!-- Right Side Of Navbar -->
                        <ul class="d-flex align-items-center justify-content-end h-100 ml-auto" id="menu">
                            
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
                            
                            {{-- AVATAR --}}
                            <li>
                                <a href="{{ route('user.perfil', ['nick' => Auth::user()->nick]) }}">
                                    <img src="{{ asset('images/user.png') }}">
                                </a>
                            </li>
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
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- FontAwesome --}}
    <script src="{{ asset('js/all.js') }}" type="text/javascript"></script>
</body>
</html>
