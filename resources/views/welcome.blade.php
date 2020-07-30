@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('views.welcome.taskManager') }}</h1>
            <p class="lead">{{ __('views.welcome.description') }}</p>
            <hr class="my-4">
            <p>{{ __('views.welcome.hexletProject') }}</p>
            <a class="btn btn-primary btn-lg" href="https://hexlet.io" role="button">{{ __('views.welcome.learnMore') }}</a>
        </div>
    </div>
@endsection
