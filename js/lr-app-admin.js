(function ($) {
    //var criticalModule = angular.module('CriticalNet', ['ngMessages','ui.mask'])
    var lolaRegApp = angular.module('la-registration-admin-app', ['critical-module']);
    lolaRegApp.controller('registrationAdminController', ["$scope", function ($scope) {
        var vm = this;
        vm.userAdditionalInfo = $scope.$eval(extraInfo.data);
        vm.government_photo = extraInfo.government_photo;
        vm.medical_photo = extraInfo.medical_photo;
        vm.personal_photo = extraInfo.personal_photo;
        $("#submit").click(function (event) {
            $scope.$apply(function () {
                $scope.extraInfoForm.$setSubmitted();
                if (!$scope.extraInfoForm.$valid)
                    event.preventDefault();
            });
        });
        vm.governmentPhotoUpload = function () {
            debugger;
            var fd = new FormData();
            fd.append('governmentIDPhoto', $("#governmentFile").get(0));
            fd.append('action', 'lr_file_upload');
            fd.append('userId', extraInfo.userId);
            $.post(extraInfo.ajax_url, fd, function (data) {
                debugger;
            });
        };
    }]);

    $(document).ready(function () {
        $("h2:contains('Personal Options')").next('.form-table').hide();
        $("h2:contains('Personal Options')").hide();
        
        $("h2:contains('Contact Info')").next('.form-table').hide();
        $("h2:contains('Contact Info')").hide();

        $("h2:contains('About the user')").next('.form-table').hide();
        $("h2:contains('About the user')").hide();

        $(".user-first-name-wrap").hide();
        $(".user-last-name-wrap").hide();
        $(".user-display-name-wrap").hide();

        $("h3:contains('User Social Networks')").next('.form-table').hide();
        $("h3:contains('User Social Networks')").hide();

        
        $("h3:contains('Customer Billing Address')").next('.form-table').find("tr").each(function () {
            var title = $(this).find("th label").text();
            $(this).find("td input").attr("placeholder", title);
        });

        $("h3:contains('Customer Shipping Address')").next('.form-table').find("tr").each(function () {
            var title = $(this).find("th label").text();
            $(this).find("td input").attr("placeholder", title);
        });
        
    });
})(jQuery);