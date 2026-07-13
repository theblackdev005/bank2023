<form wire:submit.prevent="submit_transfer_code" id="withdraw-send-money" data-background="dark" action="" method="POST" class="form breakTag bg-offwhite py-4">
    <x-dyn-recipient-data :data=$pending_transfert showForm="{{ $loadsection ? 'no' : 'yes' }}" />

    @if ($form_error_msg)
        <div class="alert alert-danger">{{ $form_error_msg }}</div>
    @endif

    <x-transfer-stats 
        :data=$pending_transfert 
        percentage="{{ $pending_fee->percentage }}" />

    <div class="pt-2">
        @if ( !$loadsection )
            <x-transfer-more-informations :fee=$pending_fee />
        @else
            <x-transfer-more-informations />
        @endif
    </div>

</form>