<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'].'/v3/config/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'].'/v3/config/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/v3/config/PHPMailer/src/SMTP.php';



$name = "";
$email = 'shohail.masud@gmail.com';
$subject = "Prison Management System";
$message = $codephp;
$from_email='shohail.masud.16@gmail.com';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = $from_email;
$mail->Password = 'auftcuezgkslcwmo';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->isHTML(true);
$mail->setFrom($from_email, "PMS");
$mail->addAddress($email, $name);
$mail->Subject = ($subject);
$mail->Body = $message;
$mail->send();









if(isset($_POST['send'])){
    // $name = htmlentities($_POST['name']);
    // $email = htmlentities($_POST['email']);
    // $subject = htmlentities($_POST['subject']);
    // $message = htmlentities($_POST['message']);

    // $mail = new PHPMailer(true);
    // $mail->isSMTP();
    // $mail->Host = 'smtp.gmail.com';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'shohail.masud.16@gmail.com';
    // $mail->Password = 'ydkhpirrjoefmzwp';
    // $mail->Port = 465;
    // $mail->SMTPSecure = 'ssl';
    // $mail->isHTML(true);
    // $mail->setFrom($email, $name);
    // $mail->addAddress('shohail.masud.16@gmail.com');
    // $mail->Subject = ("$email ($subject)");
    // $mail->Body = $message;
    // $mail->send();

    header("Location: ./response.html");
}
?>
