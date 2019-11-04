<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\Amanmin\model;


use think\Model;
use app\Amanmin\validate\Subject as SubjectValidate;

class Subject extends Model
{
    public function user(){
        return $this->hasOne('user','id','first');
    }
    public function type(){
        return $this->hasOne('type','id','type_id');
    }
    public function getCount(){
        return $this->hasMany('solveLog','subject_id','id')->where('end_time',">",0);
    }
    public function add($data){
        $validate=new SubjectValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $obj=new Subject();
        if($obj->allowField(true)->save($data)){
            model('notice')->add([
                'type'=>1,
                'title'=>'上线了新题目',
                'content'=>'上线了'.'<span class="text-default">'.$data['title'].'</span>'.'题目',
            ]);
            return 1;
        }else{
            return '添加失败';
        }
    }
    public function edit($data){
        $validate=new SubjectValidate();
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
    public function del($id){
        $res= $this->where('id',$id)->find();
        if($res){
            $res->delete();
            return 1;

        }else{
            return "数据不存在";
        }
    }
    public function getList($len=20){
        return $this->with('user')
            ->with('type')
            ->withCount('getCount')
            ->paginate($len);

    }

}