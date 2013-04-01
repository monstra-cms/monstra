if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.filesmanager = {

    init: function() { 
        this.showImage();
    },

    showImage: function() {
        $('.image').find('a').on('click', function() {
            $('#previewLightbox').lightbox('show').find('img').attr('src', $(this).attr('rel'));
        });
    }
};

$(document).ready(function(){
    $.monstra.filesmanager.init();
});