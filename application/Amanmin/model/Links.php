<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\Amanmin\model;


use think\Model;
use app\Amanmin\validate\Links as LinksValidate;

class Links extends Model
{
    public function getArticeById($id){
        return $this->where('id',$id)->find();
    }
    public function del($id){
        $a=$this->where('id',$id)->find();
        if($a){
            $a->delete();
            return 1;
        }else{
            return "该链接不存在";
        }
    }

    public function changeOrder($data){
        if(!is_numeric($data['order']) || strpos($data['order'], '.')){
            return "您需要输入一个整数";
        }
        $a=$this->where('id',$data['id'])->find();
        if($a){
            $a->order=$data['order'];
            $a->save();
            return 1;
        }else{
            return "该链接不存在";
        }
    }

    public function changeHide($id){
        $a=$this->where('id',$id)->find();
        if($a){
            $a->hide=($a->hide=='1'?'0':'1');
            $a->save();
            return 1;
        }else{
            return "该链接不存在";
        }
    }
    public function getList($len=20){
        return $this
            ->order('order','asc')
            ->paginate($len);
    }

    public function edit($data){
        $validate=new LinksValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $link=$this->where('id',$data['id'])->find();
        if($link){
            if($link->save($data)){
                return 1;
            }else{
                return "保存失败";
            }
        }else{
            return '该链接不存在';
        }
    }


    public function add($data){

        $validate=new LinksValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $link=new Links();
        if($link->allowField(true)->save($data)){
            return 1;
        }else{
            return '添加失败';
        }
    }

}