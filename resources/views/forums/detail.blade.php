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
                    <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                    <scan class="pull-right">
                        {{ __('Owner') }}: {{ $post->owner->name }}
                    </scan>
                </div>

                <div class="panel-body">
                    {{ $post->description }}
                </div>
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

                <button type="submit" name="addPost" class="btn btn-default">{{ __("Add post") }}</button>
            </form>
        @else
            @include('partials.login_link', ['message' => __("Start a session to create a post")])
        @endLogged()

    </div>
</div>

@endsection