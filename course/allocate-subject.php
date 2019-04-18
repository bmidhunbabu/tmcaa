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
                        <h3 class="heading">Subject Allocation</h3>
                    </div>
                    <div class="content-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    if(isset($_POST['allocate'])) {
                                        if(CourseSubject::existsWith(['course_id'=>$_POST['course_id'],'subject_id'=>$_POST['subject_id']])) {
                                            alert('Subject already allocated to course','danger');
                                        } else {
                                            unset($_POST['allocate']);
                                            $result = CourseSubject::create($_POST);
                                            if($result == 1) {
                                                foreach ($_POST as $key => $value) {
                                                    unset($_POST[$key]);
                                                }
                                                alert('Subject Allocated Successfully','success');
                                            }
                                        }
                                    }
                                ?>
                                <form method="POST">
                                    <div class="form-group">
                                        <label class="control-label">Course</label>
                                        <select class="form-control" name="course_id">
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
                                        <label class="control-label">Subject</label>
                                        <select class="form-control" name="subject_id" required>
                                            <option selected disabled hidden>Subject</option>
                                            <?php
                                            $sql = "select * from subjects";
                                            $subjects = $mysqli->query($sql);
                                            ?>
                                            <?php while ($subject = $subjects->fetch_assoc()) : ?>
                                                <option value="<?php echo $subject['id']; ?>" <?php echo (isset($_POST['subject_id']) && $_POST['subject_id'] == $subject['id']) ? 'selected' : ''; ?>><?php echo ucwords($subject['name']); ?></option> 
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Teacher</label>
                                        <select class="form-control" name="teacher_id" required>
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
                                    <input type="submit" class="btn" value="Allocate" name="allocate" />
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
