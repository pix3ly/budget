@extends('layout')

@section('title', 'Register')

@section('body')
    <div class="wrapper wrapper--narrow my-3">
        <div class="text-center">
            <img src="/logo.svg" style="width: 100%; max-height: 50px;" />
            <h2 class="mt-2 mb-3">Register</h2>
        </div>
        <div class="box">
            <div class="box__section">
                <form method="POST">
                    {{ csrf_field() }}
                    <div class="input">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="shadow" />
                        @include('partials.validation_error', ['payload' => 'name'])
                    </div>
                    <div class="input">
                        <label>E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="shadow" />
                        @include('partials.validation_error', ['payload' => 'email'])
                    </div>
                    <div class="input">
                        <label>Password</label>
                        <input type="password" name="password" class="shadow" />
                        @include('partials.validation_error', ['payload' => 'password'])
                    </div>
                    <div class="input">
                        <label>Verify Password</label>
                        <input type="password" name="password_confirmation" class="shadow" />
                        @include('partials.validation_error', ['payload' => 'password_confirmation'])
                    </div>
                    <div class="input">
                        <label>Currency</label>
                        <select name="currency" class="shadow">
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->name }} ({!! $currency->symbol !!})</option>
                            @endforeach
                        </select>
                        @include('partials.validation_error', ['payload' => 'currency'])
                    </div>
                    <button class="button button--wide">Register</button>
                </form>
            </div>
        </div>
        <div class="text-center mt-2">
            <a class="fs-sm" href="{{ route('login') }}">Already on Budget?</a>
        </div>
    </div>
@endsection
