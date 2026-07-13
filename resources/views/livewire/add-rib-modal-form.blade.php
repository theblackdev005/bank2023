<form action="{{ routeWithLocale('admin.add_rib.post') }}" method="post">
    @csrf

    <div class="form-group mb-4">
        <label class="form-label m-0">Compte client:</label>
        <select wire:model="selectedCustomerId" wire:change="updateSelectedCustomerId" name="add[customer_id]" id="" class="form-control">
            <option value=""></option>
            @foreach ($customers as $customer)
                @if ( ! $customer->rib()->exists() )
                    <option value="{{ $customer->id }}">{{ $customer->fullname() }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="row pt-3">
        @foreach (rib_keys() as $key => $name)
            <div class="col-md-6">
                <x-form-input label="{{ translate($name) }}" name="add.{{ $key }}"/>
            </div>
        @endforeach
    </div>

    <div class="bg-light p-4">
        <div class="form-group mb-0">
            <div>
                <label class="text-danger">Le client doit-il payer des frais, avant que son identité soit vérifiée ?</label>
            </div>
            <label for="no" class="mr-2 d-inline-block text-muted">
                <input wire:model="need_fee" type="radio" value="no" id="no"> Non
            </label>
            <label class="d-inline-block text-muted" for="yes">
                <input wire:model="need_fee" type="radio" value="yes" id="yes"> Oui
            </label>
        </div>

        @if ( $need_fee == 'yes' )
            <div class="form-group mb-0">                
                <p class="text-muted m-0 mb-2">Frais que le client doit payer sur le compte bancaire ci-dessus, afin que son identité soit vérifiée:</p>
                <div class="input-group mb-0">
                    <input wire:model="feeAmount" type="number" class="form-control shadow-none" autocomplete="nope" name="add[amount]" aria-describedby="basic-addon2" value="0" required>
                    <div class="input-group-append">
                        <span class="input-group-text font-weight-bold" id="basic-addon2">{{ optional($selectedCustomerCurrency)->name }}</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-4">
        <label for="" class="mb-0">Afficher le RIB sur le compte du client ?</label>
        <x-admin-custom-switch checked="false" name="add.enable" />
    </div>

    <div class="form-group d-flex justify-content-between">
        <button type="submit" name="submit" class="btn font-weight-bold btn-xs btn-success">
            <i class="fa fa-check-circle"></i> 
            <span>Ajouter</span>
        </button>
    </div>
</form>