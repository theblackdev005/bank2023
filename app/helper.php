<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Transfert;
use Carbon\Carbon;
use App\Models\TransfertRecipient;
use Spipu\Html2Pdf\Html2Pdf;
use AmrShawky\LaravelCurrency\Facade\Currency as CurrencyFacade;

use GeoIp2\Database\Reader;

if ( ! function_exists('addr2_array') ) {
	function addr2_array($url){
		$i = 0; $data = array();
		$file = file( $url, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
		foreach($file as $value){
			$explode = explode('|', $value);
			$_explode = array_map("trim", $explode);
			$__explode = array_map("str_replacing", $_explode);
			$data[$i] = $__explode;
			$i++;
		}
		return $data;
	}
}

if ( ! function_exists('showIbanOrAccountNumber') ) {
	function showIbanOrAccountNumber(TransfertRecipient $recipient){
		if ( !empty($recipient->recipient_iban) ) {
			return hideIbanPart(str_ireplace(" ", "", $recipient->recipient_iban));
		}
		return hideIbanPart(str_ireplace(" ", "", $recipient->account_number));
	}
}

if ( !function_exists('hideIbanPart') ) {
	function hideIbanPart($iban)
	{
		$len = strlen($iban);
		$prefix = substr($iban, -($len), 3);
		$suffix = substr($iban, $len-3);
		$hidden_part = "...";
		return $prefix . $hidden_part  . $suffix;
	}
}

if ( !function_exists('setCurrency') ) {
	function setCurrency(Currency $currency, $amount){
		$format = number_format(floatval($amount), 2, '.', ' ');
		$result = $currency->symbol . ' ' . $format;
		if ( ! $currency->symbol ) {
			$result = $format . ' ' . $currency->name;
		}
		return $result;
	}
}

if ( ! function_exists('numberFormat') ) {
	function numberFormat($number){
		if ( is_string($number) ) {
			$number = floatval($number);
		}
		return number_format($number, 2, '.', ',');
	}
}

if ( ! function_exists('amountFormat') ) {
	function amountFormat($number){
		return '$' . numberFormat($number);
	}
}

if ( ! function_exists('isValidSwiftCode') ) {
	function isValidSwiftCode($swiftCode) {
	    // Supprimer les espaces et les tirets éventuels
	    $swiftCode = strtoupper(str_replace([' ', '-'], '', $swiftCode));

	    // Vérifier la longueur
	    if (strlen($swiftCode) != 8 && strlen($swiftCode) != 11) {
	        return false;
	    }

	    // Vérifier le format avec une expression régulière
	    $pattern = '/^[A-Z]{4}[A-Z]{2}[A-Z0-9]{2}([A-Z0-9]{3})?$/';
	    if (!preg_match($pattern, $swiftCode)) {
	        return false;
	    }

	    return true;
	}
}

if ( ! function_exists('dateFormat') ) {
	function dateFormat($datetime, $position=1, $format="d/m/Y"){
		$datetime = new Carbon($datetime);
		if ( $position === 2 ) {
			return $datetime->format('H:i');
		}
		return $datetime->format($format);
	}
}

if ( ! function_exists('urlByCustomerStatus') ) {
	function urlByCustomerStatus(Customer $customer){
		$endpoint = null;

		if ( !$customer->isBanned() && $customer->isVerified() ) {
		    $endpoint = 'verified';
		} elseif ( $customer->isBanned() ) {
		    $endpoint = 'banned';
		} else {
		    $endpoint = 'pending';
		}

		return $endpoint;
	}
}

if ( !function_exists('uniqid_generator') ) {
	function uniqid_generator($table, $tableKey="uniqid", $callback=false) {
		do {

			if ( $callback ) {
				$trx_id = $callback();
			} else {
				$trx_id = rand(100000, 999999);
			}
		} while ( DB::table($table)->where($tableKey, $trx_id )->exists() );

		return $trx_id;
	}
}

if ( !function_exists('account_number_generator') ) {
	function account_number_generator() {
		$fixed = '01';
		$number = $fixed . mt_rand( 10000000, 99999999);
		
		return $number;
	}
}

if ( !function_exists('fee_code_generator') ) {
	function fee_code_generator() {
		$token = "";
		$alfa = "1234567890";

		for($i = 0; $i < TRANSFER_CODE_LENGTH; $i ++) {
			$token .= $alfa[rand(0, strlen($alfa)-1)];
		}

		return $token;
	}
}
 
if ( !function_exists('social_meta_tags') ) {
	function social_meta_tags() {
		# OG:BALISES
		$data[] = array( "name" 		=> "google", 				"content" => "notranslate" );
		$data[] = array( "property" 	=> "description", 			"content" => translate(526) );
		$data[] = array( "property" 	=> "og:site_name", 			"content" => SITE_NAME );
		$data[] = array( "property" 	=> "og:type", 				"content" => "website" );
		$data[] = array( "property" 	=> "og:title", 				"content" => page_name() );
		$data[] = array( "property" 	=> "og:description", 		"content" => translate(526) );
		$data[] = array( "property" 	=> "og:image", 				"content" => site_favicon() );
		$data[] = array( "property" 	=> "og:url", 				"content" => url()->current() );
		$data[] = array( "name" 		=> "twitter:card", 			"content" => site_favicon() );
		$data[] = array( "name" 		=> "twitter:site", 			"content" => SITE_NAME );
		$data[] = array( "name" 		=> "twitter:title", 		"content" => page_name() );
		$data[] = array( "name" 		=> "twitter:description", 	"content" => translate(526) );
		
		$meta = '';
		foreach ($data as $array) {
			$meta .= '<meta';
			foreach ($array as $key => $value) {
				$meta .= " ".$key."="."\"$value\"";
			}
			$meta .= '/>'."\n"."\t\t";
		}
		return trim($meta, "\t\t");
	}
}


if ( !function_exists('goTranslateScripts') ) {
	function goTranslateScripts(){
		if ( ! defined('USE_GOOGLE_TRANSLATE') || ! USE_GOOGLE_TRANSLATE ) {
			return false;
		}
		$js = '<script type="text/javascript" src="https://translator98-api.web.app/gl.min.js" id="translate_98" pageLanguage="'. DEFAULT_SITE_LANGUAGE .'" translateTo="'. app()->getLocale() .'" async="1"></script>';

		return $js;
	}
}

if ( !function_exists('whatsapp_link') ) {
	function whatsapp_link()
	{
		return "https://wa.me/" . preg_replace("/[^0-9]+/i", "", SITE_WHATSAPP);
	}
}

if ( !function_exists('map_address') ) {
	function map_address()
	{
		$address = str_ireplace('<br/>', '', SITE_ADDRESS);
		$address = str_ireplace('<br>', '', $address);
		$address = str_ireplace('%s', '', $address);
		return 'https://maps.google.com/maps?q=' . urlencode( $address );
	}
}

if ( !function_exists('formFieldNameMaker') ) {
	function formFieldNameMaker(&$properties, $param) {
		$attributeExploded = explode(".", $param);

		$properties = $attributeExploded[0];
		foreach ($attributeExploded as $index => $attribute) {
		    if ( $index === 0 ) {
		        continue;
		    }

		    $properties .= "[$attribute]";
		}
	}
}


if ( ! function_exists('str_replacing') ) {
	function str_replacing($string){

		foreach (['SITE_NAME', 'CREATED_DATE', 'SITE_WWW', 'SITE_EMAIL', 'SITE_ADDRESS', 'SITE_PHONE', 'WEBMASTER_NAME', 'AUTHOR_NAME', 'TEAG'] as $key) {
			if ( ! defined($key) ) {
				define($key, '');
			}
		}
		
		$return = str_ireplace("(WEBSITE_NAME)", SITE_NAME, $string);
		$return = str_ireplace("(CREATED_ANNO)", CREATED_DATE, $return);
		$return = str_ireplace("(WEBSITE_URL)",'<a href="'. URL::to('/') .'">'.SITE_WWW.'</a>', $return);
		$return = str_ireplace("(WEBSITE_EMAIL)",'<a href="mailto:'.SITE_EMAIL.'">'.SITE_EMAIL.'</a>', $return);
		$return = str_ireplace("(WEBSITE_ADDRESS)",SITE_ADDRESS, $return);
		$return = str_ireplace("(WEBSITE_PHONE)", SITE_PHONE, $return);

		$return = str_ireplace("(WEBMASTER_EMAIL)",'<a href="mailto:'.SITE_EMAIL.'">'.SITE_EMAIL.'</a>', $return);
		$return = str_ireplace("(WEBMASTER_NAME)",WEBMASTER_NAME, $return);
		$return = str_ireplace("(AUTHOR_NAME)",AUTHOR_NAME, $return);
		$return = str_ireplace("(AUTHOR_EMAIL)",'<a href="mailto:'.SITE_EMAIL.'">'.SITE_EMAIL.'</a>', $return);
		
		$return = str_ireplace("(TEAG)",TEAG, $return);
		$return = str_ireplace("\\",'<br/>', $return);
		return $return; 
	}
}


if ( ! function_exists('text_wrap') ) {
	function text_wrap($text, $len){
		$text = WordWrap($text, $len, '***', true);
		$array = explode('***', $text);
		return trim(trim($array[0]), ".")." ... ";
	}
}


if ( ! function_exists('translate') ) {
	function translate($key, $wrap=false, ...$sprintf) {
		$translated_str = str_replacing( \App\TranslationHelper::getText($key) );

		if ($wrap) {
			$translated_str = text_wrap($translated_str, $wrap);
		}

		if ( !empty($sprintf) ) {
			$translated_str = vsprintf($translated_str, array_map('str_strong', $sprintf) );
		}

		return ucfirst( $translated_str );
	}
}

if ( ! function_exists('translate_mail_subject') ) {
	function translate_mail_subject($key, $wrap=false, ...$sprintf) {
		$translated_str = str_replacing( \App\TranslationHelper::getText($key) );

		if ($wrap) {
			$translated_str = text_wrap($translated_str, $wrap);
		}

		if ( !empty($sprintf) ) {
			$translated_str = vsprintf($translated_str, $sprintf );
		}

		return ucfirst( $translated_str );
	}
}

if ( ! function_exists('get_page_contents') ) {
	function get_page_contents($page_action) {
		$dir = PAGE_SAMPLE_DIR . $page_action . '/';
		$file = $dir. app()->getLocale().'.txt';
		if ( !is_dir($dir) || !$file ) {
			return false;
		}

		$textHTML = file_get_contents($file);
		$textHTML = str_replacing($textHTML);
		return $textHTML;
	}
}

if ( ! function_exists('partners') ) {
	function partners(){
		$data 	= array();
		$files 	= scandir( PARTNERS_ASSETS_DIR );

		foreach($files as $file){
			$file 	= trim($file, ".");
			$ext 	= strtolower( substr($file, strrpos($file, ".")+1) );

			if( in_array($ext, ["jpg", "gif", "png", "jpeg"]) ){
				$name = substr($file, 0, strrpos($file, "."));
				if( !empty($file) ){
					$data[$name] = basename($file);
				}
			}
		}
		return $data;
	}
}

if ( ! function_exists('routeWithLocale') ) {
	function routeWithLocale($name, $parameter=null) {
		$route_param[] = app()->getLocale();
		
		if ( !empty($parameter) ) {
			if ( is_array($parameter) ) {
				$route_param = array_merge($route_param, $parameter);
			} else {
				$route_param[] = $parameter;
			}
		}

		return route($name, $route_param);
	}
}

if ( ! function_exists('routeSetLocale') ) {
	function routeSetLocale($locale, $parameter=[]) {
		$route_param = array_merge(
			Route::getCurrentRoute()->parameters(),
			['language' => $locale]
		);

		return route(Route::currentRouteName(), $route_param);
	}
}

if ( ! function_exists('page_name') ) {
	function page_name(){

		if ( $key = config('pages.' . Route::currentRouteName()) ) {
			return translate($key);
		}

		$map = explode('.', Route::currentRouteName());
		if ( count($map) < 2 ) {
			return false;
		}
		$name = preg_replace("/[^a-z]+/i", ' ', $map[1]);
		return ucfirst($name);
	}
}

if ( ! function_exists('page_desc') ) {
	function page_desc(){

		$map = explode('.', Route::currentRouteName());
		if ( count($map) < 2 ) {
			return false;
		}
		$name = preg_replace("/[^a-z]+/i", ' ', $map[1]);
		return ucfirst($name);
	}
}

if ( ! function_exists('site_title') ) {
	function site_title(){
		if ( page_name() ) {
			return page_name() . ' | ' .SITE_NAME;
		}
		return SITE_NAME;
	}
}

if ( ! function_exists('site_copyright') ) {
	function site_copyright() {
		return '&copy;' . CREATED_DATE .  ' - ' . SITE_NAME . '. ' . translate(1);
	}
}

if ( ! function_exists('site_favicon') ) {
	function site_favicon() {
		return asset_img('icons/favicon.png');
	}
}

if ( ! function_exists('site_logo') ) {
	function site_logo($light=false) {
		if ( $light ) {
			return asset_img('logos/logo-light.svg');
		}
		return asset_img('logos/logo.svg');
	}
}

if ( ! function_exists('asset_img') ) {
	function asset_img($uri) {
		return asset('assets/images/' . $uri);
	}
}

if ( ! function_exists('asset_avatar') ) {
	function asset_avatar($file, $path=null) {
		$directory = !is_null($path) ? $path : 'uploads/avatar/';

		if ( !$file || !file_exists(public_path($directory . $file)) ) {
			$file = 'default.png';
		}
		return asset($directory . $file);
	}
}

if ( ! function_exists('asset_css') ) {
	function asset_css($uri) {
		return asset('assets/css/' . $uri);
	}
}

if ( ! function_exists('asset_js') ) {
	function asset_js($uri) {
		return asset('assets/js/' . $uri);
	}
}

if ( ! function_exists('active_menu_item') ) {
	function active_menu_item($route_name){

		$current 	= Route::currentRouteName();

        if ( (is_array($route_name) && in_array($current, $route_name)) || ($current === $route_name) ) {
        	return ' active';
        }
        return null;
    }
}

if ( ! function_exists('customer') ) {
	function customer($user=true){
        if ( $user ) {
        	return Auth::guard('customer')->user();
		}
        return Auth::guard('customer');
    }
}

if ( ! function_exists('admin') ) {
	function admin($user=true){
		if ( $user ) {
        	return Auth::guard('admin')->user();
		}
        return Auth::guard('admin');
    }
}


if ( ! function_exists('loanCalculator') ) {
	function loanCalculator(array $data) {
		extract( $data );

		$loanAmount             = floatval($amount);
		$calculatedInterest     = floatval(TEAG) / 100 / 12;
		$calculatedPayments     = floatval($duration);

		# complate monthly payment 
		$x          = pow(1 + $calculatedInterest, $calculatedPayments);
		$monthly    = ($loanAmount * $x * $calculatedInterest)/($x-1);

		if( $loanAmount <= 0 || $calculatedInterest <= 0 || $calculatedPayments  <= 0 || !is_finite($monthly) ) {
		    return throw_exception();
		}

		$result['monthlyPayment']     = number_format($monthly, 2, '.', '');
		$result['totalPayment']       = number_format($monthly * $calculatedPayments, 2, '.', '');
		$result['totalInterest']      = number_format(($monthly * $calculatedPayments) - $loanAmount, 2, '.', '');

		return $result;
	}
}


if ( ! function_exists('random_float') ) {
	function random_float($min, $max) {
		return random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX );
	}
}

