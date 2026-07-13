<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SmsConfig;

class SmsApiConfig extends Controller
{

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$admin = admin();

		$data = $request->validate([
			'username' => ['nullable', 'string'],
			'password' => ['nullable', 'string'],
			'sender' => ['nullable', 'string', 'max:11'],
		]);

		try {
			
			$smsApi = $admin->smsApi()->first();
			if ( !$smsApi ) {
				$smsApi = new SmsConfig();
			}

			foreach ($data as $name => $value) {
				$smsApi->$name = $value;
			}
			$smsApi->admin_id = $admin->id;
			$smsApi->enabled_at = $request->filled('enable') ? now() : null;
			$smsApi->saveOrFail();

		} catch (\Exception $e) {
			return back_With_Error();
		}

		return back_With_Success(666);
	}

}
