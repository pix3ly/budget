@extends('layout')

@section('title', __('actions.edit') . ' ' . __('models.space'))

@section('body')
    <div class="wrapper my-3">
        <h2 class="mb-3">{{ __('actions.edit') }} {{ __('models.space') }}</h2>
        <form method="POST" action="/spaces/{{ $space->id }}/update">
            {{ csrf_field() }}
            <div class="box">
                <div class="box__section row">
                    <div class="row__column">
                        <h2>{{ __('general.general') }}</h2>
                    </div>
                    <div class="row__column row__column--double">
                        <div class="input input--small">
                            <label>{{ __('fields.name') }}</label>
                            <input type="text" name="name" value="{{ $space->name }}" />
                        </div>
                        <div class="input input--small mb-0">
                            <label>{{ __('fields.currency') }}</label>
                            <select disabled>
                                <option>{{ $space->currency->name }}</option>
                            </select>
                            <div class="hint mt-05">You cannot modify the currency anymore</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row--right mt-2">
                <a class="button button--secondary mr-2" href="{{ route('settings.spaces.index') }}">{{ __('actions.cancel') }}</a>
                <button class="button">{{ __('actions.save') }}</button>
            </div>
        </form>
        <div class="box mt-3">
            <div class="box__section row">
                <div class="row__column">
                    <h2>{{ __('general.members') }}</h2>
                </div>
                <div class="row__column row__column--double">
                    @foreach ($space->users as $i => $user)
                        <div class="{{ $i > 0 ? 'mt-2' : null }}">
                            <div class="color-dark mb-1">{{ $user->name }}</div>
                            <div class="fs-sm">{{ ucfirst($user->pivot->role) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="box mt-3">
            <div class="box__section row">
                <div class="row__column">
                    <h2>{{ __('general.invites') }}</h2>
                </div>
                <div class="row__column row__column--double">
                    @if (!count($space->invites))
                        <span>There aren't any invites</span>
                    @endif
                    @foreach ($space->invites as $i => $invite)
                        <div class="{{ $i > 0 ? 'mt-2' : '' }}">
                            <div class="color-dark mb-1">{{ $invite->invitee->name }}</div>
                            <div class="fs-sm">{{ __('general.invited_by') }} {{ $invite->inviter->name }} &middot; {{ $invite->status }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="box mt-3">
            <div class="box__section row">
                <div class="row__column">
                    <h2>{{ __('general.invite_someone') }}</h2>
                </div>
                <div class="row__column row__column--double">
                    @if (session('inviteStatus'))
                        @switch(session('inviteStatus'))
                            @case('success')
                                <div class="color-green mb-2">An invite has been sent</div>
                                @break

                            @case('present')
                                <div class="color-red mb-2">User is already part of space</div>
                                @break

                            @case('exists')
                                <div class="color-red mb-2">Invite has already been sent</div>
                                @break
                        @endswitch
                    @endif
                    <form method="POST" action="/spaces/{{ $space->id }}/invite">
                        {{ csrf_field() }}
                        <div class="input input--small">
                            <label>{{ __('fields.email') }}</label>
                            <input type="email" name="email" />
                            @include('partials.validation_error', ['payload' => 'email'])
                        </div>
                        <div class="input input--small">
                            <label>{{ __('fields.role') }}</label>
                            <select name="role">
                                <option value="admin">Admin</option>
                                <option value="regular" selected>Regular</option>
                            </select>
                            @include('partials.validation_error', ['payload' => 'role'])
                        </div>
                        <button class="button">{{ __('actions.invite') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
