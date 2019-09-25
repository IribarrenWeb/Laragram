@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <img class="avatar avatar-big rounded-circle border-0 mb-4  mx-auto d-block" src="{{ route('user.avatar', ['filename' => Auth::user()->image]) }}" alt="">
                    <h1 class="display-5 text-center">{{ $user->nick }}</h1>
                    <p class="lead mb-0 text-center">Mis imagenes favoritas</p>
                    <div class="d-flex mx-auto justify-content-around mt-5 w-50">
                        <button type="button" class="btn btn-outline-info hover-white d-block w-40">Propias</button>
                        <button type="button" class="btn btn-outline-info hover-white d-block w-40">De usuarios</button>
                    </div>
                </div>
            </div>
            {{-- <div class="row"> --}}
                @php
                    $count = 0;
                @endphp
                @foreach ($likes as $like)

                    @if ($like->image->user_id != $user->id)

                        @if ($count%3 == 0)
                            <div class="grid-container row">
                        @endif
                         <?php $count += 1;?>
                        <div class="col-md-4 p-0">
                            <a href="{{ route('image.detail', ['id' => $like->image->id ]) }}"><img class="grid-img" src="{{ route('image.get',['filename' => $like->image->image_path]) }}" alt="imagen de {{ $like->image->user->nick }}"></a>
                        </div>
                        @if ($count%3 == 0)
                            </div>
                        @endif

                    @endif

                @endforeach
            {{-- </div> --}}

        </div>
    </div>
</div>
@endsection
