<nav class="navbar navbar-inverse" style="border-radius: 0;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="?s=admin/entry/index">学生管理系统</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li <?php if(CONTROLLER == 'grade'): ?> class="active" <?php endif ?>><a href="?s=admin/grade/lists">班级</a></li>
                <li <?php if(CONTROLLER == 'material'): ?> class="active" <?php endif ?>><a href="?s=admin/material/lists">素材</a></li>
                <li <?php if(CONTROLLER == 'student'): ?> class="active" <?php endif ?>><a href="?s=admin/student/lists">学生</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="./index.php">返回前台</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user']['username']; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?s=admin/user/changePwd">修改密码</a></li>
                        <li><a href="?s=admin/login/out">退出</a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>