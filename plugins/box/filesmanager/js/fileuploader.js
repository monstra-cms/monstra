if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.fileuploader = {
    
    conf: {
        uploadUrl: '',
        csrf: '',
		errorMsg: '',
        uploaderId: ''
    },

    _uploaderObj: null,

    init: function(conf){
        if (!conf.uploaderId) {
            throw 'uploaderId not specified';
        }
        $.extend(this.conf, conf);
        this._uploaderObj = $('#'+ this.conf.uploaderId);
        var area = this._uploaderObj.find('.upload-area');
        area.off('dragenter.fuploader').on('dragenter.fuploader', function(e){
            e.stopPropagation();
            e.preventDefault();
            $(this).addClass('upload-area-dragenter');
        });
        area.off('dragover.fuploader').on('dragover.fuploader', function(e){
            e.stopPropagation();
            e.preventDefault();
        });
        area.off('drop.fuploader').on('drop.fuploader', function(e){
            $(this).removeClass('upload-area-dragenter').removeClass('upload-area-dragover').addClass('upload-area-drop');
            e.preventDefault();
            var files = e.originalEvent.dataTransfer.files;
            $.monstra.fileuploader.uploadFileHandle(files, area);
        });
        $(document).off('dragover.fuploader').on('dragover.fuploader', function(e){
            e.stopPropagation();
            e.preventDefault();
            area.removeClass('upload-area-dragenter').removeClass('upload-area-drop').addClass('upload-area-dragover');
        });
        $(document).off('dragenter.fuploader').on('dragenter.fuploader', function(e){
            e.stopPropagation();
            e.preventDefault();
        });
        $(document).off('drop.fuploader').on('drop.fuploader', function(e){
            e.stopPropagation();
            e.preventDefault();
        });
    },
    
    uploadFileHandle: function(files, area){
        for (var i = 0; i < files.length; i++){
            var fd = new FormData();
            fd.append('file', files[i]);
            fd.append('upload_file', 'upload_file');
			fd.append('dragndrop', '1');
            fd.append('csrf', $.monstra.fileuploader.conf.csrf);
            //this.setFileNameSize(files[i].name, files[i].size);
            
            this.uploadFile(fd, status);
        }
    },
    
    uploadFile: function(formData, status){
        var jqXHR = $.ajax({
            url: $.monstra.fileuploader.conf.uploadUrl,
            type: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            xhr: function() {
                var xhrobj = $.ajaxSettings.xhr();
                if (xhrobj.upload) {
                    xhrobj.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        $.monstra.fileuploader.setProgress(percent);
                    }, false);
                }
                return xhrobj;
            },
            success: function(data){
                $.monstra.fileuploader.setProgress(100);
                $.event.trigger('uploaded.fuploader');
            },
			error: function(){
				Messenger().post({
					type: 'error',
					message : $.monstra.fileuploader.conf.errorMsg,
					hideAfter: 3
				});
                this._uploaderObj.find('.upload-progress').animate({ width: 0 }, 1);
                this._uploaderObj.find('.upload-file-pholder').show();
			}
        });
    },
    
    setProgress: function(progress){
        if (parseInt(progress) > 0) {
            this._uploaderObj.find('.upload-file-pholder').hide();
        }
        var progressBarWidth = progress * this._uploaderObj.find('.upload-area').width() / 100;
        this._uploaderObj.find('.upload-progress').animate({ width: progressBarWidth }, 10);
    },
    
    setFileNameSize: function(fname, fsize){
        var sizeStr = '';
        var sizeKB = fsize / 1024;
        if(parseInt(sizeKB) > 1024){
            var sizeMB = sizeKB/1024;
            sizeStr = sizeMB.toFixed(2)+' MB';
        } else {
            sizeStr = sizeKB.toFixed(2)+' KB';
        }
        
        this._uploaderObj.find('.upload-file-info').html(fname +' '+ sizeStr);
    }
};
