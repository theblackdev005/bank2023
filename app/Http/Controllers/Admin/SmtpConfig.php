<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnvFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SmtpConfig extends Controller
{
    public function edit()
    {
        $smtp = array_merge($this->defaults(), EnvFile::get('MAIL_'));

        return view('pages.admin.smtp-config', compact('smtp'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'MAIL_HOST' => ['required', 'string'],
            'MAIL_PORT' => ['required', 'integer'],
            'MAIL_USERNAME' => ['required', 'string'],
            'MAIL_PASSWORD' => ['required', 'string'],
            'MAIL_ENCRYPTION' => ['required', 'string'],
            'MAIL_FROM_ADDRESS' => ['required', 'email'],
        ]);

        EnvFile::regenerate(EnvFile::set(array_merge([
            'MAIL_MAILER' => 'smtp',
            'MAIL_FROM_NAME' => '${APP_NAME}',
        ], $data)));

        return back_With_Success(666);
    }

    public function test(Request $request)
    {
        $data = $request->validate([
            'test_email' => ['required', 'email'],
        ]);

        try {
            $this->applyRuntimeMailConfig();

            Mail::send('emails.test-smtp', [
                'parameter' => [
                    'title' => 'Test SMTP',
                    'message' => "Ceci est un email de test envoyé depuis l'administration.\n\nSi vous recevez ce message, la configuration SMTP est fonctionnelle.",
                ],
            ], function ($message) use ($data) {
                $message->to($data['test_email'])
                    ->subject('Test SMTP');
            });

            return back()->withErrors([
                'success' => 'Email de test envoyé avec succès.',
            ]);
        } catch (\Exception $e) {
            return back_With_Error('Test SMTP impossible : ' . $e->getMessage());
        }
    }

    private function defaults(): array
    {
        return [
            'MAIL_HOST' => '',
            'MAIL_PORT' => '587',
            'MAIL_USERNAME' => '',
            'MAIL_PASSWORD' => '',
            'MAIL_ENCRYPTION' => 'tls',
            'MAIL_FROM_ADDRESS' => '',
        ];
    }

    private function applyRuntimeMailConfig(): void
    {
        $mail = array_merge($this->defaults(), EnvFile::get('MAIL_'));
        $encryption = $mail['MAIL_ENCRYPTION'] === 'null' ? null : $mail['MAIL_ENCRYPTION'];

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $mail['MAIL_HOST'],
            'mail.mailers.smtp.port' => $mail['MAIL_PORT'],
            'mail.mailers.smtp.username' => $mail['MAIL_USERNAME'],
            'mail.mailers.smtp.password' => $mail['MAIL_PASSWORD'],
            'mail.mailers.smtp.encryption' => $encryption,
            'mail.from.address' => $mail['MAIL_FROM_ADDRESS'],
            'mail.from.name' => config('app.name'),
        ]);
    }
}
