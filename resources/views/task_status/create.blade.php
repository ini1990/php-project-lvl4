@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('Create new Task Status') }}</h1>

    {{ Form::model($taskStatus, ['url' => route('task_statuses.store'), 'method' => 'POST', 'class' => 'w-50']) }}

        <div class="form-group">
            {{ Form::text('name', $taskStatus->name, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit(__('Create'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
