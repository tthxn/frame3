<?php
//设置命名空间，解决函数、类重名的问题
namespace hd\view;

//hd\view中的Base类，主要用于模板的制作，以及载入模板
class Base
{
    //保存分配变量的属性
    private $data = [];
    //模板路径，用于接下来方法中组合文件路径名，方便引入组合出来的路径中的文件
    private $template;

    /**
     * 分配变量
     */
    public function with($data){
//        将app/home/controller/Entry.php中传入的数据存入这个对象的data属性中
        $this->data = $data;
//      返回当前对象
//      返给\hd\view\View里面的__callStatic
//      View里面的__callStatic再返回给\app\home\controller\Entry里面的index方法(View::make())
//      Entry里面的index方法又返回给\hd\core\Boot里面的appRun方法，在appRun方法用了echo 输出这个对象
//      当一切条件如with  make 全部在hd\core\Boot中准备好，触发__toString
//      为了触发__toString（注意：仅用echo输出对象才能触发__toString）
        return $this;
    }

    /**
     * 制作模板
     */
    public function make(){
//        组合模板路径，当方便__toString载入模板使用
        $this->template = '../app/' . APP . '/view/' . CONTROLLER . '/' . ACTION . '.php';
        //返回当前对象，
        //返给\hd\view\View里面的__callStatic
        //View里面的__callStatic再返回给\app\home\controller\Entry里面的index方法(View::make())
        //Entry里面的index方法又返回给\hd\core\Boot里面的appRun方法，在appRun方法用了echo 输出这个对象
        //为了触发__toString（注意：仅用echo输出对象才能触发__toString）
        return $this;
    }

    /**
     * 载入模板
     * @return string __toString中必须先返回一个字符串，固定写法
     */
    public function __toString() {
        //把键名变为变量名，键值变为变量值 相当于 $data = ['title'=>'题目'];
//        使app/home/view/entry/index.php中读取数据的时候可以直接写成$data,
//       extract和app/home/controller/Entry.php中compact函数相对应
        extract($this->data);
//        p($this->data);
        //载入模板
        include $this->template;
        //这个方法必须返回字符串，固定写法
        return '';
    }
}