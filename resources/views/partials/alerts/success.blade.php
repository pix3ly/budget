<div class="row {{ $payload['classes'] }}" style="
    padding: 15px;
    color: #FFF;
    background: #AAD26F;
    border-radius: 5px;
">
    <div class="row__column row__column--compact" style="margin: auto; width: 5%;">
        <i class="fas fa-check fa-fw"></i>
    </div>
    <div class="row__column text-center" style="font-weight: 600;">
        {!! __('messages.' . $payload['message']) !!}
    </div>
</div>
