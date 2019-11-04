<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\home\model;


use think\Model;
use app\admin\validate\Admin as AdminValidate;

class SolveLog extends Model
{
    protected $dateFormat = 'Y-m-d H:i';
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
            ->order('end_time','desc')
            ->select();
        return $res;
    }

    public function getList($len){
        $res=$this
            ->with('getSubject')
            ->with('getUser')
            ->where('end_time','>','0')
            ->order('end_time','desc')
            ->limit($len)
            ->select();
        return $res;
    }

    public function addLog($data){
        $where=[
            'user_id'=>$data['user_id'],
            'subject_id'=>$data['subject_id']
        ];

        $data['end_time']=time();
        $res=$this->where($where)->find();
        if(!$res){
            $res=new SolveLog();

        }else{
            if($res['end_time']>1){
                return "";
            }

        }
        model('user')->where('id',$data['user_id'])->update(['end_time'=>$data['end_time']]);
        $res->save($data);
    }

    public function add($data){
        $res=$this->where($data)->find();
        if(!$res){
            $res=new SolveLog();
            $res->save($data);
        }
        return $res;
    }


    public function getCountByDay($id,$len){
        $res= $this
            ->alias('log')
            ->field("sum(s.value)num,count(1)count,FROM_UNIXTIME(end_time,'%m-%d') days")
            ->whereTime('end_time', '-'.$len.' days')
            ->where('user_id',$id)
            ->leftJoin('subject s','log.subject_id=s.id')
            ->group('days')
            ->select()
            ->toArray();
        $list=[];

        for($i=0;$i<$len;$i++){
            array_push($list,['days'=>date('m-d',strtotime("-".$i." day")),"num"=>0]);
        }
        for($i=0;$i<$len;$i++){
            for($j=0;$j<count($res);$j++){
                if($res[$j]['days']==$list[$i]['days']){
                    $list[$i]['num']=$res[$j]['num'];
                   
                }
            }
        }


        return array_reverse($list);
    }
}