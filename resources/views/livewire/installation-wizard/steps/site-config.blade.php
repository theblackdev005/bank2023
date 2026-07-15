<div wire:init="init">
    <form action="" wire:submit.prevent="submit" method="post">
        <x-sweet-alert />

        <section class="border bg-white p-3 mb-4">
            <div class="mb-3">
                <h5 class="font-weight-bold mb-1">Identité visuelle</h5>
                <p class="text-muted mb-0">Configurez les images utilisées sur le site, dans l'administration et sur les documents.</p>
            </div>

            <div class="row">
                <div class="col-md-7 mb-3 mb-md-0">
                    <label class="form-label d-block" for="installation-logo">Logo du site</label>
                    <div class="border bg-light d-flex align-items-center justify-content-center mb-2 p-3" style="min-height: 100px;">
                        <img
                            src="{{ ($logo && !$errors->has('logo')) ? $logo->temporaryUrl() : asset_img('logo.png') . '?v=' . $visualAssetVersion }}"
                            alt="Aperçu du logo"
                            style="max-width: 100%; max-height: 74px; width: auto;"
                        >
                    </div>
                    <input id="installation-logo" type="file" class="form-control-file" wire:model="logo" accept="image/png">
                    <small class="form-text text-muted">Image PNG, dimensions libres.</small>
                    @error('logo') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-5">
                    <label class="form-label d-block" for="installation-favicon">Favicon</label>
                    <div class="border bg-light d-flex align-items-center justify-content-center mb-2 p-3" style="min-height: 100px;">
                        <img
                            src="{{ ($favicon && !$errors->has('favicon')) ? $favicon->temporaryUrl() : asset_img('icons/favicon.png') . '?v=' . $visualAssetVersion }}"
                            alt="Aperçu du favicon"
                            style="width: 56px; height: 56px; object-fit: contain;"
                        >
                    </div>
                    <input id="installation-favicon" type="file" class="form-control-file" wire:model="favicon" accept="image/png">
                    <small class="form-text text-muted">Image PNG, dimensions libres.</small>
                    @error('favicon') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>
            </div>

            <div wire:loading wire:target="logo,favicon" class="text-muted mt-3">
                <span class="fa fa-spinner fa-spin mr-1"></span>
                Préparation de l'aperçu...
            </div>
        </section>

        @foreach ($configs as $id => $config)
            <div class="form-group mb-2">
                <div class="bg-light py-2 shadow-sm px-3" wire:ignore>
                    <label class="form-label m-0">
                        <span class="badge bg-primary text-white">#{{ $id + 1 }}</span>
                        <span>{{ $config->name }}</span>

                        @if ( $config->auto_set )
                            <br>
                            @foreach (explode('|', $config->auto_set) as $value)
                                <span class="badge badge-success">{{ $value }}</span>
                            @endforeach
                        @endif
                    </label>
                    <p class="text-muted m-0 mb-1">{{ $config->comment }}</p>

                    @if ( $config->input_type === 'textarea' )
                        <textarea class="form-control bg-white" wire:model.lazy="posts.{{ $config->name }}"></textarea>
                    @elseif ( $config->input_type === 'boolean' )
                        <label for="{{ $config->name }}__yes" class="form-label">
                            <input 
                                type="radio" 
                                id="{{ $config->name }}__yes" 
                                wire:model.lazy="posts.{{ $config->name }}" 
                                name="{{ $config->name }}" value="1"> OUI
                        </label>
                        <label for="{{ $config->name }}__no" class="form-label">
                            <input 
                                type="radio" 
                                id="{{ $config->name }}__no" 
                                wire:model.lazy="posts.{{ $config->name }}" 
                                name="{{ $config->name }}" value="0"> NON
                        </label>
                    @else
                        <input type="{{ $config->input_type }}" class="form-control bg-white" autocomplete="nope" wire:model.defer="posts.{{ $config->name }}">
                    @endif

                </div>
            </div>
        @endforeach

        <button type="submit" class="btn font-weight-bold btn-success" wire:loading.attr="disabled" wire:target="logo,favicon,submit">
            <span class="fa fa-check-circle"></span>
            <span>Enregistrer la configuration</span>
        </button>
    </form>
</div>
