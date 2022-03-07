<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

date_default_timezone_set('Etc/UTC');
use PHPMailer\PHPMailer\PHPMailer;
require '../../vendor/autoload.php';

$json = json_decode(file_get_contents('php://input'), true);
if($json){
    $research_name = $json["research_name"];
    $name = $json["firstname"].' '.$json["lastname"];
    
    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'mail.swu.ac.th';
    $mail->Port = 25;
    $mail->setFrom('no-reply@swu.ac.th');
    $mail->addAddress($json["user_email"]);

    $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งส่งรายละเอียดการแก้ไขบทความวิจัยหัวข้อ  ' . $research_name . ']';
    $mail->AltBody = 'ได้ส่งการแก้ไขบทความวิจัย '. $research_name .' ไปยังกรรมการเพื่อตรวจสอบรายละเอียดแล้ว <br>'. 'โปรดตรวจสอบการแก้ไขบทความวิจัยในเว็บไซต์ '. '<a href="http://service.science.swu.ac.th">http://service.science.swu.ac.th</a> นี้ <br>' . 'ขอบคุณครับ';
    $mail->Body = 'ได้ส่งการแก้ไขบทความวิจัย '. $research_name .' ไปยังกรรมการเพื่อตรวจสอบรายละเอียดแล้ว <br>'. 'โปรดตรวจสอบการแก้ไขบทความวิจัยในเว็บไซต์ '. '<a href="http://service.science.swu.ac.th">http://service.science.swu.ac.th</a> นี้ <br>' . 'ขอบคุณครับ';

    if (!$mail->send()) {
        echo json_encode(["Result" => false]);
    } else {
        echo json_encode(["Result" => true]);
    }
}
else {
    echo json_encode(["Result" => false]);
}

?>