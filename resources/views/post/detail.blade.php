@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-center text-muted">{{ __('Debate replies :name', ['name' => $post->title]) }}</h1>
        <h4>{{ __('Discussion Owner') }}: {{ $post->owner->name }}</h4>

        <a href="/forums/{{ $post->forum->slug }}" class="btn btn-info pull-right">
            {{ __("Back to the foro :name", ['name' => $post->forum->name]) }}
        </a>

        <div class="clearfix"></div>
        <br />

        @forelse ($replies as $reply)

            <div class="panel panel-default">
                <div class="panel-heading panel-heading-reply">
                    <p>{{ __('Reply from') }}: {{ $reply->author->name }}</p>
                </div>

                <div class="panel-body">
                    {{ $reply->reply }}

                    @if ($reply->attachment)
                        <img src="{{ $reply->pathAttachment() }}" alt="" class="img-responsive img-rounded">
                        
                    @endif
                </div>

                @if ($reply->isAuthor())
                <div class="panel -foot">
                    <form action="{{ route('replies.delete', [$reply->id]) }}" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" name="deleteReply" class="btn btn-danger ml-1">
                            {{ __("Delete reply") }}
                        </button>
                    </form>
                </div>
                    
                @endif
            </div>        

        @empty
            <div class="alert alert-danger">
                {{ __('There are not any reply.') }}
            </div>
        @endforelse

        @if ($replies->count())
            {{ $replies->links() }}
        @endif

        @Logged()
            <h3 class="text-muted">{{ __("Add a new reply to the post :name", ['name' => $post->name]) }}</h3>
            @include('partials.errors')
            {{-- 
                    enctype="multipart/form-data" this instruction is very important to upload files toward the data base.
            --}}
            <form method="POST" action="/replies" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                
                <div class="form-group">
                    <label for="reply" class="col-md-12 control-label">{{ __("Reply") }}</label>
                    <textarea id="reply" class="form-control" name="reply">{{ old('reply') }}</textarea>
                </div>

                <label class="btn btn-warning" for="file">
                    <input id="file" name="file" type="file" style="display:none;">
                    {{ __("Upload file") }}
                </label>
                
                <button type="submit" name="addReply" class="btn btn-default">{{ __("Add reply") }}</button>
            </form>

        @else
            @include('partials.login_link', ['message' => __("Start session to reply")])
        @endLogged()

    </div>
</div>

@endsection