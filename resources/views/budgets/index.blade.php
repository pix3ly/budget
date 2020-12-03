@extends('layout')

@section('title', __('models.budgets'))

@section('body')
    <div class="wrapper my-3">
        <div class="row">
            <div class="row__column row__column--middle">
                <h2>{{ __('models.budgets') }}</h2>
            </div>
            <div class="row__column row__column--compact row__column--middle">
                <a href="{{ route('budgets.create') }}" class="button">{{ __('actions.create') }} {{ __('models.budget') }}</a>
            </div>
        </div>
        <div class="box mt-3">
            @if (!count($budgets))
                <div class="box__section text-center">{{ __('general.empty_state', ['resource' => strtolower(__('models.budgets'))]) }}</div>
            @endif
            @foreach ($budgets as $budget)
                <div class="box__section">
                    <div>{{ $budget->tag->name }}</div>
                    <progress class="mt-2 mb-1" value="{{ $budget->spent }}" min="0" max="{{ $budget->amount }}"></progress>
                    <div style="font-size: 14px; font-weight: 600;">{!! $currency !!} {{ $budget->formatted_spent }} {{ __('general.of') }} {!! $currency !!} {{ $budget->formatted_amount }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
