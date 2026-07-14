<div wire:init="init">
    @php
        $labels = [
            'MAIL_HOST' => 'Serveur SMTP',
            'MAIL_PORT' => 'Port SMTP',
            'MAIL_USERNAME' => 'Identifiant SMTP',
            'MAIL_PASSWORD' => 'Mot de passe SMTP',
            'MAIL_ENCRYPTION' => 'Sécurité',
            'MAIL_FROM_ADDRESS' => 'Adresse expéditeur',
        ];
    @endphp

    <form wire:submit.prevent="submit" method="post">
        <x-alert />

        <p class="text-muted mb-3">La connexion sera testée avec les informations saisies avant leur enregistrement.</p>

        <div class="row">
            @foreach ($data as $key => $value)
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label mb-0">{{ $labels[$key] ?? $key }}</label>
                        <small class="d-block text-muted mb-1">{{ $key }}</small>
                        <input
                            type="{{ $key === 'MAIL_PASSWORD' ? 'password' : 'text' }}"
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
            <button type="button" wire:click="resetMailConfig" class="btn font-weight-bold btn-outline-danger">
                <span class="fa fa-refresh"></span>
                <span>Réinitialiser SMTP</span>
            </button>
        </div>
    </form>
</div>
