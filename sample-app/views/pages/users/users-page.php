<div class="row users-container">
    <div class="col-md-12">
        <br>
        <blockquote>
            <p>This is a sample app using the simple-php-pdo-class database handler in the backend.</p>
        </blockquote>
        <hr>

        <h3>Users Table</h3>

        <!-- add user trigger modal -->
        <a data-toggle="modal" href="#add-user-modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add</a>
        <br>
        <br>

        <!-- users table-->
        <?php include 'users-table.php'; ?>

        <!-- user add modal -->
        <div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Add User</h4>
                    </div>

                    <form name="add-user">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" required class="form-control" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" required class="form-control" placeholder="Enter address">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" required class="form-control" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- user edit modal -->
        <div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit User</h4>
                    </div>

                    <form name="edit-user">
                        <input type="hidden" name="id">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" required class="form-control" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" required class="form-control" placeholder="Enter address">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" required class="form-control" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- user delete modal -->
        <div class="modal fade" id="delete-user-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Confirm Delete</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                        <a class="btn btn-primary btn-delete-user" data-id="">Delete</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
</div>