<div wire:init="init">
    <form action="" wire:submit.prevent="submit" method="post">
        <x-alert />

        @if ( $provider )
            
            @foreach (['username', 'email', 'created_at'] as $key)
                <div class="form-group">
                    <label for="" class="form-label">{{ ucfirst($key) }}</label>
                    <div class="bg-light py-1 px-3 rounded border">
                        {{ $provider->$key }}
                    </div>
                </div>
            @endforeach 

        @else
            
            @foreach (['username', 'email', 'password'] as $key)
                <div class="form-group">
                    <label for="" class="form-label">{{ ucfirst($key) }}</label>
                    <input type="text" wire:model.defer="{{ $key }}" class="form-control">
                </div>
            @endforeach 

            <button type="submit" class="btn font-weight-bold btn-success">
                <span class="fa fa-check-circle"></span>
                <span>Créer un admin</span>
            </button>

        @endif

    </form>
</div>