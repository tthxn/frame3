<?php
//在public中建一个admin文件夹，当访问public时候，页面自动加载public/index.php文件，是前台页面
//在public/index.php后面加上admin，public/admin(http://localhost/c83/frame/0802/public/admin)
//于是经过此页面，header使其自动跳转到后台登陆页面
header("location:../index.php?s=admin/entry/index");