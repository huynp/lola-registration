(function ($) {
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var InputDirectives;
            (function (InputDirectives) {
                (function (InputType) {
                    InputType[InputType["email"] = 'email'] = "email";
                    InputType[InputType["date"] = 'date'] = "date";
                    InputType[InputType["number"] = 'number'] = "number";
                    InputType[InputType["text"] = 'text'] = "text";
                    InputType[InputType["password"] = 'password'] = "password";
                    InputType[InputType["ip"] = 'ip'] = "ip";
                    InputType[InputType["checkbox"] = 'checkbox'] = "checkbox";
                    InputType[InputType["phone"] = 'phone'] = "phone";
                    InputType[InputType["datePicker"] = 'datePicker'] = "datePicker";
                })(InputDirectives.InputType || (InputDirectives.InputType = {}));
                var InputType = InputDirectives.InputType;
            })(InputDirectives = Directives.InputDirectives || (Directives.InputDirectives = {}));
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var InputDirectives;
            (function (InputDirectives) {
                var Text;
                (function (Text_1) {
                    var TextController = (function () {
                        function TextController() {
                        }
                        TextController.prototype.ValidateEmail = function (value) {
                            var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            return emailPattern.test(value);
                        };
                        return TextController;
                    }());
                    var Text = (function () {
                        function Text() {
                            this.require = ['^form', 'criticalText'];
                            this.scope = {
                                options: '@',
                                bindTo: '=',
                                label: '@',
                                isDisabled:'='
                            };
                            this.controller = 'TextController';
                            this.controllerAs = 'vm';
                            this.bindToController = true;
                            this.restrict = 'E';
                            this.templateUrl = '/wp-content/plugins/lola-registration/js/directives/CriticalText.html';
                            this.compile = function (elem, attrs) {
                                var bindingOptions = eval("(" + attrs.options + ')');
                                var $input = $(elem).find('.form-control');
                                if (bindingOptions.readonly) {
                                    $input.attr('readonly', 'readonly');
                                }
                                else {
                                    var $errorMessagesContainer = $("<div class='help-block'></div>");
                                    $errorMessagesContainer.attr('ng-include', "'/wp-content/plugins/lola-registration/js/directives/ErrorMessage.html'");
                                    $errorMessagesContainer.attr('ng-messages', 'vm.form.' + bindingOptions.name + '.$error');
                                    $errorMessagesContainer.attr('ng-show', 'vm.form.' + bindingOptions.name + '.$touched || vm.form.$submitted');
                                    $(elem).append($errorMessagesContainer);
                                }
                                $input.attr('placeholder', attrs.label);
                                $input.attr('name', bindingOptions.name);
                                $input.addClass(bindingOptions.class);
                                $input.attr('placeholder', bindingOptions.placeholder);
                                $input.attr('ng-required', bindingOptions.required ? 'true' : 'false');
                                switch (bindingOptions.type) {
                                    case InputDirectives.InputType.email:
                                        $input.attr('ui-validate', "{emailValidator:'vm.ValidateEmail($value)'}");
                                        break;
                                    case InputDirectives.InputType.password:
                                        $input.attr('type', "password");
                                        break;
                                    case InputDirectives.InputType.ip:
                                        $input.attr('ip-validator', '');
                                        break;
                                    case InputDirectives.InputType.number:
                                        $input.attr('number-only', '');
                                        break;
                                    case InputDirectives.InputType.phone:
                                        $input.attr('ui-mask', '(999) 999-9999');
                                        $input.attr('ui-mask-placeholder', '');
                                        $input.attr('ui-mask-placeholder-char', '_');
                                        break;
                                    case InputDirectives.InputType.date:
                                        $input.attr('ui-mask', '99-99-9999');
                                        $input.attr('ui-mask-placeholder', '');
                                        $input.attr('ui-mask-placeholder-char', '_');
                                        $input.attr('date-validator', '');
                                        $input.attr('model-view-value', 'true');
                                        break;
                                }
                                return {
                                    pre: function (scope, elems, attrs, ctrls) {
                                        ctrls[1].form = ctrls[0];
                                        ctrls[1].bindingOptions = bindingOptions;
                                    },
                                    post: function (scope, elems, attrs, ctrls) {
                                    }
                                };
                            };
                        }
                        Text.Instance = function () {
                            return new Text();
                        };
                        return Text;
                    }());
                    Text_1.Text = Text;
                    angular.module('critical-module').controller('TextController', TextController);
                    angular.module('critical-module').directive('criticalText', Text.Instance);
                })(Text = InputDirectives.Text || (InputDirectives.Text = {}));
            })(InputDirectives = Directives.InputDirectives || (Directives.InputDirectives = {}));
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var InputDirectives;
            (function (InputDirectives) {
                var Datepicker;
                (function (Datepicker_1) {
                    var DatepickerController = (function () {
                        function DatepickerController() {
                            this.Opened = false;
                        }
                        DatepickerController.prototype.ToggleDatePicker = function () {
                            this.Opened = !this.Opened;
                        };
                        return DatepickerController;
                    }());
                    Datepicker_1.DatepickerController = DatepickerController;
                    var Datepicker = (function () {
                        function Datepicker() {
                            this.scope = {
                                bindTo: '=',
                                options: '@',
                                isDisabled: '='
                            };
                            this.require = ['^form', 'criticalDatepicker'];
                            this.controller = 'DatepickerController';
                            this.controllerAs = 'vm';
                            this.bindToController = true;
                            this.templateUrl = '/wp-content/plugins/lola-registration/js/directives/CriticalDatepicker.html';
                            this.compile = function (templateElem, templateAttrs) {
                                var bindingOptions = eval("(" + templateAttrs.options + ')');
                                $(templateElem).find('.form-control').attr('ng-required', bindingOptions.required ? 'true' : 'false');
                                $(templateElem).find('.help-block').attr('ng-messages', 'vm.form.' + bindingOptions.name + '.$error');
                                $(templateElem).find('.help-block').attr('ng-show', 'vm.form.' + bindingOptions.name + '.$invalid && (vm.form.' + bindingOptions.name + '.$touched || vm.form.$submitted)');
                                if (bindingOptions.isDisabled) {
                                    $(templateElem).find('input').attr('ng-disabled', 'true');
                                }
                                return {
                                    pre: function (scope, elem, attrs, ctrs) {
                                        ctrs[1].form = ctrs[0];
                                        ctrs[1].bindingOptions = bindingOptions;
                                    },
                                    post: function (scope, elem, attrs, ctrs) {
                                    }
                                };
                            };
                        }
                        Datepicker.Instance = function () {
                            return new Datepicker();
                        };
                        return Datepicker;
                    }());
                    Datepicker_1.Datepicker = Datepicker;
                    angular.module('critical-module').directive('criticalDatepicker', Datepicker.Instance);
                    angular.module('critical-module').controller('DatepickerController', DatepickerController);
                })(Datepicker = InputDirectives.Datepicker || (InputDirectives.Datepicker = {}));
            })(InputDirectives = Directives.InputDirectives || (Directives.InputDirectives = {}));
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var InputDirectives;
            (function (InputDirectives) {
                var Checkbox;
                (function (Checkbox_1) {
                    var Checkbox = (function () {
                        function Checkbox() {
                            this.require = ['^form'];
                            this.templateUrl = '/wp-content/plugins/lola-registration/js/directives/CriticalCheckbox.html';
                            this.scope = {
                                bindTo: '=',
                                options: '@'
                            };
                            this.compile = function (templateElem, templateAttrs) {
                                var bindingOptions = eval("(" + templateAttrs.options + ")");
                                $(templateElem).find('.critical-checkbox').attr('ng-required', bindingOptions.required ? 'true' : 'false');
                                $(templateElem).find('.help-block')
                                    .attr('ng-messages', 'form.' + bindingOptions.name + '.$error')
                                    .attr('ng-show', 'form.' + bindingOptions.name + '.$invalid && form.$submitted');
                                return {
                                    pre: function (scope, elem, attrs, formCtrl) {
                                        debugger;
                                        scope.form = formCtrl[0];
                                        scope.bindingOptions = bindingOptions;
                                    },
                                    post: function (scope, elem, attrs) { },
                                };
                            };
                        }
                        Checkbox.Instance = function () {
                            return new Checkbox();
                        };
                        return Checkbox;
                    }());
                    Checkbox_1.Checkbox = Checkbox;
                    angular.module('critical-module').directive('criticalCheckbox', Checkbox.Instance);
                })(Checkbox = InputDirectives.Checkbox || (InputDirectives.Checkbox = {}));
            })(InputDirectives = Directives.InputDirectives || (Directives.InputDirectives = {}));
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
    var CriticalNet;
    (function (CriticalNet) {
        var Directives;
        (function (Directives) {
            var InputDirectives;
            (function (InputDirectives) {
                var FormGroup;
                (function (FormGroup_1) {
                    var FormGroupController = (function () {
                        function FormGroupController() {
                        }
                        FormGroupController.$inject = [];
                        return FormGroupController;
                    }());
                    var FormGroup = (function () {
                        function FormGroup() {
                            this.require = ['^form', 'criticalFormGroup'];
                            this.replace = false;
                            this.scope = {
                                inputOptions: '@',
                                isDisabled: '=',
                                bindTo: '=',
                                label: '@'
                            };
                            this.controller = 'FormGroupController';
                            this.controllerAs = 'vm';
                            this.bindToController = true;
                            this.restrict = 'E';
                            this.templateUrl = '/wp-content/plugins/lola-registration/js/directives/CriticalFormGroup.html';
                            this.compile = function (elem, attrs) {
                                var inputOptions = eval('(' + attrs.inputOptions + ')');
                                var $input = null;
                                switch (inputOptions.type) {
                                    case InputDirectives.InputType.datePicker:
                                        $input = $("<critical-datepicker />").attr('options', attrs.inputOptions).attr('is-disabled', 'vm.isDisabled').attr('bind-to', 'vm.bindTo');
                                        break;
                                    default:
                                        $input = $("<critical-text />").attr('options', attrs.inputOptions).attr('bind-to', 'vm.bindTo').attr('is-disabled', 'vm.isDisabled').attr('label', attrs.label);
                                        break;
                                }
                                $(elem).find('.form-group').attr('ng-class', "{ 'has-error': vm.form." + inputOptions.name + ".$invalid && (vm.form." + inputOptions.name + ".$touched || vm.form.$submitted) }");
                                $(elem).find('.input-container').append($input);
                                return {
                                    pre: function (scope, elems, attrs, ctrls) {
                                        ctrls[1].form = ctrls[0];
                                    },
                                    post: function (scope, elems, attrs, ctrls) {
                                    }
                                };
                            };
                        }
                        FormGroup.Instance = function () {
                            return new FormGroup();
                        };
                        return FormGroup;
                    }());
                    FormGroup_1.FormGroup = FormGroup;
                    angular.module('critical-module').controller('FormGroupController', FormGroupController);
                    angular.module('critical-module').directive('criticalFormGroup', FormGroup.Instance);
                })(FormGroup = InputDirectives.FormGroup || (InputDirectives.FormGroup = {}));
            })(InputDirectives = Directives.InputDirectives || (Directives.InputDirectives = {}));
        })(Directives = CriticalNet.Directives || (CriticalNet.Directives = {}));
    })(CriticalNet || (CriticalNet = {}));
})(jQuery);
