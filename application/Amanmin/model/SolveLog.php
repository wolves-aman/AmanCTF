<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\Amanmin\model;


use think\Model;
use app\Amanmin\validate\Admin as AdminValidate;

class SolveLog extends Model
{
    public function getSubject(){
        return $this->hasOne('subject','id','subject_id');
    }
    public function getUser(){
        return $this->hasOne('user','id','user_id');
    }
    public function getUserList($uid){
        $res=$this
            ->with('getSubject')
            ->where('user_id',$uid)
            ->where('end_time','>','0')
            ->order('end_time','desc')
            ->select();
        return $res;
    }

    public function getSubjectList($sid){
        $res=$this
            ->with('getSubject')
            ->where('subject_id',$sid)
            ->where('end_time','>','0')
            ->order('end_time','desc')
            ->select();
        return $res;
    }
}