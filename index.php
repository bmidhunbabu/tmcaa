<?php
require_once 'includes/config.php';
(!Auth::is_logged_in()) or header('Location:home.php');
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

<body class="login">
    <div class="form-container">
        <h2 class="form-heading"><?php echo SITE_TITLE; ?></h2>
        <?php
        if (isset($_POST['login'])) {
            $result = Auth::login($_POST['username'], $_POST['password']);
            if ($result) {
                header('Location:home.php');
            } else {
                alert('invalid Credentials', 'danger');
            }
        }
        ?>
        <form method="POST" class="form-login">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required />
            </div>
            <input type="submit" value="Login" class="btn btn-block mt-5" name="login" />
        </form>
    </div>
</body>

</html>