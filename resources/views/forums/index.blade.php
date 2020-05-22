@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-center text-muted">{{ __('Forums') }}</h1>

        @forelse ($forums as $forum)

            <div class="panel panel-default">
                <div class="panel-heading panel-heading-forum">
                    <a href="/forums/{{ $forum->id }}">{{ $forum->name }}</a>
                    <scan class="pull-right">
                        {{ __('Posts') }}: {{ $forum->posts->count() }},
                        {{ __('Replies') }}: {{ $forum->replies->count() }}
                    </scan>
                </div>

                <div class="panel-body">
                    {{ $forum->description }}
                </div>
            </div>        

        @empty
            <div class="alert alert-danger">
                {{ __('There are not any forums.') }}
            </div>
        @endforelse

        @if ($forum->count())
            {{ $forums->links() }}
        @endif

    </div>
</div>

@endsection