<div x-data="{ open: false }">
    <h1 class="text-center">lauu.CH</h1>
    <form class="pastebin" wire:submit.prevent="submit">

        <div wire:ignore class="mb-3">
            <textarea id="text" class="form-control" spellcheck="false" style="" name="text"
                wire:ignore>{{ $text }}</textarea>
        </div>
        <div id="options" class=" collapse" :class="{'show': open }" style="">
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

                    <input type="text" id="code" autocomplete="off" aria-describedby="baseurl" placeholder="Shortcode"
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
                            value="" placeholder="Password" class="form-control @error('password') is-invalid @enderror"
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
        <div class="">
            <a role="button" class="btn btn-warning" @click="open = !open">Options</a>
            <button class="btn" type="submit">Shorten</button>
        </div>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </form>
</div>

<style>
    /*  .pastebin textarea {
        width: 100%;
        min-height: 50vh;
    }*/

</style>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editor = codemirror.fromTextArea(document.getElementById("text"), {
                lineNumbers: true,
                theme: 'idea'
            });
            editor.on('change', function(instance, changeObj) {
                @this.set('text', editor.getValue(), true);
            })
            @this.on('resetCode', () => {
                editor.setValue("");
                editor.clearHistory();
            });
        });
    </script>

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