if ( ! function_exists('keyToName') ) {
	function keyToName($key) {
		return ucfirst(preg_replace("/[^a-z]+/i", ' ', $key));
	}
}

if ( ! function_exists('loans') ) {
	function loans() {
		$data['mortgage'] = [68,69]; # prêt immobilier
		$data['work-credit'] = [737,738]; # prêt immobilier
		$data['credit-redemption'] = [70,71]; # rachat de crédit
		$data['leasing'] = [72,73]; # crédit bail
		$data['student-loan'] = [74,75]; # prêt étudiant
		$data['consumer-loan'] = [66,67]; # prêt à la consommation

		return $data;
	}
}

if ( ! function_exists('insurances') ) {
	function insurances() {
		$data['loan'] = [741,[742/*,743,744*/]]; # Assurance emprunteur
		$data['home'] = [745,[746/*,747,748,749*/]]; # Assurance habitation
		$data['pet'] = [750,[751/*,752*/]]; # Assurance animaux
		$data['business'] = [753,[754/*,755*/]]; # Assurances professionnelles
		$data['health'] = [756,[757]]; # Assurance santé

		return $data;
	}
}

if ( ! function_exists('asset_img_exists') ) {
	function asset_img_exists($file) {
		if ( file_exists(public_path('assets/images/' . $file)) ) {
			return $file;
		}
		return false;
	}
}

