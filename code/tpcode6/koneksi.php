<?php
//create connection
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'pengelolaan_master_detail_data';

    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if ($conn){
        echo 'Connection success <br>';
    }else{
        echo 'Connection failed <br>'. mysqli_connect_error();
    }
?>