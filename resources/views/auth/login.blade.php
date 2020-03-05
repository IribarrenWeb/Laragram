@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        {{-- CARDS COLUM --}}
        <div class="col-md-5 col-12 mt-5 mt-md-0">
            {{-- Card section --}}
            <div class="card px-4">
                <div class="card-header bg-white d-flex py-2 justify-content-center">
                    <span class="brand-big">Laragram</span>
                </div>

                <div class="card-body px-0">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <div class="">
                                <input id="nick" placeholder="Nick" type="text" value="test123" class="form-control{{ $errors->has('nick') ? ' is-invalid' : '' }}" name="nick" value="{{ old('nick') }}" required autofocus>

                                @if ($errors->has('nick'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nick') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <input id="password" placeholder="Contraseña" value="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recuerdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Iniciar sesion') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('¿Olvido su contraseña?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
            {{-- End Card section --}}
            
            {{-- Card 2 register anchor --}}
            <div class="card text-center mt-3">
                <div class="card-body px-3">
                <p class="mb-0">¿Aun no esta registrado?  <a class="card-text" href="{{ route('register') }}">Registrarse</a></p>
                </div>
            </div>
            {{-- End Card 2 register anchor --}}
        </div>
        {{-- End CARD COLUM --}}

    </div>
</div>
@endsection
