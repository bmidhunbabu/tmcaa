<?php
require_once '../includes/config.php';
Auth::is_logged_in() or header('Location:' . SITE_URL);
User::is_admin() or die('Unauthorized Access');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITE_TITLE; ?></title>
    <link href="<?php echo SITE_URL; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/css/icon-moon.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/css/admin-menu.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>/css/style.css" rel="stylesheet">
    <script src="<?php echo SITE_URL; ?>/js/jquery.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/admin-menu.js"></script>
    <script src="<?php echo SITE_URL; ?>/js/jquery.custom.js"></script>
</head>

<body>
    <?php require_once '../admin-bar.php'; ?>
    <div class="container-fluid">
        <div class="row" id="main">
            <?php require_once '../admin-menu.php'; ?>
            <div id="content">
                <div id="content-header">
                    <h3 class="heading">Users</h3>
                </div>
                <div class="content-body">
                    <?php
                    if (isset($_POST['delete'])) {
                        $result = User::delete($_POST['id']);
                        if ($result) {
                            alert('User deleted', 'success');
                        }
                    }
                    ?>
                    <?php
                    $sql = "select * from users order by created_at";
                    $result = User::all();
                    ?>
                    <?php if ($result) : ?>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                </tr>
                                <?php foreach ($result as $user) : ?>
                                    <tr>
                                        <td><?php echo $user->name; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->phone; ?></td>
                                        <td><?php echo ucfirst($user->role()->name); ?></td>
                                        <?php /*?>
                                <td>
                                    <a href="<?php echo SITE_URL; ?>/user/update.php?user_id=<?php echo $user['id']; ?>" class="btn btn-sm btn-success">Edit</a>
                                </td>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
                                        <input type="submit" class="btn btn-sm btn-danger" value="Delete" name="delete" />
                                    </form>
                                </td>
                                <?php */ ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>