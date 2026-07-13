<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer;

class AddRibModalForm extends Component
{
    public $selectedCustomerId = null;
    public $selectedCustomerCurrency = null;
    public $customers = [];

    public $need_fee = 'no';
    public $feeAmount = 0;

    public function mount($customers) {
        $this->customers = $customers;
    }

    public function updateSelectedCustomerId()
    {
        $this->selectedCustomerCurrency = null;

        if ( ! $this->selectedCustomerId ) {
            return false;
        }

        try {
            extract( $this->validate([
                'selectedCustomerId' => ['required', 'integer', 'exists:customers,id'],
            ]) );

            $customer = Customer::whereId($selectedCustomerId)
                ->whereAdminId(admin()->id)
                ->firstOrFail();

            $this->selectedCustomerCurrency = $customer->currency;

        } catch (\Exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.add-rib-modal-form');
    }
}
