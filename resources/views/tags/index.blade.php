@extends('layout')

@section('title', __('models.tags'))

@section('body')
    <div class="wrapper my-3">
        <div class="row mb-3">
            <div class="row__column row__column--middle">
                <h2>{{ __('models.tags') }}</h2>
            </div>
            <div class="row__column row__column--compact row__column--middle">
                <a href="{{ route('tags.create') }}" class="button">{{ __('actions.create') }} {{ __('models.tag') }}</a>
            </div>
        </div>
        <div class="box">
            @if (count($tags))
                <div class="box__section box__section--header row">
                    <div class="row__column row__column--compact mr-2" style="width: 20px;"></div>
                    <div class="row__column">{{ __('fields.name') }}</div>
                    <div class="row__column row__column--double" style="flex: 2;">{{ __('models.spendings') }}</div>
                </div>
                @foreach ($tags as $tag)
                    <div class="box__section row">
                        <div class="row__column row__column--compact row__column--middle mr-2">
                            <div style="width: 15px; height: 15px; border-radius: 2px; background: #{{ $tag->color }};"></div>
                        </div>
                        <div class="row__column row__column--middle">{{ $tag->name }}</div>
                        <div class="row__column row__column--middle">{{ $tag->spendings->count() }}</div>
                        <div class="row__column row__column--middle row row--right">
                            <div class="row__column row__column--compact">
                                <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}">
                                    <i class="fas fa-pencil"></i>
                                </a>
                            </div>
                            <div class="row__column row__column--compact ml-2">
                                @if ($tag->spendings->count())
                                    <i class="fas fa-trash-alt"></i>
                                @else
                                    <form method="POST" action="/tags/{{ $tag->id }}">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button class="button link">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @include('partials.empty_state', ['payload' => 'tags'])
            @endif
        </div>
    </div>
@endsection
