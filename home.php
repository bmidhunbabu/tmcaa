<?php
require_once 'includes/config.php';
Auth::is_logged_in() or header('Location:' . SITE_URL);
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
    <?php require_once 'admin-bar.php'; ?>
    <div class="container-fluid">
        <div class="row" id="main">
            <?php require_once 'admin-menu.php'; ?>
            <div id="content">
                <div id="content-header">
                    <h3 class="heading">Home</h3>
                </div>
                <div class="content-body">
                    <?php /* ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php $user = Auth::user(); ?>
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo $user->name; ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?php echo $user->username; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo $user->email; ?></td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td><?php echo $user->phone; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php */ ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box bg-orange">
                                <div class="info-box-icon">
                                    <span class="info-icon icon-users"></span>
                                </div>
                                <div class="info-box-content">
                                    <h3 class="info-title">Users</h3>
                                    <a href="<?php echo SITE_URL; ?>/user">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-amber">
                                <div class="info-box-icon">
                                    <span class="info-icon icon-users"></span>
                                </div>
                                <div class="info-box-content">
                                    <h3 class="info-title">Students</h3>
                                    <a href="<?php echo SITE_URL; ?>/user/student-list.php">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-deep-orange">
                                <div class="info-box-icon">
                                    <span class="info-icon icon-book"></span>
                                </div>
                                <div class="info-box-content">
                                    <h3 class="info-title">Courses</h3>
                                    <a href="<?php echo SITE_URL; ?>/course">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>