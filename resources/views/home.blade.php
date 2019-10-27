@extends('layouts.app')
{{-- @dump($images) --}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">

            {{-- Alert message --}}
            @include('includes.message')

            {{-- @if ($images) --}}
                {{-- Componente de Vue.js --}}
                <cards-component data-user="{{Auth::user()}}"></cards-component>
            
            {{-- @else --}}
                {{-- <div class="card text-center">
                  <div class="card-body">
                    <h4 class="card-title">Aun no hay post para mostrar</h4>
                    <a class="card-text" href="{{ route('image.create') }}">Subir una Imagen</a>
                  </div>
                </div> --}}
            {{-- @endif --}}
            
        </div>
    </div>
</div>
@endsection
