<div x-data="{ open: false }">
    <h1 class="text-center">lauu.CH</h1>

    <form wire:submit.prevent="submit">
        <div>
            <div wire:sortable="updateOrder">
                @foreach ($items as $index => $item)
                    <div class="mt-3 mb-3 row" wire:sortable.item="{{ $index }}" wire:key="item-{{ $index }}">
                        <div class="col-md-auto d-none d-md-block align-self-center" wire:sortable.handle>
                            <x-tablericon-drag-drop />
                        </div>
                        <div class="col-md-6">
                            <input type="string" id="link-{{ $index }}" placeholder="Paste a long url"
                                class="form-control form-control-lg @error('items.' . $index . '.url') is-invalid @enderror"
                                wire:model.defer="items.{{ $index }}.url">
                            @error('items.' . $index . '.url') 
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md">
                            <input type="string" id="name-{{ $index }}" placeholder="name"
                                class="form-control form-control-lg  @error('items.' . $index . '.name') is-invalid @enderror"
                                wire:model.defer="items.{{ $index }}.name">
                            @error('items.' . $index . '.name') 
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-auto" wire:ignore>
                            <x-colorpicker wire:model="items.{{ $index }}.color" class="w-md-100"
                                x-data="{ color: '{{ $items[$index]['color'] }}' }"  />
                        </div>
                        <div class="col-md-1">
                            <a class="btn btn-outline-danger w-100" wire:click="removeItem({{ $index }})">del</a>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('items') <span class="">{{ $message }}</span> @enderror
            <div id="options" class="mb-3 collapse" :class="{'show': open }" style="">
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <input type="text" id="title" autocomplete="off" name="title" value="" placeholder="Title"
                            class="form-control @error('title') is-invalid @enderror" wire:model.defer="title">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md">
                        <input type="text" id="subtitle" autocomplete="off" name="subtitle" value=""
                            placeholder="Subtitle" class="form-control @error('subtitle') is-invalid @enderror"
                            wire:model.defer="subtitle">
                        @error('subtitle')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="input-group mb-3 col-md">
                        <div class="input-group-prepend">
                            <select class="form-select @error('domain') is-invalid @enderror" wire:model="domain">
                                @foreach ($domains as $d)
                                    <option value="{{ $d->id }}" @if ($d == $domains[0]) selected @endif>{{ $d->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('domain')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                        <input type="text" id="code" autocomplete="off" aria-describedby="baseurl"
                            placeholder="Shortcode"
                            class="form-control @error('code') is-invalid @elseif($code) is-valid @enderror"
                            wire:model="code">
                        <a class="btn btn-outline-secondary" wire:click="generate">
                            <x-tablericon-refresh />
                        </a>
                        @error('code')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4" x-data="{show:false}">
                        <div class="input-group input-group-flat {{ $errors->has('password') ? 'is-invalid' : '' }}">
                            <input x-bind:type="show ? 'text' : 'password'" id="password" autocomplete="off" name="code"
                                value="" placeholder="Password"
                                class="form-control @error('password') is-invalid @enderror"
                                wire:model.defer="password">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="{{ __('Show password') }}"
                                    x-on:click="show = !show" data-bs-toggle="tooltip">
                                    <x-tablericon-eye-off x-bind:class="{'d-none': !show, 'd-block':show }" />
                                    <x-tablericon-eye x-bind:class="{'d-none':show, 'd-block':!show }" />
                                </a>
                            </span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <a class="btn btn-outline btn-success" wire:click="addItem">{{ __('Add new row') }}</a>

            <a role="button" class="btn btn-warning" @click="open = !open">{{ __('Options') }}</a>
            <button class="btn" type="submit">{{ __('Shorten') }}</button>
        </div>
    </form>

    @push('scripts')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                @this.on('triggerModal', link => {
                    window.Swal.fire({
                        title: '{{ __('Link shortened') }}',
                        html: `<div class="input-group mt-3 mb-3">
                <input type="text" id="shortened" class="form-control" readonly value="${link}" />
                <div class="input-group-append" x-data="{ shortlink_url: '${link}', copied: false }">
                    <button x-on:click="$clipboard(shortlink_url); copied = !copied" class="btn btn-secondary" :class="{'btn-success': copied}" type="button">
                        <x-tablericon-clipboard />
                        {{ __('Copy') }}
                    </button>
                </div>
            </div>
            <div class="row share">
                <div class="col-md mb-3">
                    <a class="btn btn-lg btn-block twitter" rel="nofollow"
                        href="https://twitter.com/intent/tweet?url=${encodeURIComponent(link)}&amp;text=&amp;hashtags={{ env('HASHTAGS', 'lauuch') }}"
                        target="_blank">
                        <x-tablericon-brand-twitter />
                        {{ __('Twitter') }}
                    </a>
                </div>
                <div class="col-md mb-3">
                    <a class="btn btn-lg btn-block whatsapp" rel="nofollow"
                        href="https://wa.me/?text=${encodeURIComponent(link)}" target="_blank">
                        <x-tablericon-brand-whatsapp />
                        {{ __('Whatsapp') }}
                    </a>
                </div>
                <div class="col-md mb-3">
                    <a class="btn btn-lg btn-block telegram" rel="nofollow"
                        href="https://t.me/share/url?url=${encodeURIComponent(link)}" target="_blank">
                        <x-tablericon-brand-telegram />
                        {{ __('Telegram') }}
                    </a>
                </div>
            </div>`,
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#aaa',
                        cancelButtonText: '{{ __('Close') }}',
                        confirmButtonText: '{{ __('Open in new tab') }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open(link, '_blank').focus();
                        }
                    });
                });
            })
        </script>
    @endpush
</div>
