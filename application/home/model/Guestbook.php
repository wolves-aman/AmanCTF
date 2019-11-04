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

class Guestbook extends Model
{
    public function getuser(){
        return $this->hasOne('user','id','user_id');
    }
    public function getreply(){
        return $this->hasOne('user','id','reply');
    }
    public function getreply2(){
        return $this->hasOne('admin','id','reply');
    }
    public function getclick(){
        return $this->hasMany('click','gid','id');
    }
    public function getadmin(){
        return $this->hasOne('admin','id','user_id');
    }
    public function getList(){
        return $this
            ->with('getuser')
            ->with('getreply')
            ->with('getreply2')
            ->withCount('getclick')
            ->order(['id'=>'desc'])
            ->select();
    }
    public function reply($id,$content){


        if($content==''){
            return "请输入内容";
        }

        $num=$this
            ->where('user_id',session('user.id'))
            ->whereTime('create_time','>=',(time()-300))
            ->count();
        if($num>10){
            return "您回复过于频繁，请稍后再试";
        }
        if($id==''){
            $new=new Guestbook();
            $new->save([
                'user_id'=>session('user.id'),
                'type'=>'0',
                'ip'=>request()->ip(),
                'content'=>$content
            ]);
            return 1;
        }else{
            $msg=$this->where('id',$id)->find();
            if($msg){
                if($msg['type']=='0' && $msg['user_id']==session('user.id')){
                    return "不能回复自己，二货。作者不让我这么干";
                }
                $new=new Guestbook();
                $new->save([
                    'user_id'=>session('user.id'),
                    'reply'=>$msg['user_id'],
                    'type'=>'0',
                    'ip'=>request()->ip(),
                    'who'=>$msg['type'],
                    'content'=>$content
                ]);
                return 1;
            }else{
                $new=new Guestbook();
                $new->save([
                    'user_id'=>session('user.id'),
                    'type'=>'0',
                    'ip'=>request()->ip(),
                    'content'=>$content
                ]);
                return 1;
            }


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