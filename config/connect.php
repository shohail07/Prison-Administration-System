<?php 

$connect = mysqli_connect("localhost", "root", "123", "log");

if ($connect) {
    
    $connect = mysqli_connect("localhost", "root", "123", "log");
} else {
    print_r(mysqli_connect_error());
}




?>