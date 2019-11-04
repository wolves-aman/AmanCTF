<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/9
 * Time: 18:32
 */

namespace app\home\controller;


class Comment extends Base
{
    public function index(){
        $list=model('guestbook')->getList();

        $this->assign('list',$list);

        return view();
    }
    public function reply(){
        $id=input('id');
        $content=input('content');
        $res=model('guestbook')->reply($id,$content);
        if($res==1){
            $this->success('回复成功');
        }else{
            $this->error($res);
        }
    }

}