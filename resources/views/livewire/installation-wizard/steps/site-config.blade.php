<div wire:init="init">
    <form action="" wire:submit.prevent="submit" method="post">
        <x-sweet-alert />

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

        <button type="submit" class="btn font-weight-bold btn-success">
            <span class="fa fa-check-circle"></span>
            <span>Modifier les configs</span>
        </button>
    </form>
</div>