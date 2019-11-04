<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/31
 * Time: 10:01
 */

namespace app\Amanmin\model;


use think\Model;
use app\Amanmin\validate\Tools as ToolsValidate;
class Tools extends Model
{
    public function getType(){
        return $this->hasOne('type','id','type');
    }
    public function getList($data,$len=20){
        if($data['keyword']!=''){
            return $this
                ->with('getType')
                ->where('title|des','like','%'.$data['keyword'].'%')
                ->paginate($len);

        }
        return $this->with('getType') ->paginate($len);

    }

    public function edit($data){


        $validate=new ToolsValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $file = request()->file('file');
        if($file){
            $info = $file->validate(['ext'=>'jpg,png,gif,icon'])->move( 'uploads');
            if($info){
                $name_path =str_replace('\\',"/",$info->getSaveName());
                $data['img']='/uploads/'.$name_path;

            }else{
                return $file->getError();
            }
        }

        $link=$this->where('id',$data['id'])->find();
        if($link){
            if(isset($data['img'])){
                $a = substr($link->img,1);
                @unlink($a);
            }
            if($link->save($data)){
                return 1;
            }else{
                return "保存失败";
            }
        }else{
            return '数据不存在';
        }
    }

    public function add($data){

        if(!$data['footurl'] && $data['footurl']==''){
            $data['footurl']= request()->server()['REQUEST_SCHEME']."://".request()->header()['host'];
        }
        $validate=new ToolsValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }

        $file = request()->file('file');
        if(!$file){
            return "请上传图片";
        }
        $info = $file->validate(['ext'=>'jpg,png,gif,icon'])->move( 'uploads');
        if($info){
            $name_path =str_replace('\\',"/",$info->getSaveName());
            $data['img']='/uploads/'.$name_path;
        }else{
            return $file->getError();
        }

        $link=new Tools();
        if($link->allowField(true)->save($data)){
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