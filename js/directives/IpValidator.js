(function ($) {
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var CriticalIFrameDirective;
            (function (CriticalIFrameDirective) {
                var CriticalIPValidatorDirective = (function () {
                    function CriticalIPValidatorDirective() {
                        this.require = 'ngModel';
                        this.restrict = 'A';
                        this.link = function (scope, element, attrs, ctrls) {
                            var pattern = /\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/;
                            ctrls.$parsers.push(function (value) {
                                var isValid = pattern.test(value);
                                if (value == undefined || value == '')
                                    isValid = true;
                                ctrls.$setValidity('ipValidator', isValid);
                                return isValid ? value : undefined;
                            });
                            ctrls.$formatters.push(function (value) {
                                var isValid = pattern.test(value);
                                if (value == undefined || value == '')
                                    isValid = true;
                                ctrls.$setValidity('ipValidator', isValid);
                                return value;
                            });
                        };
                    }
                    CriticalIPValidatorDirective.instance = function () {
                        return new CriticalIPValidatorDirective();
                    };
                    return CriticalIPValidatorDirective;
                }());
                CriticalIFrameDirective.CriticalIPValidatorDirective = CriticalIPValidatorDirective;
                angular.module('critical-module').directive('ipValidator', CriticalIPValidatorDirective.instance);
            })(CriticalIFrameDirective = Directives.CriticalIFrameDirective || (Directives.CriticalIFrameDirective = {}));
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
})(jQuery);