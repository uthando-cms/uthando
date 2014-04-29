
(function($){
	
	var DataGrid = function (element, options) {
	    this.$element = $(element);
	    this.id = this.$element.attr('id');
	    this.options = options;
	    if (this.options.searchForm) {
    		this.options.searchForm.submit(function(e){
    			e.preventDefault();
    			this.search(e);
    		}.bind(this));
    	}
	    this.init();
	};

	DataGrid.prototype = {
        init : function(){
        	this.thead = $('#'+this.id+' table thead tr:first-child');
        	this.tbody = $('#'+this.id+' table tbody');
        	
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
        	
        	if (this.options.columnSort) {
        		this.sortDirection = (this.options.query.sort.substring(0, 1) == '-') ? 'down' : 'up';
            	this.activeColumn = this.thead.find('th[data-field='+this.options.query.sort.replace('-', '')+']');
            	
            	if (this.sortDirection == 'up') {
            		this.activeColumn.prepend(this.options.arrowUp);
            	} else {
            		this.activeColumn.prepend(this.options.arrowDown);
            	}
        		this.setupColumnSort();
        	}
        	
        	if (this.options.rowClick){
        		this.rowClick();
        	}
        },
        
        setupColumnSort : function() {
            this.thead.on('click', 'th', function(e){
            	this.options.query.page = 1;
            	var cell = $(e.target);
                var sortDirection = cell.attr('data-field');
                
                if (cell[0] == this.activeColumn[0]) {
                	if (this.sortDirection == 'up') {
                		sortDirection = '-'+sortDirection;
                	} else {
                		sortDirection.replace('-', '');
                	}
                }
                
                $.extend(this.options.query, { sort : sortDirection });
                
                this.ajaxCall();
            }.bind(this));
        },
        
        rowClick : function() {
            this.tbody.on('click', 'tr', this.options.rowClick);
        },
        
        search : function(search)
        {
            this.options.query.page = 1;
        	id = $(search.target).attr('id');
        	params = $(search.target).serializeArray();
        	
        	data = {};
        	
        	for(var i=0; i<params.length; i++){
        		data[params[i].name] = params[i].value;
        	}
        	
        	$.extend(this.options.query, data);
        	
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
    
    $.fn.dataGrid = function (option) {
    	var $this = $(this);
        var data = $this.data('dataGrid');
        var options = $.extend(true, {}, $.fn.dataGrid.defaults, typeof option == 'object' && option);
    	if (!data) $this.data('dataGrid', (data = new DataGrid(this, options)));
    	return this;
    };
    
    $.fn.dataGrid.defaults = {
    	url : '',
    	searchForm : null,
    	arrowUp: '<i class="icon-arrow-up">&nbsp;</i>',
    	arrowDown : '<i class="icon-arrow-down">&nbsp;</i>',
    	query: {
    		sort : '',
        	count : 25,
        	offset : 0,
        	page : 1
    	},
    	paging : 'links',
    	rowClick : null,
    	columnSort : false
    };
    
    $.fn.dataGrid.Constructor = DataGrid;

})(jQuery);
