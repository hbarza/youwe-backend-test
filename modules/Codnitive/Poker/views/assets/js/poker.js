codnitive.poker = function() 
{
    this._init = function()
    {
        this.selectCardListener();
    };

    this.selectCardListener = function()
    {
        var game = this;
        $('.poker-chance.play').on('click', '.card.back:not(.disabled)', function () {
            game.play(this)
        });
    };

    this.play = function(card)
    {
        var poker = this;
        card = $(card);
        card.removeClass('back');
        card.addClass('disabled');

        $.ajax({
            method: 'GET',
            url: codnitive.baseUrl + '/poker/ajax/checkPlay',
            data: {"key": card.attr('data-key')}
        })
        .done(function (response) {
            response = $.parseJSON(response);
            if (response.status == true) {
                card.html(response.selected_card);
                poker.showModal(response)
                return;
            }
            else if (response.status == false && response.message != '') {
                alert(response.message);
                return;
            }
            card.html(response.selected_card);
            poker.updateGameInfo(response, '.poker-chance.play');
        })
        .fail(function (response) {
            console.log(response);
        });
        return this;
    };

    this.showModal = function (response)
    {
        this.updateGameInfo(response, '#poker_modal_box');
        $('#poker_modal_box .modal-body .message-wrapper').html(response.message);
        $('#poker_modal_box .modal-body .card').html(response.selected_card);
        $('#poker_modal_box').modal();
        return this;
    };

    this.updateGameInfo = function (response, wrapper)
    {
        var percentage = response.chance+'%';
        $(wrapper + ' .progress-value').html('('+percentage+')');
        $(wrapper + ' .progress-bar').attr('aria-valuenow', response.chance);
        $(wrapper + ' .progress-bar').css('width', percentage);
        $(wrapper + ' .score i').removeClass('text-primary');
        for($i = 1; $i <= response.score; $i++) {
            $(wrapper + ' .score i.star-'+$i).addClass('text-primary');
        }
        return this;
    };
}
