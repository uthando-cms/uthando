
var admin = {
	dataTable : {
		rowClick : function(e){
			var trId = $(this).find('td:first-child').text();
	        var title = $(this).find('td.tab-title').text();
	        title = (title) ? title : 'User';
	        
	        
	        if ($('#user'+trId).length) {
	            $('#userTabs a[href=#user'+trId+']').tab('show');
	        } else {
	            $('#userTabs')
	            .append('<li><a href="#user'+trId+'">'+title+'&nbsp;<em class="close">&times;</em></a></li>');
	            $('#userTabContent')
	            .append('<div class="tab-pane" id="user'+trId+'">Loading...</div>');
	            
	            $('#user'+trId).load('user/edit', {userId : trId},
	                function (responseText, textStatus, req) {
	                    
	                    if (textStatus == "error") {
	                        $('#user'+trId).html(responseText);
	                    }
	            });
	        
	            $('#userTabs a[href=#user'+trId+']').tab('show');
	        }
		}
	},
	
	tabs : {},
	
	setupTabs : function(id) {
		$('#'+id).on('click', 'a', function(e) {
        	e.preventDefault();
        	$(this).tab('show');
    	});
    
    	$(id+' a:first').tab('show');
    	this.tabs[id] = $('#'+id+' a:first');
    
    	$(id).on('click', '.close', function(e){ 
    		$($(this).parent().attr('href')).remove();
    		$(this).parent().parent().remove();
    		this.tabs[id]('show');
    	});
	},

    widgetPanelLoad : function($element, url, query) {
        $element.load(url, query, function (responseText, textStatus, req) {
            if (textStatus == "error") {
                $element.css('padding', '10px');
                $element.html(responseText);
            }
        });
    },

    addAlert : function(message, type) {
        $('#alerts').append(
            '<div class="alert alert-' + type + '">' +
            '<button type="button" class="close" data-dismiss="alert">' +
            '&times;</button>' + message + '</div>'
        );
    }
};

$(document).ready(function(){

    $(document).on({
        ajaxStart: function() { 
            $('body').addClass("loading"); 
        },
        ajaxStop: function() {
        	$('button[type=submit]').button('reset');
            $('body').removeClass("loading");
        }    
    });
    
    $('button[type=submit]').click(function(){
        $(this).button('loading');
        $('input').focus(function(){
        	$(this).button('reset');
        }.bind(this));
    });
    
    $('#showPassword').click(function(){
		var change = $(this).is(":checked") ? "text" : "password";
		document.getElementById('password').type = change;
	});
});
