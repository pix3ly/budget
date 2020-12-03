@extends('layout')

@section('title', __('models.recurrings'))

@section('body')
    <div class="wrapper my-3">
        <div class="row mb-3">
            <div class="row__column row__column--middle">
                <h2>{{ __('models.recurrings') }}</h2>
            </div>
            <div class="row__column row__column--compact row__column--middle">
                <a href="{{ route('recurrings.create') }}" class="button">{{ __('actions.create') }} {{ __('models.recurring') }}</a>
            </div>
        </div>
        <div class="box mt-3">
            @if (count($recurrings))
                @foreach ($recurrings as $recurring)
                    <div class="box__section row">
                        <div class="row__column">
                            <div class="color-dark">
                                <a href="{{ route('recurrings.show', ['recurring' => $recurring->id]) }}">{{ $recurring->description }}</a>
                            </div>
                            <div class="row mt-1">
                                <div class="row__column row__column--compact" style="font-size: 14px; font-weight: 600;">{!! $currency !!} {{ \App\Helper::formatNumber($recurring->amount / 100) }}</div>
                                @if ($recurring->due_days)
                                    <div class="row__column row__column--compact ml-2" style="font-size: 14px; font-weight: 600;"><i class="fas fa-clock"></i> Due in {{ $recurring->due_days }} days</div>
                                @endif
                            </div>
                        </div>
                        <div class="row__column row__column--middle">
                            @if ($recurring->status)
                                <span style="border-radius: 5px; background: #D8F9E8; color: #51B07F; padding: 5px 10px; font-size: 14px; font-weight: 600;"><i class="fas fa-check fa-xs"></i> Active</span>
                            @else
                                <span style="border-radius: 5px; background: #FFE7EC; color: #F25C68; padding: 5px 10px; font-size: 14px; font-weight: 600;"><i class="fas fa-times fa-xs"></i> Inactive</span>
                            @endif
                        </div>
                        <div class="row__column row__column--middle">
                            @if ($recurring->tag)
                                @include('partials.tag', ['payload' => $recurring->tag])
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                @include('partials.empty_state', ['payload' => 'recurrings'])
            @endif
        </div>
    </div>
@endsection
