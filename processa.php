
<?php
$user_msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}


	$user_msg = test_input($_POST["usermsg"]);

}

echo "Você: ". $user_msg, "<br>";

exec('python res.py', $output);
echo json_encode($output);