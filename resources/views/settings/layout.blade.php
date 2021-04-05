@extends('layout')

@section('body')
    <div class="wrapper my-3">
        <div class="tw-flex tw-space-x-10">
            <div class="tw-flex-1 tw-space-y-2" style="max-width: 260px;">
                <x-sidebar-tab
                    icon="fas fa-user"
                    text="{{ __('general.profile') }}"
                    path="/settings/profile" />
                <x-sidebar-tab
                    icon="fas fa-lock"
                    text="{{ __('general.account') }}"
                    path="/settings/account" />
                <x-sidebar-tab
                    icon="fas fa-sliders-h"
                    text="{{ __('general.preferences') }}"
                    path="/settings/preferences" />
                <x-sidebar-tab
                    icon="fas fa-home"
                    text="{{ __('general.dashboard') }}"
                    path="/settings/dashboard" />
                @if ($arePlansEnabled)
                    <x-sidebar-tab
                        icon="fas fa-wallet"
                        text="{{ __('general.billing') }}"
                        path="/settings/billings" />
                @endif
                <x-sidebar-tab
                    icon="fas fa-rocket"
                    text="{{ __('models.spaces') }}"
                    path="/settings/spaces" />
            </div>
            <div class="tw-flex-auto">
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
