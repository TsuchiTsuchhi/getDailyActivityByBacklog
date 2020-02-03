<?php
/**
 * userList取得
 */
$backlogApiKey = 'XXXXXXXXXXXXXXXXXXXXXXXX';
$userListUrl = "https://alfos.backlog.com/api/v2/users?apiKey=".$backlogApiKey;

$userListHeaders = array('Content-Type: application/x-www-form-urlencoded');
$context = array('http' => array(
	'method' => 'GET',
	'header' => $userListHeaders,
	'ignore_errors' => true
));
$response = file_get_contents($userListUrl, false, stream_context_create($context));
$array = json_decode($response, true);

echo '<pre>';
var_dump($array);
echo '</pre>';
