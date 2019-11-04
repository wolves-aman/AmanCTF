<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 10:41
 */

namespace app\Amanmin\controller;


class Links extends Base
{
    public function index(){

        $list=model('Links')->getList();
        $page=$list->render();

        $this->assign('list',$list);
        $this->assign('page',$page);
        return view();
    }

    public function check(){
        if(request()->isAjax()){
            $id=input('id');
            $link=model('links')->where('id',$id)->find();
            if($link){
                $url=$link->checkurl==""?$link->url:$link->checkurl;
                $myurl=request()->server()['SERVER_NAME'];
                $res=checkLink($url,$myurl);
                $link->save(['status'=>$res]);
                if($res==1){
                    $this->success('1');
                }else{
                    $this->error($res,'',$res);
                }
            }else{
                $this->error("链接不存在",'','');
            }
        }
    }
    public function add()
    {

        if(request()->isAjax()){
            $data=input();
            $result=model('links')->add($data);
            addSyslog("友情链接","add",$result);
            if($result==1){
                $this->success('添加成功');
            }else{
                $this->error($result);
            }
        }
        return view();
    }
    public function edit(){
        $id=input('id');
        if(request()->isAjax()){
            $data=input();
            $result=model('links')->edit($data);
            addSyslog("友情链接","edit",$result);
            if($result==1){
                $this->success('修改成功');
            }else{
                $this->error($result);
            }
        }

        $res=model('links')->where('id',$id)->find();
        if(!$res){
            $this->error('数据不存在');
        }
        $this->assign('obj',$res);
        return view();
    }
    public function changeOrder(){
        if(request()->isAjax()){
            $data=[
                'order'=>input('order'),
                'id'=>input('id')
            ];
            $result=model('links')->changeOrder($data);
            if($result==1){
                $this->success('操作成功');
            }else{
                $this->error($result);
            }
        }
    }
    public function changeHide(){
        if(request()->isAjax()){
            $id=input('id');
            $result=model('links')->changeHide($id);
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
            $res=model('links')->del($id);
            addSyslog("友情链接","del",$res);
            if($res==1){
                $this->success('操作成功');
            }else{
                $this->error($res);
            }

        }
    }

}