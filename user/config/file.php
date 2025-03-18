<?php

// require_once($_SERVER['DOCUMENT_ROOT'].'/v3/config/connect.php');

// $sql = "SELECT page_link FROM menu;";
// $result = mysqli_query($connect, $sql);

// while($row_menu_sql = mysqli_fetch_array($result)){
//     $php_array[] = $row_menu_sql["page_link"];
//     }

// print_r($php_array);


// $file_content= file_get_contents("index.php");


// $file_names = $php_array;


// for ($i = 0; $i < count($file_names); $i++) {
//     // Create the file and write the content
//    if(!file_exists($file_names[$i])){
//     $handle = fopen($file_names[$i], 'w');
//     if (!$handle) {
//         echo "Unable to create file " . $file_names[$i];
//         exit;
//     }
//     fwrite($handle, $file_content);
//     fclose($handle);
//     echo "File " . $file_names[$i] . " created successfully\n";
//    }
// }
$folder = "ok";
$fileName = 'example.txt';



$path =$_SERVER['DOCUMENT_ROOT'].'/v3/user/';
$folderPath=$path.$folder;

$filePath = $folderPath.'/'.$fileName;


if (is_dir($folderPath)) {
    echo "Folder exists.";
    
} else {
    mkdir($folderPath, 0700);
    
}

if (file_exists($filePath)) {
    echo "File exists.";
} else {
    $file = fopen($filePath, 'w'); 
    if ($file) {
        // File created successfully
        fclose($file);
        echo "File created at: " . $filePath;
    } else {
        // File creation failed
        echo "Unable to create file.";
    }
}






// if (!file_exists($filename)) {
//     // Create the file
//     $handle = fopen($filename, 'w');
//     if (!$handle) {
//         echo 'Unable to create file';
//         exit;
//     }
//     // Write some content to the file
//     fwrite($handle, 'Hello, world!');
//     // Close the file
//     fclose($handle);
// }






















// $php_array = array();
// while($row = mysqli_fetch_array($result)) {
//     $array_string = $row["page_link"];
//     $array = json_decode($array_string, true);
//     $php_array[] = $array;
// }

// print_r($php_array);
// $result = $connect->query($sql);

// // Convert the result set into a PHP array
// if ($result->num_rows > 0) {
//     $php_array = array();
//     while($row = $result->fetch_assoc()) {
//         $array_string = $row["page_link"];
//         $array = json_decode($array_string, true);
//         $php_array[] = $array;
//     }
// }

// // Close the database connection


// // Use the PHP array as needed
// print_r($php_array);


?>