<?php

use \App\Http\Controllers\Admin\Customer\Sms;
use \App\Http\Controllers\Admin\Customer\Loan;
use \App\Http\Controllers\Admin\Customer\Session;
use \App\Http\Controllers\Admin\Customer\Account;
use \App\Http\Controllers\Admin\Customer\BankCard;
use \App\Http\Controllers\Admin\Customer\Paypal;
use \App\Http\Controllers\Admin\Customer\Recipient;
use \App\Http\Controllers\Admin\Customer\Transfert;
use \App\Http\Controllers\Admin\Customer\ContactForm;
use \App\Http\Controllers\Admin\Customer\TransfertFee;
use \App\Http\Controllers\Admin\Customer\Transaction;
use \App\Http\Controllers\Admin\Customer\Identity;
use \App\Http\Controllers\Admin\Customer\Login as SwitchLogin;

use \App\Http\Controllers\Admin\App;
use \App\Http\Controllers\Admin\Rib;
use \App\Http\Controllers\Admin\Config;
use \App\Http\Controllers\Admin\Login;
use \App\Http\Controllers\Admin\MailPro;
use \App\Http\Controllers\Admin\Backup;
use \App\Http\Controllers\Admin\Currency;
use \App\Http\Controllers\Admin\Country;
use \App\Http\Controllers\Admin\Language;
use \App\Http\Controllers\Admin\Password;
use \App\Http\Controllers\Admin\Recaptcha;
use \App\Http\Controllers\Admin\CpanelConfig;
use \App\Http\Controllers\Admin\SmsApiConfig;
use \App\Http\Controllers\Admin\SmtpConfig;
use \App\Http\Controllers\Admin\Testimonial;
use \App\Http\Controllers\Admin\Account as AdAccount;

