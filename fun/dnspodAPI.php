<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 16/8/1
 * Time: 14:59
 */

function getRecordInfo(){
    $domainId = getDomainId();
    if($domainId === FALSE){
        return [
            'status' => false,
            'message' => '未成功获取Domain ID,请检查域名是否正确!',
        ];
    }

    $url = 'https://dnsapi.cn/Record.List';
    $params = $GLOBALS['curl_common_params'];
    $params['domain_id'] = $domainId;
    $re = curl_post($url, $params);
    $re = json_decode($re, TRUE);
    if($re['status']['code'] == 1){
        foreach($re['records'] as $record){
            if($record['name'] == $GLOBALS['edit_record_name']){
                return ['status' => true, 'record_id' => $record['id'], 'ip' => $record['value']];
            }
        }
    }

    return false;
}

function getDomainId(){
    $url = 'https://dnsapi.cn/Domain.Info';

    $params = $GLOBALS['curl_common_params'];
    $params['domain'] = $GLOBALS['domain'];

    $re = curl_post($url, $params);
    $re = json_decode($re, TRUE);

    if($re['status']['code'] == 1){
        return $re['domain']['id'];
    }else{
        return false;
    }
}

function setRecord($record_id = 0, $ip = ''){
    $domainId = getDomainId();
    if($domainId === FALSE){
        return [
            'status' => false,
            'message' => '未成功获取Domain ID,请检查域名是否正确!',
        ];
    }

    $url = 'https://dnsapi.cn/Record.Modify';

    $params = $GLOBALS['curl_common_params'];
    $params['domain_id'] = $domainId;
    $params['record_id'] = $record_id;
    $params['value'] = $ip;
    $params['sub_domain'] = $GLOBALS['edit_record_name'];
    $params['record_type'] = 'A';
    $params['record_line'] = '默认';
    $re = curl_post($url, $params);
    $re = json_decode($re, TRUE);
    if($re['status']['code'] == 1){
        return [
            'status' => true,
            'message' => '域名:'.$re['record']['name'].'的解析IP已修改为:'.$re['record']['value'],
        ];
    }else{
        return [
            'status' => false,
            'message' => $re['status']['message'],
        ];
    }
}