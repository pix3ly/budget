<div class="box__section text-center">
    <div class="mb-1">{{ __('general.empty_state', ['resource' => strtolower(__('models.' . $payload))]) }}</div>
    <a href="{{ route($payload . '.create') }}" style="font-size: 14px;">{{ __('actions.create') }}</a>
</div>
