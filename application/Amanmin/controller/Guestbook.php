<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 10:41
 */

namespace app\Amanmin\controller;


class Guestbook extends Base
{
    public function index(){

        $list=model('guestbook')->getList();
        $page=$list->render();

        $this->assign('list',$list);
        $this->assign('page',$page);
        return view();
    }
    public function reply(){
        if(request()->isAjax()){
            $data=[
                'id'=>input('id'),
                'content'=>input('content')
            ];
            $res=model('guestbook')->reply($data);
            if($res==1){
                $this->success('回复成功');
            }else{
                $this->error($res);
            }
        }
    }

    public function del(){
        if(request()->isAjax()){
            $id=input('id');
            $res=model('guestbook')->del($id);
            if($res==1)
                $this->success('操作成功');
            else
                $this->error($res);
        }
    }

}