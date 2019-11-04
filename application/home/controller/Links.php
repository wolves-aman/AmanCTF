<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/9
 * Time: 18:32
 */

namespace app\home\controller;


class Links extends Base
{
    public function index(){
        $list = model('links')->getList();
        $this->assign('list', $list);

        return view();
    }

}