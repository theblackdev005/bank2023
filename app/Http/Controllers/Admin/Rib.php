<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Rib as RibModel;
use App\Models\Customer;

class Rib extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		$ribs = admin()->ribs()
			->paginate( PAGINATION_PER_PAGE )
			->withQueryString();

		$customers = admin()->customers()->get();

		return view('pages.admin.rib', compact('ribs', 'customers'));
	}


	private function auto_identity_verifyer(RibModel $rib)
	{
		if ( $rib->isEnabled() && ($rib->amount <= 0) && !$rib->customer->isVerifiedIdentity() ) {
			$rib->customer->identity_verified_at = now();
			$rib->customer->saveOrFail();

			# sendIdentityVerifiedNotificationToCustomer
			$rib->customer->sendIdentityVerifiedNotificationToCustomer($rib);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$admin = admin();

		extract( $request->validate([
			'add'		=> ['required', 'array'],

			'add.customer_id' => ['required', 'integer', 'exists:customers,id'],

			'add.bank_name' => ['nullable', 'string'],
			'add.account_number' => ['nullable', 'string'],
			'add.rib_key' => ['nullable', 'string'],
			'add.iban' => ['nullable', 'string', 'iban'],
			'add.swift_bic' => ['nullable', 'string', new \App\Rules\ValidSwiftCode],
			'add.amount' => ['nullable', 'integer'],
		]) );
		unset($add['enable']);

		try {
			if ( RibModel::whereCustomerId($add['customer_id'])->whereAdminId($admin->id)->exists() ) {
				return back_With_Error(778);
			}
			$customer = Customer::whereId( $add['customer_id'] )->firstOrFail();

			$rib = new RibModel();
			foreach ($add as $name => $value) {
				$rib->$name = $value;
			}
			$rib->currency_id 		= $customer->currency->id;
			$rib->admin_id 			= $admin->id;
			$rib->enabled_at 		= $request->filled('add.enable') ? now() : null;
			$rib->saveOrFail();

			# -----------------------------------------------------------
			# Si le montant est egal a 0,
			# alors y a pas de paiement à exiger avant de valider l'identité du client.
			# -----------------------------------------------------------
			$this->auto_identity_verifyer($rib);

		} catch (\Exception $e) {
			return back_With_Error($e->getMessage());
		}

		return back_With_Success(779);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$admin 	= admin();
		$id = $request->route('rib_id');

		extract( $data = $request->validate([
			'update'		=> ['required', 'array', 'size:1'],
			"update.{$id}"	=> ['required', 'array'],

			"update.{$id}.bank_name" => ['nullable', 'string'],
			"update.{$id}.account_number" => ['nullable', 'string'],
			"update.{$id}.rib_key" => ['nullable', 'string'],
			"update.{$id}.iban" => ['nullable', 'string', 'iban'],
			"update.{$id}.swift_bic" => ['nullable', 'string', new \App\Rules\ValidSwiftCode],
		]) );
		unset($update[$id]['enable']);

		try {
			$rib = RibModel::whereId($id)
				->whereAdminId($admin->id)
			    ->firstOrFail();

			foreach (current($update) as $name => $value) {
				$rib->$name = $value;
			}

			$rib->enabled_at = $request->filled('update.' . $id . '.enable') ? now() : null;
			$rib->saveOrFail();

			# -----------------------------------------------------------
			# Si le montant est egal a 0,
			# alors y a pas de paiement à exiger avant de valider l'identité du client.
			# -----------------------------------------------------------
			$this->auto_identity_verifyer($rib);

			# sendRibUpdatedNotificationToCustomer
			if ( $rib->isEnabled() ) {
				$rib->customer->sendRibUpdatedNotificationToCustomer($rib);
			}

		} catch (\Exception $e) {
			return back_With_Error();
		}

		return back_With_Success(676);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
	    $id = $request->route('rib_id');

	    try {
	        $rib = RibModel::whereId($id)
	        	->whereAdminId(admin()->id)
	            ->firstOrFail();

	        # Envoyer un mail au client avant suppression
	        if ( $rib->isEnabled() ) {
	        	$rib->customer->sendRibDeletedNotificationToCustomer($rib);
	        }

	        $rib->delete();

	    } catch (\Exception $e) {
	        return back_With_Error($e->getMessage());
	    }

	    return back_With_Success(780);
	}

}
