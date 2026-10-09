<?php
 
 $host = 'localhost';
 $user = 'root';
 $password = '';
 $database = 'users_db';

 $conn = new mysqli($host, $user, $password, $database);

 if ($conn ->connect_error){
    die('Connection failed:'. $conn->connect_error);
 }

 $conn->set_charset('utf8mb4'); //para ok yung mga pangalan na may ñ at special characters

?>