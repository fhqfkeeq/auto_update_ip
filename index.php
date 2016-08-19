<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 16/8/19
 * Time: 15:00
 */

include "./config.php";
include "./fun/common.php";
include "./fun/dnspodAPI.php";
include "./fun/getPublicIP.php";

$info = getRecordInfo();

if($info['status'] === false){
    exit($info['message'].PHP_EOL);
}

$public_ip = getPublicIP();
if(empty($public_ip) === true){
    exit("外网IP获取失败".PHP_EOL);
}

if($info['ip'] != $public_ip){
    $re = setRecord($info['record_id'], $public_ip);
    exit($re['message'].PHP_EOL);
}