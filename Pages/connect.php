<?php # Script - mysqli_connect.php


//Dưới đây là phần định nghĩa các thông tin dùng để kết nối dưới dạng hằng số
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'databasephim');

//Kết nối với cơ sở dữ liệu bằng hàm mysqli_connect
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
		OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set ngôn ngữ theo kiểu utf8
mysqli_set_charset($dbc, 'utf8');