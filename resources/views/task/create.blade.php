@extends('layouts.app')

@section('content')
<div class="container">

    {{Form::open(['url' => route('tasks.store')])}}
    <div class="form-group col-md-4">
        {{ Form::label('name', __('models.task.name')) }}
        {{ Form::text('name', '', ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('description', __('models.task.description')) }}
        {{ Form::text('description', '', ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('status_id', __('models.task.status')) }}
        {{ Form::select('status_id', $taskStatuses, $defaultStatus, ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-4">
        {{ Form::label('assigned_to_id', __('models.task.assignee')) }}
        {{ Form::select('assigned_to_id', $users, null, ['placeholder' => '-', 'class' => 'form-control'])}}
    </div>
    {{Form::submit(__('Add'), ['class' => 'btn btn-primary btn-bg'])}}

    {{Form::close()}}
</div>
</div>
@endsection
