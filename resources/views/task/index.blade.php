@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task.index.tasks') }}</h1>
    <div class="d-flex">
        @auth
        <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">{{ __('view.task.index.add_new') }}</a>
        @endauth
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('id') }}</th>
                <th>{{ __('status') }}</th>
                <th>{{ __('name') }}</th>
                <th>{{ __('author') }}</th>
                <th>{{ __('assignee') }}</th>
                <th>{{ __('created_at') }}</th>
                @auth
                <th>{{ __('actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{optional($task->status)->name}}</td>
                    <td><a href="{{ route('tasks.show', $task) }}">{{$task->name}}</a></td>
                    <td>{{optional($task->createdBy)->name}}</td>
                    <td>{{optional($task->assignedTo)->name ?? '-'}}</td>
                    <td>{{$task->created_at}}</td>
                    @auth
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}">
                            {{ __('view.task.index.edit') }}
                        </a>
                        <a href="{{ route('tasks.destroy', $task) }}" data-confirm="{{ __('view.task.index.confirm_remove') }}" data-method="delete">
                            {{ __('view.task.index.remove') }}
                        </a>
                    </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
