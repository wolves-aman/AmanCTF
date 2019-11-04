<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use mail\PHPMailer;
use mailer\SMTP;
//发送邮件

/**
 * @param $toemail
 * @param $title
 * @param $content
 * @return int|string
 * @throws \mail\Exception
*/
function sendMail($toemail, $title, $content){
    $sys=cache('sysinfo');
    if(!$sys){
        $sys=model('sys')->getSysInfo();
        cache('sysinfo',$sys,1800);
    }
    $mail = new PHPMailer();
    $mail->isSMTP();// 使用SMTP服务
    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
    $mail->Host = "smtp.qq.com";// 发送方的SMTP服务器地址
    $mail->SMTPAuth = true;// 是否使用身份验证
    $mail->Username = $sys['email_username'];// 发送方的163邮箱用户名，就是你申请163的SMTP服务使用的163邮箱</span><span style="color:#333333;">
    $mail->Password = $sys['email_password'];// 发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”而不是邮箱的登录密码！</span><span style="color:#333333;">
    $mail->SMTPSecure = "ssl";// 使用ssl协议方式</span><span style="color:#333333;">
    $mail->Port = 465;// 163邮箱的ssl协议方式端口号是465/994
    $mail->setFrom($sys['email_username'],$sys['webtitle']);// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
    if(is_array($toemail)){
        foreach ($toemail as $v){
            $mail->addAddress($v);
        }
    }else{
        $mail->addAddress($toemail);
    }

    $mail->addReplyTo($sys['email_username'],"Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
    $mail->Subject = $title;// 邮件标题
    $mail->Body = $content;// 邮件正文
    //$mail->SMTPDebug = 2;
    //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用
    if(!$mail->send()){// 发送邮件
        addSyslog('邮件','发送',$mail->ErrorInfo);
        return $mail->ErrorInfo;
    }else{
        return 1;
    }
}

function getLogData($str,$len=100){
    $str=htmlspecialchars($str);
    if(strlen($str)>200){
        $str=substr($str ,0,$len)."....";
    }else{
        $str=substr($str ,0,$len);
    }
    return preg_replace("/\"password\":\".*?\"/","\"password\":\"******\"",$str);
}

//入侵检测
function amanCheck()
{

    $url =request()->url(); //获取url来进行检测
    if(preg_match("/admin/i", $url)  &&   !preg_match("/\.(jpg|css|js|png|gif|ico)$/i", $url)){
        return ['type'=>1,'info'=>'试图寻找后台'];
    }
    $data = file_get_contents('php://input'); //获取post的data，无论是否是mutipart
    $result=filter_attack_keyword(urldecode(filter_0x25($url))); //对URL进行检测，出现问题则拦截并记录
    if($result)
        return $result;
    $result=filter_attack_keyword(urldecode(filter_0x25($data))); //对POST的内容进行检测，出现问题拦截并记录
    if($result)
        return $result;

    if(preg_match("/\.(rar|php|zip|sql|asp|bak|git|swm|swl|tar|gz)/i", $url)){
        return ['type'=>1,'info'=>'爆破敏感文件'];
    }
    //检测请求方式，除了get和post之外拦截下来并写日志。
    if($_SERVER['REQUEST_METHOD'] != 'POST' && $_SERVER['REQUEST_METHOD'] != 'GET'){
        return ['type'=>0,'info'=>'可疑的访问方式'];
    }
    return false;
}




/*
检测网站程序存在二次编码绕过漏洞造成的%25绕过，此处是循环将%25替换成%，直至不存在%25
*/
function filter_0x25($str){
    if(strpos($str,"%25") !== false){
        $str = str_replace("%25", "%", $str);
        return filter_0x25($str);
    }else{
        return $str;
    }
}

/*
攻击关键字检测，此处由于之前将特殊字符替换成空格，即使存在绕过特性也绕不过正则的
*/
function filter_attack_keyword($str){
    if(preg_match("/[^a-zA-Z](select|and|or|create|union|insert|update|drop|delete|dumpfile|outfile|load_file|floor\(|extractvalue|updatexml|multipoint)/i", $str)){
        return ['type'=>2,'info'=>'检测到攻击关键词'];
    }
    if(preg_match("/\'|\/\*|\.\.\/|\.\/\(/i", $str)){
        return ['type'=>2,'info'=>'检测到敏感符号'];
    }
    if(preg_match("/\<input|\<script|alert|\<frame|error=|<img|onload|cookie|javascript|expression\(/i", $str)){
        return ['type'=>1,'info'=>'检测到XSS攻击'];
    }
    if(substr_count($str,$_SERVER['PHP_SELF']) < 2){
        $tmp = str_replace($_SERVER['PHP_SELF'], "", $str);
        if(preg_match("/\.\.|.*\.php[35]{0,1}/i", $tmp)){
            return ['type'=>2,'info'=>'LFI/LFR'];
        }
    }else{
        return ['type'=>2,'info'=>'LFI/LFR'];
    }
    if(preg_match("/base64_decode|eval\(|assert\(/i", $str)){
        return ['type'=>2,'info'=>'EXEC'];
    }

}


function addSyslog($title,$type,$res){
    if($type=="edit"){
        $type="编辑";
    }else if($type=='add'){
        $type="添加";
    }else if($type=='del'){
        $type="删除";
    }
    if($res==1){
        $data=[
            'usertype'=>2,
            'uid'=>session('admin.id'),
            'type'=>$type.$title,
            'info'=>$type."成功",
            'result'=>1,
        ];
        model('syslog')->addLog($data);
    }else{
        $data=[
            'usertype'=>2,
            'uid'=>session('admin.id'),
            'type'=>$type.$title,
            'info'=>$res,
            'result'=>0,
        ];
        model('syslog')->addLog($data);
    }
}

function checkLink($url,$mydomain,$timeout=5){
    if (!isset($url) || empty($url)) {
        return -1;
    }
    if (!isset($mydomain) || empty($mydomain)) {
        return -2;
    }
    $resultContent = my_file_get_contents($url,$timeout);
    if (trim($resultContent) == '') {
        return -3;
    }

    if (strripos($resultContent, $mydomain)) {
        return 1;
    } else {
        return 0;
    }
}
function my_file_get_contents($url, $timeout = 5) {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $file_contents = curl_exec($ch);
        curl_close($ch);
    } else if (ini_get('allow_url_fopen') == 1 || strtolower(ini_get('allow_url_fopen')) == 'on') {
        $file_contents = @file_get_contents($url);
    } else {
        $file_contents = '';
    }
    return $file_contents;
}

