@extends('emails.template')

@section('title', __('emails.default_title'))

@section('message')
    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
        {{ __('emails.password_changed.message') }} ({{ $updated_at }} CEST).
    </p>
@endsection

@section('button')
    <a href="{{ config('app.url') }}/login" class="button button-blue" target="_blank" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #ffffff; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097d1; border-top: 10px solid #3097d1; border-right: 18px solid #3097d1; border-bottom: 10px solid #3097d1; border-left: 18px solid #3097d1;">
        {{ __('emails.password_changed.button') }}
    </a>
@endsection
