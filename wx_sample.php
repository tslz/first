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
				{ $contentStr="欢迎访问本公司:\n 1.公司简介 \n 2.业务范围  \n 3.成功案例  \n 4.检查动态";
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
		{ $contentStr="你的地址是经度:".$ltitude."  纬度：".$longitude;
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
		
		if(!empty( $keyword ))//如果用户端微信发来的文本内容不为空，执行46--51否则52--53  
                {  
                    $msgType = "text";//回复文本信息类型为text型，变量类型为msgType  
	          switch($keyword){

                   case "1":
                   $contentStr=" 甘肃恒邦安全管理咨询有限公司成立于2012年3月，注册资金500万元。具备独立法人资格，是专业从事安全评价的第三方安全事务中介机构。
2012年取得安全评价机构资质证书（乙级）（证书号： APJ-(甘)-307  ）。
公司下设评价部、咨询部、业务部、财务部和办公室。公司现有在职员工73人，其中专业技术人员45人。现有国家级安全评价师资格人员26人，其中一级评价师4人，二级评价师10人，三级评价师17人，国家注册安全工程师15人。评价人员高级及以上职称8人，中级职称11人，初级职称13人；安全培训教师11人;职业卫生检测、评价人员23人，安全标准化评>审人员16人。此外，本公司还有一支具有高级工程师以上职称的专家队伍。并拥有安全、化工、开采、机械、冶金、电气等各类专业技术的人员。";
                    break;
                   case "2":
 $contentStr="安全评价、安全检测、安全评估、从业人员资格培训等";
                   break;
                   case "3":
                   $contentStr="自公司成立以来，始终坚持“创新、协作、客观、高效”的经营宗旨和“培育一流技术，打造一流公司”的经营目标；坚持诚信求实、热情服务的>经营风格；公正、客观、依法独立地开展安全评价；注重信誉、大胆创新、科学管理，不断提技术服务水平。通过不断开拓进取，公司现已发展成为具有较强综合实力，技术力量>较为雄厚的大型安全评价企业。";
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
		     	  
//$contentStr="拼搏属于未来，面对新的起点、新的征程，甘肃恒邦安全管理咨询有限公司恰如一只羽翼丰满的雄鹰，展翅翱翔，满怀信心地去迎接前方的机

                    break;
	            default:
                    $contentStr="欢迎访问本公司:\n 1.公司简介 \n 2.业务范围  \n 3.成功案例  \n 4.检查动态";}
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
