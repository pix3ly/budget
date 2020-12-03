@extends('layout')

@section('title', __('actions.create') . ' Budget')

@section('body')
    <div class="wrapper my-3">
        <h2>{{ __('actions.create') }} {{ __('models.budget') }}</h2>
        <div class="box mt-3">
            <form method="POST" action="/budgets">
                {{ csrf_field() }}
                <div class="box__section">
                    @if (session()->has('message'))
                        <div class="mb-2">{{ session('message') }}</div>
                    @endif
                    <div class="input input--small">
                        <label>{{ __('models.tag') }}</label>
                        <select name="tag_id">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        @include('partials.validation_error', ['payload' => 'tag_id'])
                    </div>
                    <div class="input input--small">
                        <label>{{ __('fields.period') }}</label>
                        <select name="period">
                            <option value="yearly">{{ __('calendar.intervals.yearly') }}</option>
                            <option value="monthly" selected>{{ __('calendar.intervals.monthly') }}</option>
                            <option value="weekly">{{ __('calendar.intervals.weekly') }}</option>
                            <option value="daily">{{ __('calendar.intervals.daily') }}</option>
                        </select>
                        @include('partials.validation_error', ['payload' => 'period'])
                    </div>
                    <div class="input input--small">
                        <label>{{ __('fields.amount') }}</label>
                        <input type="text" name="amount" />
                        @include('partials.validation_error', ['payload' => 'amount'])
                    </div>
                </div>
                <div class="box__section box__section--highlight row row--right">
                    <div class="row__column row__column--compact row__column--middle">
                        <a href="{{ route('budgets.index') }}">{{ __('actions.cancel') }}</a>
                    </div>
                    <div class="row__column row__column--compact ml-2">
                        <button class="button">{{ __('actions.create') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
