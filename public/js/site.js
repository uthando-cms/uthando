
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