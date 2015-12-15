$(document).ready(function(){

    /* variables goes here */
    var $usersContainer = $('.users-container'),
        $usersTable     = $usersContainer.find('.table-users'),
        $addModal       = $usersContainer.find('#add-user-modal'),
        $deleteModal 	= $usersContainer.find('#delete-user-modal'),
        $editModal 		= $usersContainer.find('#edit-user-modal');

    /* request object */
    var request = {
        'ajax': function(url, type, datatype, data, fnSuccess, fnError, fnComplete) {
            return $.ajax({
                url      : url,
                type     : type || 'POST',
                dataType : datatype || 'JSON',
                data 	 : data || {},
                success  : typeof fnSuccess  === 'function' ? fnSuccess: null,
                error 	 : function(xhr) {
                    console.log(xhr.responseText);
                },
                complete : typeof fnComplete === 'function' ? fnComplete: null
            });
        }
    };

    /* users restful functions */
    var users = {
        'add': function(oData, fnCallBack) {
            var url 		= 'services/users/add.php',
                fnCallBack	= typeof fnCallBack === 'function' ? fnCallBack: null;

            return request.ajax(url, 'post', 'json', oData).done(fnCallBack);
        },
        'delete': function(id, fnCallBack) {
            var url 		= 'services/users/delete.php',
                fnCallBack	= typeof fnCallBack === 'function' ? fnCallBack: null;

            return request.ajax(url, 'post', 'json', {id: id}).done(fnCallBack);
        },
        'edit': function(oData, fnCallBack) {
            var url 		= 'services/users/edit.php',
                fnCallBack	= typeof fnCallBack === 'function' ? fnCallBack: null;

            return request.ajax(url, 'post', 'json', oData).done(fnCallBack);
        }
    };

    /* notification object */
    var notification = {
        messages: {
            ERROR: "Something wen\'t wrong. Please try again in a few moments."
        },
        success: function (sTitle, sContent) {
            return notification.popup(sTitle, sContent, "blue");
        },
        error: function (sTitle, sContent) {
            return notification.popup(sTitle, sContent, "red");
        },
        warning: function (sTitle, sContent) {
            return notification.popup(sTitle, sContent, "yellow");
        },
        popup: function (sTitle, sContent, sColor) {
            var sTitle   = sTitle || "Title",
                sContent = sContent || "Content",
                sColor   = sColor || "green";

            return new jBox('Notice', {
                title: sTitle,
                content: sContent,
                width: '230px',
                animation: { open: 'slide', close: 'flip' },
                theme: 'TooltipDark',
                color: sColor,
                audio: 'libs/jbox/Source/audio/blop',
                volume: 80,
                zIndex: 9999
            });
        }
    };

    /* some template */
    var template = {
        users : {
            tableRow : function(oUser) {
                return '<tr>'
                        +    '<td for="id">' + oUser.id + '</td>'
                        +    '<td for="name">' + oUser.name + '</td>'
                        +    '<td for="address">' + oUser.address + '</td>'
                        +    '<td for="email">' + oUser.email + '</td>'
                        +    '<td for="buttons">'
                        +        '<div class="btn-group">'
                        +            '<button type="button" class="btn btn-default show-edit-form" data-user=\' '+ JSON.stringify(oUser) +' \'>'
                        +                '<span class="glyphicon glyphicon-edit"></span>'
                        +            '</button>'
                        +            '<button type="button" class="btn btn-default confirm-delete-user" data-user=\' '+ JSON.stringify(oUser) +' \'>'
                        +                '<span class="glyphicon glyphicon-trash"></span>'
                        +            '</button>'
                        +        '</div>'
                        +    '</td>'
                        +'</tr>';
            }
        }
    };

    /* clears form */
    var fnClearForm = function ($form) {
        $form.find('input').val('');
    };

    /* submitting add user form */
    $usersContainer.on('submit', 'form[name=add-user]', function(e){
        e.preventDefault();

        var $form       = $(this),
            $fieldset   = $form.find('fieldset'),
            oData       = $form.serialize();

        // disabled form while request is made on server
        $fieldset.prop('disabled', true);

        users.add(oData, function(response) {
            if(response.success) {
                var oUser = response.data.user;
                // append to table
                $addModal.modal('hide');
                $usersTable.find('tbody').prepend(template.users.tableRow(oUser));
                notification.success('Done', '<strong>' + oUser.name + '</strong> added on users.');

            } else {
                notification.error('Opps!', notification.messages.ERROR);
            }

            // reset fieldset
            $fieldset.prop('disabled', false); return;
            
        });
    });

    // clear form everytime is shown
    $addModal.on('show.bs.modal', function() {
        var $this = $(this),
            $form = $this.find('form[name=add-user]');

        fnClearForm($form);

    });


    /* edit user */
    $usersContainer.on('click', '.show-edit-form', function(){
        var $btn        = $(this),
            oUser       = typeof $btn.data('user') === 'object' ? $btn.data('user'): JSON.parse($btn.data('user')),
            $tableRow   = $btn.parents('tr');

        // fill form data on modal
        $editModal.modal().find('input').each(function(index, element) {
            $.each(oUser, function(index, value) {
                var $input = $(element);
                if($input.attr('name') == index) {
                    $input.val(value);
                }
            });
        });

        // attach event hanlder upon submitting editted form
        $editModal.find('form[name=edit-user]').off('submit').on('submit', function(e){
            e.preventDefault();

            var $form = $(this),
                oData = $form.serialize();

            users.edit(oData, function(response) {
                if(response.success) {

                    // replace new updated table row
                    var oUser = response.data.user;
                    $editModal.modal('hide');
                    $tableRow.replaceWith(template.users.tableRow(oUser));
                    notification.success('Done', '<strong>' + oUser.name + '</strong> updated.');
                
                } else {
                    notification.error('Opps!', notification.messages.ERROR);
                }
            });
        });
    });

    /* delete a user */
    $usersContainer.on('click', '.confirm-delete-user', function(){
        var $btn        = $(this),
            oUser       = typeof $btn.data('user') === 'object' ? $btn.data('user'): JSON.parse($btn.data('user')),
            html        = '<p>Are you sure you wan\'t do delete <strong>' + oUser.name + '</strong>?</p>',
            $tableRow   = $btn.parents('tr');

        // attach event handler when user confirms delete. and then show modal.
        $deleteModal.off('click').on('click', '.btn-delete-user', function(e){
            var $btn = $(this),
                id 	 = $btn.data('id');

            users.delete(oUser.id, function(response) {
                if(response.success) {

                    // remove table row
                    $deleteModal.modal('hide');
                    $tableRow.fadeOut('fast').remove();
                    notification.success('Done', '<strong>' + oUser.name + '</strong> removed from users.');

                } else {
                    notification.error('Opps!', notification.messages.ERROR);
                }
            });

        }).modal().find('.modal-body').html(html);
    });

}); // end of document.ready()