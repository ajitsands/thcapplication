<div class="collapse navbar-collapse" id="navbar-mobile">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block" style="color: white;">
                <i class="icon-paragraph-justify3"></i>
            </a>
        </li>
    </ul>

    <span class="badge bg-pink-400 badge-pill ml-md-3 mr-md-auto" id="div_date_time"></span>

    <ul class="navbar-nav">
        <li class="nav-item dropdown dropdown-user">
            <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                <img src="../httpdocs/images/employee_image/<?PHP echo $_SESSION['user_image']; ?>" class="rounded-circle mr-2" height="34" alt="" />
                <span style="color: white;"><?PHP echo $_SESSION['user_type'];?></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_form_vertical" id="reset_password"><i class="icon-user-plus"></i> Reset Password</a>
                <form id="logout_form">
                    <a href="#" id="log_out" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
                    <span id="user_type" style="display: none;"><?PHP echo $_SESSION['user_type'];?></span>
                    <a href="roll_and_permissions.php" class="classGivePermission dropdown-item"><i class="icon-key"></i>Permission Settings</a>
                </form>
            </div>
        </li>
    </ul>
</div>
