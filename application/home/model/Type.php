<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/15
 * Time: 10:58
 */

namespace app\home\model;


use think\Model;
use app\admin\validate\Type as TypeValidate;
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

    public function getSubject($id){
        return model('subject')->where('type_id',$id)->select();
    }
    public function getSoft($id){
        return model('Soft')->where('type',$id)->select();
    }
    public function getTools($id){
        return model('tools')->where('type',$id)->select();
    }

    public function getCtfList($type=1){
        return $this->where('type',$type)->order('order','asc')->select();
    }
    public function getList($type=1,$filed="*"){
        if($type==2){
            return $this->field($filed)->where('type',$type)->withCount('soft')->order('order','asc')->select();
        }else if($type==3){
            return $this->field($filed)->where('type',$type)->withCount('tools')->order('order','asc')->select();
        }else{
            return $this->field($filed)->where('type',$type)->withCount('subject')->order('order','asc')->select();
        }

    }
    public function getCountData(){
        return $this->where('type','1')->withCount('subject')->select();
    }

    public function usesubject(){
        return $this->hasMany('subject','type_id','id');
    }
    public function getCountByUser($id){
        return $this
            ->withCount('subject')
            ->where('type','1')
            ->select();
    }

}