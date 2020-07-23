@extends('layouts.app')

@section('content')
<div class="container">

    {{Form::open(['url' => route('tasks.update', $task), 'method' => 'PUT'])}}
    <div class="form-group col-md-4">
        {{ Form::label('name', __('Name')) }}
        {{ Form::text('name', $task->name, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('description', __('Description')) }}
        {{ Form::text('description', $task->description, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('status_id', __('Status')) }}
        {{ Form::select('status_id', $taskStatuses, $task->status_id, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('assigned_to_id', __('Assigned')) }}
        {{ Form::select('assigned_to_id', $users, $task->assigned_to_id, ['class' => 'form-control'])}}
    </div>
    {{Form::submit('Add', ['class' => 'btn btn-primary btn-bg'])}}

    {{Form::close()}}
</div>
</div>
@endsection
