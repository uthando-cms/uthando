
$(document).ready(function(){

    admin.widgetPanelLoad(
        $('#current-orders .panel-widget'),
        '/admin/shop/order/current-orders',
        null
    );

    $('#current-orders .panel-widget').on('change', 'select', function(){
        var orderNumber = $(this).parent().prev().text();
        var orderStatusId = this.value;
        $.ajax({
            url : '/admin/shop/order/update-status',
            data : {
                'orderStatusId' : orderStatusId,
                'orderNumber' : orderNumber
            },
            type : 'POST',
            success : function(json) {
                if (json.html) {
                    $('#current-orders .panel-widget').html(json.html);
                } else {
                    admin.addAlert('Failed to update order status due to database error', 'danger');
                }
            },
            error : function(response) {
                admin.addAlert(response.responseText, 'danger');
            }
        });
    });
});

