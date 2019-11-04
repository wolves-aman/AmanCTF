<?php
namespace app\Amanmin\controller;



class Tools extends Base
{
    public function index()
    {
        $data=[
            'keyword'=>input('keyword')
        ];
        $list=model('tools')->getList($data);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);

        return view();
    }
    public function changeOrder(){
        if(request()->isAjax()){
            $result=model('link')->changeOrder(input());
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
            $res=model('tools')->del($id);
            addSyslog("在线工具","del",$res);
            if($res==1)
                $this->success('操作成功');
            else
                $this->error($res);
        }
    }
    public function edit($id){
        $id=input('id');
        if(request()->isAjax()){
            $data=input();
            $result=model('tools')->edit($data);
            addSyslog("在线工具","edit",$result);
            if($result==1){
                $this->success('修改成功');
            }else{
                $this->error($result);
            }
        }

        $res=model('tools')->where('id',$id)->find();
        if(!$res){
            $this->error('数据不存在');
        }
        $this->assign('obj',$res);
        $list=model('type')->getList(3);
        $this->assign('list',$list);
        return view();

    }

    public function add(){

        if(request()->isAjax()){
            $data=input();
            $result=model('tools')->add($data);
            addSyslog("在线工具","add",$result);
            if($result==1){
                $this->success('添加成功');
            }else{
                $this->error($result);
            }
        }
        $list=model('type')->getList(3);
        $this->assign('list',$list);
        return view();
    }

}