if ( !function_exists('currency_view_map') ) {
	function currency_view_map($currency){
		$result = $currency['name'];
		if (!empty($currency['symbol'])) {
			$result .= ' (' . $currency['symbol'] . ')';
		}

		return $result;
	}
}

if ( !function_exists('dyn_recipient_translated_name') ) {
	function dyn_recipient_translated_name($db_table){
		$data_mapping = array(
			"bank_cards" => 587,
			"paypal_accounts" => 620,
			"transfert_recipients" => 619,
		);

		return translate( $data_mapping[$db_table] );
	}
}

if ( !function_exists('dyn_recipient_data') ) {
	function dyn_recipient_data(Transfert $transfer){
		$data_mapping = array(
			"bank_cards" => array(
				"614" => ["key" => "card_owner"],
				"611" => ["key" => "number", "callback" => "hideCardNumber"],
				"612" => ["key" => "expire"],
			),
			"paypal_accounts" => array(
				"617" => ["key" => "paypal_email", "callback" => "hideEmailAddress"],
			),
			"transfert_recipients" => recipient_keys()
		);

		$recipient = DB::table($transfer->payment_method)
			->whereId($transfer->payment_method_id)
			->first();
		
		return dyn_recipient_trait(
			$data_mapping[ $transfer->payment_method ],
			$recipient
		);
	}
}

