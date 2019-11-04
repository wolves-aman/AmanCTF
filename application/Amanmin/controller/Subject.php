<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/14
 * Time: 16:44
 */

namespace app\Amanmin\controller;


class Subject extends Base
{
    public function index()
    {

        $res = model('subject')->getList();
        $page = $res->render();
        $this->assign('list', $res);
        $this->assign('page',$page);
        return view();
    }
    public function info(){
        $id=input('id');
        $list=model('solveLog')->getSubjectList($id);
        $this->assign('list',$list);
        return view();
    }

    public function add()
    {

        if(request()->isAjax()){
            $data=input();
            if($data['author']=='')
                $data['author']="Aman";
            $result=model('subject')->add($data);
            addSyslog("题目","add",$result);
            if($result==1){
                $this->success('添加成功');
            }else{
                $this->error($result);
            }
        }

        $list=model('type')->getCtfList();
        $this->assign('list',$list);
        return view();
    }
    public function del(){
        if(request()->isAjax()){
            $id=input('id');
            $res=model('subject')->del($id);
            addSyslog("题目","del",$res);
            if($res==1){
                $this->success('操作成功');
            }else{
                $this->error($res);
            }
        }
    }
    public function edit(){
        $id=input('id');
        if(request()->isAjax()){
            $data=input();
            if($data['author']=='')
                $data['author']="Aman";
            $result=model('subject')->edit($data);
            addSyslog("题目","edit",$result);
            if($result==1){
                $this->success('修改成功');
            }else{
                $this->error($result);
            }
        }

        $res=model('subject')->where('id',$id)->find();
        if(!$res){
            $this->error('数据不存在');
        }
        $list=model('type')->getCtfList();
        $this->assign('list',$list);
        $this->assign('obj',$res);
        return view();
    }

}