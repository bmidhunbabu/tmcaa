<nav class="navbar fixed-top navbar-expand-md" id="admin-bar">
    <a href="#" id="admin-menu-toggle">
        <span class="fa fa-bars"></span>
    </a>
    <a href="<?php echo SITE_URL; ?>/home.php" class="navbar-brand mr-auto"><?php echo SITE_TITLE; ?></a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#admin-bar-collapse">
        <span class="fa fa-user"></span>
    </button>
    <div class="collapse navbar-collapse" id="admin-bar-collapse">
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    <?php echo Auth::userName(); ?>
                </a>
                <div class="dropdown-menu">
                    <?php if (Auth::is_logged_in()) : ?>
                        <div>
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?php echo Auth::userId(); ?>" />
                                <input type="submit" value="Logout" class="dropdown-item" name="logout" />
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </div>
</nav>