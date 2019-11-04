<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\Amanmin\model;


use think\Db;
use think\Model;
use app\Amanmin\validate\Admin as AdminValidate;
use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;
    public function getCount(){
        return $this->belongsToMany('subject','solveLog')->where('end_time','>',0)->order(['end_time'=>'asc']);
    }

    public function getSort($id){

    }
    public function getUserById($id){
        return $this->where('id',$id)->withSum('getCount','value')->find();

    }
    public function stop($id){
        $res= $this->where('id',$id)->find();
        if($res){
            $status=1;
            if($res->status=='1'){
                $status=-1;
            }
            $res->save(['status'=>$status]);
            return 1;

        }else{
            return "用户不存在";
        }
    }

    public function del($id){
        $res= $this->where('id',$id)->find();
        if($res){
            $res->delete();
            return 1;

        }else{
            return "用户不存在";
        }
    }
    public function getList($data,$len=20){
       if($data['order']=='val'){
           $order=['get_count_sum'=>'desc'];
       }else if($data['order']=='reg'){
           $order=['create_time'=>'desc'];
       }else if($data['order']=='login'){
           $order=['update_time'=>'desc'];
       }else{
           $order=['id'=>'desc'];
       }

       if($data['keyword']!=''){
           return $this
               ->withSum('getCount','value')
               ->where('username|nickname|email','like','%'.$data['keyword'].'%')
               ->order($order)
               ->paginate($len);

       }
        return $this->withSum('getCount','value')->order($order)->paginate($len);

    }

    public function getNewUserByWeek(){
        $res= $this
            ->field("count(1)num,FROM_UNIXTIME(create_time,'%m-%d') days")
            ->whereTime('create_time', '-7 days')
            ->group('days')
            ->select();
        $list=[];
        for($i=0;$i<7;$i++){
            $list[]=['days'=>date('m-d',strtotime("-".$i." day")),"num"=>0];
        }
        for($i=0;$i<7;$i++){
            for($j=0;$j<count($res);$j++){
                if($res[$j]['days']==$list[$i]['days']){
                    $list[$i]['num']=$res[$j]['num'];
                    unset($res[$j]);
                    break ;
                }
            }
        }
        return array_reverse($list);
    }


}