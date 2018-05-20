$(document).ready(function () {

    $(document).on('click', ".remove-item", function (e) {
        e.preventDefault();
        var $rowToHide = $(this).closest('.line-item');
        var route = $(this).attr('href');

        bootbox.dialog({
            title: '<i class="fa fa-exclamation-triangle" style="color: brown"></i> Confirmation',
            message: 'Etez-vous sûre de supprimer ceci ?',
            className: 'my-class',
            buttons: {
                cancel: {
                    className: 'btn btn-default',
                    label: 'Fermer'
                },
                success: {
                    className: 'fa fa-trash-o btn btn-danger',
                    label: ' Supprimer',
                    callback: function () {
                        $rowToHide.fadeOut('slow');
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: route,
                            success: function () {
                                console.log('Success');
                            },
                            error: function (XHR, status, error) {
                                $rowToHide.show();
                                console.log(XHR);
                                console.log(status);
                                console.log(error);
                                alert('erreur pendant la suppression');
                            }
                        });
                    }
                }
            }
        });
    });

    $(document).on('click', ".reject-item", function (e) {
        e.preventDefault();
        var route = $(this).attr('href');

        bootbox.dialog({
            title: '<i class="fa fa-exclamation-triangle" style="color: brown"></i> Confirmation',
            message: 'Etez-vous sûre de rejeter ceci ?',
            className: 'my-class',
            buttons: {
                cancel: {
                    className: 'btn btn-default',
                    label: 'Fermer'
                },
                success: {
                    className: 'fa fa-minus-circle btn btn-danger with-loader',
                    label: ' Rejeter',
                    callback: function () {
                        window.location.href = route;
                    }
                }
            }
        });
    });

    $(document).on('click', ".action-activate, .action-disactivate", function (e) {
        e.preventDefault();
        var self = $(this);
        var $entityId = self.attr('data-entity-id');
        var $itemToShow;
        var route = self.attr('href');
        var spiner = $('#spiner-'+ $entityId);

        // making itemToShow in variable to easy show it again in case of error after it has been hidden
        if (self.hasClass('action-activate')) {
            $itemToShow = $('#disactivate-' + $entityId);
        }
        else if (self.hasClass('action-disactivate')) {
            $itemToShow = $('#activate-' + $entityId);
        }
        else {
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: route,
            beforeSend: function () {
                self.hide();
                spiner.show();
            },
            success: function () {
                spiner.hide();
                $itemToShow.show();
                console.log('Success');
            },
            error: function (XHR, status, error) {
                spiner.hide();
                $itemToShow.hide();
                self.show();
                alert('erreur');
                console.log(XHR);
                console.log(status);
                console.log(error);
            }
        });
    });


    $(document).on('click', ".lock", function (e) {
        e.preventDefault();

        var $entityId = $(this).attr('data-entity-id');
        var $itemToHide = '#lock-' + $entityId;
        var $itemToShow = '#unlock-' + $entityId;
        var route = $(this).attr('href');

        $($itemToHide).hide();
        $($itemToShow).show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: route,
            success: function () {
                console.log('Success');
            },
            error: function (XHR, status, error) {
                $($itemToShow).hide();
                $($itemToHide).show();
                console.log(XHR);
                console.log(status);
                console.log(error);
                alert('erreur');
            }
        });
    });

    $(document).on('click', ".unlock", function (e) {
        e.preventDefault();

        var $entityId = $(this).attr('data-entity-id');
        var $itemToHide = '#unlock-' + $entityId;
        var $itemToShow = '#lock-' + $entityId;
        var route = $(this).attr('href');

        $($itemToHide).hide();
        $($itemToShow).show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: route,
            success: function () {
                console.log('Success');
            },
            error: function (XHR, status, error) {
                $($itemToShow).hide();
                $($itemToHide).show();
                console.log(XHR);
                console.log(status);
                console.log(error);
                alert('erreur');
            }
        });
    });

});