<?php
namespace app\null\controller;
use app\home\model\Safelog;
use think\Controller;

class Aman extends Controller
{
    public function initialize()
    {

        $result=amanCheck();
        if($result){
            $warn=new Safelog();
            $warn->addLog($result['type'],$result['info']);

        }

    }
    public function _empty()
    {
        return $this->fetch('index/4042');
    }
    public function index()
    {
		return $this->fetch('index/4042');
    }
	
	
}
