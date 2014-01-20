if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.fileuploader = {
    
    conf: {
        uploadUrl: '',
        csrf: ''
    },
    
    init: function(conf){
        $.extend(this.conf, conf);
        var area = $('#uploadArea');
        area.on('dragenter', function(e){
            e.stopPropagation();
            e.preventDefault();
            $(this).addClass('upload-area-dragenter');
        });
        area.on('dragover', function(e){
            e.stopPropagation();
            e.preventDefault();
        });
        area.on('drop', function(e){
            $(this).removeClass('upload-area-dragenter').removeClass('upload-area-dragover').addClass('upload-area-drop');
            e.preventDefault();
            var files = e.originalEvent.dataTransfer.files;
            $.monstra.fileuploader.uploadFileHandle(files, area);
        });
        $(document).on('dragover', function(e){
            e.stopPropagation();
            e.preventDefault();
            area.removeClass('upload-area-dragenter').removeClass('upload-area-drop').addClass('upload-area-dragover');
        });
        $(document).on('dragenter', function(e){
            e.stopPropagation();
            e.preventDefault();
        });
        $(document).on('drop', function(e){
            e.stopPropagation();
            e.preventDefault();
        });
    },
    
    uploadFileHandle: function(files, area){
        for (var i = 0; i < files.length; i++){
            var fd = new FormData();
            fd.append('file', files[i]);
            fd.append('upload_file', 'upload_file');
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
                location.href = $.monstra.fileuploader.conf.uploadUrl;
                /*$('#fuProgress').fadeOut('slow', function(){
                    $('#fuProgress').css({width: 0, display: 'block'});
                    $('#fuPlaceholder').show();
                });*/
            }
        });
    },
    
    setProgress: function(progress){
        if (parseInt(progress) > 0) {
            $('#fuPlaceholder').hide();
        }
        var progressBarWidth = progress * $('#uploadArea').width() / 100;  
        $('#fuProgress').animate({ width: progressBarWidth }, 10);
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
        
        $('#fileInfo').html(fname +' '+ sizeStr);
    }
};

$(document).ready(function(){
    $val_fUploaderInit = $('#fUploaderInit').val();
    if ($val_fUploaderInit !== undefined) {
        $.monstra.fileuploader.init($.parseJSON($val_fUploaderInit));
    }
});

