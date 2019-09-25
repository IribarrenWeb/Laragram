@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="w-100 text-center mb-4">
                <span class="display-4 font-satisfy"><strong class="text-primary">#</strong>Gente de Laragram</span>
                <hr class="mt-4">
            </div>

            {{-- Recorrer el array 'users y mostrarlo en pantalla' --}}
            @foreach ($users as $user)
                <div class="jumbotron jumbotron-fluid py-4 bg-white btn-edit rounded">
                    <div class="container">
                        <div class="d-block">
                            <img class="avatar avatar-med rounded-circle border-0 mb-4  mx-auto d-block" src="{{ route('user.avatar', ['filename' => $user->image]) }}" alt="">
                        </div>

                        <div class="d-block">
                            <h1 class="display-5 mb-3 text-center">{{ $user->nick }}</h1>
                            <p class="lead mb-0 text-center text-capitalize">{{ $user->name . ' ' . $user->surname }}</p>
                            <p class="text-center font-italic text-primary">Miembro desde {{ date_format($user->created_at, 'Y') }}</p>
                            <a href="{{ route('user.perfil', [ 'nick' => $user->nick ]) }}" class="btn btn-success d-block w-25 mx-auto mt-4">Ver perfil</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        {{-- Show pagination --}}
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection