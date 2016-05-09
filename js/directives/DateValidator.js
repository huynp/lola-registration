(function ($) {
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var CriticalIFrameDirective;
            (function (CriticalIFrameDirective) {
                var CriticalDateValidatorDirective = (function () {
                    function CriticalDateValidatorDirective() {
                        this.require = 'ngModel';
                        this.restrict = 'A';
                        this.link = function (scope, element, attrs, ctrls) {
                            var isDateValid = function (value, userFormat) {
                                if (value == undefined || value == "" || userFormat == undefined || userFormat == "")
                                    return false;
                                var userFormat = userFormat || 'mm/dd/yyyy', // default format
                                delimiter = /[^mdy]/.exec(userFormat)[0], theFormat = userFormat.split(delimiter), theDate = value.split(delimiter), isDate = function (date, format) {
                                    var m, d, y;
                                    for (var i = 0, len = format.length; i < len; i++) {
                                        if (/m/.test(format[i]))
                                            m = date[i];
                                        if (/d/.test(format[i]))
                                            d = date[i];
                                        if (/y/.test(format[i]))
                                            y = date[i];
                                    }
                                    return (m > 0 && m < 13 &&
                                        y && y.length === 4 &&
                                        d > 0 && d <= (new Date(y, m, 0)).getDate());
                                };
                                return isDate(theDate, theFormat);
                            };
                            ctrls.$parsers.push(function (value) {
                                var isValid = isDateValid(value, "mm-dd-yyyy");
                                ctrls.$setValidity('dateValidator', isValid);
                                return isValid ? value : undefined;
                            });
                            ctrls.$formatters.push(function (value) {
                                var isValid = isDateValid(value, "mm-dd-yyyy");
                                ctrls.$setValidity('dateValidator', isValid);
                                return value;
                            });
                        };
                    }
                    CriticalDateValidatorDirective.instance = function () {
                        return new CriticalDateValidatorDirective();
                    };
                    return CriticalDateValidatorDirective;
                }());
                CriticalIFrameDirective.CriticalDateValidatorDirective = CriticalDateValidatorDirective;
                angular.module('critical-module').directive('dateValidator', CriticalDateValidatorDirective.instance);
            })(CriticalIFrameDirective = Directives.CriticalIFrameDirective || (Directives.CriticalIFrameDirective = {}));
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
})(jQuery);