function getUserSort($uid){
    $order=['get_count_sum'=>'desc'];
    $res=cache('usersort'.$uid);
    if(!$res){
        $res=model('user')
            ->withSum('getCount','value')
            ->order($order)
            ->limit(999)
            ->select()
            ->toArray();
        cache('usersort'.$uid,$res,600);
    }

    for($i=0;count($res);$i++){
        if($res[$i]['id']==$uid)
            return $i+1;
    }
    return "999+";
}

//获取时间间隔
function timediff( $begin_time, $end_time )
{
    if ($begin_time < $end_time) {
        $starttime = $begin_time;
        $endtime = $end_time;
    } else {
        $starttime = $end_time;
        $endtime = $begin_time;
    }
    $timediff = $endtime - $starttime;
    $days = intval($timediff / 86400);
    $remain = $timediff % 86400;
    $hours = intval($remain / 3600);
    $remain = $remain % 3600;
    $mins = intval($remain / 60);
    $secs = $remain % 60;
    $str="";
    if($days>0)
        $str.=$days."天";
    if($hours>0)
        $str.=$hours."时";
    if($mins>0)
        $str.=$mins."分";
     $str.=$secs."秒";
     return $str;
}

function getTypeByID($id){
    $list=cache('ctflist');
    if(!$list){
        $list=model('type')->getCtfList();
        cache('ctflist',$list,60);
    }
    for($i=0;$i<count($list);$i++){
        if($list[$i]['id']==$id){
            return $list[$i];
        }
    }
    return false;
}

//清理无效的session缓存
function clearSession(){
    $path=session_save_path();
    $files=scandir($path);
    for($i=0;$i<count($files);$i++){
        if($files[$i]=='.' || $files[$i]=='..'){
            continue;
        }
        //加上@ 防止删除正在使用的session文件时报错
        //@unlink($path."/".$files[$i]);
    }
}
//判断用户时候在线
function isOnline($session){
   /* if(!$session)
        return false;
    $path=session_save_path();
    return file_exists($path."/sess_".$session);*/
   $str=strtotime($session);
   return ((time()-$str)<300);

}


