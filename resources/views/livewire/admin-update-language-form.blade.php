<div class="row pt-3">

    @foreach ($languages as $language)
        <div class="col-6 col-lg-2 mb-2">

            @if ( !$check_active && $language->isEnabled() )
                <button type="button" disabled class="py-2 px-3 border-0 w-100 rounded font-weight-bold">
                    {{ $language->name }} 
                </button>
            @else
                <label wire:click="makeUpdate()" for="{{ $language->iso }}{{ $language->id }}" @class([
                        "bg-light"          => !$language->isEnabled(),
                        "font-weight-bold"  ,
                        "d-block"           ,
                        "py-2"              ,
                        "px-3"              ,
                        "rounded"           ,
                        "text-center"       ,
                        "text-muted"        => !$language->isEnabled(),
                        "text-white"        => $language->isEnabled(),
                        "cursor-pointer"    ,
                        "bg-warning" => $language->isEnabled(),
                    ])>
                    {{ $language->name }} 
                    <input type="checkbox" class="hidden d-none" wire:model="req_language.{{ $language->id }}" value="{{ $language->id }}" id="{{ $language->iso }}{{ $language->id }}">
                </label>
            @endif
            
        </div>
    @endforeach
    
</div>