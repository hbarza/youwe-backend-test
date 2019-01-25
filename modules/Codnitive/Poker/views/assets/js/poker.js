codnitive.poker = function() 
{
    this._init = function()
    {
        this.selectCardListener();
    };

    this.selectCardListener = function()
    {
        var game = this;
        $('.card.back').on('click', function () {
            game.play(this)
        });
    };

    this.play = function(card)
    {
        card = $(card);
        $.ajax({
            method: 'GET',
            url: codnitive.baseUrl + '/poker/ajax/checkPlay',
            data: {"key": card.attr('data-key')}
        })
        .done(function (response) {
            response = $.parseJSON(response);
            console.log(response);
            return;
            var block;
            // console.log(response);
            for (var key in response) {
                if (response.hasOwnProperty(key)) {
                    block = response[key];
                    codnitive.addElement(block.element, block.type, block.content);
                }
            }
            // codnitive.addElement(response.element, response.type, response.content);
        })
        .fail(function (response) {
            console.log(response);
        });
        return this;
    };
}
