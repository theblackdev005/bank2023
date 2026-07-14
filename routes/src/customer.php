<?php

use \App\Http\Controllers\Customer\Transaction;
use \App\Http\Controllers\Customer\Transfert;
use \App\Http\Controllers\Customer\Session;
use \App\Http\Controllers\Customer\Account;
use \App\Http\Controllers\Customer\Password;
use \App\Http\Controllers\Customer\Recipient;
use \App\Http\Controllers\Customer\BankCard;
use \App\Http\Controllers\Customer\Identity;
use \App\Http\Controllers\Customer\Loan;
use \App\Http\Controllers\Customer\App;
use \App\Http\Controllers\Customer\Rib;

Route::post('/{language}/customer/timezone', [Account::class, 'timezone'])
	->middleware(['valid.language', 'auth:customer'])
	->name('customer.timezone.update');

Route::post('/{language}/customer/session/heartbeat', [Session::class, 'heartbeat'])
	->middleware(['valid.language', 'auth:customer', 'track.customer.session'])
	->name('customer.session.heartbeat');

Route::prefix('/{language}/customer')->middleware([
	'from.valid.country',
	'valid.language',
	'auth:customer',
	'customer.unverified',
	'customer.banned',
	'track.customer.session',
	'identity.verification',
	'pending.transfer.redirect'
])->group(function () {
	
	Route::middleware('verified.email')->group(function () {
		Route::get('/dashboard', [App::class, 'index'])->name('customer.dashboard');
		
		Route::prefix('/transactions')->group(function () {
			Route::get('/', [Transaction::class, 'index'])->name('customer.transactions');
			Route::get('/download', [Transaction::class, 'download'])->name('customer.download_transactions');
		});
		
		Route::prefix('/account')->group(function () {
			Route::prefix('/edit')->group(function () {
				Route::get('/', [Account::class, 'edit'])->name('customer.edit_account');
				Route::post('/', [Account::class, 'update'])->name('customer.edit_account.post');
			});

			Route::prefix('/password')->group(function () {
				Route::get('/', [Password::class, 'edit'])->name('customer.edit_password');
				Route::post('/', [Password::class, 'update'])->name('customer.edit_password.post');
			});

			Route::prefix('/identity')->group(function () {
				Route::get('/{step?}', [Identity::class, 'index'])->name('customer.identity_verification');
			});
			
			Route::get('/show', [Account::class, 'index'])->name('customer.account');
			Route::get('/banned', [Account::class, 'banishment'])->name('customer.banned');
		});

		Route::prefix('/transfert')->group(function () {
			Route::prefix('/add')->group(function () {
				Route::get('/', [Transfert::class, 'create'])->name('customer.add_transferts');
				Route::post('/', [Transfert::class, 'store'])->name('customer.add_transferts.post');
			});
			Route::get('/detail', [Transfert::class, 'show'])->middleware('no.transfer.redirect')->name('customer.show_transfert');
			Route::get('/receipt/{reference}', [Transfert::class, 'download'])->name('customer.download_transferts');
			Route::get('/list', [Transfert::class, 'index'])->name('customer.transferts');
		});

		Route::prefix('/loans')->group(function () {
			Route::prefix('/add')->group(function () {
				Route::get('/', [Loan::class, 'create'])->name('customer.add_loans');
				Route::post('/', [Loan::class, 'store'])->name('customer.add_loans.post');
			});
			Route::get('/list', [Loan::class, 'index'])->name('customer.loans');
		});

		Route::prefix('/recipients')->group(function () {
			Route::prefix('/add')->group(function () {
				Route::get('/', [Recipient::class, 'create'])->name('customer.add_recipients');
				Route::post('/', [Recipient::class, 'store'])->name('customer.add_recipients.post');
			});
			Route::get('/list', [Recipient::class, 'index'])->name('customer.recipients');
		});

		Route::prefix('/cards')->group(function () {
			Route::prefix('/add')->group(function () {
				Route::get('/', [BankCard::class, 'create'])->name('customer.add_cards');
				Route::post('/', [BankCard::class, 'store'])->name('customer.add_cards.post');
			});
			Route::get('/list', [BankCard::class, 'index'])->name('customer.cards');
		});
		
		Route::get('/activities', [Session::class, 'index'])->name('customer.sessions');
		Route::get('/rib', [Rib::class, 'index'])->name('customer.rib');
	});

	Route::get('/logout', [App::class, 'destroy'])->name('customer.logout');
});

