<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2019/10/8
 * Time: 13:47
 */

namespace app\home\model;


use think\Model;
use think\model\concern\SoftDelete;
use app\home\validate\User as UserValidate;


class User extends Model
{
    use SoftDelete;
    protected $dateFormat = 'Y-m-d';
    public function getCount(){
        return $this->belongsToMany('subject','solveLog')->where('end_time','>',0)->order(['end_time'=>'asc']);
    }
    public function etime(){
        return $this->hasOne('solveLog','user_id','id')->order(['end_time'=>'asc']);
    }

    public function getUserById($id){
        return $this->where('status','1')->where('id',$id)->withSum('getCount','value')->find();

    }

    public function getSortList($len=15){
        $order=['get_count_sum'=>'desc','end_time'=>'asc'];
        $num=model('solveLog')->count();
        if($num>0){
            $res=$this
                ->with('etime')
                ->withSum('getCount','value')
                ->withCount('getCount')
                ->where('status','1')
                ->order($order)
                ->limit($len)
                ->select();
        }else{
            $res=[];
        }

        return $res;
    }

    //登录校验
    public function login($data){
        $validate = new UserValidate();
        if(!$validate->scene('login')->check($data)){
            $data=[
                'usertype'=>0,
                'type'=>"用户登录",
                'info'=>$validate->getError(),
                'result'=>0
            ];
            model('syslog')->addLog($data);
            return $validate->getError();
        }
        $data['password']=md5($data['password']);
        $result=$this->where($data)->find();
        if($result){
            if($result->status==0){
                $data=[
                    'usertype'=>1,
                    'uid'=>$result['id'],
                    'type'=>"用户登录",
                    'info'=>"账号尚未激活",
                    'result'=>0
                ];
                model('syslog')->addLog($data);
                return "该账号尚未激活";
            }
            if($result->status==-1){
                $data=[
                    'usertype'=>1,
                    'uid'=>$result['id'],
                    'type'=>"用户登录",
                    'info'=>"账号已被禁用",
                    'result'=>0
                ];
                model('syslog')->addLog($data);
                return "该账号已被禁用";
            }
            $result->update_ip= request()->ip();
            $result->token=session_id();
            $result->update_time=time();
            if($result->save()){
                $data=[
                    'usertype'=>1,
                    'uid'=>$result['id'],
                    'type'=>"用户登录",
                    'info'=>"登录成功",
                    'result'=>1
                ];
                model('syslog')->addLog($data);
                $this->updateUserSession($result);
                return 1;
            }else{
                $data=[
                    'usertype'=>1,
                    'uid'=>$result['id'],
                    'type'=>"用户登录",
                    'info'=>"系统出错",
                    'result'=>0
                ];
                model('syslog')->addLog($data);
                return '系统出错';
            }

        }else{
            $data=[
                'usertype'=>0,
                'type'=>"用户登录",
                'info'=>"账号或密码错误",
                'result'=>0
            ];
            model('syslog')->addLog($data);
            return '账号或密码错误';
        }
    }

    public function add($data){
        $validate = new UserValidate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        unset($data['repassword']);
        $data['password']=md5($data['password']);
        $data['update_ip']=request()->ip();
        $data['cover']='/heads/hover.png';
        $data['nickname']='用户'.$data['username'];
        $data['token']=md5(time()."aman".session_id());
        $sys=cache('sysinfo');
        if(!$sys){
            $sys=model('sys')->getSysInfo();
            cache('sysinfo',$sys,1800);
        }
        if($sys['email']=='1'){
            $data['status']=0;
            sendMail( $data['email'],$sys['title'],"您好！您已经注册成功，请点击一下链接进行账号激活：". request()->server()['REQUEST_SCHEME']."://".request()->header()['host']."/home/reg/action?token=".$data['token']);
        }else{
            $data['status']=1;
        }
        $result=$this->allowField(true)->save($data);
        if($result){
            if($sys['email']=='1'){
                return 2;
            }else{
                return 1;
            }

        }else{
            return '注册失败';
        }
    }

    public function sendEmailById($id,$title,$content){
        $result=$this->where('id',$id)->find();

        if($result && $result->sendemail==1){

            sendMail( $result['email'],$title,$content);
        }
    }

    //注册激活
    public function action($token){
        $result=$this->where(['token'=>$token,'status'=>0])->find();
        if($result){
            $result->status=1;
            $result->save();
            return true;
        }else{
            return false;
        }
    }

    function updateUserSession($result){
        $result=$result->toArray();
        session('user',$result);
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
        return $this->where('status','1')->withSum('getCount','value')->order($order)->paginate($len);

    }
    //保存用户个人信息
    public function saveinfo($data){
        $validate = new UserValidate();
        $data['id']=session('user.id');
        if(!$validate->scene('info')->check($data)){
            return $validate->getError();
        }

        $result=$this->where(['id'=>session('user.id')])->find();
        //根据session查找用户，不存在可能是非法入侵，返回错误信息，并记录入侵行为（未完成）。

        if($result){
            //使用tp自带函数过滤掉无效字段并保存。
            if($result->allowField(true)->save($data)){
                //保存成功更新session
                $this->updateUserSession($result);
                return 1;
            }else{
                return 1;
            }

        }else{
            return "保存失败[code:1000]";
            $warn=new Safelog();
            $warn->addLog('0','异常的SESSION');
        }
    }
}