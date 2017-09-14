
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
        	if (this.options.paging && typeof this.options.paging == 'string') {
        		switch(this.options.paging){
        			case 'links':
        				this.setupPagingLinks();
        				break;
        			case 'vertical':
        				this.setupVerticalPaging();
        				break;
        		}
        	}
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
        
        setupVerticalPaging : function()
        {
        	this.$element.css({
        		'height' : '400px',
        		'overflow' : 'auto'
        	});
        	
        	//this.options.query.page++;
        	var lastPage = this.$element.find('#last-in-range a').html();
        	$('#pagination').css('display', 'none');
        	//var height = this.$element[0].scrollHeight - 200;
        	
        	scrollHeight = this.$element[0].scrollHeight;
        	maxScroll = scrollHeight - this.$element.height();
        	
        	console.log('scrollHeight : '+scrollHeight);
        	console.log('maxScroll : '+maxScroll);
        	
        	this.$element.on('scroll', function(e){
        		e.preventDefault();
        		
        		scrollTop = this.$element.scrollTop() + scrollHeight; //offset

        		//if (height == $(e.target).scrollTop()) {
        		if (scrollTop >= maxScroll) {
        			maxScroll = maxScroll + scrollHeight;
        			if(this.options.query.page <= lastPage) {
        				this.options.query.page++;
        				console.log(this.options.query.page);
	        			$.ajax({
	        				url : this.options.url,
	        				data : this.options.query,
	        				type : 'POST'
	        			}).done(function(data){
	        				$('#pagination').css('display', 'none');
	        				var content = $( data ).find( 'tbody tr' );
	      		          	this.tbody.append( content );
	      		          	
	      		          	scrollHeight = this.$element[0].scrollHeight;
	      		          	maxScroll = scrollHeight - this.$element.height();
	      		          	//this.options.query.page++;
	        			}.bind(this));
        			}
        		}
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
    	},
    	paging : 'links'
    };
    
    $.fn.searchForm.Constructor = SearchForm;

})(jQuery);
