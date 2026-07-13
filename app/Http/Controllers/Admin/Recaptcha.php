<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\GoogleRecaptcha;

class Recaptcha extends Controller
{

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$recaptcha = GoogleRecaptcha::first();
		return view('pages.admin.recaptcha', compact('recaptcha'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->validate([
			'site_key' => ['nullable', 'string'],
			'secret_key' => ['nullable', 'string'],
		]);

		try {
			
			$recaptcha = GoogleRecaptcha::first();
			if ( ! $recaptcha ) {
				$recaptcha = new GoogleRecaptcha();
			}

			foreach ($data as $name => $value) {
				$recaptcha->$name = $value;
			}
			$recaptcha->enabled_at = $request->filled('enable') ? now() : null;
			$recaptcha->saveOrFail();

			# REFRESH CASH
			GoogleRecaptcha::refreshCache();

		} catch (\Exception $e) {
			return back_With_Error();
		}

		return back_With_Success(666);
	}

}
