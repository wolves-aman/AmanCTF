<?php

namespace app\Amanmin\controller;

use think\Db;

class Welcome extends Base
{
    public function index()
    {

        $countinfo = [
            'user' => model('user')->count(),
            'ctf' => model('subject')->count(),
            'comment' => model('guestbook')->count(),
            'soft' => model('soft')->count(),
            'tools' => model('tools')->count(),
            'safe' => model('safelog')->count(),
        ];
        $this->assign('countinfo', $countinfo);


        //7天新增用户
        $result = model('user')->getNewUserByWeek();
        $this->assign('newuser', $result);

        //题目分类统计
        $result=model('type')->getCountData();
        $this->assign('CountType',$result);
        return view();
    }

}
