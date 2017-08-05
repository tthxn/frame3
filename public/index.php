<?php
//composer 自动载入（命名空间、文件……）
include "../vendor/autoload.php";
//调用框架启动类的run()静态方法，Boot是框架启动类
\hd\core\Boot::run();