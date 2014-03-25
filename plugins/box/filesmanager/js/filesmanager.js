if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.filesmanager = {

	init: function(){
		$('#filesDirsList').on('click', '.js-rename-dir', function(e){
			$.monstra.filesmanager.showRenameDialog(
				'dir',
				$(e.currentTarget).attr('data-dirname'),
				$(e.currentTarget).attr('data-path')
			);
		});
		$('#filesDirsList').on('click', '.js-rename-file', function(e){
			$.monstra.filesmanager.showRenameDialog(
				'file',
				$(e.currentTarget).attr('data-filename'),
				$(e.currentTarget).attr('data-path')
			);
		});
        $('#filesDirsList').on('click', '.js-file-info', function(e, el){
            $.monstra.filesmanager.showInfoDialog(e.currentTarget);
        });
	},

	showRenameDialog: function(type, renameFrom, path){
		var dialog = $('#renameDialog');
		dialog.find('input[name="rename_type"]').val(type);
		dialog.find('input[name="rename_from"]').val(renameFrom);
		dialog.find('input[name="path"]').val(path);
		dialog.find('#renameToHolder').text(renameFrom);
		dialog.find('[id$="RenameType"]').hide();
		dialog.find('#'+ type +'RenameType').show();
		dialog.modal('show');
	},

    showInfoDialog: function(btnEl){
        var dialog = $('#fileInfoDialog');
        dialog.find('.js-dimension-blck').hide();
        dialog.find('.js-filename').html($(btnEl).attr('data-filename'));
        dialog.find('.js-filetype').html($(btnEl).attr('data-filetype'));
        dialog.find('.js-filesize').html($(btnEl).attr('data-filesize'));
        dialog.find('.js-link').html($(btnEl).attr('data-link'));
        var dimension = $(btnEl).attr('data-dimension').trim();
        if (dimension) {
            dialog.find('.js-dimension').html(dimension);
            dialog.find('.js-dimension-blck').show();
        }
        dialog.modal('show');
    }
};

$(document).ready(function(){
	$.monstra.filesmanager.init();
});