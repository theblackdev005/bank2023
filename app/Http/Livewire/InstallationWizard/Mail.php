<?php

namespace App\Http\Livewire\InstallationWizard;

use App\Models\EnvFile;
use Livewire\Component;
use Swift_SmtpTransport;

class Mail extends Component
{
    public $MAIL_HOST;
    public $MAIL_PORT;
    public $MAIL_USERNAME;
    public $MAIL_PASSWORD;
    public $MAIL_ENCRYPTION;
    public $MAIL_FROM_ADDRESS;

    public $data = [];

    protected $listeners = ['checkStepOnChild'];

    public function init()
    {
        $this->emitUp('changeTitleListener', 'Configuration SMTP.');
        $this->emitUp('disableNextbtnListener', true);

        if ($this->hasCompleteConfiguration()) {
            try {
                $this->checkConnection($this->currentConfiguration());
            } catch (\Throwable $e) {
                $this->emitUp('disableNextbtnListener', true);
            }
        }
    }

    public function mount()
    {
        foreach (EnvFile::get('MAIL_') as $key => $value) {
            if (in_array($key, ['MAIL_FROM_NAME', 'MAIL_MAILER'], true)) {
                continue;
            }

            $this->{$key} = $value === 'null' ? '' : $value;
            $this->data[$key] = $this->{$key};
        }
    }

    public function checkStepOnChild()
    {
        $this->emitUp('goNextListener');
    }

    public function submit()
    {
        $this->emitUp('disableNextbtnListener', true);

        try {
            $this->MAIL_HOST = trim((string) $this->MAIL_HOST);
            $this->MAIL_USERNAME = trim((string) $this->MAIL_USERNAME);
            $this->MAIL_ENCRYPTION = strtolower(trim((string) $this->MAIL_ENCRYPTION));
            $this->MAIL_FROM_ADDRESS = trim((string) $this->MAIL_FROM_ADDRESS);

            $data = $this->validate([
                'MAIL_HOST' => 'required|string',
                'MAIL_PORT' => 'required|integer',
                'MAIL_USERNAME' => 'required|string',
                'MAIL_PASSWORD' => 'required|string',
                'MAIL_ENCRYPTION' => 'required|string|in:tls,ssl',
                'MAIL_FROM_ADDRESS' => 'required|email',
            ]);

            $this->checkConnection($data);
            EnvFile::regenerate(EnvFile::set(array_merge($data, ['MAIL_MAILER' => 'smtp'])));
            $this->applyRuntimeMailConfig($data);

            $this->addError('success', 'Configuration SMTP testée et enregistrée.');
        } catch (\Throwable $e) {
            $this->emitUp('disableNextbtnListener', true);
            $this->addError('danger', $e->getMessage());
        }
    }

    public function resetMailConfig()
    {
        $this->MAIL_HOST = '';
        $this->MAIL_PORT = '587';
        $this->MAIL_USERNAME = '';
        $this->MAIL_PASSWORD = '';
        $this->MAIL_ENCRYPTION = 'tls';
        $this->MAIL_FROM_ADDRESS = '';

        $data = array_merge(['MAIL_MAILER' => 'smtp'], $this->currentConfiguration());
        EnvFile::regenerate(EnvFile::set($data), false);
        $this->emitUp('disableNextbtnListener', true);
        $this->addError('info', 'Configuration SMTP réinitialisée. Vous pouvez recommencer ou passer cette étape.');
    }

    private function checkConnection(array $data)
    {
        $transport = new Swift_SmtpTransport(
            $data['MAIL_HOST'],
            (int) $data['MAIL_PORT'],
            $data['MAIL_ENCRYPTION']
        );
        $transport->setTimeout(10);
        $transport->setUsername($data['MAIL_USERNAME']);
        $transport->setPassword($data['MAIL_PASSWORD']);
        $transport->start();
        $transport->stop();

        $this->emitUp('disableNextbtnListener', false);
    }

    private function currentConfiguration()
    {
        return [
            'MAIL_HOST' => $this->MAIL_HOST,
            'MAIL_PORT' => $this->MAIL_PORT,
            'MAIL_USERNAME' => $this->MAIL_USERNAME,
            'MAIL_PASSWORD' => $this->MAIL_PASSWORD,
            'MAIL_ENCRYPTION' => $this->MAIL_ENCRYPTION,
            'MAIL_FROM_ADDRESS' => $this->MAIL_FROM_ADDRESS,
        ];
    }

    private function hasCompleteConfiguration()
    {
        foreach ($this->currentConfiguration() as $value) {
            if ($value === null || $value === '' || $value === 'null') {
                return false;
            }
        }

        return true;
    }

    private function applyRuntimeMailConfig(array $data)
    {
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $data['MAIL_HOST'],
            'mail.mailers.smtp.port' => (int) $data['MAIL_PORT'],
            'mail.mailers.smtp.username' => $data['MAIL_USERNAME'],
            'mail.mailers.smtp.password' => $data['MAIL_PASSWORD'],
            'mail.mailers.smtp.encryption' => $data['MAIL_ENCRYPTION'],
            'mail.from.address' => $data['MAIL_FROM_ADDRESS'],
        ]);

        app()->forgetInstance('mailer');
        app()->forgetInstance('swift.mailer');
        app()->forgetInstance('swift.transport');
    }

    public function render()
    {
        return view('livewire.installation-wizard.steps.mail');
    }
}
