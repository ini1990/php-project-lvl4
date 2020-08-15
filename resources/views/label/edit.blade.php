
@extends('layouts.app')

@section('content')
    {{ Form::model($label, ['url' => route('labels.update', $label), 'method' => 'PATCH', 'class' => 'w-50']) }}

        <div class="form-group">
            {{ Form::label('name', __('models.label.name')) }}
            {{ Form::text('name', $label->name, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit(__('views.label.edit.update'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
