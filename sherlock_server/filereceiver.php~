<?php

   // echo "asas";

	if($_FILES){

		//echo $_FILES

		$folder = basename( $_FILES['uploaded_file']['name']);
		//echo $folder;
		
		$n = explode('@', $folder);  // folder contains user's email id
		$version = $n[1];
		$folder = $n[0];
		$folder = $folder.'_'.$version;
		

	   	if (!file_exists("/home/brserver1/sherlockx_uploads/".$folder)) {
 	    		mkdir("/home/brserver1/sherlockx_uploads/".$folder, 0777, true);
				
		}

	    $file_path = "/home/brserver1/sherlockx_uploads/".$folder."/";
	    $file_path = $file_path.basename( $_FILES['uploaded_file']['name']);
	    //echo $file_path;
	    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {

	    	 //$upload_time = time() - $_SERVER['REQUEST_TIME'];   // $_SERVER['REQUEST_TIME'] gives time when first request was made

	        echo "Success";

			$l = end(explode('_',$_FILES['uploaded_file']['name']));
			if($l=='acc.zip'){
				// acceleration file
			}
			else{
				$dis_time = end(explode(':',$_FILES['uploaded_file']['name']));
				$di_ti = explode('.',$dis_time)[0];
				$dis = explode('_',$di_ti)[0];
				$time = explode('_',$di_ti)[1];
				$power = explode('_',$di_ti)[2];
				if($_POST['client_time']){
					$server_time = date("y_m_d-G_i_s",$_SERVER['REQUEST_TIME']);
					update_database($folder,$_FILES['uploaded_file']['name'],$_POST['client_time'],$server_time,$_FILES['uploaded_file']['size'],$dis,$time,$version,$power);
				}

			}



	    } else{
	        echo "Fail";
	    }
	}


	function update_database($email , $filename, $client_time, $server_time,$file_size,$dis,$time,$version,$power){

			$v = explode('.', $version); 

			$dbconn = mysqli_connect('localhost', 'root', 'brserver');
			//echo "asa";
			if(!$dbconn) return;

			$versiondb = 'Sherlockx'.$v[0].'_'.$v[1];
			$db_selected = mysqli_select_db($dbconn,$versiondb);
			
			if(!$db_selected){
				$sql = 'CREATE DATABASE IF NOT EXISTS Sherlockx';
				$sql = $sql.$v[0].'_'.$v[1];
				mysqli_query($dbconn,$sql);
				
				
			}
			
			if($version=='1.0'){
				$q = "CREATE TABLE IF NOT EXISTS synctime ( email VARCHAR (255) DEFAULT NULL , filename VARCHAR (255) DEFAULT NULL , client_time VARCHAR (255), server_time VARCHAR (255), size INTEGER DEFAULT 0,distance INTEGER DEFAULT 0, time INTEGER DEFAULT 0, power INTEGER DEFAULT 0)";
			if(mysqli_query($dbconn,$q)){
				$sql = "INSERT INTO synctime (email, filename, client_time, server_time,size,distance,time,power) VALUES ('$email' , '$filename', '$client_time', '$server_time','$file_size','$dis','$time','$power')";
				mysqli_query($dbconn,$sql);
				}	
			}
			
		}


 ?>
