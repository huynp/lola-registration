(function ($) {
    //var criticalModule = angular.module('CriticalNet', ['ngMessages','ui.mask'])
    var lolaRegApp = angular.module('la-registration-app', ['critical-module']);
    lolaRegApp.service('registrationService', ['$http', function ($http) {
        return {
            createUser: function (user) {
                return $http({
                    method: 'POST',
                    url: lrSettings.ajax_url,
                    data: jQuery.param({
                        action: 'lr_user_registration',
                        userData: JSON.stringify(user),
                        nonce: lrSettings.nonce
                    }),
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                });
            },
            login:function(user)
            {
                return $http({
                    method: 'POST',
                    url: lrSettings.ajax_url,
                    data: jQuery.param({
                        action: 'lr_user_login',
                        userData: JSON.stringify(user),
                        nonce: lrSettings.nonce
                    }),
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                });
            },
            updateUserAddintionalData: function (userId,userAddintionalData) {
                return $http({
                    method: 'POST',
                    url: lrSettings.ajax_url,
                    data: jQuery.param({
                        action: 'lr_user_additional_data_update',
                        userAddintionalData: JSON.stringify(userAddintionalData),
                        nonce: lrSettings.nonce,
                        userId:userId
                    }),
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                });
            }
        };
    }]);
    lolaRegApp.controller('registrationController', ["$scope", "registrationService", function ($scope, registrationService) {
        var vm = this;
        vm.init = function () {
            vm.showLoading = false;
            vm.mode = 'init';
            vm.contentText = "Whether you're max relaxed or folding laundry like a boss, a hit of Lola Lola can sure hit the spot. Peek behind the curtain and discover how your favorite little creatures like to Lola. Then share the Lola love with all your peeps.";
            vm.loginInfo = {};
            vm.user = {};
            vm.userAdditionalInfo = {};
            vm.userAdditionalInfo.govIssueType = "1";
            vm.step = 1;
            vm.stepProgressBar = "/wp-content/plugins/lola-registration/images/progression_bar_1.png";
            vm.characterImage = "/wp-content/plugins/lola-registration/images/char_1.png";
            $scope.loginForm && $scope.loginForm.$setPristine();
            $scope.registrationFormStep1 && $scope.registrationFormStep1.$setPristine();
            $scope.registrationFormStep2 && $scope.registrationFormStep2.$setPristine();
            $scope.registrationFormStep3 && $scope.registrationFormStep3.$setPristine();
            $scope.registrationFormStep5 && $scope.registrationFormStep5.$setPristine();

            $(".registration-link").bind('click', function () {
                $("body").addClass("lr-show").append($("<div class='lr-backdrop'></div>"));
                $(".registration-cover").removeClass("hide");
            })
            $(".mk-button--dimension-outline").bind('click', function () {
                $("body").addClass("lr-show").append($("<div class='lr-backdrop'></div>"));
                $(".registration-cover").removeClass("hide");
                $scope.$apply(function () {
                    vm.mode = 'popup';
                    vm.popupType = 'account-not-verified-message';
                });
            })
        }

        $scope.$watch(function watchStep(scope) {
            return (vm.step);
        },
        function changeProgressBarBg() {
            vm.stepProgressBar = "/wp-content/plugins/lola-registration/images/progression_bar_" + vm.step + ".png";
            vm.characterImage = "/wp-content/plugins/lola-registration/images/char_" + vm.step + ".png";
        });

        vm.PrevBtnClick = function () {
            if (vm.step > 1)
                vm.step = vm.step - 1;
            vm.stepProgressBar = "/wp-content/plugins/lola-registration/images/progression_bar_" + vm.step + ".png";
        }

        vm.StepSubmitBtnClick = function () {

            switch(vm.step)
            {
                case 1:
                    $scope.registrationFormStep1.$setSubmitted();
                    if (!vm.user || !$scope.registrationFormStep1.$valid)
                        return;
                    if ( vm.user.userId == undefined)
                    {
                        vm.showLoading = true;
                        registrationService.createUser(vm.user).then(function (response) {
                            vm.showLoading = false;
                            if (response.data.status == "success") {
                                vm.user.userId = response.data.resultData;
                                vm.step += 1;
                            }
                            else
                                alert(response.data.errorMessage);
                        });
                    }
                    else
                    {
                        vm.step += 1;
                    }
                    break;
                case 2:
                    $scope.registrationFormStep2.$setSubmitted();
                    if (!$scope.registrationFormStep2.$valid)
                        return;

                    vm.showLoading = true;

                    // Add more info for billing address and create shipping address
                    vm.userAdditionalInfo.email = vm.user.email;
                    vm.userAdditionalInfo.billingEmail = vm.user.email;
                    vm.userAdditionalInfo.billingCellPhone = vm.userAdditionalInfo.cellPhone;
                    vm.userAdditionalInfo.billingPostCode = vm.userAdditionalInfo.postCode;
                    vm.userAdditionalInfo.billingAddress1 = vm.userAdditionalInfo.address1;
                    vm.userAdditionalInfo.billingAddress2 = vm.userAdditionalInfo.address2;
                    vm.userAdditionalInfo.billingFirstName = vm.userAdditionalInfo.firstName;
                    vm.userAdditionalInfo.billingLastName = vm.userAdditionalInfo.lastName;
                    vm.userAdditionalInfo.billingCountry = "US";

                    vm.userAdditionalInfo.sameAsShipping = true;
                    vm.userAdditionalInfo.shippingAddress1= vm.userAdditionalInfo.address1;
                    vm.userAdditionalInfo.shippingAddress2 = vm.userAdditionalInfo.address2;
                    vm.userAdditionalInfo.shippingFirstName = vm.userAdditionalInfo.firstName;
                    vm.userAdditionalInfo.shippingLastName = vm.userAdditionalInfo.lastName;
                    vm.userAdditionalInfo.shippingCellPhone = vm.userAdditionalInfo.cellPhone;
                    vm.userAdditionalInfo.shippingPostCode = vm.userAdditionalInfo.postCode;
                    vm.userAdditionalInfo.shippingCountry = "US";

                    registrationService.updateUserAddintionalData(vm.user.userId, vm.userAdditionalInfo).then(function (response) {
                        vm.showLoading = false;
                        if (response.data.status == "success")
                            vm.step += 1;
                        else
                            alert(response.data.errorMessage);
                    });
                    break;
                case 3:
                    $scope.registrationFormStep3.$setSubmitted();
                    if (!$scope.registrationFormStep3.$valid)
                        return;
                    vm.showLoading = true;
                    registrationService.updateUserAddintionalData(vm.user.userId, vm.userAdditionalInfo).then(function (response) {
                        vm.showLoading = false;
                        if (response.data.status == "success") 
                            vm.step += 1;
                        else
                            alert(response.data.errorMessage);
                    });
                    break;
                case 4:
                    vm.showLoading = true;
                    $('#documentUploadForm').ajaxForm({
                        url: lrSettings.ajax_url, // there on the admin side, do-it-yourself on the front-end
                        data: { action: "lr_file_upload", userId: vm.user.userId },
                        type: 'POST',
                        contentType: 'json',
                        success: function (response) {
                            $scope.$apply(function () {
                                vm.showLoading = false;
                                vm.step+=1;
                            });
                        }
                    });
                    $('#documentUploadForm').submit();
                    break;
                case 5:
                    $scope.registrationFormStep5.$setSubmitted();
                    if (!$scope.registrationFormStep5.$valid)
                        return;
                    vm.showLoading = true;
                    registrationService.updateUserAddintionalData(vm.user.userId, vm.userAdditionalInfo).then(function (response) {
                        if (response.data.status == "success")
                        {
                            registrationService.login(vm.user).then(function (response) {
                                if (response.data.status == "success")
                                {
                                    var lrPopup = $(".lr-popup").lrPopup({
                                        onClose: function () {
                                            location.reload();
                                        }
                                    });

                                    var $popupContent = $("<div class='lr-success-message'>").html("Mission accomplished, welcome to Lolalandia! It only takes 30 minutes to confirm your registration, then you are ready to shop. Please check your email for account verification, then follow the link to Get Lola Lola.");
                                    var $popupButton = $('<button class="lr-popup-btn lr-popup-close" >OK</button>');
                                    var buttons = [];
                                    buttons.push($popupButton);
                                    lrPopup.show($popupContent, buttons);
                                }
                                else
                                    alert(response.data.errorMessage);
                            });
                        }
                        else
                            alert(response.data.errorMessage);
                    });
                    break;
            }

           

        }

        vm.CancelBtnClick = function () {
            vm.init();
            $(".lr-backdrop").remove();
            $(".registration-cover").addClass("hide");
            $("body").removeClass("lr-show");
        };

        vm.RegistrationNow = function () {
            vm.mode = 'registration';
        };

        vm.Login = function () {
            $scope.loginForm.$setSubmitted();
            if (!vm.loginInfo || !$scope.loginForm.$valid)
                return;
            vm.showLoading = true;
            registrationService.login(vm.loginInfo).then(function (response) {
                vm.showLoading = false;
                if (response.data.status == "success")
                    location.reload();
                else
                    alert(response.data.errorMessage);
            });
        }
        vm.init();
    }]);
    $(document).ready(function () {

        $(".inactive-user").click(function () {
            var lrPopup = $(".lr-popup").lrPopup();
            var $popupContent = $("<div class='lr-inactive-message'>").html("We’re sorry, there was trouble processing your request. If you are over 18 years old, have a valid medicinal marijuana card, and are a CA resident, please contact <a href='mailto:support@getlolalola.com' target='_top'>support@getlolalola.com </a>for further assistance.");
            var $popupButton = $('<button class="lr-popup-btn lr-popup-close" >OK</button>');
            var buttons = [];
            buttons.push($popupButton);
            lrPopup.show($popupContent, buttons);
        });

        if(!lrSettings.is_user_logged_in)
            $(".my-account-item").hide();
        else 
            $(".registration-link").hide();

        if (!lrSettings.is_user_active)
            $(".shopping-cart-header").remove();
    });
})(jQuery);