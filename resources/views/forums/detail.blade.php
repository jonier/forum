@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-center text-muted">{{ __('Posts') }}</h1>

        @forelse ($posts as $post)

            <div class="panel panel-default">
                <div class="panel-heading">
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

    </div>
</div>

@endsection