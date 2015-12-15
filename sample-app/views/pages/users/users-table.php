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
                <td for="id"><?php echo $user['id'] ?></td>
                <td for="name"><?php echo $user['name'] ?></td>
                <td for="address"><?php echo $user['address'] ?></td>
                <td for="email"><?php echo $user['email'] ?></td>
                <td for="buttons">
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