<!DOCTYPE html>
<html>
    <head>
        <title>{{ View::hasSection('title') ? View::getSection('title') . ' - ' . config('app.name') : config('app.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="/twemoji-flags.css" />
        <script defer src="https://pro.fontawesome.com/releases/v5.10.0/js/all.js" integrity="sha384-G/ZR3ntz68JZrH4pfPJyRbjW+c0+ojii5f+GYiYwldYU69A+Ejat6yIfLSxljXxD" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:400,400i,600,600i" />
        <link rel="stylesheet" href="/css/app.css" />
        <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css" />
        <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
        <link rel="manifest" href="/site.webmanifest" />
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="theme-color" content="#ffffff" />
        <style>
            .ct-series-a .ct-slice-donut-solid {
                fill: #179BD1;
            }

            .ct-series-b .ct-slice-donut-solid {
                fill: #E4E8EB;
            }

            .ct-series-a .ct-line {
                stroke-width: 2px;
                stroke: #179BD1;
            }

            .theme-dark .ct-label {
                color: #758193;
            }

            [v-cloak] {
                display: none;
            }
        </style>
    </head>
    <body class="theme-{{ Auth::check() ? Auth::user()->theme : 'light' }}">
        <div id="app">
            @if (Auth::check())
                <div class="navigation">
                    <div class="wrapper">
                        <ul class="navigation__menu">
                            <li>
                                <a href="{{ route('dashboard') }}" {!! (Request::path() == 'dashboard') ? 'class="active"' : '' !!}><i class="fas fa-home fa-sm color-blue"></i> <span class="hidden ml-05">{{ __('general.dashboard') }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('transactions.index') }}" {!! (Request::path() == 'transactions') ? 'class="active"' : '' !!}><i class="fas fa-exchange-alt fa-sm color-green"></i> <span class="hidden ml-05">{{ __('models.transactions') }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('budgets.index') }}" {!! (Request::path() == 'budgets') ? 'class="active"' : '' !!}><i class="fas fa-wallet fa-sm color-red"></i> <span class="hidden ml-05">{{ __('models.budgets') }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('tags.index') }}" {!! (Request::path() == 'tags') ? 'class="active"' : '' !!}><i class="fas fa-tag fa-sm color-blue"></i> <span class="hidden ml-05">{{ __('models.tags') }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('reports.index') }}" {!! (Request::path() == 'reports') ? 'class="active"' : '' !!}><i class="fas fa-chart-line fa-sm color-green"></i> <span class="hidden ml-05">{{ __('pages.reports') }}</span></a>
                            </li>
                        </ul>
                        <ul class="navigation__menu">
                            <li>
                                <button-dropdown>
                                    <a slot="button" href="{{ route('transactions.create') }}">{{ __('actions.create') }} {{ __('models.transaction') }}</a>
                                    <ul slot="menu" v-cloak>
                                        <li>
                                            <a href="{{ route('tags.create') }}">{{ __('actions.create') }} {{ __('models.tag') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('imports.create') }}">{{ __('actions.create') }} {{ __('models.import') }}</a>
                                        </li>
                                    </ul>
                                </button-dropdown>
                            </li>
                            <li>
                                <a href="{{ route('activities.index') }}">
                                    <i class="fas fa-clock"></i>
                                </a>
                            </li>
                            @if (Auth::user()->spaces->count() > 1)
                                <li>
                                    <dropdown>
                                        <span slot="button">
                                            {{ $selectedSpace->abbreviated_name }} <i class="fas fa-caret-down fa-sm"></i>
                                        </span>
                                        <ul slot="menu" v-cloak>
                                            @foreach (Auth::user()->spaces as $space)
                                                <li>
                                                    <a href="{{ route('spaces.show', ['space' => $space->id]) }}">{{ $space->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </dropdown>
                                </li>
                            @endif
                            <li>
                                <dropdown>
                                    <span slot="button">
                                        <img src="{{ Auth::user()->avatar }}" class="avatar mr-05" /> <i class="fas fa-caret-down fa-sm"></i>
                                    </span>
                                    <ul slot="menu" v-cloak>
                                        <li>
                                            <a href="{{ route('imports.index') }}">{{ __('models.imports') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('settings.index') }}">{{ __('pages.settings') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}">{{ __('pages.log_out') }}</a>
                                        </li>
                                    </ul>
                                </dropdown>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            @if (Auth::check() && Auth::user()->verification_token)
                <div class="text-center" style="
                    padding: 15px;
                    color: #FFF;
                    background: #F86380;
                ">{!! __('general.verify_account') !!} (or <form method="POST" action="{{ route('resend_verification_mail') }}" style="display: inline-block;">{{ csrf_field() }}<button class="button link">resend</button></form>)</div>
            @endif
            @if (session('verification_mail_status'))
                <div class="wrapper mt-3">
                    @switch(session('verification_mail_status'))
                        @case('success')
                            @include('partials.alerts.success', ['payload' => ['classes' => '', 'message' => 'An e-mail has been sent your way']])
                            @break

                        @case('already_verified')
                            @include('partials.alerts.danger', ['payload' => ['classes' => '', 'message' => 'You\'ve already been verified']])
                            @break

                        @case('rate_limited')
                            @include('partials.alerts.danger', ['payload' => ['classes' => '', 'message' => 'Please wait a few minutes before requesting another e-mail']])
                            @break
                    @endswitch
                </div>
            @endif
            @yield('body')
            @if (auth()->check())
                <div class="text-center mb-3">
                    @if ($suggestionBoxEnabled)
                        <a class="fs-sm" href="{{ route('ideas.create') }}">{{ __('general.got_a_suggestion') }}?</a> &middot; {{ $versionNumber }}
                    @else
                        {{ $versionNumber }}
                    @endif
                </div>
            @endif
        </div>
        <script src="/js/app.js"></script>
        @yield('scripts')
    </body>
</html>
