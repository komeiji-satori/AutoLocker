<?php
ini_set('date.timezone','Asia/Shanghai');
$device_ip=$argv[1];
$i=is_offline($device_ip);
do{
	is_offline($device_ip);
	sleep(1);
} while ($i);
function is_offline($device_ip){
	exec('ping '.$device_ip.' -n 1 -l 1 -w 2000',$sys);
	$return = $sys[2];
	$return = iconv("gbk","utf-8",$return);
	$stime=explode('=1',$return);
	$ptime=explode('=',$stime[1]);
	if (@$ptime[1]==NULL) {
		$ptime[1]='Error';
	}
	$pre=explode(' ',@$ptime[1]);
	if (strstr($return,'无法')||strstr($return,'请求超时')||strstr($return,'Request timed out')) {
	system('TITLE Device Now is Offline  '.'['.$device_ip.']');
	system('rundll32.exe user32.dll,LockWorkStation');
	echo("[".date('H:i:s')."]".' Device is Offline,Screen Locked'."\n"."[".date('H:i:s',time())."]"." Device IP: ".$device_ip)."\n";

	return true;
	}else{
	system('TITLE Device Now is Online  '.'['.$device_ip.']');
	echo "[".date('H:i:s')."]".' Device Now is online  Delay:'.$pre[0]."\n";
	return true;
	}
}