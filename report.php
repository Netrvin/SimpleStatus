<?php

include_once 'config.php';

if (empty($_POST['token']) || empty($_POST['agent_id']) || empty($_POST['data'])){
    die('No enough parameters.');
}

if ($_POST['token'] != TOKEN){
    die('Invalid token.');
}

$upload_data = json_decode($_POST['data'], true);
$upload_data['timestamp'] = time();

file_put_contents('data/'.$_POST['agent_id'].'.json',json_encode($upload_data));

echo 'OK';