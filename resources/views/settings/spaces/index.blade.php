@extends('settings.layout')

@section('settings_title')
    <h2>{{ __('models.spaces') }}</h2>
    <p class="mt-1 mb-3">{{ __('general.spaces_explanation') }}</p>
@endsection

@section('settings_body')
    <a class="button mb-2" href="{{ route('spaces.create') }}">{{ __('actions.create') }}</a>
    <div class="box">
        <ul class="box__section">
            @foreach ($spaces as $space)
                <li class="row row--middle">
                    <div class="row__column">{{ $space->name }} &middot; {{ ucfirst($space->pivot->role) }}</div>
                    <div class="row__column row__column--compact">
                        @can('edit', $space)
                            <a class="button button--secondary button--small" href="{{ route('spaces.edit', ['space' => $space->id]) }}">{{ __('pages.settings') }}</a>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
