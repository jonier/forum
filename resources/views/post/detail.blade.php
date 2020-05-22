@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-center text-muted">{{ __('Debate replies :name', ['name' => $post->title]) }}</h1>
        <h4>{{ __('Discussion Owner') }}: {{ $post->owner->name }}</h4>

        <a href="/forums/{{ $post->forum->id }}" class="btn btn-info pull-right">
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
                </div>
            </div>        

        @empty
            <div class="alert alert-danger">
                {{ __('There are not any reply.') }}
            </div>
        @endforelse

        @if ($replies->count())
            {{ $replies->links() }}
        @endif

    </div>
</div>

@endsection