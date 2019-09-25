@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10  main-content">
            @include('includes.message')

                <div class="row mx-0">

                    {{-- Image card--}}
                    <div class="card col-md-8 detail-image px-0">
                        <div class="card-body p-0">
                            <div class="w-100 h-100 d-flex align-items-center">
                                <img class="image w-100" src="{{ route('image.get',['filename' => $image->image_path]) }}" alt="">
                            </div>

                        </div>
                    </div>

                    {{-- SIDEBAR DETAIL --}}
                    <div class="card col-md-4 p-0 detail-sidebar">

                        {{-- Init row --}}
                        <div class="row mx-0">

                            {{-- INIT SECTION --}}
                                {{-- User nick --}}
                            <div class="col-md-12 card-header bg-white d-flex">
                                <div class="d-flex w-75">
                                    <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" alt="">
                                    <div class="ml-3 mr-2 my-auto">
                                        <strong class="font-weight-bold"><a class="text-decoration-none text-md" href="{{ route('user.perfil', ['nick' => $image->user->nick]) }}" title="">{{ $image->user->nick }}</a></strong>
                                    </div>
                                </div>
                                {{-- Edit and delete options --}}
                                @if ($image->user->id == Auth::id())

                                    <div class="w-50 mt-2 dropup">
                                        <a id="dropedit" data-toggle="dropdown" href=""><i class="fas fa-ellipsis-h float-right text-dark"></i></a>
                                        <div style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif;" class="dropdown-menu" aria-labelledby="dropedit">
                                            <a class="dropdown-item" href="{{ route('image.edit', ['id' => $image->id]) }}">Editar</a>
                                            <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modalDelete" href="#">Eliminar</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{-- END INIT SECTION --}}


                            {{-- MIDDLE SECTION --}}
                                {{-- Mostrar comentarios --}}
                            <div class="col-md-12 d-block overflow-hidden px-3 pt-1 comment-section">

                                <div class="pt-2">
                                    <div class="d-inline-block mr-3 mb-2">
                                        <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" alt="">
                                    </div>
                                    <strong class="d-inline-block mr-1">{{ $image->user->nick }}</strong>
                                    <p class="mb-0 d-inline-block">{{ $image->description }}</p>
                                </div>
                                <hr class="mb-1">
                                <span class="text-capitalize text-monospace text-muted mb-3 d-block">
                                    Comentarios ({{ count($image->comments) }})
                                </span>

                                {{-- Bucle para mostrar los comentarios --}}
                                @foreach ($image->comments as $comment)

                                    <div class="d-flex mb-2 position-relative">
                                        <div class="mr-3">
                                            <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>$comment->user->image]) }}" alt="">
                                        </div>
                                        <p class="mb-0 d-inline-block text-break">
                                            <strong class="d-inline-block mr-1 text-sm">{{ $comment->user->nick }}</strong>
                                            {{ $comment->content }}
                                            <br>
                                            <span style="font-size: 16px;" class="text-capitalize text-monospace text-muted mb-0">
                                                {{ \FormatTime::LongTimeFilter($comment->created_at) }}
                                                @if ($comment->user->id == Auth::id() || $image->user->id == Auth::id())
                                                    <a class="text-danger text-sm text-right text-lowercase" href="{{ route('comment.delete',['id' => $comment->id, 'image_id' => $image->id]) }}" title="">eliminar</a>
                                                @endif
                                            </span>
                                        </p>

                                    </div>

                                @endforeach

                            </div>
                            {{-- END MIDDLE SECTION --}}

                            {{-- FOOTER SECTION --}}
                            <div class="col-md-12 align-items-baseline px-0">
                                {{-- Likes and icons section --}}
                                <div class="row border-top px-0 mx-0 py-1">
                                    <div class="likes col-md-2 icons">
                                        {{-- Comprobacion de like del usuario identificado --}}
                                        @php
                                            $is_liked = false;
                                        @endphp
                                        @foreach ($image->likes as $like)
                                            @if ($like->user->id == Auth::id())
                                                <?php $is_liked = true;?>
                                            @endif
                                        @endforeach
                                        <i class="{{ $is_liked ? 'fas like' : 'far dislike' }} fa-heart" data-id="{{ $image->id }}"></i>
                                    </div>
                                    <div class="comment ml-3 col-md-2 icons">
                                        <i class="far fa-comment"></i>
                                    </div>
                                    <div class="col-md-11 mt-1 mb-0">
                                        @if (count($image->likes) >= 1)
                                            <strong class="d-block">Le gusta a <span class="text-primary">{{ count($image->likes) }}</span> personas</strong>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <p class="text-uppercase text text-monospace text-muted mb-0">{{ \FormatTime::LongTimeFilter($image->created_at) }}</p>
                                    </div>
                                </div>

                                {{-- Formulario para ingresar un comentario --}}
                                 <div class="comment">
                                    <form action="{{ route('comment.save') }}" method="POST" accept-charset="utf-8">
                                        @csrf

                                        <div class="form-group d-flex mb-0 mt-2">
                                            <input type="hidden" name="id" value="{{ $image->id }}">
                                            <input type="hidden" name="detail" value="true">
                                            <textarea class="form-control rounded-bottom border-bottom-0 border-left-0 border-right-0" type="text" name="content" value="" placeholder="Comentario" required></textarea>
                                            <div class="input-group-append border-top border-left">
                                                <button class="btn btn-sm bg-white text-primary font-weight-bold" type="submit">Post</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- END FOOTER SECTION --}}

                        </div>
                        {{-- End row --}}

                    </div>
                    {{-- END SIDEBAR DETAIL --}}

                </div>

        </div>
    </div>
</div>

@include('includes.modal',['image_id'=>$image->id])

@endsection