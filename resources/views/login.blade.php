@extends('layout')

@section('body')
    <div class="wrapper wrapper--narrow my-3">
        <div class="text-center">
            <img src="/logo.svg" style="width: 100%; max-height: 50px;" />
            <h2 class="mt-2 mb-3">Log in</h2>
        </div>
        @if (session('alert_type') && session('alert_message'))
            @include('partials.alerts.' . session('alert_type'), ['payload' => ['classes' => 'mb-2', 'message' => session('alert_message')]])
        @endif
        <div class="box">
            <div class="box__section">
                <form method="POST">
                    {{ csrf_field() }}
                    <div class="input">
                        <label>E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="shadow" autofocus />
                    </div>
                    <div class="input">
                        <label>Password</label>
                        <input type="password" name="password" class="shadow" />
                        <div class="mt-1 text-right">
                            <a href="{{ route('reset_password') }}" class="fs-sm">Forgot your password?</a>
                        </div>
                    </div>
                    <button class="button button--wide">Log in</button>
                </form>
            </div>
        </div>
        <div class="text-center mt-2">
            <a class="fs-sm" href="{{ route('register') }}">New to Budget?</a>
        </div>
    </div>
@endsection
