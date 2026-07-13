<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mailpro as MailproModel;
use App\Models\CpanelConfig;

class MailPro extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$admin = admin();

    	$mails = $admin->mails()
    	    ->paginate( PAGINATION_PER_PAGE )
    	    ->withQueryString();

    	$cpanel_config = $admin->cpanelApi()->first();

        return view('pages.admin.mail-pro', compact('mails', 'cpanel_config'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		extract( $request->validate([
			'username' => ['required', 'string'],
			'password' => ['required', 'string'],
		]) );
		$admin = admin();

		try {
			if ( !$credentials = $admin->cpanelApi()->whereNotNull('enabled_at')->first() ) {
			    return back_With_Error(673);
			}
			$emailCompose = $username . "@" . $credentials->domain_name;

			# Verifier s'il existe
			if ( MailproModel::whereUsername($username)->exists() ) {
				return back_With_Error(675);
			}

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://". $credentials->domain_name .":2083/execute/Email/add_pop?" . http_build_query([
				"email" 	=> $emailCompose,
				"password" 	=> $password,
			]));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

			$headers = array();
			$headers[] = "Authorization: cpanel " . $credentials->username . ":" . $credentials->apikey;
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				return back_With_Error( curl_error($ch) );
			}
			curl_close($ch);
			$data = json_decode($result, true);

			if ( intval(@$data['status']) === 1 ) {
				$webmail_url = 'https://' . $credentials->domain_name . '/webmail';

				$mail = new MailproModel();
				$mail->admin_id 	= $admin->id;
				$mail->username 	= $username;
				$mail->password 	= $password;
				$mail->webmail_url 	= $webmail_url;
				$mail->saveOrFail();

				return back_With_Success(674);
			}

			if ( !empty($data['errors'][0]) ) {
				return back_With_Error( $data['errors'][0] );
			}
			return back_With_Error(688);

		} catch (\Exception $e) {
			return back_With_Error();
		}
	}

}
