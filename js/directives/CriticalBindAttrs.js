(function ($) {
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var CriticalBindAttrs = (function () {
                function CriticalBindAttrs() {
                    this.restrict = 'A';
                    this.link = function ($scope, $element, $attrs) {
                        var attrsObj = $scope.$eval($attrs.criticalBindAttrs);
                        angular.forEach(attrsObj, function (value, key) {
                            $attrs.$set(key, value);
                        });
                    };
                }
                CriticalBindAttrs.Instance = function () {
                    return new CriticalBindAttrs();
                };
                return CriticalBindAttrs;
            }());
            Directives.CriticalBindAttrs = CriticalBindAttrs;
            angular.module('critical-module').directive('criticalBindAttrs', CriticalBindAttrs.Instance);
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
})(jQuery);