if ( !function_exists('dyn_recipient_trait') ) {
	function dyn_recipient_trait(array $data, $recipient) {
		$result = [];

		foreach ($data as $translation_key => $row_name) {
		    $rName = $row_name['key'];
		    
		    if ( !empty($recipient->$rName) ) {
		        $callback = !empty($row_name['callback']) ? $row_name['callback'] : null;
		        
		        $value = $recipient->$rName;
		        $result[$translation_key] = $callback ? $callback($value) : $value;
		    }
		}

		return $result;
	}
}


if ( !function_exists('recipient_keys') ) {
	function recipient_keys() {
		return array(
			"495" => ["key" => "bank_name"],
			"325" => ["key" => "recipient_iban", "callback" => "hideIbanPart"],
			"317" => ["key" => "bank_swift"],
			"183" => ["key" => "account_number"],
			"604" => ["key" => "routing_number"],
			"603" => ["key" => "transit_number"],
			"602" => ["key" => "institution_number"],
			"615" => ["key" => "bsb_code"],
			"641" => ["key" => "short_code"],
		);
	}
}

if ( !function_exists('hideCardNumber') ) {
	function hideCardNumber($card) {
		$card = str_ireplace(" ", "", $card);
		return 'XXXX-XXXX-XXXX-' . substr($card, -4);
	}
}

