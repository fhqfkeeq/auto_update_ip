<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 16/8/1
 * Time: 14:45
 */

function getPublicIP(){
    $info_json = file_get_contents("http://httpbin.org/ip");
    $info = json_decode($info_json, true);
    return $info['origin'];
}