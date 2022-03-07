<?php
date_default_timezone_set('Etc/UTC');
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
// require 'vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$json = json_decode(file_get_contents('php://input'), true);

if ($json) {

    
    $countjson = count($json); 
    for($i = 0; $i < $countjson; $i++){
        $data = array_values($json[$i]);
        $email_admin = $data[0];
        $no_id = $data[1]["no_id"];
        $topic = $data[1]["topic"];
        $type = $data[1]["type"];
        $detail = $data[1]["detail"];
        $email = $data[1]["email"];
        if($data[1]["phone"]){
            $phone = $data[1]["phone"];

            $mail = new PHPMailer;
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'mail.swu.ac.th';
            $mail->Port = 25;
            $mail->setFrom('no-reply@swu.ac.th');
            $mail->addAddress($email_admin);

            $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งส่งเรื่องจากระบบร้องเรียนหมายเลข '.$no_id.']';
            $mail->AltBody = 'หมายเลขร้องเรียน: '.$no_id.'<br>'.'หัวข้อร้องเรียน: '.$topic.'<br>'.'E-mail ผู้แจ้ง: '.$email.'<br>'.'เบอร์ติดต่อ: '.$phone.'<br>'.'ประเภทการร้องเรียน: '.$type.'<br>'.'รายละเอียด: '.$detail.'<br><br>'.'////link';
            $mail->Body = 'หมายเลขร้องเรียน: '.$no_id.'<br>'.'หัวข้อร้องเรียน: '.$topic.'<br>'.'E-mail ผู้แจ้ง: '.$email.'<br>'.'เบอร์ติดต่อ: '.$phone.'<br>'.'ประเภทการร้องเรียน: '.$type.'<br>'.'รายละเอียด: '.$detail.'<br><br>'.'////link';
        }
        else{
            $mail = new PHPMailer;
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'mail.swu.ac.th';
            $mail->Port = 25;
            $mail->setFrom('no-reply@swu.ac.th');
            $mail->addAddress($email_admin);

            $mail->Subject = '[แจ้งอัตโนมัติ_โปรดอย่าตอบกลับ]แจ้งส่งเรื่องจากระบบร้องเรียนหมายเลข '.$no_id.']';
            $mail->AltBody = 'หมายเลขร้องเรียน: '.$no_id.'<br>'.'หัวข้อร้องเรียน: '.$topic.'<br>'.'E-mail ผู้แจ้ง: '.$email.'<br>'.'ประเภทการร้องเรียน: '.$type.'<br>'.'รายละเอียด: '.$detail.'<br><br>'.'////link';
            $mail->Body = 'หมายเลขร้องเรียน: '.$no_id.'<br>'.'หัวข้อร้องเรียน: '.$topic.'<br>'.'E-mail ผู้แจ้ง: '.$email.'<br>'.'ประเภทการร้องเรียน: '.$type.'<br>'.'รายละเอียด: '.$detail.'<br><br>'.'////link';
        }
        
        if (!$mail->send()) {
            echo json_encode([ "Result" => false ]);
        } else {
            $output = 
                        [
                        "Result" => true
    
                        ];
                echo json_encode($output);
        }
    }
}
else{
    echo json_encode([ "Result" => false ]);
}

?>
