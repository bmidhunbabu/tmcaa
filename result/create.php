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
                        <h3 class="heading">Result</h3>
                    </div>
                    <div class="content-body">
                        <div class="row">
                            <div class="col-md-6">
                            <?php
                                    if(isset($_POST['create']))     {
                                        if(!ctype_digit($_POST['marks_obtained'])) {
                                            alert(' Marks must be a number','danger');
                                        } else if(Result::existsWith(['exam_id' => $_POST['exam_id'],'student_id' => $_POST['student_id']])) {
                                            alert('Marks already Added','danger');
                                        } else {
                                            unset($_POST['create']);
                                            $result = Result::create($_POST);
                                            if($result == 1) {
                                                foreach ($_POST as $key => $value) {
                                                    unset($_POST[$key]);
                                                }
                                                alert('Result created Successfully','success');
                                            }
                                        }
                                    }
                                ?>
                                <form method="POST">
                                    <div class="form-group">
                                        <label class="control-label">Exam</label>
                                        <select class="form-control" name="exam_id" id="exam_id">
                                            <option selected disabled hidden>Exam</option>
                                            <?php
                                            $sql = "select * from exams";
                                            $results = $mysqli->query($sql);
                                            ?>
                                            <?php while ($exam = $results->fetch_assoc()) : ?>
                                                <option value="<?php echo $exam['id']; ?>" <?php echo (isset($_POST['exam_id']) && $_POST['exam_id'] == $exam['id']) ? 'selected' : ''; ?>><?php echo ucwords($exam['name']) . " On " . $exam['date']; ?></option> 
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
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
                                        <option selected disabled hidden>Marks Obtained</option>
                                        <input type="text" class="form-control" name="marks_obtained" placeholder="Mark Obtained" />
                                    </div>
                                    <input type="hidden" name="teacher_id" value="<?php echo Auth::userId(); ?>" />
                                    <input type="submit" name="create" value="Create" class="btn" />
                                </form>
                            </div>
                            <div class="col-md-6">
                            <?php
                                    $sql = "select u.name as student_name,e.name as exam_name,e.maximum_marks,r.marks_obtained,r.id,e.date from results r inner join exams e on r.exam_id = e.id inner join users u on r.student_id = u.id order by r.created_at";
                                    $result = $mysqli->query($sql);
                                ?>
                                <?php if($result->num_rows) : ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td>Exam</td>
                                                <td>Student</td>
                                                <td>Marks</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($res = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo $res['exam_name'];?></td>
                                                    <td><?php echo $res['student_name'];?></td>
                                                    <td><?php echo $res['marks_obtained'];?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>                                         
                                    </table>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#exam_id').change(function() {
                $.ajax({url: "<?php echo SITE_URL; ?>/result/student-list.php",
                    data: {
                        exam_id : $(this).val()
                    },
                    success: function(result){
                        console.log(result);
                        $("#student_id").html(result);
                    }
                });
            });
        </script>
    </body>
</html>
