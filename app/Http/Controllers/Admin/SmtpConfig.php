<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnvFile;
use Illuminate\Http\Request;

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
}
