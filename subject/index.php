<?php 
    require_once '../includes/config.php';
    Auth::is_logged_in() or header('Location:'.SITE_URL);
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
                        <h3 class="heading">Subjects</h3>
                    </div>
                    <div class="content-body">
                        <?php
                            if(isset($_POST['delete'])) {
                                $result = Subject::delete($_POST['id']);
                                if($result) {
                                    alert('Subject deleted','success');
                                }
                            }
                        ?>
                        <?php
                            $sql = "select * from subjects order by created_at";
                            $result = $mysqli->query($sql);
                        ?>
                        <?php if($result->num_rows): ?>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Credits</th>
                                    </tr>
                                    <?php while($subject = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $subject['name']; ?></td>
                                            <td><?php echo $subject['credits'] ; ?></td>
                                            <?php /* ?>
                                            <td>
                                                <a href="<?php echo SITE_URL; ?>/subject/update.php?subject_id=<?php echo $subject['id']; ?>" class="btn btn-sm btn-success">Edit</a>
                                            </td>
                                            <td>
                                                <form method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $subject['id']; ?>" />
                                                    <input type="submit" class="btn btn-sm btn-danger" value="Delete" name="delete" />
                                                </form>
                                            </td>
                                            <?php */ ?>
                                        </tr>
                                     <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
