if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.blocks = {

    init: function() { },

    embedCodes: function(name) {
        $('#shortcode').html('{block get="'+name+'"}');
        $('#phpcode').html('&lt;?php echo Block::get("'+name+'"); ?&gt;');
        $('#embedCodes').modal();
    }

};


$(document).ready(function(){
    $.monstra.blocks.init();
});