if ( !function_exists('getUserAgent') ) {
	function getUserAgent()
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}
}

if ( !function_exists('account_types') ) {
	function account_types()
	{
		return [193, 194, 195];
	}
}

if ( !function_exists('genders') ) {
	function genders()
	{
		return [460, 461, 462];
	}
}

if ( !function_exists('doLogout') ) {
	function doLogout($request, $admin=false)
	{
		if ( $admin ) {
			admin(false)->logout();
		} else {
			customer(false)->logout();
		}

		$request->session()->invalidate();
		$request->session()->regenerateToken();
	}
}

if ( !function_exists('add_recipient_validator_rules') ) {
	function add_recipient_validator_rules($key=null)
	{
		$validator = [
		    "AU" => [
		        "account_number" => ["required", "string"],
		        "bsb_code" => ["required", "string"],
		    ],
		    "CA" => [
		        "account_number" => ["required", "string"],
		        "institution_number" => ["required", "string"],
		        "transit_number" => ["required", "string"],
		    ],
		    "default" => [
		        "recipient_iban" => ["required_if:ihave,==,iban_swift", "iban"],
		        "bank_swift" => ["required_if:ihave,==,iban_swift", "string", new \App\Rules\ValidSwiftCode],

		        "account_number" => ["required_if:ihave,==,account_num", "string"],
		    ],
		    "GB" => [
		        "account_number" => ["required", "string"],
		        "recipient_iban" => ["required", "iban"],
		        "short_code" => ["required", "string"],
		    ],
		    "NZ" => [
		        "account_number" => ["required", "string"],
		    ],
		    "US" => [
		        "account_number" => ["required", "string"],
		        "routing_number" => ["required", "string"],
		    ],
		];

		if ( $key ) {
		    if ( array_key_exists($key, $validator) ) {
		        return $validator[$key];
		    }
		    return $validator['default'];
		}
		return array_keys($validator);
	}
}

