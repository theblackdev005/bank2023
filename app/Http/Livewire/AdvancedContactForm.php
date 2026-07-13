<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Admin;

class AdvancedContactForm extends Component
{
    public $admins = [];
    public $department = 'customer_care';

    public $accountCustomer = false;

    public function mount($accountCustomer=false)
    {
        if ( $accountCustomer === false ) {
            if ( !is_null(old('account_manager')) ) {
                $this->department = 'manager';
                $this->retreiveManagers();
            }
        } else {
            $this->accountCustomer = $accountCustomer;
        }
    }

    public function retreiveManagers() {
        $this->admins = Admin::all();
    }

    public function render()
    {
        return view('livewire.advanced-contact-form');
    }
}
