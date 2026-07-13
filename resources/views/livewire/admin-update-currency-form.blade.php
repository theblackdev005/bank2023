<div class="row pt-3">    
    @foreach ($currencies as $currency)
        <div class="col-6 col-lg-2 mb-2">
            <label wire:click="makeUpdate()" for="{{ $currency->name }}{{ $currency->id }}" @class([
                    "bg-light"          => !$currency->isEnabled(),
                    "font-weight-bold"  ,
                    "d-block"           ,
                    "py-2"              ,
                    "px-3"              ,
                    "rounded"           ,
                    "text-center"       ,
                    "text-muted"        => !$currency->isEnabled(),
                    "text-white"        => $currency->isEnabled(),
                    "cursor-pointer"    ,
                    "bg-success" => $currency->isEnabled(),
                ])>
                {{ currency_view_map($currency) }} 
                <input type="checkbox" class="hidden d-none" wire:model="req_currency.{{ $currency->id }}" value="{{ $currency->id }}" id="{{ $currency->name }}{{ $currency->id }}">
            </label>
        </div>
    @endforeach
</div>