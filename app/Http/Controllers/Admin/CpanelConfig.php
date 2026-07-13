<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CpanelConfig as CpanelModel;

class CpanelConfig extends Controller
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
			'apikey' => ['nullable', 'string'],
			'domain_name' => ['nullable', 'string'],
		]);

		try {
			
			$cpanel = $admin->cpanelApi()->first();
			if ( !$cpanel ) {
				$cpanel = new CpanelModel();
			}

			foreach ($data as $name => $value) {
				$cpanel->$name = $value;
			}
			$cpanel->admin_id = $admin->id;
			$cpanel->enabled_at = $request->filled('enable') ? now() : null;
			$cpanel->saveOrFail();

		} catch (\Exception $e) {
			return back_With_Error();
		}

		return back_With_Success(666);
	}

}
