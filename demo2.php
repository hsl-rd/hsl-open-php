<?php
header('Content-Type:application/json; charset=utf-8');

/**
 * 接受推送，验证流程
 */
require_once './vendor/autoload.php'; // 加载自动加载文件

$postData = file_get_contents("php://input");
$postData = json_decode($postData, true);

$headers = getAllHeaders();
$token = $headers['Access-Token'] ?? '';
$messageUuid = $headers['Messageuuid'] ?? '';

use Hsl\Open\Open;

$hslOpen = new Open(APP_ID, './private.pem', './public.pem', true);
// 判断接口加密是否正确
// var_dump($hslOpen->checkPostRsa($postData, $token));
// .. 执行下面流程

// 返回结果
file_put_contents('./a.log', $messageUuid . 'status:' . $hslOpen->checkPostRsa($postData, $token));
exit(json_encode([
    'code' => 200,
    'message' => 'OK',
    'messageUuid' => $messageUuid
]));

/**
 * 获取请求头数据
 * @return array
 */
function getAllHeaders()
{
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}

