if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.plugins = {

    init: function(){
        if (window.location.hash && $('a[href="'+ window.location.hash +'"]')) {
            $('a[href="'+ window.location.hash +'"]').click();
        }
    }

};

$(document).ready(function(){
    $.monstra.plugins.init();
});