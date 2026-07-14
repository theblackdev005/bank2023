<div wire:init="init">
    @php
        $labels = [
            'DB_CONNECTION' => 'Type de base de données',
            'DB_HOST' => 'Hôte de la base',
            'DB_PORT' => 'Port',
            'DB_DATABASE' => 'Nom de la base',
            'DB_USERNAME' => 'Utilisateur',
            'DB_PASSWORD' => 'Mot de passe',
        ];
    @endphp

    <form wire:submit.prevent="submit" method="post">
        <x-alert />

        <div class="alert bg-light border">
            <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                <div>
                    <span>État de la connexion : </span>
                    <span class="badge badge-{{ $dbIsConnected ? 'success' : 'secondary' }}">
                        {{ $dbIsConnected ? 'Connexion validée' : 'En attente de test' }}
                    </span>
                </div>
                @if ($connectionMessage)
                    <span class="text-success font-weight-bold">{{ $connectionMessage }}</span>
                @endif
            </div>
        </div>

        @if ($console_output)
            <div class="bg-secondary p-2 mb-3">
                <p class="m-0 font-weight-bold text-cmd">{!! nl2br(e($console_output)) !!}</p>
            </div>
        @endif

        <div class="row">
            @foreach ($data as $key => $value)
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label mb-0">{{ $labels[$key] ?? $key }}</label>
                        <small class="d-block text-muted mb-1">{{ $key }}</small>
                        <input
                            type="{{ $key === 'DB_PASSWORD' ? 'password' : 'text' }}"
                            autocomplete="off"
                            wire:model.defer="{{ $key }}"
                            class="form-control @error($key) is-invalid @enderror"
                        >
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex flex-wrap" style="gap: 8px;">
            <button type="submit" class="btn font-weight-bold btn-success">
                <span class="fa fa-check-circle"></span>
                <span>Tester et enregistrer</span>
            </button>
            <button type="button" @disabled(!$dbIsConnected) wire:click="migrate" class="btn font-weight-bold btn-dark">
                <span class="fa fa-upload"></span>
                <span>Lancer la migration</span>
            </button>
            <button type="button" wire:click="resetDatabaseConfig" class="btn font-weight-bold btn-outline-danger">
                <span class="fa fa-refresh"></span>
                <span>Réinitialiser</span>
            </button>
        </div>
    </form>
</div>
