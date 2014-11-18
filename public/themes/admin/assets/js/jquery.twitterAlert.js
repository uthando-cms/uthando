
(function($){
    "use strict";

    var TwitterAlert = function(el, options)
    {
        this.el = (el) ? $(el) : $(options.target);
        this.options = options;
        this.init;
    };

    TwitterAlert.prototype = {
        init : function()
        {
            this.el.append(
                '<div class="alert alert-' + this.options.type + '">' +
                '<button type="button" class="close" data-dismiss="alert">' +
                '&times;</button>' + this.options.message + '</div>'
            );
        }
    };

    $.fn.twitterAlert = function(option)
    {
        var $this = $(this);
        var data = $this.data('twitterAlert');
        var options = $.extend(true, {}, $.fn.twitterAlert.defaults, typeof option == 'object' && option);
        if (!data) $this.data('twitterAlert', (data = new TwitterAlert(this, options)));
        return this;
    };

    $.fn.defaults = {
        target : '#alerts',
        type : 'info',
        message : ''
    };

    $.fn.twitterAlert.Constructor = TwitterAlert;
})(jQuery);