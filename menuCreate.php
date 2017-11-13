<?php
/**
 * 微信公众平台-自定义菜单功能源代码
 * ================================
 * Copyright 2013-2014 David Tang
 * http://www.cnblogs.com/mchina/
 * 乐思乐享微信论坛
 * http://www.joythink.net/
 * ================================
 * Author:David|唐超
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2013-10-12
 */

header('Content-Type: text/html; charset=UTF-8');

//更换成自己的APPID和APPSECRET
//$APPID="wx84687ae718f0be89";
//$APPSECRET="96xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

//$TOKEN_URL="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$APPID."&secret=".$APPSECRET;

//$json=file_get_contents($TOKEN_URL);
//$result=json_decode($json);

$ACC_TOKEN="NuDPwMamTucIj6Sr-L7k4MwvXjxyTh9tZ8zpgefPkbBhWZcNQBPM2kH1-z2lToi3ta0u8v6p8CQ_J6RogTpM54phLvx21Yi76yOxa-vBNfcnIY0R2ayJ8ix6-crst1B3AUUgADARLL";
$data='{
		 "button":[
		 {
			   "name":"微查询",
			   "sub_button":[
				{
				   "type":"view",
				   "name":"地理位置",
				   "url":"http://j.map.baidu.com/nKJ3H"
				},
				{
				   "type":"view",
				   "name":"经营动态",
				   "url":"http://lanzhouhotel.com/index.asp"
				},
				{
				   "type":"view",
				   "name":"饭店荣誉",
				  "url":"http://lanzhouhotel.com/showmsg.asp?name=%D7%EE%D0%C2%CF%FB%CF%A2&ID=457"
				}]
		  },
		  {
			   "name":"微服务",
			   "sub_button":[
				{
				   "type":"view",
				   "name":"客房服务",
				   "url":"http://lanzhouhotel.com/kffw.asp"
				},
				{
				   "type":"view",
				   "name":"餐饮娱乐",
				    "url":"http://lanzhouhotel.com/cyyl.asp"
				   
				},
				{
				   "type":"view",
				   "name":"会议接待",
				   "url":"http://lanzhouhotel.com/hyjd.asp"
				},
				{
				   "type":"view",
				   "name":"其他服务",
				  "url":"http://lanzhouhotel.com/qtfw.asp"
				}]
		   },
		   {
			   "type":"view",
			   "name":"联系我们",
			   "url":"http://lanzhouhotel.com/lxwm.asp"
		   }]
       }';

$MENU_URL="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$ACC_TOKEN;

$ch = curl_init($MENU_URL);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
$info = curl_exec($ch);
$menu = json_decode($info);
print_r($info);		//创建成功返回：{"errcode":0,"errmsg":"ok"}

if($menu->errcode == "0"){
	echo "菜单创建成功";
}else{
	echo "菜单创建失败";
}

/*$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL, $MENU_URL); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

$info = curl_exec($ch);

if (curl_errno($ch)) {
	echo 'Errno'.curl_error($ch);
}

curl_close($ch);

var_dump($info);*/

?>
