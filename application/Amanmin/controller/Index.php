<?php

namespace app\Amanmin\controller;

use app\admin\model\Computer;
use app\admin\model\File;

class Index extends Base
{
    public function index()
    {



        return view();
    }

    public function test()
    {



        //添加随机订单
        /*for($i=0;$i<300;$i++){
            $order=new Order();
            $order->shop_id=rand(1,5);
            $order->user_id=rand(1,6);
            $order->sn=getSn();
            $order->type=rand(0,3)-1;
            if($order->type==-1){
                $order->paytype=1;
            }else{
                $order->paytype=rand(1,2);
            }
            $order->pay_status=rand(1,3)-1;
            $order->filenum=rand(1,3);

            $order->pay_time=time()-rand(-5000,1000);
            $order->price=rand(100,1000)/100.00;
            $order->papernum=rand(1,30);
            $order->parint_status=rand(1,2);
            $order->computer_id=rand(1,50);
            $order->scomputer_id= $order->computer_id;
            $order->print_id=rand(1,100);
            if(rand(0,1)==1){
                $order->online_status=rand(0,6);
            }else{
                $order->online_status=rand(3,4);
            }
            if(rand(0,10)>2){
                $order->color=0;
            }else{
                $order->color=1;
            }
            $time=strtotime('2019-07-'.rand(1,11).' 00:00:00');
            $time+=rand(1,86400)-1;
            $order->create_time=$time;
            $order->save();

        }*/


        //生成用户
        /*for($i=0;$i<50;$i++){
            $user=new User();
            $time=strtotime('2019-07-'.rand(1,11).' 00:00:00');
            $time+=rand(1,86400)-1;
            $user->openid=md5(getSn());
            $user->create_time=$time;
            $user->nickname="测试用户-".$i;
            $user->city=getRandCity();
            $user->save();
        }*/


        //生成电脑
        /*for($i=0;$i<50;$i++){
            $c=new Computer();
            $time=strtotime('2019-07-'.rand(1,11).' 00:00:00');
            $time+=rand(1,86400)-1;
            $c->shop_id=rand(1,5);
            $c->name=getRandStr();
            $c->os='win10';
            $c->soft='office';
            $c->edition='v1.0.1';

            $c->save();
        }*/
        //生成打印机
       /* for($i=0;$i<200;$i++){
            $c=new Printer();
            $time=strtotime('2019-07-'.rand(1,11).' 00:00:00');
            $time+=rand(1,86400)-1;
            $c->shop_id=rand(1,5);
            $c->name=rand(1111,9999).(rand(0,5)>1?'黑白':'彩色');
            $c->drive='Canon iR-ADV 6075 UFR II';
            $c->color=rand(0,1);
            $c->status=1;
            $c->intercept='1';

            $c->save();
        }*/

       //生成 上传文件
        $order=['20190711135920398114','20190711135920889587','20190711135920674172','20190711135920923699','20190711135920499160','20190711135920565243','20190711135920482434','20190711135920969705','20190711135920957839','20190711135920775604','20190711135920772418','20190711135920629623','20190711135920730422','20190711135920664724','20190711135920661813','20190711135920689086','20190711135920321786','20190711135920301022','20190711135920344143','20190711135920473205','20190711135920465405','20190711135920827349','20190711135920171548','20190711135920815704','20190711135920307806','20190711135920869866','20190711135920364468','20190711135920404733','20190711135920801943','20190711135921727319','20190711135921311514','20190711135921152761','20190711135921324423','20190711135921197860','20190711135921256829','20190711135921967260','20190711135921281796','20190711135921971215','20190711135921240872','20190711135921188192','20190711135921973660','20190711135921718008','20190711135921507647','20190711135921839077','20190711135921212527','20190711135921756488','20190711135921800927','20190711135921528247','2019071113592173'];
        for($i=0;$i<count($order);$i++){
            $o=model('order')->where('sn',$order[$i])->find();
            if($o){
                $o->getnum='G-'.rand(1000,9999);
                $o->page_type=rand(1,2);
                $o->size=rand(1,2);
                $o->layout=1;
                $o->scope=0;
                $o->binding=0;
                $o->save();
                $f=new File();
                $f->sn=$order[$i];
                $f->name='文件'.rand(0,99999).".doc";
                $f->create_time=time();
                $f->save();
            }else{
                echo $order[$i].',';
            }


        }
        return 1;
    }
}
