<?php

function getIp(){
    return $_SERVER['REMOTE_ADDR'];
}

function getIp2(){
    $ip = "Unknow";

    if (getenv("HTTP_CLIENT_IP")){
        $ip = getenv("HTTP_CLIENT_IP");
    }
    else if(getenv("HTTP_X_FORWARDED_FOR")){
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    }
    else if(getenv("REMOTE_ADDR")){
        $ip = getenv("REMOTE_ADDR");
    }
    
    return $ip;    
}

function formatData(){
    return $_SERVER['REMOTE_ADDR'];
}

function getObjectType($value){
    if(is_string($value)){
        return 'string';
    }
    if(is_bool($value)){
        return 'bool';
    }
    if(is_int($value)){
        return 'int';
    }
    if(is_float($value)){
        return 'floor';
    }
    if(is_integer($value)){
        return 'integer';
    }
    if(is_real($value)){
        return 'real';
    }
    if(is_array($value)){
        return 'array';
    }
    if(is_object($value)){
        return 'object';
    }
}

function http_get_contents($pay_server){
    // create a new curl resource
    $timeout = 30;
    $ch = curl_init();    
    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $pay_server);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    
    return $file_contents;  
}

function http_post_contents($pay_server, $post_data){
    // create a new curl resource
    $timeout = 30;
    $ch = curl_init();    
    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $pay_server);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    
    return $file_contents;  
}

//要抓https请先确定php.ini内有
//extension=php_openssl.dll
//allow_url_include=on
function https_get_contents($token_url)
{
    // Get an App Access Token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $params = curl_exec($ch);
    curl_close($ch);
    return $params;
}

function http_post_json_data($pay_server, $post_data) {
    $data_string = json_encode($post_data);

    $ch = curl_init($pay_server);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);    
    return $result;
}

function https_get_header_json($token_url) {
    // create a new curl resource
    $timeout = 30;
    $ch = curl_init();    
    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $token_url);
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);

    return $file_contents;
}

?>
