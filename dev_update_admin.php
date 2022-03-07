<?php

date_default_timezone_set('Etc/UTC');

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$json = json_decode(file_get_contents('php://input'), true);
if ($json) {

    $emailAdmin = "pariwat.zen@gmail.com";
    $emailSend = $json["email"];
    $phone = $json["phone"];
    $id = $json["id"];
    $topic = $json["topic"];
    $note = $json["note"];

    if ($json["status"] === "WAITING") {
        $status_change = "รอรับเรื่อง";
    } else if ($json["status"] === "RECEIVED") {
        $status_change = "รับเรื่องแล้ว รอพิจารณา";
    } else if ($json["status"] === "CONSIDERING") {
        $status_change = "กำลังพิจารณา";
    } else if ($json["status"] === "EDIT") {
        $status_change = "ต้องการข้อมูลเพิ่มเติม รอข้อมูลจากผู้แจ้ง";
    } else if ($json["status"] === "RESULT") {
        $status_change = "เสร็จสิ้นการพิจารณา";
    }

    if ($json["status_before"] === "WAITING") {
        $status_before = "รอรับเรื่อง";
    } else if ($json["status_before"] === "RECEIVED") {
        $status_before = "รับเรื่องแล้ว รอพิจารณา";
    } else if ($json["status_before"] === "CONSIDERING") {
        $status_before = "กำลังพิจารณา";
    } else if ($json["status_before"] === "EDIT") {
        $status_before = "ต้องการข้อมูลเพิ่มเติม รอข้อมูลจากผู้แจ้ง";
    } else if ($json["status_before"] === "RESULT") {
        $status_before = "เสร็จสิ้นการพิจารณา";
    }

    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'mail.swu.ac.th';
    $mail->Port = 25;
    $mail->setFrom('no-reply@swu.ac.th');
    $mail->addAddress($emailAdmin);

    $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งอัพเดตสถานะจากระบบร้องเรียนไอดี  ' . $id . 'หัวข้อ ' . $topic . ']';
    
    if($note){
        $mail->AltBody = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'ได้เปลี่ยนจากสถานะ ' . $status_before . 'เป็น ' . $status_change .'<br> หมายเหตุ: '. $note;
        $mail->Body = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'ได้เปลี่ยนจากสถานะ ' . $status_before . 'เป็น ' . $status_change .'<br> หมายเหตุ: '. $note;
    }else{
        $mail->AltBody = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'ได้เปลี่ยนจากสถานะ ' . $status_before . 'เป็น ' . $status_change;
        $mail->Body = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'ได้เปลี่ยนจากสถานะ ' . $status_before . 'เป็น ' . $status_change;
    }


    if (!$mail->send()) {
        echo json_encode(["Result" => false]);
    } else {
        echo json_encode(["Result" => true]);
    }
} else {
    echo json_encode(["Result" => false]);
}
