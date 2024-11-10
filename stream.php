<?php
/**
 * 源码名：dc-aichat
 * 邓草（博客：http://blog.5300.cn） 
 * Github：https://github.com/dengcao/dc-aichat   or   Gitee：https://gitee.com/dengzhenhua/dc-aichat
 */
 
check_fromurl();//检测来路，禁止外部网站连接。
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/event-stream");
header("X-Accel-Buffering: no");
session_start();
$postData = $_SESSION['data'];
$_SESSION['response'] = "";
$ch = curl_init();

$postData_arr=json_decode($postData,true);//转为数组

if($postData_arr["model"]=="glm-4-flash"){
	//智谱AI（GLM-4-Flash），免费
	$my_CURLOPT_URL="https://open.bigmodel.cn/api/paas/v4/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."ee78651fcxxxxx3341980fcd0.AMmxxxxxxTG9s";//API密钥
	}else if($postData_arr["model"]=="general"){
	//讯飞星火（Spark Lite）免费
	$my_CURLOPT_URL="https://spark-api-open.xf-yun.com/v1/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."PYBVxxxxxxxxxzmRAqEg:jHzWxxxxxxxxxFiFQR";//API密钥，APIPassword
	}else if($postData_arr["model"]=="generalv3.5"){
	//讯飞星火（Spark Max）收费
	$my_CURLOPT_URL="https://spark-api-open.xf-yun.com/v1/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."KaRNxxxxxxxxxUU:hAgvAxxxxxxxxxUlM";//API密钥，APIPassword
	}else if($postData_arr["model"]=="ERNIE-Speed-128K"){
	//百度千帆（ERNIE-Speed-128K）免费，目前不可用
	$my_CURLOPT_URL="https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/ernie-speed-128k";//请求地址
	$OPENAI_API_KEY = "authStringPrefix/signedHeaders/signature
bce-auth-v1/giKjaxxxxxxxxxGS9rs/2024-10-11T06:36:08Z/180000000700000/host;x-bce-date/a4181xxxxxxxxxcb5f09629f2546b7ca04";//API密钥，APIPassword
	}else if($postData_arr["model"]=="internlm2.5-latest"){
	//书生浦语大模型（internlm2.5-latest）免费
	$my_CURLOPT_URL="https://internlm-chat.intern-ai.org.cn/puyu/api/v1/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."eyJ0eXBxxxxxxxxxjoiSFM1MTIifQ.eyJqdGkiOixxxxxxxxx3ntUMOp-9811tJxxxxxxxxxHnHDWHw";//API密钥，APIPassword
	}else if($postData_arr["model"]=="moonshot-v1-8k"){
	//Moonshot AI,Kimi.ai（moonshot-v1-8k）
	$my_CURLOPT_URL="https://api.moonshot.cn/v1/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."sk-OQ8hfYYxxxxxxxxxAfOaEpwaDZ9gYj";//API密钥
	}else if($postData_arr["model"]=="ep-20241011220923-btqr7" || $postData_arr["model"]=="ep-20241008224821-kj2sj" || $postData_arr["model"]=="ep-20241011223049-2wmpg" || $postData_arr["model"]=="ep-20241011225913-6t2p2"){
	//豆包AI（doubao-lite-4k等）火山方舟
	$my_CURLOPT_URL="https://ark.cn-beijing.volces.com/api/v3/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."9axxxx84-bxx9-4xx2a-95d8-52xxxxxxxxxb2";//API密钥
	}
	
	
	/*else if($postData_arr["model"]=="Atom-13B-Chat"){
	//Llama Family（Atom-13B-Chat）免费
	$my_CURLOPT_URL="https://api.atomecho.cn/v1/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."sk-7e757ccxxxxxxxxx3163cc";//API密钥，APIPassword
	}else if($postData_arr["model"]=="Atom-7B-Chat"){
	//Llama Family（Atom-7B-Chat）免费
	$my_CURLOPT_URL="https://api.atomecho.cn/v1/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."sk-7e757xxxxxxxxxeac13163cc";//API密钥，APIPassword
	}else if($postData_arr["model"]=="deepseek-ai/DeepSeek-V2-Chat"){
	//Llama Family（deepseek-ai/DeepSeek-V2-Chat）免费
	$my_CURLOPT_URL="https://api.siliconflow.cn/v1/chat/completions";//请求地址
	$OPENAI_API_KEY = "Bearer "."sk-uxwqfubjisgxxxxxxxxxaehynemzlojh";//API密钥，APIPassword
	}*/

