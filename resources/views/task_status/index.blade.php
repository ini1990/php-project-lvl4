@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('Task Statuses') }}</h1>
@auth
<a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('Add') }}</a>
@endauth
<table class="table mt-2">
    <thead>
        <tr>
            <th>{{ __('id') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Created At') }}</th>
            @auth
            <th>{{ __('Actions') }}</th>
            @endauth
        </tr>
    </thead>
    <tbody>
        @foreach($taskStatuses as $taskStatus)
        <tr>
            <td>{{$taskStatus->id}}</td>
            <td>{{$taskStatus->name}}</td>
            <td>{{$taskStatus->created_at}}</td>
            @auth
            <td>
                <a href="{{ route('task_statuses.destroy', $taskStatus) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('Are you sure?') }}">{{ __('Destroy') }}</a>
                <a href="{{ route('task_statuses.edit', $taskStatus) }}">
                    {{ __('Edit') }}
                </a>
            </td>
            @endauth
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
