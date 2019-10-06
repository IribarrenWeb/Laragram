@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">

            {{-- Alert message --}}
            @include('includes.message')

            @if (count($images) >= 1)
            
                {{-- Bucle foreach to show image cards --}}
                @foreach ($images as $image)

                    @include('includes.card_home', [ 'image' => $image ])

                @endforeach
                {{-- End bucle foreach --}}
                
                {{-- Show pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $images->links() }}
                </div>
            
            @else
                <div class="card text-center">
                  <div class="card-body">
                    <h4 class="card-title">Aun no hay post para mostrar</h4>
                    <a class="card-text" href="{{ route('image.create') }}">Subir una Imagen</a>
                  </div>
                </div>
            @endif
            
        </div>
    </div>
</div>
@endsection
