<?php  
/** 
  * wechat php test 
  */  
  
//define your token  
define("TOKEN", "xgyjb");  
$wechatObj = new wechatCallbackapiTest();//将11行的class类实例化  
//$wechatObj->valid();//使用-》访问类中valid方法，用来验证开发模式  
//11--23行代码为签名及接口验证。
$wechatObj->responseMsg();
class wechatCallbackapiTest  
{  
    public function valid()//验证接口的方法  
    {  
        $echoStr = $_GET["echostr"];//从微信用户端获取一个随机字符赋予变量echostr  
  
        //valid signature , option访问地61行的checkSignature签名验证方法，如果签名一致，输出变量echostr，完整验证配置接口的操作  
        if($this->checkSignature()){  
            echo $echoStr;  
            exit;  
        }  
    }  
    //公有的responseMsg的方法，是我们回复微信的关键。以后的章节修改代码就是修改这个。  
    public function responseMsg()  
    {  
        //get post data, May be due to the different environments  
       // $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//将用户端放松的数据保存到变量postStr中，由于微信端发送的都是xml，使用postStr无法解析，故使用$GLOBALS["HTTP_RAW_POST_DATA"]获取  
   $postStr = file_get_contents("php://input");
        //extract post data如果用户端数据不为空，执行30-55否则56-58  
        if (!empty($postStr)){  
                  
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//将postStr变量进行解析并赋予变量postObj。simplexml_load_string（）函数是php中一个解析XML的函数，SimpleXMLElement为新对象的类，LIBXML_NOCDATA表示将CDATA设置为文本节点，CDATA标签中的文本XML不进行解析  
                $fromUsername = $postObj->FromUserName;//将微信用户端的用户名赋予变量FromUserName  
                $toUsername = $postObj->ToUserName;//将你的微信公众账号ID赋予变量ToUserName
		$type=  $postObj->MsgType;
	$CustomType= $postObj->Event;
		$ltitude=$postObj->Location_X;
		$longitude=$postObj->Location_Y;
		$MediaId= $postObj->MediaId;
                $keyword = trim($postObj->Content);//将用户微信发来的文本内容去掉空格后赋予变量keyword  
                $time = time();//将系统时间赋予变量time  
                //构建XML格式的文本赋予变量textTpl，注意XML格式为微信内容固定格式，详见文档  
                $textTpl = "<xml>  
                            <ToUserName><![CDATA[%s]]></ToUserName>  
                            <FromUserName><![CDATA[%s]]></FromUserName>  
                            <CreateTime>%s</CreateTime>  
                            <MsgType><![CDATA[%s]]></MsgType>  
                            <Content><![CDATA[%s]]></Content>  
                            <FuncFlag>0</FuncFlag>  
                            </xml>";  
                            //39行，%s表示要转换成字符的数据类型，CDATA表示不转义  
                            //40行为微信来源方  
                            //41行为系统时间  
                            //42行为回复微信的信息类型  
                            //43行为回复微信的内容  
                            //44行为是否星标微信  
                            //XML格式文本结束符号  
		file_put_contents("log.txt", $type.$CustomType.$keyword."/n", FILE_APPEND);

	      if    ($type=="event" and   $CustomType=="subscribe")
				{ $contentStr="欢迎访问本饭店:\n 1.饭店简介 \n 2.业务范围  \n 3.饭店荣誉  \n 4.特色产品  \n 5.饭店全景";
				 $msgType = "text";//回复文本信息类型为text型，变量类型为msgType

                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                    echo $resultStr;
				}
	     elseif    ($type=="event" and   $CustomType=="unsubscribe")
		{ $contentStr="欢迎关注本公司";
		 $msgType = "text";//回复文本信息类型为text型，变量类型为msgType 
		 $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                 echo $resultStr;} 
	     elseif          ($type=="location" )
		{ $contentStr="你的地址是经度:".$longitude."  纬度：".$ltitude;
		 $msgType = "text";//回复文本信息类型为text型，变量类型为msgType 
		 $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数
                 echo $resultStr;} 
	     elseif          ($type=="voice")
		{        $voicetpl="<xml><ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                             <CreateTime>%s</CreateTime>
                             <MsgType><![CDATA[voice]]></MsgType>
                             <Voice>
                             <MediaId><![CDATA[PY857WVKrnlvwj41gFTwurj_hLCZhqB5Gl7N3ks4k9zOZCJP28Ucw1Y_7sX8HH-4]]></MediaId>
                             </Voice>
                               </xml>";
	         $msgType = "voice";//回复文本信息类型为text型，变量类型为msgType 
		 $resultStr = sprintf( $voicetpl, $fromUsername, $toUsername, $time, $msgType);//将XML格式中的变量分别赋值。注意sprintf函数
                 echo $resultStr;} 
		 elseif        ($type=="video")
		 {       $videotpl="<xml><ToUserName><![CDATA[%s]]></ToUserName>
                                    <FromUserName><![CDATA[%s]]></FromUserName>
                                    <CreateTime>%s</CreateTime>
                                    <MsgType><![CDATA[%s]]></MsgType>
                                    <Video>
                                   <MediaId><![CDATA[I3g8191JIkJrdSo1j3AX2MRY0zGCgKQlBebosZlwT3PhFaieWH6C2T9Hu2B_7S-j]]></MediaId>
                                   <Title><![CDATA[test]]></Title>
                                   <Description><![CDATA[first video]]></Description>
                                   </Video>
                                   </xml>";
                               $msgType = "video";//回复文本信息类型为text型，变量类型为msgType 
                       $resultStr = sprintf( $videotpl, $fromUsername, $toUsername, $time, $msgType);//将XML格式中的变量分别赋值。注意sprintf函数
                        echo $resultStr;} 
	      if(!empty( $keyword ))//如果用户端微信发来的文本内容不为空，执行46--51否则52--53  
                {  
                    $msgType = "text";//回复文本信息类型为text型，变量类型为msgType  
	          switch($keyword){

                   case "1":
                   $contentStr="兰州饭店座落于古丝绸之路重镇的甘肃省兰州市之繁华地段，南向火车站仅千米之距，西紧邻民航售票处，位置优越，交通十分便利。兰州饭店于1956年元月开业，隶属甘肃省人民政府办公厅和省机关事务管理局，是中国旅游饭店协会的首批会员。建店以来，一直是甘肃省内外交际、重大会议和政务活动的主要场所，一大批党和国家领导人以及国宾如邓小平、彭德怀、贺龙、陈毅、班禪、习仲勋以及缅甸总理吴觉迎和大批外国专家在这里下塌；梅兰芳、常香玉等名人也曾驻足兰州饭店并留下了墨宝。开业当天，省政府就在这里设宴外国专家，同年八月，贺龙元帅在中八楼会议室亲自为西北军的将领授衔，并举行宴会，盛况空前。
    兰州饭店建筑面积五万多平方米，服务配套，设施齐全,2006年12月被批准为四星级涉外旅游饭店。现有三幢客楼，共有客房419间，其中商务房50间，行政房28间，标准间340间，行政豪华房1间；配有大、中、小各类会议室近16个；贵宾室、各式豪华宴会厅、餐厅餐位近2000个，可为宾客提供各式宴席。另有商务中心电话、传真直通世界各地，还设信用卡支付、卫星电视、棋牌室、美容美发等服务项目，成为集吃、住、行、游、购、乐、会议为一体的多功能饭店。 
    兰州饭店建筑庄严古朴，院内绿树成荫，环境幽雅，得到了社会各界的赞誉。许多领导和宾客为饭店留下了宝贵的题词，被誉为陇上第一店。";
                    break;
                   case "2":
 $contentStr="客房服务、餐饮娱乐、会议接待、机票代理、特色产品销售等";
                   break;
                   case "3":
                   $contentStr="中国餐饮三十年卓越企业奖、中国十佳度假服务酒店";
                    break;
                    case "4":
                      $imgTpl = "<xml>  
                            <ToUserName><![CDATA[%s]]></ToUserName>  
                            <FromUserName><![CDATA[%s]]></FromUserName>  
                            <CreateTime>%s</CreateTime>  
                            <MsgType><![CDATA[image]]></MsgType> 
			     <Image>
			     <MediaId><![CDATA[94CRNEvYQYtXVUwp6MWcIvKyIgaer-YMDXK44ql4wpdGbU0Rfyu2_FKGVzsBvDQQ]]></MediaId>
                           //<MediaId><![CDATA[PLpMRxLFgj97iNtvwRHbrUyPwqGzv1awifeJqPkrb5mlvLgxjqQLNFfJj-ujTnGH]]></MediaId>
                           </Image>
		// <PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz_jpg/T5tu8teC8dA7SBxbkia9prN7SnSsuTTibTlffudqnKZzE2ATbUO8d4qXpUexKJKjibNicuj7U9Lic8o7Gibvc6q37ibKg/0]]></PicUrl> 
                           <FuncFlag>0</FuncFlag>  
                            </xml>";  
				
				$resultStr = sprintf($imgTpl, $fromUsername, $toUsername, $time);//将XML格式中的变量分别赋值。注意sprintf函数  
                    echo $resultStr;  
		     	  
           //$contentStr="拼搏属于未来，面对新的起点、新的征程，展翅翱翔，满怀信心地去迎接前方的机

                    break;
	           case "5":
		   $imgTpl = "<xml>  
                            <ToUserName><![CDATA[%s]]></ToUserName>  
                            <FromUserName><![CDATA[%s]]></FromUserName>  
			    <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
                            <ArticleCount>2</ArticleCount>
                            <Articles>
                            <item>
                            <Title><![CDATA[兰州饭店夜景]]></Title> 
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>
			    <item>
                            <Title><![CDATA[兰州饭店全景]]></Title> 
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>
                            </Articles>
                             </xml>";  
			    $description1=" 兰州饭店建筑庄严古朴，院内绿树成荫，环境幽雅，得到了社会各界的赞誉。许多领导和宾客为饭店留下了宝贵的题词，被誉为“陇上第一店”。";
		            $PicUrl1="http://two-twoapp.a3c1.starter-us-west-1.openshiftapps.com/lzfd1.jpg";
			    $url1="http://lanzhouhotel.com/bggk.asp";
			    $description2="我们将以美味的佳肴、整洁舒适的住宿、快捷方便的通讯、温馨热情的微笑和周到细致的服务恭候您的光临。";
		             $PicUrl2="http://two-twoapp.a3c1.starter-us-west-1.openshiftapps.com/lzfd2.jpg";
			    $url2="http://lanzhouhotel.com/index.asp";
			    $resultStr = sprintf($imgTpl, $fromUsername, $toUsername, $time,$description1,$PicUrl1,$url1, $description2, $PicUrl2,$url2);//将XML格式中的变量分别赋值。注意sprintf函数  
                    echo $resultStr;  
			 break;	  
	            default:
                    $contentStr="欢迎访问本饭店:\n 1.饭店简介 \n 2.业务范围  \n 3.饭店荣誉  \n 4.特色产品  \n 5.饭店全景";}
                   // $contentStr = "Welcome to wechat world!";//我们进行文本输入的内容，变量名为contentStr，如果你要更改回复信息，就在这儿  
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//将XML格式中的变量分别赋值。注意sprintf函数  
                    echo $resultStr;//输出回复信息，即发送微信  
                }else{  
                    echo "Input something...";//不发送到微信端，只是测试使用  
                }  
  
        }else {  
            echo "";//回复为空，无意义，调试用  
            exit;  
        }  
    }  
    //签名验证程序    ，checkSignature被18行调用。官方加密、校验流程：将token，timestamp，nonce这三个参数进行字典序排序，然后将这三个参数字符串拼接成一个字符串惊喜shal加密，开发者获得加密后的字符串可以与signature对比，表示该请求来源于微信。  
    private function checkSignature()  
    {  
        $signature = $_GET["signature"];//从用户端获取签名赋予变量signature  
        $timestamp = $_GET["timestamp"];//从用户端获取时间戳赋予变量timestamp  
        $nonce = $_GET["nonce"];    //从用户端获取随机数赋予变量nonce  
                  
        $token = TOKEN;//将常量token赋予变量token  
        $tmpArr = array($token, $timestamp, $nonce);//简历数组变量tmpArr  
        sort($tmpArr, SORT_STRING);//新建排序  
        $tmpStr = implode( $tmpArr );//字典排序  
        $tmpStr = sha1( $tmpStr );//shal加密  
        //tmpStr与signature值相同，返回真，否则返回假  
        if( $tmpStr == $signature ){  
            return true;  
        }else{  
            return false;  
        }  
    }  
} 
  
?>  
