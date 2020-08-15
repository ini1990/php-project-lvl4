@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('views.label.create.createNewLabel') }}</h1>

{{ Form::open(['url' => route('labels.store'), 'class' => 'w-50']) }}

<div class="form-group">
    {{ Form::text('name', '', ['class' => 'form-control']) }}
</div>

{{ Form::submit(__('views.label.create.create'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection
