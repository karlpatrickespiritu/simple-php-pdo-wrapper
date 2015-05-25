<div class="table-responsive table-users">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['id'] ?></td>
                <td><?php echo $user['name'] ?></td>
                <td><?php echo $user['address'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default show-edit-form" data-user='<?php echo json_encode($user); ?>'>
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button type="button" class="btn btn-default confirm-delete-user" data-user='<?php echo json_encode($user); ?>'>
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>