<?php

namespace App\Http\Livewire\InstallationWizard;

use Livewire\Component;

class BankCards extends Component
{

    public $theme_card = [
        'basic'     => '#14181f',
        'standard'  => '#008099',
        'premium'   => '#DDDD33',
    ];

    public $title_card = [
        'basic'     => 'Basic',
        'standard'  => 'Standard',
        'premium'   => 'Premium',
    ];

    protected $listeners = array(
        'checkStepOnChild',
    );

    public function checkStepOnChild() {
        return $this->emitUp('goNextListener');
    }

    public function init() {
        $this->emitUp('disableNextbtnListener', false);
        $this->emitUp('changeTitleListener', 'Bank Cards.');
    }

    public function submit()
    {
        extract( $this->validate([
            'theme_card'      => ['required', 'array', 'size:3'],
            'theme_card.*'    => ['required', 'string', 'size:7'],
            
            'title_card'      => ['required', 'array', 'size:3'],
            'title_card.*'    => ['required', 'string', 'max:8'],
        ]) );

        try {
            foreach ($theme_card as $key => $value) {
                $title = ucfirst($title_card[$key]);
                bank_card_theming($key, $title, $value);
            }

            return $this->addError('success', "Cartes bancaires générées avec succès !");
        } catch (\Exception $e) {
            return $this->addError('danger', $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.installation-wizard.steps.bank-cards');
    }
}
