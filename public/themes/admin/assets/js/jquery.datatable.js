
(function($){
	
	var DataGrid = function (element, options)
    {
	    this.$element = $(element);
	    this.id = this.$element.attr('id');
	    this.options = options;
	    if (this.options.searchForm) {
    		this.options.searchForm.submit(function(e){
    			e.preventDefault();
    			this.getFormData();
				this.ajaxCall();
    		}.bind(this));
    	}
	    this.init();
	};

	DataGrid.prototype = {
        init : function()
        {
        	this.thead = $('#'+this.id+' table thead tr:first-child');
        	this.tbody = $('#'+this.id+' table tbody');

            this.setupPagingLinks();
        	
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
        
        setupColumnSort : function()
        {
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
        
        rowClick : function()
        {
            this.tbody.on('click', 'tr', this.options.rowClick);
        },

		getFormData : function()
		{
			search = this.options.searchForm;

			this.options.query.page = 1;
			id = $(search).attr('id');
			params = $(search).serializeArray();

			data = {};

			for(var i=0; i<params.length; i++){
				data[params[i].name] = params[i].value;
			}

			$.extend(this.options.query, data);

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
        
        ajaxCall : function()
        {
			this.getFormData();

            $.ajax({
                url : this.options.url,
                data : this.options.query,
                type : 'POST',
                beforeSend : function() {
                    this.$element.loadingOverlay();
                }.bind(this),
                success : function(responseText) {
                    this.$element.html(responseText);
                }.bind(this),
                error : function(response) {
                    admin.addAlert(response.responseText, 'danger');
                }.bind(this),
                complete : function() {
                    this.init();
                    $('button[type=submit]').button('reset');
                    $('html, body').animate({
                        scrollTop: $("body").offset().top
                    }, 1000);
                    this.$element.loadingOverlay('remove');
                }.bind(this)
            });
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
    	arrowUp: '<i class="glyphicon glyphicon-arrow-up">&nbsp;</i>',
    	arrowDown : '<i class="glyphicon glyphicon-arrow-down">&nbsp;</i>',
    	query: {
    		sort : '',
        	count : 25,
        	offset : 0,
        	page : 1
    	},
    	rowClick : null,
    	columnSort : false
    };
    
    $.fn.dataGrid.Constructor = DataGrid;

})(jQuery);
