(function ($) {
    //var criticalModule = angular.module('CriticalNet', ['ngMessages','ui.mask'])
    var lolaRegApp = angular.module('lr-my-account-app', ['critical-module']);
    lolaRegApp.controller('lrMyAccountController', ["$scope", "$http", function ($scope, $http) {
        var vm = this;
        vm.showLoading = false;
        vm.userInfo = $scope.$eval(myAccountData.data);

        vm.removeImage = function (name) {
            vm.showLoading = true;
            $http({
                method: 'POST',
                url: myAccountData.ajaxUrl,
                data: $.param({
                    action: 'lr_file_remove',
                    userId: myAccountData.userId,
                    imageType: name
                }),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(function (response) {
                vm.showLoading = false;
                switch (name) {
                    case "government":
                        vm.userInfo.government_photo = myAccountData.noImgUrl;
                        break;
                    case "medical":
                        vm.userInfo.medical_photo = myAccountData.noImgUrl;
                        break;
                    case "personal":
                        vm.userInfo.personal_photo = myAccountData.noImgUrl;
                        break;
                }
            });
        }

        vm.uploadImage = function (name) {
            $scope.$apply(function () {
                vm.showLoading = true;
            });
            $('#documentUploadForm').ajaxForm({
                url: myAccountData.ajaxUrl, // there on the admin side, do-it-yourself on the front-end
                data: { action: "lr_file_upload", userId: myAccountData.userId },
                type: 'POST',
                contentType: 'json',
                success: function (response) {
                    data = $scope.$eval(response);
                    $scope.$apply(function () {
                        vm.showLoading = false;
                        d = new Date();
                        switch (name) {
                            case "government":
                                vm.userInfo.government_photo = data.resultData.government_photo+"?"+d.getTime();
                                break;
                            case "medical":
                                vm.userInfo.medical_photo = data.resultData.medical_photo + "?" + d.getTime();
                                break;
                            case "personal":
                                vm.userInfo.personal_photo = data.resultData.personal_photo + "?" + d.getTime();
                                break;
                        }
                    });
                    $('#documentUploadForm').find("input").each(function () {
                        this.value = "";
                    });
                },
                error: function (errorMessage) {
                    $scope.$apply(function () {
                        debugger;
                        vm.showLoading = false;
                        alert(errorMessage);
                    });
                }
            });
            $('#documentUploadForm').submit();
        };

        vm.myAccountSubmit = function () {
            vm.showLoading = true;
            if (vm.userInfo.sameAsShipping) {
                vm.userInfo.shippingAddress1 = vm.userInfo.billingAddress1;
                vm.userInfo.shippingAddress2 = vm.userInfo.billingAddress2;
                vm.userInfo.shippingFirstName = vm.userInfo.billingFirstName;
                vm.userInfo.shippingLastName = vm.userInfo.billingLastName;
                vm.userInfo.shippingState = vm.userInfo.billingState;
                vm.userInfo.shippingPostCode = vm.userInfo.billingPostCode;
                vm.userInfo.shippingCity = vm.userInfo.billingCity;
                vm.userInfo.shippingCountry = "US";
            }
            $http({
                method: 'POST',
                url: myAccountData.ajaxUrl,
                data: $.param({
                    action: 'lr_my_account_update',
                    userInfo: JSON.stringify(vm.userInfo),
                    userId: myAccountData.userId
                }),
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(function (response) {
                location.reload();
                vm.showLoading = false;
            }, function (errorMessage) {
                vm.showLoading = false;
            });
        }
    }]);
})(jQuery);