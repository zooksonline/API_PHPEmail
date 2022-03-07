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
    $user_email = $json["user_email"];
    if($json["status"] === "WAITING"){
        $research_status = "รอกรรมการตรวจสอบ";
    }
    else if($json["status"] === "WAITINGADMIN"){
        $research_status = "รอฝ่ายวิจัยตรวจสอบ";
    }
    else if($json["status"] === "EDIT"){
        $research_status = "แก้ไขรายละเอียด";
    }
    else if($json["status"] === "REJECT"){
        $research_status = "ยกเลิก";
    }
    else if($json["status"] === "APPROVED"){
        $research_status = "ผ่านการตรวจสอบ";
    }

    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'mail.swu.ac.th';
    $mail->Port = 25;
    $mail->setFrom('no-reply@swu.ac.th');
    $mail->addAddress($user_email);

    $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งเปลี่่ยนแปลงสถานะการจัดส่งหัวเรื่องบทความวิจัย ' . $research_name . ']';
    $mail->AltBody = 'หัวเรื่องบทความวิจัย ' . $research_name . ' ของคุณ'. $name .' ได้เปลี่ยนสถานะเป็น '. $research_status . '<br>' .'ตรวจสอบสถานะการส่งบทความวิจัยได้ที่เว็บไซต์  '. '<a href="http://service.science.swu.ac.th">http://service.science.swu.ac.th</a> นี้ <br>' . 'ขอบคุณครับ';
    $mail->Body = 'หัวเรื่องบทความวิจัย ' . $research_name . ' ของคุณ'. $name .' ได้เปลี่ยนสถานะเป็น '. $research_status . '<br>' .'ตรวจสอบสถานะการส่งบทความวิจัยได้ที่เว็บไซต์  '. '<a href="http://service.science.swu.ac.th">http://service.science.swu.ac.th</a> นี้ <br>' . 'ขอบคุณครับ';

    if (!$mail->send()) {
        echo json_encode(["Result" => false]);
    } else {
        echo json_encode(["Result" => true]);
    }
}else {
    echo json_encode(["Result" => false]);
}
?>

