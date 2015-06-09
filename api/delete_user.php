<?php
//this is an api to delete users
// +-----------------------------------+
// + STEP 1: include required files    +
// +-----------------------------------+
require_once("../php_include/db_connection.php");

$success=$msg="0";$data=array();

// +-----------------------------------+
// + STEP 2: get data				   +
// +-----------------------------------+
$access_token=$_REQUEST['access_token'];


if(!($access_token)){
	$success="0";
	$msg="Incomplete Parameters";
}
else{
	$sql="select * from tokens where token_key=:access_token";
	$sth=$conn->prepare($sql);
	$sth->bindValue("access_token",$access_token);
	try{$sth->execute();}catch(Exception $e){}
	$result=$sth->fetchAll();
	$uid=$result[0]['user_id'];
	
if(count($result)){
	$sql="delete from users where id=:user_id";
		$sth=$conn->prepare($sql);
		$sth->bindValue('user_id',$uid);
		$count1=0;
		try{$count1=$sth->execute();}
		catch(Exception $e){echo $e->getMessage();}

	
	if($count1){
		$success="1";
		$msg="User Deleted";
	}
	else{
		$success="0";
		$msg="Error occurred";
	}
}
else{
	$success="0";
	$msg="Invalid access token";
}
}

// +-----------------------------------+
// + STEP 4: send json data			   +
// +-----------------------------------+
echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
?>