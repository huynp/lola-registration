(function ($) {
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var NumberOnlyDirective = (function () {
                function NumberOnlyDirective() {
                    this.require = 'ngModel';
                    this.restrict = 'A';
                    this.link = function (scope, elems, attrs, ctrl) {
                        $(elems).on('keydown', function (e) {
                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                return;
                            }
                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });
                    };
                }
                NumberOnlyDirective.instance = function () {
                    return new NumberOnlyDirective();
                };
                return NumberOnlyDirective;
            }());
            Directives.NumberOnlyDirective = NumberOnlyDirective;
            angular.module('critical-module').directive('numberOnly', NumberOnlyDirective.instance);
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
})(jQuery);