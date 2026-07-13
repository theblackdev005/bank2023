var app = angular.module("bankingNgApp", []);

app.controller("addRecipientsCtrl", function($scope, $timeout) {

    const authorizedCountries = ["AU", "CA", "NZ", "US", "GB"];
	$scope.showDefaultForm = true;
    $scope.countryIso = null;
    $scope.showLoader = false;
    $scope.ihave = 'iban_swift';

    $scope.showFormByCountry = function (name) {
        if ( ($scope.countryIso === name) && !$scope.showDefaultForm ) {
            return true;
        }
        return false;
    }

    $scope.setCountryIso = function (name) {
        $scope.showLoader = true;
        $scope.showDefaultForm = true;

        $timeout( function(){
            $scope.showLoader = false;

            $scope.countryIso = name;
            if ( authorizedCountries.includes(name) ) {
                $scope.showDefaultForm = false;
            }

        }, 2000);
    }
});

app.controller("addWireTransfertCtrl", function($scope, $timeout, $http) {
    $scope.currentTab = 'recipients';
    $scope.balanceTypingError = false;

    $scope.showIf = function (key) {
        if ( $scope.currentTab == key ) {
            return true;
        }
        return false;
    }

    $scope.InitialiserVars = function (n) {
        setNewBalance(n);
    };

    let setNewBalance = function (b) {
        $scope.newBalance = parseFloat(b);
    }

    $scope.setBalance = function (max_value) {
        $scope.balanceTypingError = false;
        let typingBalance = parseFloat($scope.balance_typing);
        let maxBalance = parseFloat(max_value);
        if ( Number.isNaN(typingBalance) || (typingBalance > maxBalance) ) {
            if ( Number.isNaN(typingBalance) ) {
                setNewBalance(maxBalance);
            } else {
                setNewBalance(0);
            }
            $scope.balanceTypingError = true;
            return false;
        }
        setNewBalance(maxBalance - typingBalance);
    }

    $scope.activating = function (key) {
        $scope.currentTab = key;
    }

    // Ajouter un compte paypal
    $scope.chooseOrAddPpl = '1';
    $scope.paypal_form_error = false;
    $scope.paypal_form_spinner = false;
    $scope.paypal_form_error_msg = false;
    $scope.paypal_form = {
        submitAddPplAcc: 1
    };

    $scope.addPplAcc = function (uri) {
        $scope.paypal_form_error_msg = false;
        $scope.paypal_form_error = false;
        $scope.paypal_form_spinner = true;

        $http.post(uri, $scope.paypal_form).then(function(response) {
            $scope.paypal_form_spinner = false;
            let data$ = response.data;

            if ( !data$.success ) {
                $scope.paypal_form_error = true;
                $scope.paypal_form_error_msg = data$.error;
                return false;
            }

            $scope.paypal_form_error = false;
            if ( data$.location ) {
                window.location.href = data$.location;
            }
        }, function(response) {
            $scope.paypal_form_spinner = false;
            $scope.paypal_form_error = true;
        });
    }

});