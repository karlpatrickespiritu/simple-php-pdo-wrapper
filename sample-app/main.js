$(document).ready(function(){

    /* variables goes here */
    var $usersContainer = $('.users-container'),
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

    /* submitting add user form */
    $usersContainer.on('submit', 'form[name=add-user]', function(e){
        e.preventDefault();

        var $form = $(this),
            oData = $form.serialize();

        users.add(oData, function(response) {
            if(response.success) {
                // let's just simply reload the page after adding data
                location.reload();
            }
        });
    });

    /* edit user */
    $usersContainer.on('click', '.show-edit-form', function(){
        var $btn = $(this),
            user = $btn.data('user');

        // fill form data on modal
        $editModal.modal().find('input').each(function(index, element) {
            $.each(user, function(index, value) {
                var $input = $(element);
                if($input.attr('name') == index) {
                    $input.val(value);
                }
            });
        });

        // attach event hanlder upon submitting editted form
        $editModal.find('form[name=edit-user]').on('submit', function(e){
            e.preventDefault();

            var $form = $(this),
                oData = $form.serialize();

            users.edit(oData, function(response) {
                if(response.success) {
                    // let's just simply reload the page after adding data
                    location.reload();
                }
            });
        });
    });

    /* delete a user */
    $usersContainer.on('click', '.confirm-delete-user', function(){
        var $btn = $(this),
            user = $btn.data('user'),
            html = '<p>Are you sure you wan\'t do delete <strong>' + user.name + '</strong>?</p>';

        // set id on btn delete
        $deleteModal.find('.btn-delete-user').data('id', user.id);

        // attach event handler when user confirms delete. and then show modal.
        $deleteModal.on('click', '.btn-delete-user', function(e){
            var $btn = $(this),
                id 	 = $btn.data('id');

            users.delete(id, function(response) {
                if(response.success) {
                    // let's just simply reload the page after adding data
                    location.reload();
                }
            });
        }).modal().find('.modal-body').html(html);
    });

}); // end of document.ready()