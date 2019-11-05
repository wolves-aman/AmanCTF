<?php
namespace app\home\controller;

class Index extends Base
{
    public function index()
    {
        //排行榜
        $list=model('user')->getSortList();
        if($list){
            $list=$list->toArray();
        }
        $this->assign("list",$list);
        //最新注册
        $list=model('user')->getList(['order'=>'reg'],15);
        $this->assign("reglist",$list);

        //解题记录
        $list=model('solveLog')->getList(9);
        $this->assign("solvelist",$list);

        //题目分类统计
        $result=model('type')->getCountData();
        $this->assign('CountType',$result);

        //公告
        $result=model('notice')->getList();
        $this->assign('notices',$result);

        //
        $result=model('guestbook')->getList();
        $this->assign('guestbook',$result);


        return view();
    }

}
