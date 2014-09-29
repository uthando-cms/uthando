
(function($){
	
	var SearchForm = function (element, options) {
	    this.$element = $(element);
	    this.id = this.$element.attr('id');
	    this.options = options;
	    this.init();
	    
	    if (this.options.searchForm) {
    		this.options.searchForm.submit(function(e){
    			e.preventDefault();
    			this.search(e);
    		}.bind(this));
    		
    		this.setSearchParams(this.options.searchForm);
    	}
	};

	SearchForm.prototype = {
        init : function()
        {
        	this.setupPagingLinks();
        },
        
        setSearchParams : function(searchForm)
        {
        	data = {};
	    	params = $(searchForm).serializeArray();
	    	
        	for(var i=0; i<params.length; i++) {
        		data[params[i].name] = params[i].value;
        	}
        	
        	$.extend(this.options.query, data);
        },
        
        search : function(search)
        {
        	this.options.query.page = 1;
        	this.setSearchParams(search.target);
        	
        	this.ajaxCall();
        	
        	return false;
        },
        
        setupPagingLinks : function()
        {
        	pagingLinks = $('#pagination-links');
        	
        	pagingLinks.on('click', 'a', function(e){
        		e.preventDefault();
        		href = $(e.target).attr('href');
        		this.options.query.page = href.split('/page/')[1];
        		this.ajaxCall();
        	}.bind(this));
        },
        
        ajaxCall : function(data)
        {
        	this.$element.load(this.options.url, this.options.query,
        		function (responseText, textStatus, req) {
        			//if (this.options.searchForm) this.options.searchForm.unbind('submit');
                    if (textStatus == "error") {
                        this.$element.html(responseText);
                    } else {
                    	this.init();
                    	$('html, body').animate({
                            scrollTop: $("body").offset().top
                        }, 1000);
                    }
            }.bind(this));
        }
    };
    
    $.fn.searchForm = function (option) {
    	var $this = $(this);
        var data = $this.data('searchForm');
        var options = $.extend(true, {}, $.fn.searchForm.defaults, typeof option == 'object' && option);
    	if (!data) $this.data('searchForm', (data = new SearchForm(this, options)));
    	return this;
    };
    
    $.fn.searchForm.defaults = {
    	url : '',
    	searchForm : null,
    	query: {
        	count : 25,
        	page : 1
    	}
    };
    
    $.fn.searchForm.Constructor = SearchForm;

})(jQuery);
