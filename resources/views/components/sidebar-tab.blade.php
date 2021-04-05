<div class="{{ $isCurrentPath ? 'tw-bg-primary-light' : 'hover:tw-bg-primary-light' }} tw-rounded-md">
    <a class="tw-py-3 tw-px-5 tw-flex tw-items-center tw-text-sm {{ $isCurrentPath ? 'tw-text-primary-regular' : 'tw-text-gray-700 hover:tw-text-primary-regular' }}" href="{{ $path }}">
        <i class="{{ $icon }} tw-mr-2"></i>
        {{ $text }}
    </a>
</div>
