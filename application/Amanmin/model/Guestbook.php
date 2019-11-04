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
    public function getList($len=20){
        return $this
            ->with('getuser')
            ->with('getreply')
            ->with('getreply2')
            ->withCount('getclick')
            ->paginate($len);
    }
    public function reply($data){
        $msg=$this->where('id',$data['id'])->find();
        if(!$msg){
            return "数据不存在";
        }
        if($msg['type']=='1' && $msg['user_id']==session('admin.id')){
            return "不能回复自己，二货。作者不让我这么干";
        }
        $new=new Guestbook();
        $new->save([
            'user_id'=>session('admin.id'),
            'reply'=>$msg['user_id'],
            'type'=>'1',
            'ip'=>request()->ip(),
            'who'=>$msg['type'],
            'content'=>$data['content']
        ]);
        return 1;
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