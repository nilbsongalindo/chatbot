<?php

function RandomString(){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randstring = '';
	for ($i = 0; $i < 10; $i++) {
		$randstring .= $characters[rand(0, strlen($characters))];
	}
	return $randstring;
}

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$start = microtime(true);

$user_msg = test_input($_POST["text"]);
$tmp_file = RandomString();

$data = array(
	'user_msg' => $user_msg,
	'tmp_file' => $tmp_file,
);

$file = 'tmp/log.txt';

file_put_contents($file, json_encode($data)."\n", FILE_APPEND | LOCK_EX);

set_time_limit(0);

$out_file = "./tmp/" . $tmp_file;
$success = false;
do {
	sleep(1);
	$time_elapsed_secs = microtime(true) - $start;
    if($time_elapsed_secs > 10){
    	break;
    }
    if (file_exists($out_file)) {
    	$success = true;
        break;
    }
    
} while(true);

if($success){
	$out = file_get_contents($out_file);
	unlink($out_file);

	echo $out;

}else{
	echo 'Servidor Offline';
}
