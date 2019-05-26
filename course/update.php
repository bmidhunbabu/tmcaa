<?php
require_once '../includes/config.php';
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
    <?php require_once '../admin-bar.php'; ?>
    <div class="container-fluid">
        <div class="row" id="main">
            <?php require_once '../admin-menu.php'; ?>
            <div id="content">
                <div id="content-header">
                    <h3 class="heading">Course Registration</h3>
                </div>
                <div class="content-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            if (isset($_GET['course_id'])) {
                                $id = $_GET['course_id'];
                                $course = Course::find($id);
                            }
                            ?>
                            <?php if ($course) : ?>
                                <?php
                                if (isset($_POST['update'])) {
                                    if (preg_match('/[^a-zA-Z\s]/', $_POST['name'])) {
                                        alert('Course Name cannot contain numbers and special characters', 'danger');
                                    } else if (preg_match('/[^a-zA-Z\s]/', $_POST['type'])) {
                                        alert('Course Type cannot contain numbers and special characters', 'danger');
                                    } else {
                                        unset($_POST['update']);
                                        $result = Course::update($_POST, $course->id);
                                        if ($result == 1) {
                                            alert('Course Updated Successfully', 'success');
                                        }
                                    }
                                }
                                ?>
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="name">Course Name</label>
                                        <input type="text" class="form-control" placeholder="Course Name" name="name" value="<?php echo input('name', $course->name); ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Course Type</label>
                                        <input type="text" class="form-control" placeholder="Course Type" name="type" value="<?php echo input('type', $course->type); ?>" />
                                    </div>
                                    <input type="submit" class="btn" value="Update" name="update" />
                                </form>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $sql = "select * from courses order by updated_at DESC LIMIT 10";
                            $result = $mysqli->query($sql);
                            ?>
                            <?php if ($result->num_rows) : ?>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Course Name</td>
                                            <td>Course Type</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($course = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?php echo $course['name']; ?></td>
                                                <td><?php echo $course['type']; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>