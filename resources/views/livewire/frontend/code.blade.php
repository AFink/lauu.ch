<div>
    <div class="mb-3">
        <button wire:click="clone" class="btn btn-primary">
            {{ __('Clone + Edit') }}
        </button>
        <a href="{{ route('pastebin') }}" class="btn btn-primary">
            {{ __('New') }}
        </a>
        <a href="{{ route('visit', ['code' => $shortlink->code, 'type' => 'raw']) }}" class="btn btn-primary">
            {{ __('Raw') }} {{-- TODO: RAW --}}
        </a>
    </div>
    <pre><code>{{ $shortlink->target->code }}</code></pre>

    <x-disclaimer :shortlink="$shortlink" />

    @push('scripts')
        <script>
            hljs.highlightAll();
            hljs.initLineNumbersOnLoad();
        </script>
    @endpush
</div>
