<?php

//http://worktile.aihelp.net/worktile/getaccesstoken.php?code=
require './common.php';
require './app_config.php';

$code = $_GET['code'];
$state = $_GET['state'];

if($state == 'aihelp168'){
    //
}

file_put_contents('/data/htdocs/worktile/a.log',  'code:'. $code . ' state:  ' . $state, FILE_APPEND);
file_put_contents('/data/htdocs/worktile/a.log', "\r\n", FILE_APPEND);

// config file
if(empty($code) && empty($state)){
    
}
else {
    $result = getAccessToken($GET_ACCESS_TOKEN, $client_id, $client_secret, $code);
}

echo json_encode($result);
function getAccessToken($GET_ACCESS_TOKEN, $clientId, $clientSecret, $code){
    $grant_type='authorization_code';
    $redirect_uri='http://worktile.aihelp.net/worktile/getaccesstoken.php';

    $post_data['client_id'] = $clientId;
    $post_data['client_secret'] = $clientSecret;
    $post_data['code'] = $code;
    $post_data['grant_type'] = $grant_type;
    $post_data['redirect_uri']= $redirect_uri;
    $result = http_post_json_data($GET_ACCESS_TOKEN, $post_data);

    file_put_contents('/data/htdocs/worktile/a.log', $result, FILE_APPEND);
    file_put_contents('/data/htdocs/worktile/a.log', "\r\n", FILE_APPEND);

    // set global data
    $result = json_decode($result, true);
    $access_token = $result['access_token'];
    $expires_in = $result['expires_in'];
    $refresh_token = $result['refresh_token'];
 
    // test 1
    getTasksInInbox($access_token);

    // test 2
    $taskData = array();
    $taskData['title'] = array('yy-task1', 'yy-task2');
    //https://aihelp.worktile.com/tasks/projects/5a6ed3ffe44f516d525c29aa
    createTasks($access_token, '5a6ed3ffe44f516d525c29aa', $taskData);

   return $result;
}

//
function refreshToken($refreshToken, $clientId){
    $REFRESH_TOKEN = 'https://api.worktile.com/oauth2/refresh_token';

    $refresh_token_url = $REFRESH_TOKEN . '?refresh_token=' . $refreshToken . '&client_id=' . $clientId;
    $result = https_get_header_json($refresh_token_uri);

    // set global data
    $result = json_decode($result, true);
    $access_token = $result['access_token'];
    $expires_in = $result['expires_in'];
    $refresh_token = $result['refresh_token'];

    return $result;
} 

function getTasksInInbox($accessToken){
    $INBOX = 'https://dev.worktile.com/api/mission/tasks/inbox';
    $inbox_url = $INBOX . '?access_token=' . $accessToken;
    $result = https_get_header_json($inbox_url);
    file_put_contents('a.log', '1-inbox:' . $accessToken, FILE_APPEND);
    file_put_contents('a.log', "\r\n", FILE_APPEND);
    file_put_contents('a.log', '2-inbox:' . json_encode($result), FILE_APPEND);
    file_put_contents('a.log', "\r\n", FILE_APPEND);
}

function createTasks($accessToken, $pid, $taskData){
    $TASKS = 'https://dev.worktile.com/api/mission/tasks?pid=';
    $tasks_url = $TASKS . $pid;
    
    $taskData['pid'] = $pid;   
    $taskData['access_token'] = $accessToken;
    //$taskData['assignee'] = $assignee;
    //$taskData['parent'] = $parent;
    //$taskData['due_date'] = $entry;

    $result = http_post_json_data($tasks_url, $taskData);
    file_put_contents('a.log', '1-tasks:' . $accessToken, FILE_APPEND); 
    file_put_contents('a.log', "\r\n", FILE_APPEND);
    file_put_contents('a.log', '2-tasks:' . json_encode($result), FILE_APPEND);
    file_put_contents('a.log', "\r\n", FILE_APPEND);
}
?>
