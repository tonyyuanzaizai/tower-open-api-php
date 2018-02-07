<?php
require './common.php';
require './app_config.php';

// config file
$redirect_uri='https://worktile.aihelp.net/worktile/tower/getaccesstoken.php';//tower 要求必须是https

$get_data['client_id']= $client_id;
$get_data['redirect_uri']= $redirect_uri;
$get_data['response_type']= 'code';
$get_data['scope']= 'mission';
$get_data['state']= 'aihelp168';
$oauth_url = $OAUTH . '?client_id=' . $get_data['client_id'] . '&response_type=' . $get_data['response_type']. '&scope=' . $get_data['scope']. '&state=' . $get_data['state'] . '&redirect_uri=' . $get_data['redirect_uri'];

echo 
file_put_contents('/data/htdocs/worktile/a.log', $oauth_url, FILE_APPEND);
file_put_contents('/data/htdocs/worktile/a.log', "\r\n", FILE_APPEND);

//http_get_contents($oauth_url);
?>