Route::prefix('/{language}/admin')->middleware(['valid.language'])->group(function () {
	
	Route::post('/sms/webhook/{uniqid}', [Sms::class, 'update'])->name('admin.sms_webhook.post');

	Route::middleware(['auth:admin'])->group(function () {
		Route::get('/dashboard', [App::class, 'index'])->name('admin.dashboard');
		Route::get('/list', [AdAccount::class, 'index'])->name('admin.listing');
		Route::get('/helps', [App::class, 'helps'])->name('admin.helps');
		
		Route::prefix('/account')->group(function () {

			Route::post('/add', [AdAccount::class, 'store'])->name('admin.add_admin.post');
			Route::post('/delete', [AdAccount::class, 'destroy'])->name('admin.delete_admin.post');
			
			Route::prefix('/edit')->group(function () {
				Route::get('/', [AdAccount::class, 'edit'])->name('admin.edit_account');
				Route::post('/', [AdAccount::class, 'update'])->name('admin.edit_account.post');
			});

			Route::prefix('/password')->group(function () {
				Route::get('/', [Password::class, 'edit'])->name('admin.edit_password');
				Route::post('/', [Password::class, 'update'])->name('admin.edit_password.post');
			});
		});

		Route::prefix('/manage')->group(function () {
			Route::get('/currencies', [Currency::class, 'index'])->name('admin.manage_currencies');
			Route::get('/countries', [Country::class, 'index'])->name('admin.manage_countries');
			Route::get('/languages', [Language::class, 'index'])->name('admin.manage_languages');

			Route::prefix('/config')->group(function () {
				Route::get('/', [Config::class, 'create'])->name('admin.site_configs');
				Route::post('/', [Config::class, 'store'])->name('admin.site_configs.post');
			});

			Route::prefix('/contact-form/request')->group(function () {
				Route::get('/', [ContactForm::class, 'index'])->name('admin.contacts');
				Route::post('/retry', [ContactForm::class, 'update'])->name('admin.contacts.post');
			});

			Route::prefix('/recaptcha')->group(function () {
				Route::get('/', [Recaptcha::class, 'create'])->name('admin.manage_recaptcha');
				Route::post('/', [Recaptcha::class, 'store'])->name('admin.manage_recaptcha.post');
			});

			Route::prefix('/cpanel-api')->group(function () {
				Route::post('/', [CpanelConfig::class, 'store'])->name('admin.manage_cpanelapi.post');
			});

			Route::prefix('/sms-api')->group(function () {
				Route::post('/', [SmsApiConfig::class, 'store'])->name('admin.manage_smsapi.post');
			});

			Route::prefix('/smtp')->group(function () {
				Route::get('/', [SmtpConfig::class, 'edit'])->name('admin.smtp_config');
				Route::post('/', [SmtpConfig::class, 'update'])->name('admin.smtp_config.post');
				Route::post('/test', [SmtpConfig::class, 'test'])->name('admin.smtp_config.test');
			});

			Route::prefix('/mail-pro')->group(function () {
				Route::get('/', [MailPro::class, 'index'])->name('admin.mail_pro');
				Route::post('/', [MailPro::class, 'store'])->name('admin.mail_pro.post');
			});

			Route::prefix('/rib')->group(function () {
				Route::get('/', [Rib::class, 'index'])->name('admin.rib');
				Route::post('/', [Rib::class, 'store'])->name('admin.add_rib.post');
				Route::post('/edit/{rib_id}', [Rib::class, 'update'])->name('admin.edit_rib.post');
				Route::get('/delete/{rib_id}', [Rib::class, 'destroy'])->name('admin.delete_rib');
				Route::get('/verify-identity/{rib_id}', [Identity::class, 'update'])->name('admin.verify_identity');
			});

			Route::prefix('/testimonials')->group(function () {
				Route::get('/', [Testimonial::class, 'index'])->name('admin.testimonials');
				Route::get('/delete/{id}', [Testimonial::class, 'destroy'])->name('admin.delete_testimonials');
				Route::post('/', [Testimonial::class, 'store'])->name('admin.testimonials.post');
			});

			Route::get('/backup', [Backup::class, 'store'])->name('admin.backup');
		});

		Route::prefix('/customers')->group(function () {
			# action === pending, verified, banned
			Route::get('/{action?}', [Account::class, 'index'])->name('admin.customers');
		});

		Route::prefix('/customer')->group(function () {
			
			Route::post('/balance/{username}', [Account::class, 'balance'])->name('admin.customer_balance.post');
			Route::post('/verify/{username}', [Account::class, 'verify'])->name('admin.customer_verification.post');

			Route::prefix('/add')->group(function () {
				Route::get('/', [Account::class, 'create'])->name('admin.add_customer');
				Route::post('/', [Account::class, 'store'])->name('admin.add_customer.post');
			});

			Route::prefix('/fees')->group(function () {
				Route::post('/{transfert_id}', [TransfertFee::class, 'store'])->name('admin.transfert_fee.post');
				Route::get('/pay/{fee_id}', [TransfertFee::class, 'update'])->name('admin.transfert_fee.validate');
				Route::get('/send/code/{fee_id}', [TransfertFee::class, 'sendCode'])->name('admin.transfert_fee.send_code');
				Route::get('/delete/{fee_id}', [TransfertFee::class, 'destroy'])->name('admin.transfert_fee.delete');
			});

			Route::middleware('admin.customer.checker')->group(function () {
				Route::get('/connect/{username}', [SwitchLogin::class, 'switch'])->name('admin.customer_connect');
				Route::get('/delete/{username}', [Account::class, 'destroy'])->name('admin.delete_customer');
				Route::post('/deposit/{username}', [Account::class, 'deposit'])->name('admin.customer_deposit.post');
				Route::post('/reset-password/{username}', [Account::class, 'resetPassword'])->name('admin.customer_reset_password.post');

				Route::prefix('/lock/{username}')->group(function () {
					Route::get('/', [Account::class, 'lock'])->name('admin.customer_lock');
					Route::post('/', [Account::class, 'update'])->name('admin.customer_lock.post');
				});
				
				Route::prefix('/edit/{username}')->group(function () {
					Route::get('/', [Account::class, 'edit'])->name('admin.edit_customer');
					Route::post('/', [Account::class, 'update'])->name('admin.edit_customer.post');
				});

				Route::prefix('/transactions')->group(function () {
					Route::get('/{username}', [Transaction::class, 'index'])->name('admin.transactions');
					Route::get('/delete/{username}/{uniqid}', [Transaction::class, 'destroy'])->name('admin.delete_transaction');
				});

				Route::prefix('/transferts')->group(function () {
					Route::get('/{username}', [Transfert::class, 'index'])->name('admin.transferts');
					Route::get('/delete/{username}/{id}', [Transfert::class, 'destroy'])->name('admin.delete_transfert');
				});

			});

			Route::prefix('/sessions')->group(function () {
				Route::get('/', [Session::class, 'index'])->name('admin.customers_sessions');
				Route::post('/delete', [Session::class, 'destroy'])->name('admin.delete_sessions.post');
			});

			Route::prefix('/cards')->group(function () {
				Route::get('/', [BankCard::class, 'index'])->name('admin.credit_cards');
				Route::post('/approve', [BankCard::class, 'update'])->name('admin.approve_card.post');
				Route::post('/delete', [BankCard::class, 'destroy'])->name('admin.delete_card.post');
			});

			Route::prefix('/paypals')->group(function () {
				Route::get('/', [Paypal::class, 'index'])->name('admin.paypal_accounts');
				Route::post('/approve', [Paypal::class, 'update'])->name('admin.approve_paypal.post');
				Route::post('/delete', [Paypal::class, 'destroy'])->name('admin.delete_paypal.post');
			});

			Route::prefix('/recipients')->group(function () {
				Route::get('/', [Recipient::class, 'index'])->name('admin.recipients');
				Route::post('/approve', [Recipient::class, 'update'])->name('admin.approve_recipient.post');
				Route::post('/delete', [Recipient::class, 'destroy'])->name('admin.delete_recipient.post');
			});

			Route::prefix('/loan')->group(function () {
				Route::get('/pending', [Loan::class, 'index'])->name('admin.pending_loans');
				Route::post('/add', [Loan::class, 'store'])->name('admin.add_loan.post');
				Route::post('/approve', [Loan::class, 'update'])->name('admin.approve_loan.post');
				Route::post('/delete', [Loan::class, 'destroy'])->name('admin.delete_loan.post');
			});

			Route::prefix('/sms')->group(function () {
				Route::get('/', [Sms::class, 'index'])->name('admin.sms');
				Route::post('/send', [Sms::class, 'store'])->name('admin.send_sms.post');
			});

		});

		Route::get('/logout', [App::class, 'destroy'])->name('admin.logout');
	});

	Route::prefix('/{page?}')->middleware('guest')->group(function () {
		Route::get('/', [Login::class, 'create'])->name('admin.login');
		Route::post('/', [Login::class, 'store'])->middleware('google.recaptcha')->name('admin.login.post');
	});
});

