<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TransferCountDown extends Component
{

    public function mount($loadsection)
    {
        $this->loadsection = $loadsection;
    }

    public function exitPage()
    {
        return redirect(routeWithLocale('customer.transferts'));
    }

    public function render()
    {
        return view('livewire.transfer-count-down');
    }
}
