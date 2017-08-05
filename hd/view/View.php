<?php
//设置命名空间，和其他命名空间区分开来，解决类名或者函数出现重名的情况
namespace hd\view;


class View
{
//    __callStatic调用未定义的静态方法的时候，自动触发这个方法
    public static function __callStatic( $name, $arguments ) {
//        这里接收hd//Base.php返回的数据并且返回到app/home/controller/Entry.php里面
//        实例化类，调用类中的$name方法，传入参数
        return call_user_func_array([new Base(),$name],$arguments);
    }

}