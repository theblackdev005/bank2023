<?php

use \App\Http\Controllers\Guest\App;
use \App\Http\Controllers\Guest\Login;
use \App\Http\Controllers\Guest\Loan;
use \App\Http\Controllers\Guest\About;
use \App\Http\Controllers\Guest\Helps;
use \App\Http\Controllers\Guest\Security;
use \App\Http\Controllers\Guest\Insurance;
use \App\Http\Controllers\Guest\CookiePolicy;
use \App\Http\Controllers\Guest\LegalText;
use \App\Http\Controllers\Guest\LegalNotice;
use \App\Http\Controllers\Guest\BankAccount;
use \App\Http\Controllers\Guest\BankCard;
use \App\Http\Controllers\Guest\Contact;
use \App\Http\Controllers\Guest\Register;
use \App\Http\Controllers\Guest\Testimonial;
use \App\Http\Controllers\Guest\Password;

Route::middleware('from.valid.country')->group(function () {
	
	Route::get('/{language?}', [App::class, 'index'])->middleware('valid.language')->name('guest.index.root');

	Route::prefix('/{language}')->middleware('valid.language')->group(function () {

		Route::get('/', [App::class, 'index'])->name('guest.index.root_with_language');
		Route::get('/index', [App::class, 'index'])->name('guest.index');
		
		Route::get('/about', [About::class, 'index'])->name('guest.about');
		Route::get('/helps', [Helps::class, 'index'])->name('guest.helps');
		Route::get('/testimonials', [Testimonial::class, 'index'])->name('guest.testimonials');
		Route::get('/security', [Security::class, 'index'])->name('guest.security');
		Route::get('/cards/{type?}', [BankCard::class, 'index'])->name('guest.bank_cards');
		Route::get('/bank-accounts', [BankAccount::class, 'index'])->name('guest.bank_accounts');
		
		Route::get('/legal/{endpoint}', [LegalText::class, 'index'])->name('guest.legal_text');
		Route::get('/cookie-policy', [CookiePolicy::class, 'index'])->name('guest.cookie_policy');
		Route::get('/legal-notice', [LegalNotice::class, 'index'])->name('guest.legal_notice');

		Route::prefix('/contact')->group(function () {
			Route::get('/', [Contact::class, 'create'])->name('guest.contact');
			Route::post('/', [Contact::class, 'store'])->middleware('google.recaptcha')->name('guest.contact.post');
		});

		Route::prefix('/loans')->group(function () {

			Route::prefix('/request')->group(function () {
				Route::get('/', [Loan::class, 'create'])->name('guest.loan_request');
				Route::post('/', [Loan::class, 'store'])->name('guest.loan_request.post');
			});
			Route::get('/{type?}', [Loan::class, 'index'])->name('guest.loans');
		});
		Route::get('/insurances/{type?}', [Insurance::class, 'index'])->name('guest.insurance');

		Route::middleware('guest')->group(function () {
			
			Route::get('/login', [Login::class, 'create'])->name('guest.login');
			Route::get('/register', [Register::class, 'create'])->name('guest.register');

			Route::middleware('google.recaptcha')->group(function () {
				Route::post('/login', [Login::class, 'store'])->name('guest.login.post');
				Route::post('/register', [Register::class, 'store'])->name('guest.register.post');
			});

			Route::prefix('/password')->group(function () {
				Route::get('/forgot', [Password::class, 'create'])->name('guest.password_forget');
				Route::post('/forgot', [Password::class, 'store'])->middleware(['throttle:3,10', 'google.recaptcha'])->name('guest.password_forget.post');
				
				Route::get('/reset/{uid}/{token}', [Password::class, 'edit'])->name('guest.password_reset');
				Route::post('/reset', [Password::class, 'update'])->name('guest.password_reset.post');
			});
		});

	});
	
});
