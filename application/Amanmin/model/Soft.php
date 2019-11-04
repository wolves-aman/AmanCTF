<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\Amanmin\model;


use think\Model;
use app\Amanmin\validate\Soft as SoftValidate;
class Soft extends Model
{
    public function getType(){
        return $this->hasOne('type','id','type');
    }
    public function getList($data,$len=20){
        if($data['keyword']!=''){
            return $this
                ->with('getType')
                ->where('title|des|author','like','%'.$data['keyword'].'%')
                ->paginate($len);

        }
        return $this->with('getType') ->paginate($len);

    }
    public function edit($data){
        $validate=new SoftValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $obj=$this->where('id',$data['id'])->find();
        if($obj->allowField(true)->save($data)){
            return 1;
        }else{
            return '保存失败';
        }
    }

    public function add($data){
        $validate=new SoftValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $obj=new Soft();
        if($obj->allowField(true)->save($data)){
            return 1;
        }else{
            return '添加失败';
        }
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
}