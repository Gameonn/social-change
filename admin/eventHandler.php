<?php 
//this page is to handle all the admin events occured at client side
 require_once("../php_include/db_connection.php"); 
require_once('../PHPMailer_5.2.4/class.phpmailer.php');
$success=0;
$msg="";

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



//switch case to handle different events
switch($_REQUEST['event']){
	case "signin":
	
		$success=0;
		$user=$_REQUEST['username'];
		$password=$_REQUEST['password'];
		$redirect=$_REQUEST['redirect'];
		$sth=$conn->prepare("select * from admin where (username=:username or email=:email)");
		$sth->bindValue("username",$user);
		$sth->bindValue("email",$user);
		$count=0;
		try{$count=$sth->execute();}catch(Exception $e){
		//echo $e->getMessage();
		}
		$result=$sth->fetchAll(PDO::FETCH_ASSOC);
		
		if($count && count($result)){
			foreach($result as $row){
			
				if($row['password']==md5($password)){
					session_start();
					$success=1;
					$_SESSION['admin']['id']=$row['id'];
					$_SESSION['admin']['username']=$row['username'];
					$_SESSION['admin']['email']=$row['email'];
					
				}
			}
		}
		if(!$success){
			$redirect="index.php";
			$msg="Invalid Username/Password";
		}
		header("Location: $redirect?success=$success&msg=$msg");
		break;
	
	case "signout":
	session_start();
		unset($_SESSION['admin']);
		session_destroy();
		header("Location: index.php?success=1&msg=Signout Successful!");
		break;
		
	case "payout":
	
	$uid=$_REQUEST["user_id"];
	$sth=$conn->prepare("select role from users where id=:id");
	$sth->bindValue("id",$uid);
	try{$sth->execute();}catch(Exception $e){
	echo $e->getMessage();
	}
	$result=$sth->fetchAll(PDO::FETCH_ASSOC);
	if($result[0]['role']=='Member')
	$redirect='users.php';
	else
	$redirect="npo.php";
	$sth=$conn->prepare("update payout set amount_paid=amount_paid+100 where user_id=:user_id");
	$sth->bindValue("user_id",$uid);
	try{$sth->execute();}catch(Exception $e){echo $e->getMessage();}
	
	header("Location: $redirect?success=1&msg=Payout Successful!");
	break;
	
	
	case "email_template":
	 $type=$_REQUEST["type"];
		$subject_mail=$_REQUEST["subject_mail"];
		$body_mail=$_REQUEST["body_mail"];
		$support_email=$_REQUEST["support_email"];
		$url=$_REQUEST["url"];
		$redirect="view_email_template.php";
	
	
	$sql="update email_temp set subject_mail=:subject_mail,body_mail=:body_mail,support_email=:support_email,url=:url where id=:id ";
	$sth=$conn->prepare($sql);
	$sth->bindValue('subject_mail',$subject_mail);
	$sth->bindValue('body_mail',$body_mail);
	$sth->bindValue('url',$url);
	$sth->bindValue('support_email',$support_email);
	$sth->bindValue('id',$type);
	try{$sth->execute();}
	catch(Exception $e){
	echo $e->getMessage();
	}
	
	header("Location: $redirect?type=$type");
	break;
	
	case 'get_template':
	//print_r($_REQUEST);
	$type=$_REQUEST['type'];
	$sql="select * from email_temp where id=:id";
	$sth=$conn->prepare($sql);
	$sth->bindValue('id',$type);
	try{$sth->execute();}
	catch(Exception $e){
	echo $e->getMessage();
	}
	$res=$sth->fetchAll();
	
	echo json_encode($res);
	break;
	
	case "reset-password":
		$token=$_REQUEST["token"];
		$username=$_REQUEST["username"];
		$password=$_REQUEST["password"];
		$confirm=$_REQUEST["confirm"];
		$redirect="../thank_you.php";
		if(!($username && $token)){
		if($password==$confirm){
			$sth=$conn->prepare("update admin set password=:password where username='admin'");
			$sth->bindValue("password",md5($password));
			$count=0;
			try{$count=$sth->execute();}catch(Exception $e){echo $e->getMessage();}
			if($count){
				$success=1;
				$redirect="index.php";
				$msg="Password changed successfully";
			}
			}else{
				$redirect="../reset-password.php";
				$success=0;
				$msg="Passwords didn't match";
			}
		}
		else{
		if($password==$confirm){
				$sth=$conn->prepare("update users set password=:password where username=:username");
				$sth->bindValue("username",$username);
				$sth->bindValue("password",md5($password));
				$count=0;
				try{$count=$sth->execute();}catch(Exception $e){echo $e;}
				if($count){
					$success=1;
					$msg="Password changed successfully";
				}
			}else{
				$success=0;
				$redirect="../reset-password.php";
				$msg="Passwords didn't match";
			}
			}
	header("Location: $redirect?success=$success&msg=$msg");
	break;
	
	case "delete-user":
	//print_r($_POST);die;
	$uid=$_REQUEST['user_id'];
		$sql="delete from users where id=:user_id";
		$sth=$conn->prepare($sql);
		$sth->bindValue('user_id',$uid);
		$count1=0;
		try{$count1=$sth->execute();}
		catch(Exception $e){
		echo $e->getMessage();
		}
	if($count1){
		$success="1";
		echo $msg="User Deleted";
	}
	else{
		$success="0";
		echo 'error';
	}
	
	break;
	
	
	case "change-password":
		$success=$msg=null;
		$redirect=$_REQUEST['redirect'];
		$oldpass=$_REQUEST['oldpass'];
		$newpass=$_REQUEST['newpass'];
		
		$sth=$conn->prepare("select * from admin where password=:password");
		$sth->bindValue("password",md5($oldpass));
		
		try{$sth->execute();}
		catch(Exception $e){
		//echo $e->getMessage();
		}
		$result=$sth->fetchAll(PDO::FETCH_ASSOC);
		
		if(count($result) && $newpass && ($newpass==$_REQUEST['confirm'])){
			$newpass=md5($newpass);
			$sth=$conn->prepare("update admin set password=:password where username=:username");
			$sth->bindValue("username",'admin');
			$sth->bindValue("password",$newpass);
			$count=0;
			try{$count=$sth->execute();}catch(Exception $e){echo $e->getMessage();}
			if($count){
				$success=1;
				$msg="Password Updated!";
			}
			else{
				$success=0;
				$msg="Invalid Request! Try Again Later!";
				$redirect="changePassword.php";
			}
		}
		else{
			$success=0;
			
			if($newpass) $msg="All Fields are required!"; else $msg="Passwords didn't match!";
			$redirect="changePassword.php";
		}
		
		
		header("Location: $redirect?success=$success&msg=$msg");
		break;
		
		
	   case 'forgot_password':
          $email=$_REQUEST['email'];
          $redirect='forgot_password.php';
          if(!($email)){
           $success="0";
           $msg="Incomplete Parameters";
         }
         else{
           $sql="select * from admin where email=:email";
           $sth=$conn->prepare($sql);
           $sth->bindValue("email",$email);
           try{$sth->execute();}catch(Exception $e){
        	echo $e->getMessage();
           }
           $res=$sth->fetchAll();
		   
		$sql="select * from email_temp where id=2";
		$sth=$conn->prepare($sql);
		try{$sth->execute();}
		catch(Exception $e){}
		$temp_email=$sth->fetchAll();
		$subject_mail=$temp_email[0]['subject_mail'];
		$body_mail=$temp_email[0]['body_mail'];
		$url=$temp_email[0]['url'];
		$support_email=$temp_email[0]['support_email'];
		
           if(count($res)){ 
                        
              $success="1";
              $msg="An email is sent to you";
              
             sendEmail($email,$subject_mail,
			"<div style='font-size:20px;line-height:1.6;'>
				<p>Dear Admin,</p>
				<br>
				<p>". $body_mail ."</p>
				<p>Please follow the link below to set a new password:</p>
				<p><a href='".BASE_PATH."reset-password.php'>".BASE_PATH."reset-password.php</a></p>
				<p>For questions or technical assistance, please email SocialChange technical support: ".$support_email . "</p>
		                <br>
		                <p>Thank you,</p>
		                <p>SocialChange</p>
		                <p><a href='".$url." '> ". $url ." </a></p>
		              </div>"
		,SMTP_EMAIL);
          
          }
          else{
            $success="0";
            $msg="Invalid Email ";
          }
        }
        header("Location: $redirect?success=$success&msg=$msg");
        break;
        	
}	
?>