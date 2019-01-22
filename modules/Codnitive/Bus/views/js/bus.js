var bus = 
{
    init: function ()
    {
        bus.getOrigins();
        bus.getDestinations();
        bus.saveCityName();
        bus.getBus();
    },

    saveCityName: function ()
    {
        $('.bilit-serach-box').on('change', '#bus-origin', function() {
            $('#bus-origin_name').val($('#bus-origin option:selected').text()).trigger('change');
        });
        $('.bilit-serach-box').on('change', '#bus-destination', function() {
            $('#bus-destination_name').val($('#bus-destination option:selected').text()).trigger('change');
        });
    },

    search: function ()
    {
        codnitive.ajax(codnitive.getBaseUrl() + 'bus/ajax/searchResult');
    },

    reserveTicket: function ()
    {
        codnitive.ajax(codnitive.getBaseUrl() + 'bus/ajax/reserveTicket');
    },

    getOrigins: function ()
    {
        $('.bilit-serach-box').on('click', '.tab-bus .field-bus-origin .btn', function () {
            codnitive.ajax(codnitive.getBaseUrl() + 'bus/ajax/getOrigins');
        });
    },

    getDestinations: function ()
    {
        // $('.bilit-serach-box').on('change', '#bus-origin', function () {
        $('.bilit-serach-box').on('change', '#bus-origin_name', function () {
            $params = {origin: $('#bus-origin').val(), origin_name: $(this).val()};
            codnitive.ajax(codnitive.getBaseUrl() + 'bus/ajax/getDestinations', $params);
        });
    },

    getBus: function ()
    {
        $('.buses-list').on('click', '.viewseatbtn', function () {
            var btn = $(this);
            if (btn.hasClass('disabled')) {
                return false;
            }
            // if (codnitive.isEmptyElement(btn.parents('.box-bus-item').children('.bus-seat-map'))) {
                // $('.bus-seat-map').hide();
                var loading = '<div class="message text-center p-5"><i class="fa fa-spinner rotating ml-1"></i>در حال دریافت...</div>';
                $('.bus-seat-map').html('');
                btn.parents('.bus-item').children('.bus-seat-map').html(loading);
                codnitive.ajax($(this).prop('href'), null, 'GET');
                busSearchResultListSort.isotope();
                $('.bus-seat-map').show();
            // }
            return false;
        });
    }
}

$(document).ready(function () {
    bus.init();
});
