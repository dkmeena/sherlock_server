<?php

if($_POST){

$rec = $_POST['phone_email'];
$phone = explode(" - ",$rec)[1];
$email = explode(" - ",$rec)[0];

$dbconn = mysqli_connect('localhost', 'root', 'brserver');
	//echo "asa";
	if(!$dbconn) return;

	$db = 'Sherlockx_General';
	$db_selected = mysqli_select_db($db, $dbconn);
	if(!$db_selected){
		$sql = 'CREATE DATABASE '.$db;
		mysqli_query($sql,$dbconn);
	}

	$q = "CREATE TABLE IF NOT EXISTS phone ( email VARCHAR (255) DEFAULT NULL , phone VARCHAR (255) DEFAULT NULL,PRIMARY KEY (email, phone))";
	if(mysqli_query($q,$dbconn)){

		$sql = "INSERT IGNORE INTO phone (email, phone) VALUES ('$email' , '$phone')";
		if(mysqli_query($sql,$dbconn)){
			echo "Success";
			return;
		}

	}
	echo "Fail";
}

?>
