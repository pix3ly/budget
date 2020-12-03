@extends('layout')

@section('title', __('models.imports'))

@section('body')
    <div class="wrapper my-3">
        <div class="row mb-3">
            <div class="row__column row__column--middle">
                <h2>{{ __('models.imports') }}</h2>
            </div>
            <div class="row__column row__column--compact row__column--middle">
                <a href="{{ route('imports.create') }}" class="button">{{ __('actions.create') }} {{ __('models.import') }}</a>
            </div>
        </div>
        <div class="box">
            @if (count($imports))
                <div class="box__section box__section--header row">
                    <div class="row__column">Name</div>
                    <div class="row__column">Status</div>
                    <div class="row__column row__column--compact" style="width: 150px;"></div>
                </div>
                @foreach ($imports as $import)
                    <div class="box__section row">
                        <div class="row__column">{{ $import->name }}</div>
                        <div class="row__column">{{ $import->status < 2 ? $import->status + 1 . ' / 3' : 'Completed' }}</div>
                        <div class="row__column row__column--compact text-right" style="width: 100px;">
                            @if ($import->status < 2)
                                <a href="{{ route('imports.' . ($import->status == 0 ? 'prepare' : 'complete'), ['import' => $import->id]) }}">Next</a>
                            @endif
                        </div>
                        <div class="row__column row__column--compact text-right" style="width: 50px;">
                            @if ($import->spendings->count())
                                <i class="fas fa-trash-alt"></i>
                            @else
                                <form method="POST" action="/imports/{{ $import->id }}">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="button link">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                @include('partials.empty_state', ['payload' => 'imports'])
            @endif
        </div>
    </div>
@endsection
