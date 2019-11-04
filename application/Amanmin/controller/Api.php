<?php

namespace app\Amanmin\controller;



class Api extends Base
{
    public function testemail(){
        if(request()->isAjax()){
            if(input('email')!=''){
                if (!filter_var(input('email'), FILTER_VALIDATE_EMAIL)) {
                    $this->error('错误的邮箱格式');
                }
                sendMail(input('email'),'测试邮件','如果收到这封邮件说明啥？你说说明啥？');
                $this->success('邮件已发送，10秒没收到那就查看网站日志是什么问题');
            }else{
                $this->error('请输入邮箱');
            }
        }

    }
    public function uploadsoft(){

        $file = request()->file('file');

        if($file){
            $info = $file->validate(['ext'=>'zip,rar,7z'])->move( 'soft');
            if($info){
                $name_path =str_replace('\\',"/",$info->getSaveName());
                $data['soft']='/soft/'.$name_path;
                $data['soft_time']=time();
                $data['softname']=$file->getInfo('name');
                $sys=model('sys')->where('id','1')->find();
                model('sys')->edit($data);
                $a = substr($sys->soft,1);
                @unlink($a);
                $this->success('保存成功');
            }else{
                return $this->error($file->getError());
            }
        }
    }

    public function uploadlogo(){

        $file = request()->file('file');
        if($file){
            $info = $file->validate(['ext'=>'jpg,png,gif,icon'])->move( 'uploads');
            if($info){
                $name_path =str_replace('\\',"/",$info->getSaveName());
                $data['logo']='/uploads/'.$name_path;
                $sys=model('sys')->where('id','1')->find();
                model('sys')->edit($data);
                $a = substr($sys->logo,1);
                @unlink($a);
                $this->success('保存成功');
            }else{
                return $this->error($file->getError());
            }
        }
    }
    public function ly_upload_img()
    {
        $file = request()->file('file');
        $info = $file->validate(['ext'=>'jpg,png,gif,icon,zip,rar,7z'])->move( 'uploads');
        if($info){
            $result['code']=0;
            $result['msg']='上传成功!';
            $name_path =str_replace('\\',"/",$info->getSaveName());
            $result['data']['src']='/uploads/'.$name_path;
            $result['data']['title']=$info->getFilename();

        }else{
            $result['code']=1;
            $result['msg']=$file->getError();

        }
        echo json_encode($result);
    }
    public function ly_del_img(){
        $path='uploads'.getMidStr(input('imgpath').']]]','uploads',']]]');
        @unlink($path);
    }

}
