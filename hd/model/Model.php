<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/30
 * Time: 23:58
 */

namespace hd\model;


class Model
{
//    __callStatic调用未定义的方法的时候，自动触发这个方法
    public static function __callStatic($name, $arguments)
    {
//        get_called_class()获取当前调用这个方法的子类的名称，注意这个函数一定要写在类中
        $className = get_called_class();
//        p($className);
//        system\model\User  当Entry.php中调用Arc中的get方法时候，此时p输出结果值是system\model\User

//        通过获取的子类的名称   截取表名  （system\model\Arc类名和表名是一样的，类是Arc 表是arc）
//        获取system\model\Arc中最后一个字段，并且将他们转化成小写， strrchr根据\进行从右边的截取，但是一个\是转义的意思，\\是阻止转义
        $table = strtolower(ltrim(strrchr($className,'\\'),'\\'));


//        给Base传入表名，如arc，对$table表进行数据库的增改删查的操作
//        实例化类，调用类中的$name方法，传入参数
        return call_user_func_array([new Base($table),$name],$arguments);
    }
}