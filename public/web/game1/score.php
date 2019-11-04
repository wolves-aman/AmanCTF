<?php 
$score=$_GET["score"]; 
$ip=$_GET["ip"];
$sign=$_GET["sign"];
if($score!="" && $score==base64_decode(substr($sign,2,strlen($sign)-4)) && $score>=3000){
	echo "flag{T0werGetF1a9}";
	
}else{
	
	echo "失败了";
}
?>