@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-center text-muted">
            {{ __('Forum name posts :name', ['name' => $forum->name]) }}
        </h1>
        <a href="/" class="btn btn-info pull-right">
            {{ __("Back to the forom list") }}
        </a>

        <div class="clearfix"></div>
        <br />
        @forelse ($posts as $post)

            <div class="panel panel-default">
                <div class="panel-heading panel-heading-post">
                    <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                    <scan class="pull-right">
                        {{ __('Owner') }}: {{ $post->owner->name }}
                    </scan>
                </div>

                <div class="panel-body">
                    {{ $post->description }}

                    @if ($post->attachment)
                        <img src="{{ $post->pathAttachment() }}" alt="" class="img-responsive img-rounded">
                    @endif
                </div>
                @if ($post->isOwner())
                <div class="panel -foot">
                    <form action="/posts/{{ $post->slug }}" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" name="deletePost" class="btn btn-danger ml-1">
                            {{ __("Delete post") }}
                        </button>
                    </form>
                </div>
                @endif
            </div>        

        @empty
            <div class="alert alert-danger">
                {{ __('There are not any post.') }}
            </div>
        @endforelse

        @if ($posts->count())
            {{ $posts->links() }}
        @endif

        @Logged()
            <h3 class="text-muted">{{ __("Add a new post to the forum :name", ['name' => $forum->name]) }}</h3>
            @include('partials.errors')

            {{-- 
                    enctype="multipart/form-data" this instruction is very important to upload files toward the data base.
            --}}            
            <form method="POST" action="/posts" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="forum_id" value="{{ $forum->id }}"/>

                <div class="form-group">
                    <label for="title" class="col-md-12 control-label">{{ __("Title") }}</label>
                    <input id="title" class="form-control" name="title" value="{{ old('title') }}"/>
                </div>

                <div class="form-group">
                    <label for="description" class="col-md-12 control-label">{{ __("Description") }}</label>
                    <textarea id="description" class="form-control"
                              name="description">{{ old('description') }}
                    </textarea>
                </div>

                <label class="btn btn-warning" for="file">
                    <input id="file" name="file" type="file" style="display:none;">
                    {{ __("Upload file") }}
                </label>

                <button type="submit" name="addPost" class="btn btn-default">{{ __("Add post") }}</button>
            </form>
        @else
            @include('partials.login_link', ['message' => __("Start a session to create a post")])
        @endLogged()

    </div>
</div>

@endsection