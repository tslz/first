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

$ACC_TOKEN="6-RPZhrI7B-ksJIFlF_Bbj5639nnrNG0OClgF9vUoTSl2iOPk4xpnkWEF2rHcOTAGOk77VHxtupCGlCw09m3DhW_wce-375lny8D_M0JmCsd-7kiXzFCm5WJGDqDgm4FCBEgAAAHGJ";
$data='{
		 "button":[
		 {
			   "name":"微查询",
			   "sub_button":[
				{
				   "type":"view",
				   "name":"安全法律法规",
				   "url":"http://www.chinasafety.gov.cn/newpage/zcfg2016/zcfg2016.htm"
				},
				{
				   "type":"view",
				   "name":"安全生产新闻",
				   "url":"http://www.chinasafety.gov.cn/newpage/xwzx2016/xwzx2016.htm"
				},
				{
				   "type":"view",
				   "name":"资质查询",
				  
				    "url":"http://www.chinasafety.gov.cn/newpage/zwdt2016/cxfw.htm"
				}]
		  },
		  {
			   "name":"微服务",
			   "sub_button":[
				{
				   "type":"view",
				   "name":"安全评价",
				   "url":"http://www.gansuhengbang.com/news.asp?Cla=20"
				},
				{
				   "type":"view",
				   "name":"安全标准化",
				   
				   "url":"http://www.gansuhengbang.com/news.asp?Cla=22"
				   
				},
				{
				   "type":"view",
				   "name":"职业卫生",
				  
				   "url":"http://www.gansuhengbang.com/news.asp?Cla=15"
				},
				{
				   "type":"view",
				   "name":"HAZOP分析",
				  
				    "url":"http://www.gansuhengbang.com/news.asp?Cla=25"
				}]
		   },
		   {
			   "type":"view",
			   "name":"联系我们",
			   "url":"http://www.gansuhengbang.com/about.asp?Cla=18"
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
