<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/9
 * Time: 18:32
 */

namespace app\home\controller;


class Notice extends Base
{
    public function index()
    {

        //公告
        $result=model('notice')->getList(-1);
        $this->assign('notices',$result);


        return view();
    }


    public function info()
    {

        $id = input('id');

        $user = model('notice')->getNotice($id);
        if (!$user) {
            $this->redirect("/404");
        }
        $this->assign('v', $user);


        return view();
    }
}