<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 17:30
 */

namespace app\Amanmin\controller;


class Syslog extends Base
{
    public function index(){
        $log=model('syslog')->getAll();
        $page=$log->render();

        $this->assign('list',$log);
        $this->assign('page',$page);
        return view();
    }


}