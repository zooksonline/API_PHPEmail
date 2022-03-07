<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

date_default_timezone_set('Etc/UTC');

use PHPMailer\PHPMailer\PHPMailer;

require '../../../vendor/autoload.php';
$json = json_decode(file_get_contents('php://input'), true);
if ($json) {
    $project_name = $json["project_name"];

    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'mail.swu.ac.th';
    $mail->Port = 25;
    $mail->setFrom('no-reply@swu.ac.th');
    $mail->addAddress($json["email"]);

    $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งการส่งโครงการวิจัยหัวข้อ ' . $project_name;
    $mail->AltBody = 'โครงการวิจัย ' . $project_name . ' ได้ถูกส่งมาที่ E-Research เพื่อรอกรรมการตรวจสอบแล้ว' . '<br>' . 'ท่านสามารถตรวจสอบสถานะการส่งบทความวิจัยได้ที่เว็บไซต์ ' . '<a href="http://service.science.swu.ac.th">http://service.science.swu.ac.th</a> นี้ <br>' . 'ขอบคุณครับ';
    $mail->Body = 'โครงการวิจัย ' . $project_name . ' ได้ถูกส่งมาที่ E-Research เพื่อรอกรรมการตรวจสอบแล้ว' . '<br>' . 'ท่านสามารถตรวจสอบสถานะการส่งบทความวิจัยได้ที่เว็บไซต์ ' . '<a href="http://service.science.swu.ac.th">http://service.science.swu.ac.th</a> นี้ <br>' . 'ขอบคุณครับ';

    if (!$mail->send()) {
        echo json_encode(["Result" => false]);
    } else {
        echo json_encode(["Result" => true]);
    }
} else {
    echo json_encode(["Result" => false]);
}
