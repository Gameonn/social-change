<?php
//this is an api to recover password
// +-----------------------------------+
// + STEP 1: include required files    +
// +-----------------------------------+
require_once "../php_include/db_connection.php"; 
require_once('../PHPMailer_5.2.4/class.phpmailer.php');


function sendEmail($email,$subjectMail,$bodyMail,$email_back){

	$mail = new PHPMailer(true); 
	$mail->IsSMTP(); // telling the class to use SMTP
	try {
	  //$mail->Host       = SMTP_HOST; // SMTP server
	  $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	  $mail->SMTPAuth   = true;                  // enable SMTP authentication
	  $mail->Host       = SMTP_HOST; // sets the SMTP server
	  $mail->Port       = SMTP_PORT;                    // set the SMTP port for the GMAIL server
	  $mail->Username   = SMTP_USER; // SMTP account username
	  $mail->Password   = SMTP_PASSWORD;        // SMTP account password
	  $mail->AddAddress($email, '');     // SMTP account password
	  $mail->SetFrom(SMTP_EMAIL, SMTP_NAME);
	  $mail->AddReplyTo($email_back, SMTP_NAME);
	  $mail->Subject = $subjectMail;
	  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automaticall//y
	  $mail->MsgHTML($bodyMail) ;
	  if(!$mail->Send()){
			$success='0';
			$msg="Error in sending mail";
	  }else{
			$success='1';
	  }
	} catch (phpmailerException $e) {
	  $msg=$e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  $msg=$e->getMessage(); //Boring error messages from anything else!
	}
	//echo $msg;
}




$success=$msg="0";$data=array();

// +-----------------------------------+
// + STEP 2: get data				   +
// +-----------------------------------+
$email=$_REQUEST['email'];

if(!($email)){
	$success="0";
	$msg="Incomplete Parameters";
}
else{
	$sql="select * from users where email=:email";
	$sth=$conn->prepare($sql);
	$sth->bindValue("email",$email);
	try{$sth->execute();}
	catch(Exception $e){}
	$res=$sth->fetchAll();
	$uid=$res[0]['id'];
	if(count($res)){
	
		$token=md5($email. rand(1,9999999));
		$sql="update tokens set token_key=:token_key where user_id=:user_id";
		$sth=$conn->prepare($sql);
		$sth->bindValue('token_key',$token);
		$sth->bindValue('user_id',$uid);
		$count=0;
		try{$count=$sth->execute();
		}
		catch(Exception $e){echo $e->getMessage();}

	if($count){
		$success="1";
		$msg="Email Sent";
		$sql="select * from email_temp where id=2";
		$sth=$conn->prepare($sql);
		try{$sth->execute();}
		catch(Exception $e){}
		$temp_email=$sth->fetchAll();
		$subject_mail=$temp_email[0]['subject_mail'];
		$body_mail=$temp_email[0]['body_mail'];
		$url=$temp_email[0]['url'];
		$support_email=$temp_email[0]['support_email'];
		
		$sql="select username from users where email=:email";
		$sth=$conn->prepare($sql);
		$sth->bindValue('email',$email);
		try{ $sth->execute();}
		catch(Exception $e){}
		$result=$sth->fetchAll();
		$username=ucwords($result[0]['username']);
		$user=$result[0]['username'];
		sendEmail($email,$subject_mail,
						"<div style='font-size:20px;line-height:1.4;'>
							<p>Dear $username,</p>
							<br>
							<p>". $body_mail ."</p>
							<p>Please follow the link below to set a new password:</p>
							<p><a href='".BASE_PATH."reset-password.php?token={$token}&username={$user}'>".BASE_PATH."reset-password.php?token=		{$token}&username={$user}</a></p>
							<p>For questions or technical assistance, please email SocialChange technical support: ". $support_email ."</p>
					                <br>
					                <p>Thank you,</p>
					                <p>SocialChange</p>
					                <p><a href='". $url ."'>". $url ." </a></p>
					              </div>"
					,SMTP_EMAIL);
	}else{
		$success="0";
		$msg="Error occurred";
	}
	}
	else{
		$success="0";
		$msg="Invalid Email";
	}
	
}
// +-----------------------------------+
// + STEP 4: send json data			   +
// +-----------------------------------+
echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
?>