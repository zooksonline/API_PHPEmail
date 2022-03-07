<?php

date_default_timezone_set('Etc/UTC');

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$json = json_decode(file_get_contents('php://input'), true);
if ($json) {
    $emailAdmin = "admin_sci_appeal@g.swu.ac.th";
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
    $mail->addAddress($emailSend);

    $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งส่งเรื่องจากระบบร้องเรียนหัวข้อ  ' . $topic . ']';

    if ($member === "ผู้แจ้งนอกระบบ") {
        $mail->AltBody = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'เบอร์ติดต่อ: ' . $phone . '<br>' . 'ประเภทการร้องเรียน: ' . $type . '<br>' . 'รายละเอียด: ' . $detail . '<br><br>ทางคณะวิทยาศาสตร์จะดำเนินตามหัวข้อที่แจ้งและอัพเดตความคืบหน้าผ่าน E-mail นี้ ขอบคุณครับ';
        $mail->Body = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'เบอร์ติดต่อ: ' . $phone . '<br>' . 'ประเภทการร้องเรียน: ' . $type . '<br>' . 'รายละเอียด: ' . $detail . '<br><br>ทางคณะวิทยาศาสตร์จะดำเนินตามหัวข้อที่แจ้งและอัพเดตความคืบหน้าผ่าน E-mail นี้ ขอบคุณครับ';
    } else {
        $mail->AltBody = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'เบอร์ติดต่อ: ' . $phone . '<br>' . 'ประเภทการร้องเรียน: ' . $type . '<br>' . 'รายละเอียด: ' . $detail . '<br><br>ทางคณะวิทยาศาสตร์จะดำเนินตามหัวข้อที่แจ้งและอัพเดตความคืบหน้าผ่าน E-mail นี้และเว็บไซต์ ' . '<a href="http://service.science.swu.ac.th">http://service.science.swu.ac.th</a> <br>' . 'ขอบคุณครับ';
        $mail->Body = 'หัวข้อร้องเรียน: ' . $topic . '<br>' . 'E-mail ผู้แจ้ง: ' . $emailSend . '<br>' . 'เบอร์ติดต่อ: ' . $phone . '<br>' . 'ประเภทการร้องเรียน: ' . $type . '<br>' . 'รายละเอียด: ' . $detail . '<br><br>ทางคณะวิทยาศาสตร์จะดำเนินตามหัวข้อที่แจ้งและอัพเดตความคืบหน้าผ่าน E-mail นี้และเว็บไซต์ ' . '<a href="http://service.science.swu.ac.th">http://service.science.swu.ac.th</a> <br>' . 'ขอบคุณครับ';
    }


    if (!$mail->send()) {
        echo json_encode(["Result" => false]);
    } else {
        echo json_encode(["Result" => true]);
    }
} else {
    echo json_encode(["Result" => false]);
}
