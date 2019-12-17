@extends('settings.layout')

@section('settings_title')
    <h2 class="mb-3">{{ __('models.tags') }}</h2>
@endsection

@section('settings_body')
    <div class="wrapper my-3">
        <h2>{{ __('actions.create') }} {{ __('models.tag') }}</h2>
        <div class="box mt-3">
            <form method="POST" action="/settings/tags" autocomplete="off">
                {{ csrf_field() }}
                <div class="box__section">
                    <div class="input input--small">
                        <label>{{ __('fields.name') }}</label>
                        <input type="text" name="name" />
                        @include('partials.validation_error', ['payload' => 'name'])
                    </div>
                    <div class="input input--small mb-0">
                        <label>{{ __('fields.color') }}</label>
                        <color-picker></color-picker>
                        @include('partials.validation_error', ['payload' => 'color'])
                    </div>
                </div>
                <div class="box__section box__section--highlight row row--right">
                    <div class="row__column row__column--compact row__column--middle">
                        <a href="/settings/tags">{{ __('actions.cancel') }}</a>
                    </div>
                    <div class="row__column row__column--compact ml-2">
                        <button class="button">{{ __('actions.create') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
