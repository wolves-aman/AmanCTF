<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/8
 * Time: 13:48
 */

namespace app\home\model;


use think\Model;

class Subject extends Model
{
    public function user(){
        return $this->hasOne('user','id','first');
    }
    public function getCount(){
        return $this->hasMany('solveLog','subject_id','id')->where('end_time',">",0);
    }
    public function isfinish(){
        return $this->hasOne('solveLog','subject_id','id')->where('user_id',session('user.id'));
    }
    public function getList(){
        return $this->field("id,title,value,type_id")->with('isfinish')->select();
    }


    public function getSubjectById($id){
        $res=$this
            ->withCount('getCount')
            ->where('id',$id)
            ->find();
        return $res;
    }

    public function addFirst($id){
        $res=$this->where('id',$id)->find();
        $res->save(['first'=>session('user.id')]);
    }

}