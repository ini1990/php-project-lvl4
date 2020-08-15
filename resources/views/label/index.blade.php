@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('views.label.index.list') }}</h1>
@auth
<a href="{{ route('labels.create') }}" class="btn btn-primary">{{ __('views.label.index.addNew') }}</a>
@endauth
<table class="table mt-2">
    <thead>
        <tr>
            <th>{{ __('models.label.id') }}</th>
            <th>{{ __('models.label.name') }}</th>
            @auth
            <th>{{ __('views.label.index.actions') }}</th>
            @endauth
        </tr>
    </thead>
    <tbody>
        @foreach($labels as $label)
        <tr>
            <td>{{$label->id}}</td>
            <td>{{$label->name}}</td>
            @auth
            <td>
                <a href="{{ route('labels.destroy', $label) }}" data-method="delete" rel="nofollow"
                    data-confirm="{{ __('views.label.index.confirm') }}">{{ __('views.label.index.delete') }}</a>
                <a href="{{ route('labels.edit', $label) }}">
                    {{ __('views.label.index.edit') }}
                </a>
            </td>
            @endauth
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
