(function ($) {
    $.fn.lrPopup = function (opts) {
        var options = {
            onClose: function () { },
            onOpen: function () { }
        };
        $.extend(options, opts);
        var me = $(this);
        var $popupContentBody = me.find(".body-content");
        var $popupControlBar = me.find(".lr-popup-action-bar");

        var instance = {
            show: function ($content, buttons) {
                $popupContentBody.html($content);
                $(buttons).each(function (index, el) {
                    $popupControlBar.empty();
                    $popupControlBar.append(el);
                });
                me.show();
                options.onOpen();
            },
            hide: function () {
                me.hide();
                options.onClose();
            }
        };

        me.on("click", ".lr-popup-close-btn, .lr-popup-close", function () {
            instance.hide();
        });

        return instance;
    };
})(jQuery);