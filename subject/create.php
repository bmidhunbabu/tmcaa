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
                    <h3 class="heading">Subject Registration</h3>
                </div>
                <div class="content-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            /* if(isset($_POST['register'])) {
                                        if(preg_match('/[^a-zA-Z\s]/', $_POST['name'])) {
                                            alert('Subject Name cannot contain numbers and special characters','danger');
                                        } else if (!ctype_digit($_POST['credits'])) {
                                            alert('Invalid Number for credit','danger');
                                        } else if (Subject::exists('name',$_POST['name'])) {
                                            alert("Subject ".$_POST['name']." already exists",'danger');
                                        } else if (Subject::existsWith(['name' => $_POST['name'],'credits' => $_POST['credits']])) {
                                            alert("Subject ".$_POST['name']." already exists",'danger');
                                        } else {
                                            unset($_POST['register']);
                                            $result = Subject::create($_POST);
                                            if($result) {
                                                foreach ($_POST as $key => $value) {
                                                    unset($_POST[$key]);
                                                }
                                                alert('Subject Created Successfully','success');
                                            }
                                        }
                                    } */
                            ?>
                            <form method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Subject Name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Subject Code" name="code" value="<?php echo isset($_POST['code']) ? $_POST['code'] : ''; ?>" />
                                </div>
                                <div class="form-group">
                                    <?php $courses = Course::all('name'); ?>
                                    <?php if ($courses) : ?>
                                        <select name="courSe_id" id="courSe_id" class="form-control">
                                            <option selected hidden disabled>Course</option>
                                            <?php foreach ($courses as $course) : ?>
                                                <option value="<?php echo $course->id; ?>"><?php echo $course->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                                <input type="submit" class="btn" value="Register" name="register" />
                            </form>
                        </div>
                        <div class="col-md-6">
                            <?php /* ?>
                            <?php
                            $sql = "select * from subjects order by created_at LIMIT 10";
                            $result = $mysqli->query($sql);
                            ?>
                            <?php if ($result->num_rows) : ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Credits</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($subject = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?php echo $subject['name']; ?></td>
                                        <td><?php echo $subject['credits']; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>