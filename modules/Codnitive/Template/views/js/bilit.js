var bilit = {
    defaultTab: 'box-bus',

    init: function()
    {
        bilit.homeSearchTabsListener();
        bilit.changeSortIcon();

        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
            $('.selectpicker').selectpicker('mobile');
        }
    },
    
    loadTabContent: function(tab)
    {
        tab = $(tab);
        var contentWrapper   = $('#' + tab.attr('data-tab-id'));
        if (codnitive.isEmptyElement(contentWrapper)) {
            codnitive.showLoading(contentWrapper, '<i class="fa fa-spinner rotating"></i>در حال دریافت...');
            codnitive.ajax(
                codnitive.getBaseUrl() + tab.attr('data-form')
            );
        }
    },

    homeSearchTabsListener: function ()
    {
        $('.homepage').on('click', '.tab-item', function () {
            // bilit.loadTabContent(this);
            bilit.changeSlide(this);
        });
    },

    changeSlide: function(_this)
    {
        _this = $(_this);
        $('.home_slider_container .slide.active').removeClass('active');
        var id = _this.prop('id');
        var slide = $('#' + id.replace('box', 'slide'));
        // slide.css('background-image', 'url(/media/images/insurance-slide.jpg)');
        slide.addClass('active');
        
        // change colors
        var home = $('.homepage');
        var currentColor = home.attr('data-current-color');
        var newColor = _this.attr('data-color');
        home.removeClass(currentColor)
            .addClass(newColor)
            .attr('data-current-color', newColor);

        // change about
        $('.homepage .about .active').removeClass('active');
        $('#' + id.replace('box', 'about')).addClass('active');
    },

    changeSortIcon: function ()
    {
        $(document).on('click', '.sort-btn', function () {
            var btn = $(this);
            var icon = btn.find('.fa');
            btn.parents('.sorting.bar').find('.sort-btn.active').removeClass('active');
            btn.addClass('active');
            if (icon.hasClass('fa-sort-amount-down')) {
                icon.removeClass('fa-sort-amount-down');
                icon.addClass('fa-sort-amount-up');
            }
            else if (icon.hasClass('fa-sort-amount-up')) {
                icon.removeClass('fa-sort-amount-up');
                icon.addClass('fa-sort-amount-down');
            }
        });
    },

    updateSearchResultCount: function (count)
    {
        $('.search-result-count').html(count);
    }
}

$(document).ready(function() {
    bilit.init();
    /*if ($('#box-bus').length) {
        bilit.loadTabContent($('#box-bus'));
        $('.homepage').addClass('pink');
        $('.homepage').attr('data-current-color', 'pink');
    }*/
    var tab = codnitive.getUrlParam('tab');
    if (undefined == tab) {
        tab = bilit.defaultTab;
    }
    $('#' + tab).trigger('click');
});
