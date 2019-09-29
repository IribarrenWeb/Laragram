@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="jumbotron pt-0 mb-0 bg-transparent jumbotron-fluid">
                <div class="container d-flex">
                    <div class="w-25">
                        <img class="avatar avatar-med rounded-circle border-0 mb-4  mx-auto d-block" src="{{ route('user.avatar', ['filename' => $user->image]) }}" alt="">
                    </div>
                    <div class="w-75 my-auto px-4">
                        <div class="w-100">
                            <div class="d-block w-100 mb-3">
                                <h1 style="color:#262626; font-size: 28px;" class="text-regular d-inline-block">{{ $user->nick }}</h1>
                                @if ($user->id == Auth::id())

                                    <div class="float-right">
                                        <a href="{{ route('uconfig') }}" class="btn btn-sm btn-outline-secondary btn-edit">Editar perfil</a>
                                        <i class="ml-3 fas fa-cog"></i>
                                    </div>

                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="d-flex">
                                <p><span class="font-weight-bold">{{ count($images) }}</span> publicaciones</p>
                                <p><span class="font-weight-bold ml-4">{{ count($user->likes) }}</span> favoritos</p>
                                <p><span class="font-weight-bold ml-4">{{ $likes }}</span> likes</p>
                            </div>
                        </div>
                        <div style="font-size: 16px;" class="font-weight-light mb-5">
                            <span class="d-block font-weight-bold text-capitalize mt-3">{{ $user->name . ' ' . $user->surname }}</span>
                            <span class="d-block text-capitalize mt-1">Usuario desde {{ date_format($user->created_at, 'Y') }}</span>
                        </div>
                    </div>
                </div>
                <hr class="mb-0 mt-0">
            </div>
            
            @php
                $count = 0; 
            @endphp
            @foreach ($images as $image)

                @if ($count%3 == 0)
                    <div class="grid-container row">
                @endif
                 <?php $count += 1;?>
                <div class="col-md-4 p-0">
                <a href="{{ route('image.detail', ['id' => $image->id ]) }}"><img class="grid-img" src="{{ route('image.get', ['filename' => $image->image_path]) }}" alt="imagen de {{ $image->user->nick }}"></a>

                </div>
                @if ($count%3 == 0)
                    </div>
                @endif


            @endforeach


        </div>
    </div>
    {{-- Show pagination --}}
    <div class="d-flex justify-content-center">
        {{ $images->links() }}
    </div>
</div>
@endsection