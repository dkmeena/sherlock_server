<?php
//	echo "1";

if($_POST['data_synced']){

	$rec = explode('-',$_POST['data_synced']);
	$email = $rec[0];
	$size = $rec[1];
	$dbconn = mysqli_connect('localhost', 'root', 'brserver');
	if(!$dbconn) return;
//	echo "2";
	$db = "Sherlockx_General";
	$db_selected = mysqli_select_db($dbconn,$db);

	if(!$db_selected){
		$sql = 'CREATE DATABASE '.$db;
		mysqli_query($dbconn,$sql);

	}
//	echo "3";
	$q = "CREATE TABLE IF NOT EXISTS threshold ( email VARCHAR (255) DEFAULT NULL , date VARCHAR (255) , size INTEGER DEFAULT 0,PRIMARY KEY(email))";

	if(mysqli_query($dbconn,$q)){
//		echo "4";
		$q = "SELECT * FROM threshold WHERE email ='$email'";
		if($result=mysqli_query($dbconn,$q)){
			if(mysqli_num_rows($result)==0){

				$date = date('d-m-o');

				$sql = "REPLACE INTO threshold (email,date,size) VALUES ('$email' , '$date' ,'$size')";
				mysqli_query($dbconn,$sql);

			}
			else{

				$row = mysqli_fetch_assoc($result);
                $date = $row['date'];
				$sz= $row['size'];
				$size = $size + $sz;
                $sql = "REPLACE INTO threshold (email,date,size) VALUES ('$email' , '$date' ,'$size')";
                mysqli_query($dbconn,$sql);
 			}
		}

	}


}

else if($_POST['data_synced_check']){

		$ret = "true";
        $email = $_POST['data_synced_check'];
        $dbconn = mysqli_connect('localhost', 'root', 'brserver');
        if(!$dbconn) return;
//      echo "2";
        $db = "Sherlockx_General";
        $db_selected = mysqli_select_db($dbconn,$db);

        if(!$db_selected){
                $sql = 'CREATE DATABASE '.$db;
                mysqli_query($dbconn,$sql);

        }


        $q = "SELECT * FROM threshold WHERE email ='$email'";
		if($result = mysqli_query($dbconn,$q)){

			if(mysqli_num_rows($result)==0){
				$ret="true";

			}

			else{

				$row = mysqli_fetch_assoc($result);
		        $datedb = $row['date'];
		        $sz = $row['size'];
				$date = date('d-m-o');

				$date1 = date_create($date);
				$date2 = date_create($datedb);
				$diff12 = $date1->diff($date2);
				$days = $diff12->days;
				// echo $date." ";
				// echo $datedb;
				// echo "days==".$days." ";
				if($days<=30 && $sz>=100000000){
					$ret="false";

				}
				else if($days>30 && $sz<=100000000 || $days>30 && $sz>=100000000){

					$sql = "REPLACE INTO threshold (email,date,size) VALUES ('$email' , '$date' , 0)";
	                mysqli_query($dbconn,$sql);
					$ret = "true";
				}
				else{

					$ret="true";
				}
			}
		}


		echo $ret;
}






?>


