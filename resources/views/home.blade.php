@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">

            {{-- Alert message --}}
            @include('includes.message')


            {{-- Bucle foreach to show image cards --}}
            @foreach ($images as $image)

                @include('includes.card_home', [ 'image' => $image ])

            @endforeach
            {{-- End bucle foreach --}}

            {{-- Show pagination --}}
            <div class="d-flex justify-content-center">
                {{ $images->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
