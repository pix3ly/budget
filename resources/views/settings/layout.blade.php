@extends('layout')

@section('body')
    <div class="wrapper my-3">
        <div class="row row--responsive">
            <div class="row__column mr-3" style="max-width: 300px;">
                <div class="box">
                    <div class="box__section box__section--header">{{ __('pages.settings') }}</div>
                    <ul class="box__section">
                        <li><a href="{{ route('settings.profile') }}"><i class="fas fa-user fa-sm"></i> {{ __('general.profile') }}</a></li>
                        <li><a href="{{ route('settings.account') }}"><i class="fas fa-lock fa-sm"></i> {{ __('general.account') }}</a></li>
                        <li><a href="{{ route('settings.preferences') }}"><i class="fas fa-sliders-h fa-sm"></i> {{ __('general.preferences') }}</a></li>
                        @if ($arePlansEnabled)
                            <li><a href="{{ route('settings.billing') }}"><i class="fas fa-wallet fa-sm"></i> {{ __('general.billing') }}</a></li>
                        @endif
                        <li><a href="{{ route('settings.spaces.index') }}"><i class="fas fa-rocket fa-sm"></i> {{ __('models.spaces') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="row__column">
                @yield('settings_title')
                <form method="POST" action="/settings" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @yield('settings_body')
                </form>
                @yield('settings_body_formless')
            </div>
        </div>
    </div>
@endsection
