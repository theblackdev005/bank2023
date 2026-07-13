<div class="row pt-3">
    
    @foreach ($countries as $country)
        <div class="col-6 col-lg-2 mb-2">
            <label wire:click="makeUpdate()" for="{{ $country->iso }}{{ $country->id }}" @class([
                    "bg-light"          => !$country->isEnabled(),
                    "font-weight-bold"  ,
                    "d-block"           ,
                    "py-2"              ,
                    "px-3"              ,
                    "rounded"           ,
                    "text-center"       ,
                    "text-muted"        => !$country->isEnabled(),
                    "text-white"        => $country->isEnabled(),
                    "cursor-pointer"    ,
                    "bg-primary" => $country->isEnabled(),
                ])>
                {{ $country->name }} 
                <input type="checkbox" class="hidden d-none" wire:model="req_country.{{ $country->id }}" value="{{ $country->id }}" id="{{ $country->iso }}{{ $country->id }}">
            </label>
        </div>
    @endforeach
    
</div>