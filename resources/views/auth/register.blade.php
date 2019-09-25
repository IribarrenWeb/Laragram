@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        {{-- INIT COLUM --}}
        <div class="col-md-12">
            
            {{-- Init Row --}}
            <div class="row justify-content-center">

                {{-- IMG Section --}}
                <div class="col-md-6 d-none d-lg-block">
                    <img src="{{ asset('images/larapp.png') }}" alt="">
                </div>
                {{-- End ING Section --}}

                {{-- Card section --}}
                <div class="col-12 col-sm-8 col-lg-5">
                    <div class="card px-3">

                        <div class="card-header bg-white d-flex py-2 justify-content-center">
                            <span class="brand-big">Laragram</span>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group row">
                                    <input id="name" placeholder="Nombre" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <input id="surname" placeholder="Apellido" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required autofocus>

                                    @if ($errors->has('surname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('surname') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <input id="nick" placeholder="Nickname" type="text" class="form-control{{ $errors->has('nick') ? ' is-invalid' : '' }}" name="nick" value="{{ old('nick') }}" required autofocus>

                                    @if ($errors->has('nick'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nick') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <input id="email" placeholder="Email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <input id="password" placeholder="Contraseña" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <input id="password-confirm" placeholder="Comfirmar contraseña" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="form-group row mb-0">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        {{ __('Registrarme') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    {{-- Card 2 Login anchor --}}
                    <div class="card text-center mt-2">
                        <div class="card-body px-2 py-3">
                            <p class="mb-0 my-auto">¿Ya tiene una cuenta?  <a class="card-text" href="{{ route('login') }}">Ingresar</a></p>
                        </div>
                    </div>
                    {{-- End Card 2 register anchor --}}
                
                </div>
                {{-- End Card section --}}
           
            </div>
            {{-- End Row --}}

        </div>
        {{-- END COLUM --}}
    </div>
</div>
@endsection
