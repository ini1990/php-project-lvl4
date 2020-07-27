@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('views.task.index.list') }}</h1>
<div class="d-flex">
    @auth
    <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">{{ __('views.task.index.addNewTask') }}</a>
    @endauth
</div>
<table class="table mt-2">
    <thead>
        <tr>
            <th>{{ __('models.task.id') }}</th>
            <th>{{ __('models.task.status') }}</th>
            <th>{{ __('models.task.name') }}</th>
            <th>{{ __('models.task.creator') }}</th>
            <th>{{ __('models.task.assignee') }}</th>
            <th>{{ __('models.task.createdAt') }}</th>
            @auth
            <th>{{ __('models.task.actions') }}</th>
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
            <td>{{implode(', ', $task->labels->pluck('name')->all())}}</td>

            @auth
            <td>
                <a href="{{ route('tasks.edit', $task) }}">
                    {{ __('views.task.index.edit') }}
                </a>

                @can('delete-task', $task)

                <a href="{{ route('tasks.destroy', $task) }}" data-confirm="{{ __('views.task.index.confirm') }}"
                    data-method="delete">
                    {{ __('views.task.index.delete') }}
                </a>
                @endcan
            </td>
            @endauth
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
