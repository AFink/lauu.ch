<div>
    <h1 class="text-center">{{ $shortlink->target->title ?? __('Links') }}</h1>
    @if ($shortlink->target->subtitle)
        <h2 class="text-center">{{ $shortlink->target->subtitle }}</h2>
    @endif

    <div class="row justify-content-center">
        <div class="mt-5 col-md-4">
            @foreach ($shortlink->target->items as $item)
                <a href="{{ $item->url }}" class="btn btn-primary btn-block w-100 mb-3"
                    style="background-color: {{ $item->color }};">{{ $item->name }}</a>

                </hr>
            @endforeach
        </div>
    </div>

    <x-disclaimer class="text-center" :shortlink="$shortlink" />
</div>
