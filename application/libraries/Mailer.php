<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('PHPMailer/class.phpmailer.php'); 
class Mailer {
 
    public $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
 
        $this->mail->IsSMTP();
        $this->mail->CharSet = "utf-8";
        $this->mail->SMTPAuth   = true; 
        $this->mail->Host       = "smtp.qq.com";  //smtp服务器的名称
        $this->mail->Username   = "373254555@qq.com";	// SMTP 用户账号
        $this->mail->Password   = "jkr.name2015";    // SMTP 密码 		
    }
 
    public function sendmail($to, $to_name, $subject, $body){
		
        try{
            $this->mail->From = '373254555@qq.com'; //发件人
            $this->mail->FromName = '深圳市海外国际旅行社';	//发件人姓名
            $this->mail->AddAddress($to, $to_name);
            $this->mail->WordWrap = 50;  
            $this->mail->IsHTML(true);  

            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->Send();
            return true;
 
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
			return false;
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
		   return false;
        }
    }
}