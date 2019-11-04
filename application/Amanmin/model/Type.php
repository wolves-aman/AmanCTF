<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 10:58
 */

namespace app\Amanmin\model;


use think\Model;
use app\Amanmin\validate\Type as TypeValidate;
class Type extends Model
{
    public function subject(){
        return $this->hasMany('subject','type_id','id');
    }

    public function soft(){
        return $this->hasMany('soft','type','id');
    }

    public function tools(){
        return $this->hasMany('tools','type','id');
    }

    public function add($data){
        $validate=new TypeValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $type=new Type();
        if($type->allowField(true)->save($data)){
            return 1;
        }else{
            return '添加失败';
        }
    }
    public function getSubject($id){
        return model('subject')->where('type_id',$id)->select();
    }
    public function getSoft($id){
        return model('Soft')->where('type',$id)->select();
    }
    public function getTools($id){
        return model('tools')->where('type',$id)->select();
    }


    public function getList($type=1){
        if($type==2){
            return $this->where('type',$type)->withCount('soft')->order('order','asc')->select();
        }else if($type==3){
            return $this->where('type',$type)->withCount('tools')->order('order','asc')->select();
        }else{
            return $this->where('type',$type)->withCount('subject')->order('order','asc')->select();
        }

    }
    public function changeOrder($data){
        $res=$this->where('id',$data['id'])->find();
        if($res){
            $res->save(['order'=>$data['order']]);
                return 1;
        }

        return "数据不存在";
    }
    public function del($id){
        $res= $this->where('id',$id)->find();
        if($res){
            $res->delete();
            return 1;

        }else{
            return "数据不存在";
        }
    }
    public function getCtfList($type=1){
        return $this->where('type',$type)->order('order','asc')->select();
    }
    public function getCountData(){
        return $this->where('type','1')->withCount('subject')->select();
    }

}