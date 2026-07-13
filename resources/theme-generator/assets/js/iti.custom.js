(function () {
	function getIp(callback) {
		fetch('https://ipinfo.io/json?token=a4d887079b1b23', { headers: { 'Accept': 'application/json' }})
			.then((resp) => resp.json())
			.catch(() => {
				return {
					country: 'us',
				};
			})
			.then((resp) => callback(resp.country));
	}

	const phoneInputField = document.querySelector("#phone_number_field");
	if ( !phoneInputField ) {
		return false;
	}
	const phoneInput = window.intlTelInput(phoneInputField, {
		initialCountry: "auto",
		geoIpLookup: getIp,
		hiddenInput: phoneInputField.dataset.fullInput,
		utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
	});
})();