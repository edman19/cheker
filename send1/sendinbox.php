<?php
error_reporting(0);
require('class.Sendinbox.php');
require('phpmailer/PHPMailerAutoload.php');
require('config.php');
class Sendinbox extends Modules
{
	function __construct()
	{
            echo "=========================================\r\n";
            echo "      _______    || Sendinbox ".$this->version()."\r\n";
            echo "     |==   []|   || (c) 2017 Bug7sec\r\n";
            echo "     |  ==== |   || www.bmarket.or.id\r\n";
            echo "     '-------'   ||\r\n";
            echo "=========================================\r\n";
            $LoadEmail = $this->stuck("[ Load Email List ] : "); $this->LoadEmail       = $LoadEmail;
		$this->listEmail = $this->load($this->LoadEmail);
	}
	public function senders($email){
		$mail = new PHPMailer(); $mail->IsSMTP(); $mail->SMTPDebug = 0; $mail->SMTPAuth = true; 
		$mail->SMTPSecure 		= $this->smtp_secure;
		$mail->Host 			= $this->smtp_host;
		$mail->Port 			= $this->smtp_port; 
		$mail->Username 		      = $this->smtp_email;
		$mail->Password 		      = $this->smtp_pass;
		$mail->Subject 			= $this->sendsubject;

		$mail->SetFrom($this->smtp_from_email,$this->smtp_from); 
            $mail->AddReplyTo($this->smtp_from_email,$this->smtp_from);
		$mail->IsHTML(true);

		$mail->Encoding = 'base64';
            $mail->CharSet = 'UTF-8';

		$mail->MsgHTML($this->meletter);
		$mail->AddAddress($email);
		if( $mail->Send() ){
			echo "Send Succes\r\n";
		}else{
                  echo $mail->ErrorInfo;
			//echo "Send Failed\r\n";
		}
	}
    public function send(){
      	$config           = new Config; 
      	$emailList        = $this->listEmail['list'];
      	$break 	      = false;
		$breaks           = false;
		$smtacchit        = 1;
      	foreach ($config->account() as $keys => $account) {
                  $this->smtp_secure      = $account['secure'];
                  $this->smtp_email       = $account['email'];
                  $this->smtp_pass        = $account['password'];
                  $this->smtp_host        = $account['host'];
                  $this->smtp_port        = $account['port'];
                  $this->smtp_limit       = $account['limit'];
                  
                  $this->smtp_from        = $this->check_random( $this->arrayrandom( $account['from']  ) );
                  $this->smtp_from_email  = $this->check_random( $this->arrayrandom( $account['from_email']  ) );
                  $this->sendsubject      = $this->check_random( $this->arrayrandom( $account['subject']  ) );

                  $this->pause            = $account['options']['pause'];
                  $this->delay            = $account['options']['for'];
      		$hitMail  = 1;
      		$hitMails = 1;  
      		foreach ($emailList as $key => $email) {
      			if($hitMails === $this->pause){
      				echo "[Sendinbox][==== delay ====] for $this->delay second ";
      				sleep($this->delay);
      				echo "\r\n";
      				echo "[Sendinbox][".$hitMail."/".$this->listEmail[total]."|".$smtacchit."/".count($config->account())."|".$this->smtp_limit."] ".$email." => ";
      				$hitMails = 0;
      			}else{
      				echo "[Sendinbox][".$hitMail."/".$this->listEmail[total]."|".$smtacchit."/".count($config->account())."|".$this->smtp_limit."] ".$email." => ";
      			}
                        
      			/* ARRAY LETTER / ALIAS | SETTING ALIAS DISINI */
                        $array_letter = array(
                              '{token}'   => md5(time()),
      				'{email}' 	=> $email, 
                              '{name}'    => 'Jhoe',
      				'{link}' 	=> "http://google.com", 
      				'{date}'  	=> date("D , d/m/Y")
      			);


      			$this->meletter = $config->letter($array_letter,$account['letter']);

      			$this->senders($email);
      			unset($emailList[$key]);
				if($hitMail >= $this->smtp_limit){
					$break = true;
				}
				if($break === true){
					$breaks = true;	
					$break = false;
					break;
				}
				$hitMails++;
				$hitMail++;
      		}
      			$smtacchit++;
      	}
    }
}
$Sendinbox = new Sendinbox;
$Sendinbox->send();
?>