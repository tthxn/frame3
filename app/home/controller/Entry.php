<?php

namespace app\home\controller;

use hd\core\Controller;
use hd\model\Model;
use hd\view\View;


class Entry extends Controller {
    /**
     * 前台首页
     */
    public function index(){
        $sql = "SELECT * FROM stu s JOIN grade g ON s.gid=g.gid JOIN material m ON s.profile=m.path ORDER BY sid ASC";
        $data = Model::q($sql);
       return View::make()->with(compact('data'));
    }

    public function show(){
        $sql = "SELECT * FROM stu s JOIN grade g ON s.gid=g.gid JOIN material m ON s.profile=m.path WHERE sid={$_GET['sid']} ORDER BY sid ASC ";
        $data = Model::q($sql);
        $data = current($data);
        return View::make()->with(compact('data'));
    }
}