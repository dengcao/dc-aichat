<?php
/**
 * 源码名：dc-aichat
 * 邓草（博客：http://blog.5300.cn） 
 * Github：https://github.com/dengcao/dc-aichat   or   Gitee：https://gitee.com/dengzhenhua/dc-aichat
 */
 
$context = json_decode($_POST['context'] ?: "[]") ?: [];
$model_type=trim($_POST['model_type']);
if(!$model_type){
	$model_type="glm-4-flash";//模型编码。默认：智谱AI（GLM-4-Flash）
	}
$postData = [
    "model" => $model_type,//模型编码。
    "temperature" => 0,
    "stream" => true,
    "messages" => [],
];
if (!empty($context)) {
    $context = array_slice($context, -5);
    foreach ($context as $message) {
        $postData['messages'][] = ['role' => 'user', 'content' => str_replace("\n", "\\n", $message[0])];
        $postData['messages'][] = ['role' => 'assistant', 'content' => str_replace("\n", "\\n", $message[1])];
    }
}
$postData['messages'][] = ['role' => 'user', 'content' => $_POST['message']];
$postData = json_encode($postData);
session_start();
$_SESSION['data'] = $postData;
if ((isset($_POST['key'])) && (!empty($_POST['key']))) {
    $_SESSION['key'] = $_POST['key'];
}
echo '{"success":true}';
