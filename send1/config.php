<?php
class Config
{
	public function account(){
		return array(
			/*------------- SENDINBOX -------------*/
			/*
				--- 
					THIS FUNCTION ONLY from , from email and subject 
				---
				use command : {type,length} // default 10

				use command : {numrandom,20} for ony random number
				use command : {textrandom,20} for ony random text
				use command : {textnumrandom,20} for ony random number and text

			*/


			/*------------- congig in here -------------*/
			array(
				'email' 		=> 'udson@pedro-storebook.cc', // smtp  username
				'password' 		=> 'Warkop148',	      // smtp  password
				'host' 			=> 'smtp-relay.gmail.com',     // smtp  host	
				'port' 			=> '587', 				 // smtp  port	  
				'secure'    	=> 'tls',
				'limit' 		=> '300',  
				'from' 			=>  array( 'Apple'),
				'from_email' 	=> 	array( 'appleid.billingaccount@mail.com'),
				'subject'   	=> 	array( 'RE: [ Summary Report Alert ] : New Statement Update Account Submitted to Update Information'),
				'letter' 		=> 'letter1.html',  
				'options'   	=> array(
					'pause' 	=> 5,
					'for' 		=> 15,
				)
			),
			/*-----------------------------------------*/


		);
	}
	public function letter($config = null,$letters = null){
		$letter = file_get_contents("letter/".$letters);
		foreach ($config as $key => $value) {
			$letter = str_replace($key, $value, $letter);
		}
		return $letter;
	}
}