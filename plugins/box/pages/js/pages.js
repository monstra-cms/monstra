if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.pages = {

    init: function() { 
        this.pagesExpandProcess();
    },

    pageExpand: function(slug, expand, token) {
        $.ajax({
            type:"post",        
            data:"page_slug="+slug+"&page_expand="+expand+"&token="+token,
            url: $('form input[name="url"]').val()
        });
    },

    pagesExpandProcess: function() {
        $(".parent").click(function() {
            if ($(this).html() == "-") {
                $('[rel="children_' + $(this).attr('rel')+'"]').hide();                                
                $(this).html("+");
                $.monstra.pages.pageExpand($(this).attr("rel"), "1", $(this).attr("token"));
            } else {
                $('[rel="children_' + $(this).attr('rel')+'"]').show();
                $(this).html("-");
                $.monstra.pages.pageExpand($(this).attr("rel"), "0", $(this).attr("token"));
            }
        });
    }

};


$(document).ready(function(){
    $.monstra.pages.init();
});