
(function($) {

    "use strict";

    var AjaxWidgetPanel = function(el, options)
    {
        this.el = $(el);
        this.options = options;
        this.init();
    };

    AjaxWidgetPanel.prototype = {
        init : function()
        {
            this.el.load(this.options.url, this.options.data, function(responseText, textStatus) {
                if (textStatus == "error") {
                    this.el.css('padding', '10px');
                    this.el.html(responseText);
                }
            });
        }
    };

    $.fn.ajaxWidgetPanel = function(option)
    {
        var $this = $(this);
        var data = $this.data('ajaxWidgetPanel');
        var options = $.extend(true, {}, $.fn.ajaxWidgetPanel.defaults, typeof option == 'object' && option);
        if (!data) $this.data('ajaxWidgetPanel', (data = new AjaxWidgetPanel(this, options)));
        return this;
    };

    $.fn.defaults = {
        url : '',
        data : {}
    };

    $.fn.ajaxWidgetPanel.Constructor = AjaxWidgetPanel;

})(jQuery);
