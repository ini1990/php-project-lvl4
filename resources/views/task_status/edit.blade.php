
@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('Task Status') }}</h1>

    {{ Form::model($taskStatus, ['url' => route('task_statuses.update', $taskStatus), 'method' => 'PUT', 'class' => 'w-50']) }}

        <div class="form-group">
            {{ Form::label('name', __('Name')) }}
            {{ Form::text('name', $taskStatus->name, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