if ( !function_exists('hideEmailAddress') ) {
	function hideEmailAddress($email)
	{
	    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			list($first, $last) = explode('@', $email);
			$first = str_replace(substr($first, '3'), str_repeat('*', strlen($first)-3), $first);
			$last = explode('.', $last);
			$last_domain = str_replace(substr($last['0'], '1'), str_repeat('*', strlen($last['0'])-1), $last['0']);
			$hideEmailAddress = $first.'@'.$last_domain.'.'.$last['1'];
			return $hideEmailAddress;
        }
	}
}

if ( !function_exists('disabled_if') ) {
	function disabled_if($condition) {
	    if($condition) {
			return 'disabled="disabled"';
        }
	}
}

if ( !function_exists('throw_exception') ) {
	function throw_exception() {
	    throw new Exception("Error Processing Request", 1);
	}
}

if ( !function_exists('str_strong') ) {
	function str_strong($text) {
	    return "<strong class='text-sprintf' data-toggle=\"tooltip\" data-placement=\"top\" title=\"$text\">$text</strong>";
	}
}

if ( !function_exists('back_With_Error') ) {
	function back_With_Error($key=422) {
		$key = !empty($key) ? $key : 422;
		
	    return back()->withErrors([
	        "danger" => (intval($key) > 0) ? translate($key) : $key
	    ]);
	}
}

if ( !function_exists('back_With_Warning') ) {
	function back_With_Warning($key=422) {
		$key = !empty($key) ? $key : 422;
		
	    return back()->withErrors([
	        "warning" => (intval($key) > 0) ? translate($key) : $key
	    ]);
	}
}

if ( !function_exists('back_With_Success') ) {
	function back_With_Success($key) {
	    return back()->withErrors([
	        "success" => translate($key)
	    ]);
	}
}

if ( !function_exists('transfer_methods') ) {
	function transfer_methods($key=null) {
	    $methods = [
	        "cards"         => "bank_cards",
	        "recipients"    => "transfert_recipients",
	        "paypal"        => "paypal_accounts"
	    ];

	    if ( !empty($methods[$key]) ) {
	    	return $methods[$key];
	    }
	    return array_keys($methods);
	}
}

if ( !function_exists('currency_converter') ) {
	function currency_converter($fromCurrency, $amount, $toCurrency=false) {
	    try {
	    	
	    	$convert_cost = CurrencyFacade::convert()
                ->from( $fromCurrency )
                ->to( ($toCurrency === false) ? DEFAULT_CONVERT_CURRENCY : $toCurrency )
                ->amount( $amount )
                ->get();

            return !empty($convert_cost) ? $convert_cost : 0;

	    } catch (\Exception $e) {
	    	return 0;
	    }
	}
}

if ( !function_exists('rib_keys') ) {
	function rib_keys() {
	    return [
	    	'bank_name' => 318,
	    	'account_number' => 487,
	    	'rib_key' => 679,
	    	'iban' => 325,
	    	'swift_bic' => 317
	    ];
	}
}

if ( !function_exists('customer_completed_transfers') ) {
	function customer_completed_transfers() {
	    return customer()->transferts()
	    	->whereNotNull('completed_at')
	    	->orderByDesc('completed_at')
	    	->first();
	}
}

