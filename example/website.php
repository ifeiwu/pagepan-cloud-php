<?php
require 'common.php';

$client = new PagepanCloud\WebsiteClient(ACCESS_TOKEN);
$url = 'https://test.example.com';

$res = $client->addInfo($url);

//$res = $client->find($url);

//$res = $client->update($url, [
//    'state' => 1,
//    'title' => 'test',
//    'email' => 'test@qq.com',
//    'version' => '7.25.5',
//    'end_date' => '2024-08-01'
//]);

//$res = $client->findChild($url);

//$res = $client->list(['pagenum' => 1, 'perpage' => 10]);

//$res = $client->delete($url);

if ( $res['code'] === 0 ) {
    dump('成功信息：', $res);
} else {
    dump('失败信息：', $res);
}