//获取浏览器类型
function getBrowser($agent){
    if( (false == strpos($agent,'MSIE')) && (strpos($agent, 'Trident')!==FALSE) ){
        return '/static/img/browser/ie.png';
    }else if(false!==strpos($agent,'MSIE 10.0')){
        return '/static/img/browser/ie.png';
    }else if(false!==strpos($agent,'MSIE 9.0')){
        return '/static/img/browser/ie.png';
    }else if(false!==strpos($agent,'MSIE 8.0')){
        return '/static/img/browser/ie.png';
    }else if(false!==strpos($agent,'MSIE 7.0')){
        return '/static/img/browser/ie.png';
    }else if(false!==strpos($agent,'MSIE 6.0')){
        return '/static/img/browser/ie.png';
    }else if(false!==strpos($agent,'Edge')){
        return '/static/img/browser/edge.png';
    }else if(false!==strpos($agent,'Firefox')){
        return '/static/img/browser/firefox.png';
    }else if(false!==strpos($agent,'Chrome')){
        return '/static/img/browser/chrome.png';
    }else if(false!==strpos($agent,'Safari')){
        return '/static/img/browser/safari.png';
    }else if(false!==strpos($agent,'Opera')){
        return '/static/img/browser/opera.png';
    }else if(false!==strpos($agent,'360SE')){
        return '/static/img/browser/360.ico';
    }else  if(false!==strpos($agent,'MicroMessage')){
        return '/static/img/browser/MicroMessage.png';
    }else{
        return "/static/img/browser/null.png";
    }
}

//获取系统类型
function getOs($agent){
    $os = false;
    if (preg_match('/win/i', $agent) && strpos($agent, '95'))
        $os = 'Windows 95';
    else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))
        $os = 'Windows ME';
    else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))
        $os = 'Windows 98';
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent))
        $os = 'Windows Vista';
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent))
        $os = 'Windows 7';
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent))
        $os = 'Windows 8';
    else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent))
        $os = 'Windows 10';#添加win10判断
    else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent))
        $os = 'Windows XP';
    else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent))
        $os = 'Windows 2000';
    else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent))
        $os = 'Windows NT';
    else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent))
        $os = 'Windows 32';
    else if (preg_match('/linux/i', $agent))
        $os = 'Linux';
    else if (preg_match('/unix/i', $agent))
        $os = 'Unix';
    else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent))
        $os = 'SunOS';
    else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent))
        $os = 'IBM OS/2';
    else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent))
        $os = 'Macintosh';
    else if (preg_match('/PowerPC/i', $agent))
        $os = 'PowerPC';
    else if (preg_match('/AIX/i', $agent))
        $os = 'AIX';
    else if (preg_match('/HPUX/i', $agent))
        $os = 'HPUX';
    else if (preg_match('/NetBSD/i', $agent))
        $os = 'NetBSD';
    else if (preg_match('/BSD/i', $agent))
        $os = 'BSD';
    else if (preg_match('/OSF1/i', $agent))
        $os = 'OSF1';
    else if (preg_match('/IRIX/i', $agent))
        $os = 'IRIX';
    else if (preg_match('/FreeBSD/i', $agent))
        $os = 'FreeBSD';
    else if (preg_match('/teleport/i', $agent))
        $os = 'teleport';
    else if (preg_match('/flashget/i', $agent))
        $os = 'flashget';
    else if (preg_match('/webzip/i', $agent))
        $os = 'webzip';
    else if (preg_match('/offline/i', $agent))
        $os = 'offline';
    else
        $os = '未知';
    return $os;
}



function getCity()
{
    $ip = request()->server()["REMOTE_ADDR"];
    $url = "https://api.map.baidu.com/location/ip?ak=s5mH7GofLFW9ET9Et86hKxoRZWOgBuYG&ip=" . $ip;
    $ip = json_decode(file_get_contents($url), true);
    return str_replace('市', '', $ip['content']['address_detail']['city']);
}

function getMysqlVer()
{
    $v = model('sys')->query("select VERSION() as ver");
    return $v[0]['ver'];

}

function getMidStr($str, $leftStr, $rightStr)
{
    $left = strpos($str, $leftStr);
    $right = strpos($str, $rightStr, $left);
    if ($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
}