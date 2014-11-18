
(function($){
    "use strict";

    var AjaxModalForm = function(el, options)
    {
        this.el = $(el);
        this.options = options;
        this.init;
    };

    AjaxModalForm.prototype = {
        init : function()
        {
            $.ajax({
                url : this.options.url,
                data : this.el.find('form').serialize(),
                type : 'POST',
                success : this.success,
                error : this.error
            });
        },

        success : function(response)
        {
            if ($.isPlainObject(response)) {
                this.alert(response.status, response.messages);
                this.el.modal('hide');
                return;
            } else {
                this.el.find('.modal-body').html(response);
            }
        },

        error : function(response)
        {
            this.alert('danger',response);
            this.el.modal('hide');
        },

        alert : function(type, message)
        {
            new TwitterAlert({
                type : type,
                message : message
            });
        }
    };

    $.fn.ajaxModalForm = function(option)
    {
        var $this = $(this);
        var data = $this.data('ajaxModalForm');
        var options = $.extend(true, {}, $.fn.ajaxModalForm.defaults, typeof option == 'object' && option);
        if (!data) $this.data('ajaxModalForm', (data = new AjaxModalForm(this, options)));
        return this;
    };

    $.fn.defaults = {
        url : ''
    };

    $.fn.ajaxModalForm.Constructor = AjaxModalForm;
})(jQuery);