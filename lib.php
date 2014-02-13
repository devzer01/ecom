<?php 

//library functions used by the system


function sendMail($email, $subject, $message)
{
	if(trim($email) == "") return false;
	
	require_once "Mail.php";
	
	$params["host"] = "ssl://smtp.gmail.com";
	$params["port"] = 465;
	$params["auth"] = true;
	$params["username"] = MAIL_USERNAME;
	$params["password"] = MAIL_PASSWORD;
	$headers['MIME-Version'] = '1.0';
	$headers['Content-type'] = 'text/html; charset=utf8';
	$headers['From'] = "slbeat@corp-gems.com";
	$headers['To'] = $email;
	$headers['Subject'] = "=?utf-8?B?".base64_encode($subject)."?=";

	$mail = Mail::factory("smtp", $params);
	$result = $mail->send($email, $headers, $message);

	if (PEAR::isError($result))return false;
		
	return true;
}