<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/31
 * Time: 11:23
 */

namespace app\Amanmin\controller;


class User extends Base
{

    public function index(){


        $data=[
            'order'=>input('order'),
            'keyword'=>input('keyword')
        ];
        $list=model('user')->getList($data);
        $page = $list->render();
        $this->assign('list',$list);
        $this->assign('page', $page);
        return view();
    }

    public function stop(){
        if(request()->isAjax()){
            $id=input('id');
            $res=model('user')->stop($id);
            addSyslog("用户","禁用/启用",$res);
            if($res==1){
                $this->success('操作成功');
            }
            else{
                $this->error($res);
            }

        }
    }
    public function del(){
        if(request()->isAjax()){
            $id=input('id');
            $res=model('user')->del($id);
            addSyslog("用户","del",$res);
            if($res==1)
                $this->success('操作成功');
            else
                $this->error($res);
        }
    }
    public function info(){
        $id=input('id');
        $user=model('user')->getUserByID($id);
        if(!$user){
            $this->error("用户不存在");
        }
        $this->assign('user',$user);

        $list=model('solveLog')->getUserList($id);
        $this->assign('list',$list);
        return view();
    }
    public function save(){
        if(request()->isAjax()){
            $res=model('admin')->edit(input());
            addSyslog("用户","edit",$res);
            if($res==1){
                $this->success('修改成功');
            }else{
                $this->error($res);
            }


        }
    }

}
