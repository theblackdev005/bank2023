<div wire:init="init">
    <form action="" wire:submit.prevent="submit" method="post">
        <x-alert />

        @foreach (['basic', 'standard', 'premium'] as $key)
            <div class="form-group mb-4">
                <label for="" class="form-label">Couleur carte {{ strtoupper($key) }} ( <a href="{{ asset_img('cards/' . $key . '.svg') }}" target="_blank">consulter</a> )</label>
                <div class="row">
                    <div class="col-6">
                        <input type="text" placeholder="{{ $key }}" wire:model="title_card.{{ $key }}" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="text" wire:model="theme_card.{{ $key }}" class="form-control font-weight-bold text-white" style="background: {{ $theme_card[$key] }};">
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn font-weight-bold btn-success">
            <span class="fa fa-check-circle"></span>
            <span>Générer les cartes</span>
        </button>
    </form>
</div>