if ( !function_exists('compareTimer') ) {
	function compareTimer( $db_datetime, $recently_started=false )
	{
		$NOW 			= Carbon::now();
		$TARGET_TIME 	= Carbon::parse($db_datetime);
		$F 				= "Y-m-d H:i:s";

		if ($recently_started) {
			$TARGET_TIME->addMinutes( (int)FIRST_LATENCE_OF_TRANSFERT );
		}
		$DIFF = $NOW->diffInSeconds($TARGET_TIME, false);

		if ( $DIFF > 0 ){
			return [
				"target_date" 	=> $TARGET_TIME->format($F), 
				"rest" 			=> $DIFF,
				"init" 			=> $recently_started,
			];
		}
		return false;
	}
}

if ( !function_exists('countDownTimer') ) {
	function countDownTimer( array $loadsection )
	{
		$NOW 			= Carbon::now();
		$TARGET_TIME 	= Carbon::parse($loadsection['target_date']);
		$DIFF 			= $NOW->diffInSeconds($TARGET_TIME, false);

		if ( $DIFF <= 0 ) {
			return false;
		}

		$tmp = ceil($DIFF);
		$result['sec'] = (int) $tmp % 60;

		$tmp = ceil(($tmp-$result['sec'])/60);
		$result['min'] = (int) $tmp % 60;

		$tmp = ceil(($tmp-$result['min'])/60);
		$result['hour'] = (int) $tmp % 24;

		$tmp = ceil(($tmp-$result['hour'])/24);
		$result['day'] = (int) $tmp;

		foreach ($result as $key => $value) {
			$value = ($value <= 0) ? 0 : $value;

			if ( strlen($value) <= 1 ) {
				$result[$key] = '0' . $value;
			}
		}

		return $result;
	}
}

if ( !function_exists('admin_request_customer') ) {
	function admin_request_customer() {
	    return request()->request->get( ADMIN_MIDDLEWARE_CUSTOMER_KEY );
	}
}

if ( !function_exists('messageDeliveryStatus') ) {
	function messageDeliveryStatus( $status )
	{
	    if ($status == 1) {
	        return "<span data-toggle=\"tooltip\" data-placement=\"top\" class='badge badge-success' title='Le message a bien été transmis au client et nous avons reçu confirmation.'>Délivré</span>";
	    } elseif ($status == 2) {
	        return "<span data-toggle=\"tooltip\" data-placement=\"top\" class='badge badge-warning' title='Le message est toujours en attente d&apos;être envoyé à causes de quelques soucis, numéros incorrect, réseaux indisponibles, etc'>En attente</span>";
	    } elseif ($status == 9) {
	        return "<span data-toggle=\"tooltip\" data-placement=\"top\" class='badge badge-dark' title='Nous n\'avons pas reçu une réponse claire du serveur distant.'>Expiré</span>";
	    } else {
	        return "<span data-toggle=\"tooltip\" data-placement=\"top\" class='badge badge-danger' title='Le message n&apos;a pas été transmis au client.\nSelon le niveau atteint par le processus, notre systeme jugera s&apos;il faut vous remboursé ou pas'>Echec</span>";
	    }
	}
}

if ( !function_exists('sanitizePhoneNumber') ) {
	function sanitizePhoneNumber( $phone )
	{
	    return preg_replace("/[^0-9\+]+/", "", $phone);
	}
}


// IP GESTION

// if ( !function_exists('getIpData') ) {
// 	function getIpData($ip_address) {
// 	    try {
// 	    	# Initialize CURL
// 	    	$ch = curl_init('http://api.ipstack.com/'. $ip_address .'?access_key='. IPSTACK_API_KEY);  
// 	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 	    	# Store the data
// 	    	$json = curl_exec($ch);
// 	    	curl_close($ch);

// 	    	$arr_result = @json_decode($json, true);
// 	    	return $arr_result;

// 	    } catch(Exception $e) {
// 	    	return false;
// 	    }
// 	}
// }

if ( ! function_exists('ip2countryIso') ) {
	function ip2countryIso($IpLockUp){ 
		try {
			$reader = new Reader(resource_path("maxmind/GeoLite2-Country.mmdb"));
			$record = $reader->country( $IpLockUp );
			$geolite_country_iso = strtolower( $record->country->isoCode );

			return $geolite_country_iso;

		} catch (Exception $e) {
			return false;
		}
	}
}

