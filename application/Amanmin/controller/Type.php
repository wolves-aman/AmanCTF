<?php
namespace app\Amanmin\controller;

class Type extends Base
{
    public function ctf()
    {
        $res=model('type')->getList(1);
        $this->assign('list',$res);
        return view();
    }
    public function down()
    {
        $res=model('type')->getList(2);
        $this->assign('list',$res);
        return view();
    }
    public function tools()
    {
        $res=model('type')->getList(3);
        $this->assign('list',$res);
        return view();
    }
    public function changeOrder(){
        if(request()->isAjax()){
            $data=[
                'order'=>input('order'),
                'id'=>input('id')
            ];
            $result=model('type')->changeOrder($data);
            if($result==1){
                $this->success('操作成功');
            }else{
                $this->error($result);
            }
        }
    }

    public function del(){
        if(request()->isAjax()){
            $id=input('id');
            $res=model('type')->del($id);
            addSyslog("分类","del",$res);
            if($res==1){
                $this->success('操作成功');
            }else{
                $this->error($res);
            }
        }
    }
    public function info($id){
        $info=model('type')->getSubject($id);
        $this->assign('list',$info);
        return view();
    }

    public function softinfo($id){
        $info=model('type')->getSoft($id);
        $this->assign('list',$info);
        return view();
    }
    public function toolsinfo($id){
        $info=model('type')->getTools($id);
        $this->assign('list',$info);
        return view();
    }
    public function add(){

        if(request()->isAjax()){
            $result=model('type')->add(input());
            addSyslog("分类","add",$result);
            if($result==1){
                $this->success('添加成功');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

}
