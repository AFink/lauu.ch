<div class="row align-items-center mt-2">
    <div class="container mt-1">
        <div class="alert alert-dark" role="alert">
            @lang('The link you are trying to access is password protected').
        </div>
        <form wire:submit.prevent="submit">
            @csrf
            <div class="row m-0">
                <div class="input-group mb-3">
                    <input wire:model.defer="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="@lang('Password')"
                        required>
                    <button type="submit" class="btn btn-primary col-3">@lang('Enter')</button>
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
        </form>
    </div>
</div>
