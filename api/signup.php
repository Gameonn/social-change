<?php
//this is an api to register users on the server

// +-----------------------------------+
// + STEP 1: include required files    +
// +-----------------------------------+
require_once("../php_include/db_connection.php");
require_once('../PHPMailer_5.2.4/class.phpmailer.php');

//random file name generator
function randomFileNameGenerator($prefix){
	$r=substr(str_replace(".","",uniqid($prefix,true)),0,20);
	if(file_exists("../uploads/$r")) randomFileNameGenerator($prefix);
	else return $r;
}

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
$username=$_REQUEST['username'];
$email=$_REQUEST['email'];
$fbid=$_REQUEST['fbid']?$_REQUEST['fbid']:'';
$twid=$_REQUEST['twitterid']?$_REQUEST['twitterid']:'';
$googleid=$_REQUEST['googleid']?$_REQUEST['googleid']:'';
$instagram_id=$_REQUEST['instagram_id']?$_REQUEST['instagram_id']:'';
$image=$_FILES['pic'];
$password=isset($_REQUEST['password']) && $_REQUEST['password'] ? $_REQUEST['password'] : null;
$contact=$_REQUEST['contact_number']?$_REQUEST['contact_number']:'';
$taxid=$_REQUEST['tax_id']?$_REQUEST['tax_id']:'';
$paypal=$_REQUEST['paypal_email']?$_REQUEST['paypal_email']:'';

 $role=$_REQUEST['role'];
 
 $verified=0;
 if($role=='Brand'){
 $brand=$username;
 }
 else
 $brand=$role;
 
global $conn;

if(!($username && $email && $role && $password && $image)){
	$success="0";
	$msg="Incomplete Parameters";
	$data=array();
}
	elseif($image["error"]>0){
		$success="0";
		$msg="Invalid image";
		if($image["error"]==4) $success="1"; //image is not mandatory
	}
	//upload image
	elseif(in_array($image['type'],array("image/gif","image/jpeg","image/jpg","image/png","image/pjpeg","image/x-png")) && in_array(end(explode(".",$image['name'])), array("gif","jpeg","jpg","png"))){
		$randomFileName=randomFileNameGenerator("Img_").".".end(explode(".",$image['name']));
		if(@move_uploaded_file($image['tmp_name'], "../uploads/$randomFileName")){
			$success="1";
			$image_path=$randomFileName;
		}
		else{
			$success="0";
			$msg="Error in uploading image";
		}
	}
	else{
		$success="1";
		$msg="Invalid Image";
	}
	
	
	if($success=="1"){ 
	$sth=$conn->prepare("select * from users where (username=:username or email=:email) ");
	$sth->bindValue("username",$username);
	$sth->bindValue("email",$email);
	try{$sth->execute();}catch(Exception $e){}
	$result=$sth->fetchAll(PDO::FETCH_ASSOC);
	if(count($result)){
		$success="0";
		if($username==$result[0]['username'])
			$msg="Username is already taken";
		else
			$msg="Email is already registered";
			
	//delete image
	if($image_path){ if(@unlink("../uploads/$image_path")){}}
	}
	else{	
	
	$sql="insert into users values(DEFAULT,:fbid,:twitterid,:googleid, :instagram_id,:email, :role,:username,:password,:contact_number, :paypal_email,:tax_id,:brand_name, :pic, 0,:verified,NOW())";
		$sth=$conn->prepare($sql);
		$sth->bindValue("fbid",$fbid);
		$sth->bindValue("twitterid",$twid);
		$sth->bindValue("googleid",$googleid);
		$sth->bindValue("instagram_id",$instagram_id);
		$sth->bindValue("email",$email);
		$sth->bindValue("role",$role);
		$sth->bindValue("username",$username);
		$sth->bindValue("password",md5($password));
		$sth->bindValue("contact_number",$contact);
		$sth->bindValue("paypal_email",$paypal);
		$sth->bindValue("tax_id",$taxid);
		$sth->bindValue("brand_name",$brand);
		$sth->bindValue('pic',$image_path);
		$sth->bindValue('verified',$verified);
		
		$count1=0;
		try{$count1=$sth->execute();
		$uid=$conn->lastInsertId();
		}catch(Exception $e){echo $e->getMessage();}
		
		$code=md5($username . rand(1,9999999));
		
		$sql="insert into tokens values(DEFAULT,:token_key,:user_id)";
		$sth=$conn->prepare($sql);
		$sth->bindValue("token_key",$code);
		$sth->bindValue("user_id",$uid);
		$count2=0;
		try{$count2=$sth->execute();}catch(Exception $e){echo $e->getMessage();}
		
		if($count1 && $count2){
		//$msg="Users Successfully registered";
		    $success="1";
              $msg="Email Sent";
              
			  	$sql="select * from email_temp where id=1";
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
              try{ $sth->execute();}catch(Exception $e){}
              $result=$sth->fetchAll();
              $username=ucwords($username);
              sendEmail($email,$subject_mail,
                "<div style='font-size:20px;line-height:1.4;'>
                <p>Dear $username,</p>
                <br>
                <p>". $body_mail."</p>
                <p>Please follow the link below to verify your account:</p>
                <p><a href='".BASE_PATH."thank_you.php?token={$code}'>".BASE_PATH."thank_you.php?token={$code}</a></p>
                <p>For questions or technical assistance, please email SocialChange technical support: ". $support_email."</p>
                <br>
                <p>Thank you,</p>
                <p>SocialChange</p>
                <p><a href='".$url."'> ".$url." </a></p>
              </div>"
              ,SMTP_EMAIL);
		
		}
		}
	
	}	
 $code=$code?$code:"";


// +-----------------------------------+
// + STEP 4: send json data			   +
// +-----------------------------------+

echo json_encode(array("success"=>$success,"msg"=>$msg,"access_token"=>$code));
?>