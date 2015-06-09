<?php
//this is an api to link users socially

// +-----------------------------------+
// + STEP 1: include required files    +
// +-----------------------------------+
require_once("../php_include/db_connection.php");

$success=$msg="0";$data=array();
// +-----------------------------------+
// + STEP 2: get data				   +
// +-----------------------------------+
$username=$_REQUEST['username'];

$fbid=$_REQUEST['fbid']?$_REQUEST['fbid']:'';
$twid=$_REQUEST['twitterid']?$_REQUEST['twitterid']:'';
$googleid=$_REQUEST['googleid']?$_REQUEST['googleid']:'';
$instagram_id=$_REQUEST['instagram_id']?$_REQUEST['instagram_id']:'';

global $conn;

if(!($username && ($fbid || $twid || $googleid || $instagram_id))){
	$success="0";
	$msg="Incomplete Parameters";
	$data=array();
}
		
else{ 
	$sth=$conn->prepare("select * from users where username=:username");
	$sth->bindValue("username",$username);
	try{$sth->execute();}catch(Exception $e){}
	$result=$sth->fetchAll(PDO::FETCH_ASSOC);
	if(count($result)){
		$success="0";
		if($fbid){
		$sth=$conn->prepare("update users set fbid=:fbid,verified=1 where username=:username ");
	$sth->bindValue("username",$username);
	$sth->bindValue("fbid",$fbid);
	}
	elseif($twid){
	$sth=$conn->prepare("update users set twitterid=:twid,verified=1 where username=:username ");
	$sth->bindValue("username",$username);
	$sth->bindValue("twid",$twid);
	}
	elseif($googleid){
	$sth=$conn->prepare("update users set googleid=:googleid,verified=1 where username=:username ");
	$sth->bindValue("username",$username);
	$sth->bindValue("googleid",$googleid);
	}
	elseif($instagram_id){
	$sth=$conn->prepare("update users set instagram_id=:instagram_id,verified=1 where username=:username ");
	$sth->bindValue("username",$username);
	$sth->bindValue("instagram_id",$instagram_id);
	}
	
	$count=0;
	try{$count=$sth->execute();}catch(Exception $e){}
	
		if($count){
		$success=1;
		$msg="Profile linked successfully";
		}
		else{
		$success=0;
		$msg="Error during linking";
		}
			}

	
	else{	
	$success=0;
	$msg="User Doesnot exists";
		}
	
	}	



// +-----------------------------------+
// + STEP 4: send json data			   +
// +-----------------------------------+

echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
?>