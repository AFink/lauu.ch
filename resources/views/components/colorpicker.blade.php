<div x-init="
        picker = new Picker($refs.button);
        picker.setOptions({alpha: false});
        picker.onClose = rawColor => {
            color = rawColor.hex;
            $dispatch('input', color)
        }
        picker.onChange = rawColor => {
            color = rawColor.hex;
        }
        $wire.on('updateColor', () => {
            picker.setColor(@entangle($attributes->wire('model')), true);
            console.log(@entangle($attributes->wire('model')));
        })

    " wire:ignore {{ $attributes }}>
    <button class="avatar text-white" :style="`background: ${color}`" x-ref="button"></button>
</div>
