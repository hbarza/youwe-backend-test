var account = {
    init: function()
    {
        this.viewOrderListener();
    },

    viewOrderListener: function() 
    {
        $('table').on('click', '.view-order-details', function () {
            var row = $(this).parents('tr');
            var orderId = row.attr('data-key');
            var newRowId = 'order_details_'+orderId;
            if ($('#'+newRowId).length) {
                $('#'+newRowId).toggle();
                return
            }

            $.ajax({
                method: 'POST',
                url: codnitive.getBaseUrl() + 'account/sales/getOrderDetails?id='+orderId,
            })
            .done(function (response) {
                response = $.parseJSON(response);
                var block = '';
                for (var key in response) {
                    if (response.hasOwnProperty(key)) {
                        block += response[key];
                    }
                }
                account.addTableRow('tr[data-key='+orderId+']', block, newRowId);
            })
            .fail(function (response) {
                console.log(response.status + ': ' + response.statusText);
            });
        })
    },

    addTableRow: function(after, content, trId)
    {
        var row  = $(document.createElement('tr')).attr({id: trId, class: 'bg-white'});
        var cell = $(document.createElement('td')).attr({colspan: 9})
        cell.html(content).appendTo(row);
        $(after).after(row);
    },
}

$(document).ready(function() {
    codnitive.changePerPage();
    account.init();
});
