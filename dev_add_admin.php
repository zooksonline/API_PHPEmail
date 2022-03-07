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
    if ($json["member"] === "GUEST") {
        $member = "ผู้แจ้งนอกระบบ";
    } else {
        $member = "ผู้แจ้งภายในระบบ";
    }
    $type = $json["type"];
    $topic = $json["topic"];
    $detail = $json["detail"];

    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'mail.swu.ac.th';
    $mail->Port = 25;
    $mail->setFrom('no-reply@swu.ac.th');
    $mail->addAddress($emailAdmin);

    $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งส่งเรื่องจากระบบร้องเรียนหัวข้อ  ' . $topic . ']';
    $mail->AltBody = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'เบอร์ติดต่อ: ' . $phone . '<br>' . 'ประเภทการร้องเรียน: ' . $type . '<br>' . 'รายละเอียด: ' . $detail;
    $mail->Body = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'เบอร์ติดต่อ: ' . $phone . '<br>' . 'ประเภทการร้องเรียน: ' . $type . '<br>' . 'รายละเอียด: ' . $detail;

    if (!$mail->send()) {
        echo json_encode(["Result" => false]);
    } else {
        echo json_encode(["Result" => true]);
    }
} else {
    echo json_encode(["Result" => false]);
}