if (isset($_SESSION['key'])) {
    $OPENAI_API_KEY = "Bearer ".$_SESSION['key'];
}
$headers  = [
    'Accept: application/json',
    'Content-Type: application/json',
    'Authorization: ' . $OPENAI_API_KEY
];

setcookie("errcode", ""); //EventSource无法获取错误信息，通过cookie传递
setcookie("errmsg", "");

$callback = function ($ch, $data) {
    $complete = json_decode($data);
    if (isset($complete->error)) {
        setcookie("errcode", $complete->error->code);
        setcookie("errmsg", $data);
        if (strpos($complete->error->message, "Rate limit reached") === 0) { //访问频率超限错误返回的code为空，特殊处理一下
            setcookie("errcode", "rate_limit_reached");
        }
        if (strpos($complete->error->message, "Your access was terminated") === 0) { //违规使用，被封禁，特殊处理一下
            setcookie("errcode", "access_terminated");
        }
        if (strpos($complete->error->message, "You didn't provide an API key") === 0) { //未提供API-KEY
            setcookie("errcode", "no_api_key");
        }
        if (strpos($complete->error->message, "You exceeded your current quota") === 0) { //API-KEY余额不足
            setcookie("errcode", "insufficient_quota");
        }
        if (strpos($complete->error->message, "That model is currently overloaded") === 0) { //OpenAI服务器超负荷
            setcookie("errcode", "model_overloaded");
        }
    } else {
        echo $data;
        $_SESSION['response'] .= $data;
    }
    return strlen($data);
};

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_URL, $my_CURLOPT_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_WRITEFUNCTION, $callback);
//curl_setopt($ch, CURLOPT_PROXY, "http://127.0.0.1:1081");

curl_exec($ch);

$answer = "";
if (substr(trim($_SESSION['response']), -6) == "[DONE]") {
    $_SESSION['response'] = substr(trim($_SESSION['response']), 0, -6) . "{";
}
$responsearr = explode("}\n\ndata: {", $_SESSION['response']);

foreach ($responsearr as $msg) {
    $contentarr = json_decode("{" . trim($msg) . "}", true);
    if (isset($contentarr['choices'][0]['delta']['content'])) {
        $answer .= $contentarr['choices'][0]['delta']['content'];
    }
}

/*
$questionarr = json_decode($_SESSION['data'], true);
$filecontent = $_SERVER["REMOTE_ADDR"] . " | " . date("Y-m-d H:i:s") . "\n";
$filecontent .= "Q:" . end($questionarr['messages'])['content'] .  "\nA:" . trim($answer) . "\n----------------\n";
$myfile = fopen(__DIR__ . "/chat.txt", "a") or die("Writing file failed.");
fwrite($myfile, $filecontent);
fclose($myfile);
curl_close($ch);
*/


//检测来路，禁止外部网站连接。
function check_fromurl(){   
  //如果直接从浏览器连接到页面，就拒绝
  //echo   "referer:".$_SERVER['HTTP_REFERER'];   
  if(!isset($_SERVER['HTTP_REFERER']))   {   
  //header("location:/");
  echo "failed";
  exit;   
  }   
  $urlar   =   parse_url($_SERVER['HTTP_REFERER']);   
  //如果页面的域名不是服务器域名,就拒绝
  if($_SERVER['HTTP_HOST']   !=   $urlar["host"]   &&   $urlar["host"]   !=   "202.102.110.204"   &&   $urlar["host"]   !=   "http:$url")   {   
  //header("location:/");
  echo "failed";
  exit;   
  }     
  }