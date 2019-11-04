<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/9
 * Time: 18:32
 */

namespace app\home\controller;


class Rank extends Base
{
    public function index(){
        //排行榜
        $list=model('user')->getSortList(50);
        $this->assign("list",$list);
        return view();
    }

}