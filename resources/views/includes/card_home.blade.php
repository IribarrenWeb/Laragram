
{{-- Init card section --}}
<div class="card card-home mb-5">

    {{-- ******************** Card header ********************** --}}
    <div class="card-header bg-white d-flex">
        <div class="">
            <img class="avatar rounded-circle" src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" height="500px" alt="">
        </div>
        <div class="ml-3 mr-2 my-auto">
            <strong class="text-capitalize"><a class="text-muted" href="{{ route('user.perfil', ['nick' => $image->user->nick]) }}" title="">{{ $image->user->name . ' ' . $image->user->surname  }}</a></strong>
        </div>
        <span class="border-left pl-2 my-auto">{{ '@' . $image->user->nick }}</span>
    </div>
    {{-- ******************** END Card header ****************** --}}


    {{-- ****************** Card body ******************** --}}
    <div class="card-body p-0">
        <div class="w-100 d-flex">
            <a class="d-block m-auto" href="{{ route('image.detail', ['id' => $image->id ]) }}" title="">
                <img src="{{ route('image.get',['filename' => $image->image_path]) }}" alt="">
            </a>
        </div>
    </div>
    {{-- ****************** END Card body ******************** --}}


    {{-- ********************* Card footer ******************** --}}
    <div class="card-footer bg-white">

        {{-- Likes and comments icons --}}
        <div class="d-flex mb-2 icons">

            {{-- Likes --}}
            <div class="likes">
                {{-- Comprobacion de like del usuario identificado --}}
                @php($is_liked = false)

                @foreach ($image->likes as $like)
                    @if ($like->user->id == Auth::id())
                        @php($is_liked = true)
                    @endif
                @endforeach

                @php($like_path = $is_liked ? 'likered.png' : 'like.png')
                
                <img src="{{ asset("images/{$like_path}" )}}" 
                    class="{{ $is_liked ? 'like' : 'dislike' }}" 
                    data-id="{{ $image->id }}">
            </div>

            {{-- Comments --}}
            <div class="comment">
                <a href="{{ route('image.detail', ['id' => $image->id ]) }}">
                    <img src="{{ asset('images\comment.png') }}" width="30px" alt="">
                </a>
            </div>
            <div style="font-weight:500" class="mb-3 d-block info-likes w-100">               
            @if (count($image->likes) >= 1)
                Le gusta a <strong>{{ count($image->likes) }}</strong> personas
            @else
                Se el primero en indicar que te gusta.
            @endif
            </div> 
        </div>


        {{-- Show comments --}}
        <div class="d-block">
            <strong class="d-inline-block">{{ $image->user->nick }} - </strong>
            <p class="mb-0 d-inline-block">{{ $image->description }}</p>
            
            @if (count($image->comments) >= 2 || count($image->comments) != 0)
                <p class="mb-0 mt-2 comment"><a class="text-muted" href="{{ route('image.detail', ['id' => $image->id ]) }}" title="">Ver los {{ count($image->comments) }} comentarios. </a></p>

                @php($comment = $image->comments()->first())
            
                <div class="d-block comment_show">
                    <p class="mb-0 d-inline-block">
                        <strong class="d-inline-block mr-1">                                
                            {{ $comment->user->nick }}
                        </strong>
                        {{ $comment->content }}
                    </p>
                </div>
            @endif
        
        </div>

        {{-- Show hour --}}
        <div class="d-block time mt-2">
            <p class="text-uppercase text text-monospace text-muted mb-0">{{ \FormatTime::LongTimeFilter($image->created_at) }}</p>
        </div>

    </div>
    {{-- ********************* END Card footer ******************** --}}


    {{-- ********************** Form to post a comment ******************** --}}
    <div class="comment">
        <form class="form_comment" action="{{ route('comment.save') }}" accept-charset="utf-8">
            @csrf

            <div class="form-group d-flex mb-0 mt-2">
                <input type="hidden" name="id" value="{{ $image->id }}">
                <textarea class="form-control rounded-bottom border-bottom-0 border-left-0 border-right-0" type="text" name="content" value="" placeholder="Escribe un comentario"></textarea>
                <div class="input-group-append border-top border-left">
                    <button class="btn btn-sm bg-white text-primary font-weight-bold" type="submit" disabled>Post</button>
                </div>
            </div>
        </form>
    </div>
    {{-- ********************** END Form to post a comment ******************** --}}

</div>