<?php
	 $dbhost = "localhost";
	 $dbuser = "root";
	 $dbpass = "";
	 $db = "orphanage_managment";

	 $conn =mysqli_connect($dbhost, $dbuser, $dbpass, $db) ;
	 if(!$conn){
	 	die("Connect failed");
	 } 
?>