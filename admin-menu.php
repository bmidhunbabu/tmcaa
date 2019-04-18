<div id="admin-menu" class="navbar">
    <ul id="menu" class="nav mb-auto">
        <li><a href="<?php echo SITE_URL; ?>/home.php"><span class="fa icon-home"></span>Home</a></li>
        <?php if (Auth::is_logged_in() && !User::is_admin()) : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <span class="fa icon-users"></span>Attendance
                </a>
                <div class="dropdown-menu">
                    <?php if (Auth::is_logged_in() && User::is_student()) : ?>
                        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/attendance/student-attendance.php">All Attendance</a>
                    <?php endif; ?>
                    <?php if (Auth::is_logged_in() && User::is_staff()) : ?>
                        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/attendance/create.php">Add Attendance</a>
                        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/attendance/update.php">Modify Attendance</a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endif; ?>
        <?php if (Auth::is_logged_in() && User::is_admin()) : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <span class="fa icon-users"></span>Courses
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo SITE_URL; ?>/course">All Courses</a>
                    <a class="dropdown-item" href="<?php echo SITE_URL; ?>/course/create.php">New Course</a>
                    <a class="dropdown-item" href="<?php echo SITE_URL; ?>/course/allocate-subject.php">Subject Allocation</a>
                </div>
            </li>
        <?php endif; ?>
        <?php /* >
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <span class="fa icon-users"></span>Exam
            </a>
            <div class="dropdown-menu">
                <?php if (Auth::is_logged_in() && User::is_admin()) : ?>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/exam">All Exams</a>
        <?php endif; ?>
        <?php if (Auth::is_logged_in() && User::is_student()) : ?>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/exam/exam-list.php">All Exams</a>
        <?php endif; ?>
        <?php if (Auth::is_logged_in() && User::is_staff()) : ?>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/exam/create.php">New Exams</a>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/exam/create-category.php">Exam Category</a>
        <?php endif; ?>
</div>
</li>
<?php if (Auth::is_logged_in() && User::is_staff()) : ?>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
        <span class="fa icon-users"></span>Internal Marks
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/internal-mark">All Internal Marks</a>
        <?php if (Auth::is_logged_in() && User::is_student()) : ?>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/internal-mark/mark-list.php">All Internal Marks</a>
        <?php endif; ?>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/internal-mark/create.php">New Internal Mark</a>
    </div>
</li>
<?php endif; ?>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
        <span class="fa icon-users"></span>Results
    </a>
    <div class="dropdown-menu">
        <?php if (Auth::is_logged_in() && (User::is_admin() || User::is_staff())) : ?>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/result">All Results</a>
        <?php endif; ?>
        <?php if (Auth::is_logged_in() && User::is_student()) : ?>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/result/mark-list.php">All Results</a>
        <?php endif; ?>
        <?php if (Auth::is_logged_in() && User::is_staff()) : ?>
        <a class="dropdown-item" href="<?php echo SITE_URL; ?>/result/create.php">New Result</a>
        <?php endif; ?>
    </div>
</li>
<?php */ ?>
<?php if (Auth::is_logged_in() && User::is_admin()) : ?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            <span class="fa icon-users"></span>Subjects
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo SITE_URL; ?>/subject">All Subjects</a>
            <a class="dropdown-item" href="<?php echo SITE_URL; ?>/subject/create.php">New Subject</a>
        </div>
    </li>
<?php endif; ?>
<?php if (Auth::is_logged_in() && User::is_staff()) : ?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            <span class="fa icon-users"></span>Students
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo SITE_URL; ?>/user/student-list.php">All Users</a>
            <a class="dropdown-item" href="<?php echo SITE_URL; ?>/user/create-student.php">New User</a>
        </div>
    </li>
<?php endif; ?>
<?php if (Auth::is_logged_in() && User::is_admin()) : ?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            <span class="fa icon-users"></span>Users
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="<?php echo SITE_URL; ?>/user">All Users</a>
            <a class="dropdown-item" href="<?php echo SITE_URL; ?>/user/student-list.php">All Students</a>
            <a class="dropdown-item" href="<?php echo SITE_URL; ?>/user/create.php">New User</a>
        </div>
    </li>
<?php endif; ?>
<!-- <li><a href="#"><span class="fa icon-earth"></span>Websites</a></li>
        <li><a href="#"><span class="fa icon-users"></span>Clients</a></li>
        <li><a href="#"><span class="fa icon-address-book"></span>Contacts</a></li>
        <li><a href="#"><span class="fa fa-cogs"></span>Settings</a></li>
        <li><a href="#"><span class="fa icon-profile"></span>Account</a></li> -->
</ul>
</div>