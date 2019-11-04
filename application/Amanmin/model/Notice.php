<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/11
 * Time: 10:49
 */

namespace app\Amanmin\model;


use think\Model;

class Notice extends Model
{
    public function getNoticeById($id){
        return $this->where('id',$id)->find();
    }
    public function del($id){
        $a=$this->where('id',$id)->find();
        if($a){
            $a->delete();
            return 1;
        }else{
            return "该公告不存在";
        }
    }

    public function getList($data,$len=20){
        $where=[
            ['content','like','%'.$data['keyword'].'%'],
        ];
        return $this
            ->where($where)
            ->order('create_time','desc')
            ->paginate($len);
    }

    public function edit($data){
        $notice=$this->where('id',$data['id'])->find();
        if($notice){
            if($notice->save($data)){
                return 1;
            }else{
                return "保存失败";
            }
        }else{
            return '编辑失败';
        }
    }


    public function add($data){
        $notice=new Notice();
        if($notice->allowField(true)->save($data)){
            return 1;
        }else{
            return '添加失败';
        }
    }

}