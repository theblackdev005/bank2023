<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Currency;

class GuestLoanCalculator extends Component
{

    public $currencies  = [];
    public $currency    = null;

    public $montant_du_pret = 0;
    public $monnaie_locale  = 0;
    public $duree_du_pret   = 0;

    public $mensualite      = 0;

    public function mount($currencies)
    {
        $this->currencies = $currencies;

        $this->currency = Currency::whereId(old('monnaie_locale'))->first();
        if ( !$this->currency ) {
            $this->currency = new Currency;
        } else {
            $this->monnaie_locale = old('monnaie_locale');
        }
    }

    public function updatedMonnaieLocale($value)
    {
        try {
            $this->currency = Currency::whereId($value)->firstOrFail();
        } catch (\Exception $e) {
            $this->currency = new Currency;
        }
    }

    public function updatedDureeDuPret($value) {
        if ( $value <= 0 ) {
            return false;
        }
        $this->calculate();
    }

    public function updatedMontantDuPret($value) {
        if ( $value <= 0 ) {
            return false;
        }
        $this->calculate();
    }

    private function calculate()
    {
        # Get the form values from the AJAX request
        $loanTerm      = intval($this->duree_du_pret);
        $interestRate  = floatval(TEAG);
        $loanAmount    = floatval($this->montant_du_pret);

        $monthlyInterestRate = $interestRate / 100 / 12;
        $diviseur = (1 - pow(1 + $monthlyInterestRate, - $loanTerm));
        if ( $diviseur <= 0 ) {
            return false;
        }

        # Calculate monthly payment
        $this->mensualite = ($loanAmount * $monthlyInterestRate) / $diviseur;
    }

    public function render()
    {
        return view('livewire.guest-loan-calculator');
    }
}
