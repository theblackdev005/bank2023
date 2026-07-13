<div wire:init="init">
    <form action="" wire:submit.prevent="submit" method="post">
        <x-alert />

        @foreach (['site_key', 'secret_key'] as $key)
            <div class="form-group">
                <label for="" class="form-label">{{ ucfirst($key) }}</label>
                <input type="text" wire:model.defer="{{ $key }}" class="form-control">
            </div>
        @endforeach 

        <button type="submit" class="btn font-weight-bold btn-success">
            <span class="fa fa-check-circle"></span>
            <span>Configurer recaptcha</span>
        </button>
    </form>
</div>