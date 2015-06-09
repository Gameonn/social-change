<?php
//this is an api for checking hash tags

// +-----------------------------------+
// + STEP 1: include required files    +
// +-----------------------------------+
require_once("../php_include/db_connection.php");
//require_once('../classes/AllClasses.php');
//$cl = new Users;
$success=$msg="0";$data=array();
// +-----------------------------------+
// + STEP 2: get data				   +
// +-----------------------------------+

//$role=$_REQUEST['role'];
//$uid=$_REQUEST['user_id'];
$title=$_REQUEST['title'];
$desc=$_REQUEST['description']?$_REQUEST['description']:"";
$cap=1000;
$users='0';
//$price=$_REQUEST['price_id']?$_REQUEST['price_id']:'';


if(!($title && $cap )){
	$success="0";
	$msg="Incomplete Parameters";
	$data=array();
}
else{

	//check for the duplicate hash--title
	global $conn;
	$sth=$conn->prepare("select * from hash_tags where title=:title");
	$sth->bindValue("title",$title);
	try{$sth->execute();}
	catch(Exception $e){ echo $e->getMessage();}
	$result=$sth->fetchAll(PDO::FETCH_ASSOC);
	//print_r($result);die;
	if(count($result)){
		$success="0";
		$msg="Hashtag already exists";
	}
	else{
	$success='1';
	$msg="Hashtag Valid";
	}
	
}
echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
?>	