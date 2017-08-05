<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/2
 * Time: 19:22
 */

namespace app\admin\controller;

//载入hd\core\Controller类，控制跳转，成功提示，错误提示等
use hd\core\Controller;
/**
 * Class Common公共控制类，判断用户是否登陆（每个类都继承 Common这个类，这样每个页面都可以判断用户是否有登陆）
 * 注意login页面不能继承这个类，显示登陆页面，一直是没有$_SESSION['user']状态，又跳转到登陆页面，这样会形成死循环
 * @package app\admin\controller
 */
class Common extends Controller
{
    /**
     * Common constructor.构造函数，子类继承父类，子类中如果没有构造函数，父类中的构造函数自动运行
     * 如果子类中有构造函数，那么子类中的构造函数会将父类中的构造函数覆盖掉
     */
    public function __construct()
    {
//      如果没有登陆，当session中没有存储用户的信息，表示用户没有登陆
        if(!isset($_SESSION['user'])){
//		    当没有登陆的时候，调用hd/core中的functions.php中的go方法，进行页面自动跳转到登陆页面
            go("?s=admin/login/index");
        }
    }
}