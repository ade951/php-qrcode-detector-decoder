<?php

/**
 * 识别图片二维码内容
 * 通过GET请求，传递image_url参数过来，返回识别到的内容
 */

require_once 'bootstrap.php';
require_once 'common.php';

use Zxing\QrReader;


$timestart = time();
$imageUrl = ($_GET['image_url'] ?? '');
if (empty($imageUrl)) {
    error('参数错误');
    exit;
};

//获取图片内容
//注：因此处file_get_contents很慢，这里使用curl系列函数
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch,CURLOPT_URL, $imageUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$imageContent = curl_exec($ch);
curl_close($ch);

if (empty($imageContent)) {
    error('图片不存在');
    exit;
}

//识别
$qrcode = new QrReader($imageContent, QrReader::SOURCE_TYPE_BLOB);
$timeUsed = time() - $timestart;

$text = $qrcode->text();
$status = ($text !== false ? 'success' : 'error');
if ($text !== false) {
    success($text);
} else {
    error('识别失败');
}

exit;
