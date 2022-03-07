<?php
date_default_timezone_set('Etc/UTC');
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
// require 'vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$json = json_decode(file_get_contents('php://input'), true);

if($json){
    $email_send = $json["email_send"];
    $no_id = $json["no_id"];
    $topic = $json["topic"];
    $old_status = $json["old_status"];
    $new_status = $json["new_status"];

    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'mail.swu.ac.th';
    $mail->Port = 25;
    $mail->setFrom('no-reply@swu.ac.th');
    $mail->addAddress($email_send);

    $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งส่งเรื่องจากระบบร้องเรียนหมายเลข '.$no_id.']';;
    $mail->AltBody = 'หมายเลขร้องเรียน: '.$no_id.'<br>'.'หัวข้อร้องเรียน: '.$topic.'<br>'.'มีการเปลี่ยนสถานะจาก: '.$old_status.'<br>'.'เป็นสถานะ: '.$new_status.'<br>'.'สามารถเช็คได้ที่ Website';
    $mail->Body = 'หมายเลขร้องเรียน: '.$no_id.'<br>'.'หัวข้อร้องเรียน: '.$topic.'<br>'.'มีการเปลี่ยนสถานะจาก: '.$old_status.'<br>'.'เป็นสถานะ: '.$new_status.'<br>'.'สามารถเช็คได้ที่ Website';

    
    if (!$mail->send()) {
        echo json_encode([ "Result" => "Send Email falied!" ]);
    }else{
        echo json_encode(["Result" => " Send Email success!"]);
    }
}else{
    echo json_encode(["Result" => " Send Email falied!"]);
}   
?>