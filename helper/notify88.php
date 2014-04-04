<?php 
	//set_time_limit(0);
	require_once('PHPMailer_v5.1/class.phpmailer.php'); 
	require_once('PHPMailer_v5.1/class.smtp.php'); 
	
	define('GUSER', 'notify.88@gmail.com');          // Email
	define('GPWD', 'kimliena8');                 // Password
        
    /*******************************************************
    * Decription               : send mail by smtp
    * Create Date              : 20110417
    * Parameter                :
    *              $to         : recipients mail
    *            $from        : sender
    *            $from_name    : name of sender
    *            $subject    : subject of mail
    *            $body        : body of mail
    * Return                   : true or false
    * Note                     : code by khoinguonit.com
    *******************************************************/
    function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        global $message;
        $mail = new PHPMailer();                  // tạo một đối tượng mới từ class PHPMailer
        $mail->IsSMTP();                         // bật chức năng SMTP
        $mail->SMTPDebug = 0;                      // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
        $mail->SMTPAuth = true;                  // bật chức năng đăng nhập vào SMTP này
        $mail->SMTPSecure = 'ssl';                 // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
        $mail->Host = 'smtp.gmail.com';         // smtp của gmail
        $mail->Port = 465;                         // port của smpt gmail
        $mail->Username = GUSER;  
        $mail->Password = GPWD;           
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
		$mail->CharSet = 'UTF-8';		
		
        if(!$mail->Send())
        {	
            $message = 'Gởi mail bị lỗi: '.$mail->ErrorInfo; 
            return false;
        } else {			
            $message = 'Thư của bạn đã được gởi đi ';
            return true;
        }
    }
	function notify($title,$content,$status=""){ 
		if (strtolower($status)=="bad"){			
			if (smtpmailer("thinhnp@gmail.com", "notify.88@gmail.com", "[ Notify.88 ]", $title, $content."\r\n\r\n-----------\r\n// Bad")) 
				return true;
		} else {
			if (smtpmailer("thinhnp@gmail.com", "notify.88@gmail.com", "[ Notify.88 ]", $title, $content."\r\n\r\n-----------\r\n// Good"))
				return true;
		}
		return false;
	}	
    //notify("c","d","BaD");
    //echo $message;
    ?>