<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Config as ConfigModel;
use App\Models\Language;
use App\Models\Currency;

class Config extends Controller
{

	private static function _confg() {
		return ConfigModel::whereReadonly(false)->get();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$configs = self::_confg();
		return view('pages.admin.configs', compact('configs'));
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
			'config' => ['required', 'array'],
			'config.*' => ['present', 'nullable', 'string'],
		]);

		# ---------------------------------------------
		# MESURE PREVENTIVE
		# ---------------------------------------------
		$count = 0;
		foreach (['LOGIN_USING_ACCOUNTNUMBER_AND_BIRTHDATE', 'LOGIN_USING_EMAIL_AND_PASSWORD', 'LOGIN_USING_ACCOUNTNUMBER_AND_PASSWORD'] as $key) {
			if ( $request->filled('config.' . $key) ) {
				$count++;
			}
		}

		if ( $count !== 1 ) {
			return back_With_Error(826);
		}

		foreach (self::_confg() as $config) {
			
			if ( $config->input_type === 'boolean' ) {
				$config->value = intval($request->filled('config.' . $config->name));
			} else {
				$config->value = $data['config'][$config->name];

				# DEFAULT_SITE_LANGUAGE
				if ( $config->name == 'DEFAULT_SITE_LANGUAGE' ) {
				    if ( !Language::whereIso($config->value)->whereNotNull('enabled_at')->exists() ) {
				        continue;
				    }
				} elseif ( $config->name == 'DEFAULT_CONVERT_CURRENCY' ) {
					if ( ! Currency::whereName($config->value)->exists() ) {
						continue;
					}
				} elseif ( $config->name == 'TEAG' ) {
					if ( floatval($config->value) <= 0 ) {
						continue;
					}
				} elseif ( $config->name == 'SITE_NAME' ) {
					ConfigModel::generate_env_appName($config);
				}
			}
			
			$config->saveOrFail();
		}

		# REFRESH CASH
		ConfigModel::refreshCache();

		return back_With_Success(666);
	}

}