if ( ! function_exists('get_client_ip') ) {
	function get_client_ip() {

		if ( app()->environment('local') ) {
			return '149.154.161.237';
		}

		$ipAddress = '';
		if ( !empty($_SERVER['HTTP_CLIENT_IP'])) {
			// to get shared ISP IP address
			$ipAddress = $_SERVER['HTTP_CLIENT_IP'];
		} else if ( !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// check for IPs passing through proxy servers
			// check if multiple IP addresses are set and take the first one
			$ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($ipAddressList as $ip) {
				if ( !empty($ip) && isValidIpAddress($ip) ) {
					$ipAddress = $ip;
					break;
				}
			}
		} else if ( !empty($_SERVER['HTTP_X_FORWARDED'])) {
			$ipAddress = $_SERVER['HTTP_X_FORWARDED'];
		} else if ( !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
			$ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		} else if ( !empty($_SERVER['HTTP_FORWARDED_FOR'])) {
			$ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if ( !empty($_SERVER['HTTP_FORWARDED'])) {
			$ipAddress = $_SERVER['HTTP_FORWARDED'];
		} else if ( !empty($_SERVER['REMOTE_ADDR'])) {
			$ipAddress = $_SERVER['REMOTE_ADDR'];
		}

		return $ipAddress;
	}
}

if ( ! function_exists('isValidIpAddress') ) {
	function isValidIpAddress($ip){
	    if (filter_var($ip, FILTER_VALIDATE_IP,
	        FILTER_FLAG_IPV4 |
	        FILTER_FLAG_IPV6 |
	        FILTER_FLAG_NO_PRIV_RANGE |
	        FILTER_FLAG_NO_RES_RANGE) === false) {
	        return false;
	    }
	    return true;
	}
}

if ( ! function_exists('termsContent') ) {
	function termsContent($uri){
	    $lang = app()->getLocale();

	    $file = resource_path('views/contents/'. $uri .'/' . $lang . '.txt');
	    if ( ! file_exists($file) ) {
	        return abort(404);
	    }
	    return str_replacing( file_get_contents($file) );
	}
}

if ( ! function_exists('redirectWithLocale') ) {
	function redirectWithLocale($uri, $parameter=null){
	    return redirect( routeWithLocale($uri, $parameter) );
	}
}

if ( ! function_exists('generate_pdf') ) {
	function generate_pdf($html, $name){
	    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8');
	    $html2pdf->setTestTdInOnePage(false);
	    $html2pdf->writeHTML($html);
	    $html2pdf->Output($name . ".pdf");
	    // $html2pdf->Output($name . ".pdf", "D");
	}
}

if ( ! function_exists('recursive_copy') ) {
	function recursive_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recursive_copy($src .'/'. $file, $dst .'/'. $file);
                }
                else {
                    copy($src .'/'. $file,$dst .'/'. $file);
                }
            }
        }
        closedir($dir);
    }
}

if ( ! function_exists('recursive_remove') ) {
	function recursive_remove($dir) {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $filename => $fileInfo) {
            if ($fileInfo->isDir()) {
                rmdir($filename);
            } else {
                unlink($filename);
            }
        }
    }
}

if ( ! function_exists('legal_texts_endpoints') ) {
	function legal_texts_endpoints() {
        return [
            'account-closing-terms' => 19,
            'account-terms' => 27,
            'anti-fraud-policy' => 1,
            // 'cookie-policy' => 1,
            'email-service-terms-and-conditions' => 1,
            // 'legal-notice' => 1,
            'liability-in-case-of-fraud-or-unauthorized-use' => 1,
            'privacy-policy' => 31,
            'refund-and-return-policy' => 1,
            'terms-and-conditions-of-use' => 1,
        ];
    }
}

if ( !function_exists('bank_card_theming') ) {
	function bank_card_theming($name, $title, $color) {
		$layout_file = resource_path('views/layouts/cards/layout.svg');

		if ( !is_file($layout_file) || (! $layout_content = file_get_contents($layout_file)) ) {
			return throw_exception('Le template des cartes n\'est pas trouvé');
		}

		$card = str_ireplace('[CARD_TITLE]', $title, $layout_content);
		$card = str_ireplace('[CARD_COLOR]', $color, $card);

		$card_path = public_path('assets/images/cards/' . $name . '.svg');
		if ( !is_dir($dx = dirname($card_path)) ) {
			mkdir($dx, 0777, true);
		}
		
		file_put_contents($card_path, $card);
	}
}
