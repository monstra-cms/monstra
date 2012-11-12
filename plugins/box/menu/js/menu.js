if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.menu = {

    init: function() { },

    selectPage: function (slug, title) {
        $('input[name=menu_item_link]').val(slug);
        $('input[name=menu_item_name]').val(title);
        $('#selectPageModal').modal('hide');
    },

    selectCategory: function (name) {
        $('input[name=menu_item_category]').val(name);
        $('#selectCategoryModal').modal('hide');
    }

};


$(document).ready(function(){
    $.monstra.menu.init();
});