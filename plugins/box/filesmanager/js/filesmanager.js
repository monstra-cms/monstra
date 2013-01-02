if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.filesmanager = {

    init: function() { 
        this.showImage();
    },

    showImage: function() {
        $('.image').find('a').on('click', function() {
            var src = $(this).attr('href');
            var file = $(src.split('/')).last();
            var image = new Image();
            image.src = src;
            $(image).load(function() {
                $('#showImage')
                    .modal('show')
                    .css({"min-width": 632})
                    .find('img')
                    .attr('src', src);
                $('#showImage').find('h3 span').text(file[0]);
                $('#showImage').find('img').css({"max-width": 600});
                $('#showImage').find('img').attr('alt', file[0]);
            });
            return false;
        });
    }
};

$(document).ready(function(){
    $.monstra.filesmanager.init();
});