<?php
//设置命名空间，和其他命名空间区分开来，解决类名或者函数出现重名的情况
namespace hd\core;

/**
 * Class Controller控制器类，在app/home/controller/Entry.php中Entry类中有继承Controller这个类
 * @package hd\core
 */
class Controller{
//    url为跳转哪一页的参数，设置一个初始的url的值，当  如：app/home/Entry.php中add方法不传递参数的时候，默认返回上一级
    private $url = 'window.history.back()';
//    定义一个中转页面初始的属性，方便接下来各种方法的的使用
    private $template;
//    设置一个msg的属性，方便各个方法中的调用，用于成功失败中的消息提示
    private $msg;

    /**
     * 跳转
     * @param $url跳转地址
     */
    protected function setRedirect($url){
//        当用户传递了url的值的时候，页面自动跳转
        $this->url = "location.href = '{$url}'";
//		返回当前的对象，
//      返回给app/home/controller/Entry.php中的某一方法，如add方法
//      Entry类里面的add方法又返回给hd\core\Boot.php,在appRun中用echo输出对象，
//        自动触发本页hd\core\Controller.php中的__toString
        return $this;
    }

    /**
     * 成功的时候的提示
     */
    protected function success($msg){
//        成功提示消息
        $this->msg = $msg;
//        成功了，就跳转到public/view/success.php这个页面，中转页面
        $this->template = "./view/success.php";
        //		返回当前的对象，
//      返回给app/home/controller/Entry.php中的某一方法，如add方法
//      Entry类里面的add方法又返回给hd\core\Boot.php,在appRun中用echo输出对象，
//        自动触发本页hd\core\Controller.php中的__toString
        return $this;
    }

    /**
     * 失败的时候
     */
    protected function error($msg){
//        成功提示消息
        $this->msg = $msg;
//        成功了，就跳转到public/view/error.php这个页面，中转页面
        $this->template = "./view/error.php";
//		返回当前的对象，
//      返回给app/home/controller/Entry.php中的某一方法，如add方法
//      Entry类里面的add方法又返回给hd\core\Boot.php,在appRun中用echo输出对象，
//        自动触发本页hd\core\Controller.php中的__toString
        return $this;
    }

//    前期准备完成后，在hd/core/Boot.php中，因为有echo输出对象，自动触发这个方法，载入模板
    public function __toString()
    {
//        载入模板
        include $this->template;
//        __toString()触发必须要返回一个字符串，固定格式
        return '';
    }
}