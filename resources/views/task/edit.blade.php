@extends('layouts.app')

@section('content')
<div class="container">

    {{Form::model($task, ['url' => route('tasks.update', $task), 'method' => "PATCH"])}}
    <div class="form-group col-md-4">
        {{ Form::label('name', __('models.task.name')) }}
        {{ Form::text('name', $task->name, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('description', __('models.task.description')) }}
        {{ Form::text('description', $task->description, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('status_id', __('models.task.status')) }}
        {{ Form::select('status_id', $taskStatuses, $task->status_id, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('assigned_to_id', __('models.task.assignee')) }}
        {{ Form::select('assigned_to_id', $users, $task->assigned_to_id, ['class' => 'form-control'])}}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('labels', __('views.task.create.labels')) }}
        <select name="labels[]" multiple class="multiselect-started form-control" data-placeholder="{{__('views.task.edit.chooseLabel')}}"
            data-tags="true">
            @foreach ($labels as $name)
            @if($task->labels()->pluck('name')->contains($name))
            <option selected value="{{ $name }}">{{ $name }}</option>
            @else
            <option value="{{ $name }}">{{ $name }}</option>
            @endif
            @endforeach
        </select>
    </div>
    {{Form::submit(__('views.task.edit.update'), ['class' => 'btn btn-primary btn-bg'])}}

    {{Form::close()}}
</div>
</div>
@endsection
