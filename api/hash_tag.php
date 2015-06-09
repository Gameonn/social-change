<?php
//this is an api for hash

// +-----------------------------------+
// + STEP 1: include required files    +
// +-----------------------------------+
require_once("../php_include/db_connection.php");
require_once('../classes/AllClasses.php');
$cl = new Users;
$success=$msg="0";$data=array();
// +-----------------------------------+
// + STEP 2: get data				   +
// +-----------------------------------+

$role=$_REQUEST['role'];
$uid=$_REQUEST['user_id'];
$title=$_REQUEST['title'];
$desc=$_REQUEST['description']?$_REQUEST['description']:"";
$cap=1000;
$users='0';
$price=$_REQUEST['price_id']?$_REQUEST['price_id']:'';

if($role=="Brand"){
if(!($title && $cap && $price )){
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

		$sql="insert into hash_tags values(DEFAULT,:user_id,:title,:description,:users,:set_cap,NOW())";
		$sth=$conn->prepare($sql);
		$sth->bindValue("user_id",$uid);
		$sth->bindValue("title",$title);
		$sth->bindValue("description",$desc);
		$sth->bindValue("users",$users);
		$sth->bindValue("set_cap",$cap);
		//$sth->bindValue("created_on",date('Y-m-d H:i:s'));
		$count1=0;
		
		try{$count1=$sth->execute();
		$hid=$conn->lastInsertId();
		}catch(Exception $e){
		//echo $e->getMessage();
		}
			
		
		$sql="insert into budget values(DEFAULT,:user_id,:hash_id,:price_id)";
		$sth=$conn->prepare($sql);
		$sth->bindValue('user_id',$uid);
		$sth->bindValue('hash_id',$hid);
		$sth->bindValue('price_id',$price);
		$count2=0;
		
		try{$count2=$sth->execute();	
		}
		catch(Exception $e){
		//echo $e->getMessage();
		}
		
		if($count1 && $count2 ){
		$success="1";
		$msg="Hashtag Created successfully";
		$final = $cl->get_brand_profile($role,$uid);
	
		$success=1;
	
		$data=array();
		if($final){
		foreach($final as $key=>$value){
		$data['brand'][]=$value;
		}}
		$data['role']="Brand";
		$data['pricing']=$cl->get_prices();
		}
		else{
		$success='0';
		$msg='Hashtag Creation Failed';
		}
}
}

}
elseif($role=="Non Profit Organization"){
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

		$sql="insert into hash_tags values(DEFAULT,:user_id,:title,:description,:users,:set_cap,NOW())";
		$sth=$conn->prepare($sql);
		$sth->bindValue("user_id",$uid);
		$sth->bindValue("title",$title);
		$sth->bindValue("description",$desc);
		$sth->bindValue("users",$users);
		$sth->bindValue("set_cap",$cap);
		$count=0;
		
		try{$count=$sth->execute();
		}catch(Exception $e){
		//echo $e->getMessage();
		}
				
		if($count){
		$success="1";
		$msg="Hashtag Created successfully";
			$final = $cl->get_npo_profile($role,$uid);

	$success=1;
	
	$data=array();
	if($final){
	foreach($final as $key=>$value){
		$data['npo'][]=$value;
	}}
	$data['role']="Non Profit Organization";
			}
		else{
		$success='0';
		$msg='Hashtag Creation Failed';
		}
	}
	

}


}
else{
$success='0';
$msg='Error Occured';
}
// +-----------------------------------+
// + STEP 4: send json data			   +
// +-----------------------------------+

echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
?>