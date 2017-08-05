<?php
//设置命名空间，和其他命名空间区分开来，解决类名或者函数出现重名的情况
namespace app\admin\controller;
//载入hd\view\View类，控制模板的载入
use hd\view\View;

/**
 * Class Entry后台入口类
 * @package app\admin\controller
 */
class Entry extends Common
{
//    后台默认s=admin/entry/index
    public function index(){
//        载入模板
        return View::make();
    }
}