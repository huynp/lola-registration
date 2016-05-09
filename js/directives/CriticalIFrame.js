(function ($) {
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var CriticalIFrameDirective;
            (function (CriticalIFrameDirective_1) {
                var CriticalIframeController = (function () {
                    function CriticalIframeController() {
                    }
                    return CriticalIframeController;
                }());
                var CriticalIFrameDirective = (function () {
                    function CriticalIFrameDirective() {
                        this.replace = true;
                        this.scope = {
                            src: '@',
                            height: '@',
                            width: '@',
                            onLoaded: '&',
                        };
                        this.controller = "CriticalIframeController";
                        this.controllerAs = "vm";
                        this.bindToController = true;
                        this.template = '<iframe id="iframeID" class="frame" frameborder="0" border="0" marginwidth="0" marginheight="0"  width="{{vm.width}}" height="{{vm.height}}" ></iframe>';
                        this.restrict = 'E';
                        this.link = {
                            pre: function (scope, elements, attrs, ctrl) {
                                $(elements).attr('src', attrs.src);
                                $(elements).on("load", function () {
                                    ctrl.onLoaded({ iframeId: $(this).attr('id') });
                                });
                            }
                        };
                    }
                    CriticalIFrameDirective.instance = function () {
                        return new CriticalIFrameDirective();
                    };
                    return CriticalIFrameDirective;
                }());
                CriticalIFrameDirective_1.CriticalIFrameDirective = CriticalIFrameDirective;
                angular.module('critical-module').controller('CriticalIframeController', CriticalIframeController);
                angular.module('CriticalNet').directive('criticalIframe', CriticalIFrameDirective.instance);
            })(CriticalIFrameDirective = Directives.CriticalIFrameDirective || (Directives.CriticalIFrameDirective = {}));
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));

})(jQuery);