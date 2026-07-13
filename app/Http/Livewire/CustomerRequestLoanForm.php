<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CustomerRequestLoanForm extends Component
{

    public $amount = 0;
    public $duration = 0;
    public $goal = null;

    public $monthlyPayment  = 0;
    public $totalPayment    = 0;
    public $totalInterest   = 0;
    
    public $customer   = [];
    public $readyForm   = false;

    public function mount($customer) {
        $this->customer = $customer;
    }

    public function updated()
    {
        $this->readyForm = false;

        try {
            extract( $data = $this->validate([
                'amount'    => ['required', 'integer'],
                'duration'  => ['required', 'integer'],
                'goal'      => ['nullable', 'string'],
            ]) );
            
            foreach (loanCalculator($data) as $key => $value) {
                $this->$key = $value;
            }
            $this->readyForm = true;

        } catch (\Exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.customer-request-loan-form');
    }
}
