<div {{ $attributes }}>
    <p class="mt-5">
        @if ($shortlink->user)
            {{ $shortlink->user->name }}
        @else
            {{ __('An unknown user') }}
        @endif
        {{ __('has created the paste.') }}
        </br>
        {{ __('If you think this link is against the ToS, please report it.') }}
    </p>
</div>
