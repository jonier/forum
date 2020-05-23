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

        <h2>{{ __("Add a new forum") }}</h2>
        <hr>

        @include('partials.errors')

        <form method="POST" action="/forums">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="col-md-12 control-label">{{ __("Name") }}</label>
                <input id="name" class="form-control" name="name" value="{{ old('name') }}"/>
            </div>
            <div class="form-group">
                <label for="description" class="col-md-12 control-label">{{ __("Description") }}</label>
                <textarea id="description" class="form-control" name="description">{{ old('description') }}</textarea>
            </div>
            <button type="submit" name="addForum" class="btn btn-default">
                {{ __("Add forum") }}
            </button>
        </form>

    </div>
</div>

@endsection