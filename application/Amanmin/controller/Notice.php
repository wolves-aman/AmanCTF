<?php
namespace app\Amanmin\controller;



class Notice extends Base
{
    public function index()
    {
        $data=[
            'keyword'=>input('keyword')
        ];
        $list=model('notice')->getList($data);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);

        return view();
    }

    public function del(){
        if(request()->isAjax()){
            $id=input('id');
            $res=model('notice')->del($id);
            addSyslog("公告","del",$res);
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
            $result=model('notice')->edit($data);
            addSyslog("公告","edit",$result);
            if($result==1){
                $this->success('修改成功');
            }else{
                $this->error($result);
            }
        }

        $res=model('notice')->where('id',$id)->find();
        if(!$res){
            $this->error('数据不存在');
        }
        $this->assign('obj',$res);
        return view();

    }

    public function add(){

        if(request()->isAjax()){
            $data=[
                'type'=>0,
                'content'=>input('content'),
                'title'=>input('title')
            ];
            $result=model('notice')->add($data);
            addSyslog("公告","add",$result);
            if($result==1){
                $this->success('添加成功');
            }else{
                $this->error($result);
            }
        }
        return view();
    }

}
