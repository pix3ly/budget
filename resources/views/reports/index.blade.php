@extends('layout')

@section('title', __('pages.reports'))

@section('body')
    <div class="wrapper my-3">
        <h2>{{ __('pages.reports') }}</h2>
        <div class="row row--gutter row--responsive mt-3">
            <div class="row__column">
                <div class="card">
                    <a href="{{ route('reports.show', ['slug' => 'weekly-report']) }}">{{ __('reports.weekly_balance.title') }}</a>
                    <p class="mt-1">{!! __('reports.weekly_balance.description') !!}</p>
                </div>
            </div>
            <div class="row__column">
                <div class="card">
                    <a href="{{ route('reports.show', ['slug'  => 'most-expensive-tags']) }}">{{ __('reports.most_expensive_tags.title') }}</a>
                    <p class="mt-1">{!! __('reports.most_expensive_tags.description') !!}</p>
                </div>
            </div>
            <div class="row__column">
                <!-- EMPTY -->
            </div>
        </div>
    </div>
@endsection
