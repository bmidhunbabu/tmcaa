<?php 
    require_once '../includes/config.php';
    Auth::is_logged_in() or header('Location:'.SITE_URL);
    User::is_teacher() or die('Unauthorized Access');
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
                        <h3 class="heading">Internal Mark</h3>
                    </div>
                    <div class="content-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    if(isset($_POST['publish'])) {
                                        if(!ctype_digit($_POST['semester'])) {
                                            alert('Semester Must be a number','danger');
                                        } else if(!ctype_digit($_POST['marks_obtained'])) {
                                            alert('Mark Must be a number','danger');
                                        } else if(InternalMark::existsWith(['student_id' => $_POST['student_id'],'subject_id' => $_POST['subject_id'],'semester' => $_POST['semester']])) {
                                            alert('Marks already Added','danger');
                                        } else {
                                            unset($_POST['publish']);
                                            $result = InternalMark::create($_POST);
                                            if($result == 1) {
                                                foreach ($_POST as $key => $value) {
                                                    unset($_POST[$key]);
                                                }
                                                alert('Mark published Successfully','success');
                                            }
                                        }
                                    }
                                ?>
                                <form method="POST">
                                    <div class="form-group">
                                        <label class="control-label">Student</label>
                                        <select class="form-control" name="student_id" id="student_id">
                                            <option selected disabled hidden>Student</option>
                                            <?php
                                            $sql = "select * from users where role_id = (select id from roles where name= 'student')";
                                            $results = $mysqli->query($sql);
                                            ?>
                                            <?php while ($student = $results->fetch_assoc()) : ?>
                                                <option value="<?php echo $student['id']; ?>" <?php echo (isset($_POST['student_id']) && $_POST['student_id'] == $student['id']) ? 'selected' : ''; ?>><?php echo ucwords($student['name']); ?></option> 
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Subject</label>
                                        <select class="form-control" name="subject_id" id="subject_id">
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
                                        <label class="control-label">Semester</label>
                                        <input type="text" class="form-control" name="semester" placeholder="Semester" value="<?php echo isset($_POST['semester']) ? $_POST['semester'] : '' ; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Marks Obtained</label>
                                        <input type="text" class="form-control" name="marks_obtained" placeholder="Marks Obtained" value="<?php echo isset($_POST['marks_obtained']) ? $_POST['marks_obtained'] : '' ; ?>" />
                                    </div>
                                    <input type="submit" class="btn" value="Publish" name="publish" />
                                </form>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#student_id').change(function() {
                $.ajax({url: "<?php echo SITE_URL; ?>/internal-mark/subject-list.php",
                    data: {
                        student_id : $(this).val()
                    },
                    success: function(result){
                        $("#subject_id").html(result);
                    }
                });
            });
        </script>
    </body>
</html>
