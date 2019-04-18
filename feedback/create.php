<?php 
    require_once '../includes/config.php';
    Auth::is_logged_in() or header('Location:'.SITE_URL);
    User::is_student() or die('Unauthorized Access');
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
                        <h3 class="heading">Feedback</h3>
                    </div>
                    <div class="content-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="POST">
                                    <?php
                                        if(isset($_POST['publish'])) {
                                            if(!ctype_digit($_POST['semester'])) {
                                                alert('Semester Must be a number','danger');
                                            } else if(Feedback::existsWith(['teacher_id' => $_POST['teacher_id'],'course_id' => $_POST['course_id'],'semester' => $_POST['semester']])) {
                                                alert('Feedback already submitted','danger');
                                            } else {
                                                unset($_POST['publish']);
                                                $result = Feedback::create($_POST);
                                                if($result == 1) {
                                                    foreach ($_POST as $key => $value) {
                                                        unset($_POST[$key]);
                                                    }
                                                    alert('Feedback Added Successfully','success');
                                                }
                                            }
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label">Course</label>
                                        <select class="form-control" name="course_id" required>
                                            <option selected disabled hidden>Course</option>
                                            <?php
                                            $sql = "select * from courses";
                                            $courses = $mysqli->query($sql);
                                            ?>
                                            <?php while ($course = $courses->fetch_assoc()) : ?>
                                                <option value="<?php echo $course['id']; ?>" <?php echo (isset($_POST['course_id']) && $_POST['course_id'] == $course['id']) ? 'selected' : ''; ?>><?php echo ucwords($course['name']); ?></option> 
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Semester</label>
                                        <input type="text" class="form-control" name="semester" placeholder="Semester" value="<?php echo isset($_POST['semester']) ? $_POST['semester'] : '' ; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Teacher</label>
                                        <select class="form-control" name="teacher_id">
                                            <option selected disabled hidden>Teacher</option>
                                            <?php
                                            $sql = "select * from users where role_id = (select id from roles where name= 'teacher')";
                                            $results = $mysqli->query($sql);
                                            ?>
                                            <?php while ($teacher = $results->fetch_assoc()) : ?>
                                                <option value="<?php echo $teacher['id']; ?>" <?php echo (isset($_POST['teacher_id']) && $_POST['teacher_id'] == $teacher['id']) ? 'selected' : ''; ?>><?php echo ucwords($teacher['name']); ?></option> 
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Feedback</label>
                                        <textarea name="content" class="form-control" required><?php echo isset($_POST['content']) ?$_POST['content'] :'' ; ?></textarea>
                                    </div>
                                    <input type="submit" class="btn" name="publish" value="Publish" />
                                </form>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
