<?php
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'databasephim';

    $conn = @mysqli_connect($server, $user, $password, $db)
            OR die ('Could not connect to MySQL: ' . mysqli_connect_error());


    mysqli_set_charset($conn, 'utf8');
?>