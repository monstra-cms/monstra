(function($) {
    $.fn.confirmModal = function(opts)
    {
        var body = $('body');
        var defaultOptions    = {
            confirmTitle     : 'Please confirm',
            confirmMessage   : 'Are you sure you want to perform this action ?',
            confirmOk        : 'Yes',
            confirmCancel    : 'Cancel',
            confirmDirection : 'rtl',
            confirmStyle     : 'primary',
            confirmCallback  : defaultCallback
        };
        var options = $.extend(defaultOptions, opts);
        var time    = Date.now();

        var headModalTemplate =
            '<div class="modal fade" id="#modalId#">' +
              '<div class="modal-dialog">' +
                '<div class="modal-content">' +
                    '<div class="modal-header">' +
                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                        '<h4 class="modal-title">#Heading#</h4>' +
                    '</div>' +
                    '<div class="modal-body">' +
                        '#Body#' +
                    '</div>' +
                    '<div class="modal-footer">' +
                        '#buttonTemplate#' +
                    '</div>' +
                '</div>' +
              '</div>' +
            '</div>'
            ;

        return this.each(function(index)
        {
            var confirmLink = $(this);
            var targetData  = confirmLink.data();

            var currentOptions = $.extend(options, targetData);

            var modalId = "confirmModal" + parseInt(time + index);
            var modalTemplate = headModalTemplate;
            var buttonTemplate =
                '<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">#Cancel#</button>' +
                '<button class="btn btn-#Style#" data-dismiss="ok" data-href="' + confirmLink.attr('href') + '">#Ok#</button>'
            ;

            if(options.confirmDirection == 'ltr')
            {
                buttonTemplate =
                    '<button class="btn btn-#Style#" data-dismiss="ok" data-href="' + confirmLink.attr('href') + '">#Ok#</button>' +
                    '<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">#Cancel#</button>'
                ;
            }

            modalTemplate = modalTemplate.
                replace('#buttonTemplate#', buttonTemplate).
                replace('#modalId#', modalId).
                replace('#AriaLabel#', options.confirmTitle).
                replace('#Heading#', options.confirmTitle).
                replace('#Body#', options.confirmMessage).
                replace('#Ok#', options.confirmOk).
                replace('#Cancel#', options.confirmCancel).
                replace('#Style#', options.confirmStyle)
            ;

            body.append(modalTemplate);

            var confirmModal = $('#' + modalId);

            confirmLink.on('click', function(modalEvent)
            {
                modalEvent.preventDefault();
                confirmModal.modal('show');

                $('button[data-dismiss="ok"]', confirmModal).on('click', function(event) {
                    confirmModal.modal('hide');
                    options.confirmCallback(confirmLink);
                });
            });
        });

        function defaultCallback(target)
        {
            window.location = $(target).attr('href');
        }
    };
})(jQuery);