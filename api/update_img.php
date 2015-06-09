<?php
//this is an api to link users socially

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
$username=$_REQUEST['username'];
$image=$_FILES['pic'];
$uid=$_REQUEST['user_id'];
  function randomFileNameGenerator($prefix){
    $r=substr(str_replace(".","",uniqid($prefix,true)),0,20);
    if(file_exists("../uploads/$r")) randomFileNameGenerator($prefix);
    else return $r;
  }

global $conn;

if(!($username && $image)){
	$success="0";
	$msg="Incomplete Parameters";
	$data=array();
}
		
else{ 
	$sth=$conn->prepare("select * from users where username=:username ");
	$sth->bindValue("username",$username);
	try{$sth->execute();}catch(Exception $e){}
	$result=$sth->fetchAll(PDO::FETCH_ASSOC);
	$role=$result[0]['role'];
	if(count($result)){
	
	  $randomFileName=randomFileNameGenerator("Img_").".".end(explode(".",$image['name']));
	    if(@move_uploaded_file($image['tmp_name'], "../uploads/$randomFileName")){
	      $success="1";
	      $url=$randomFileName;
	    }
	
	$success='1';
	$msg='Image Updated Successfully';
	$sth=$conn->prepare("update users set pic=:pic where username=:username ");
	$sth->bindValue("username",$username);
	$sth->bindValue("pic",$url);
	try{$sth->execute();}catch(Exception $e){}
	
	if($role=='Brand'){
	
	$final = $cl->get_brand_profile($role,$uid);
	
	$success=1;
	
	$data=array();
	if($final){
	foreach($final as $key=>$value){
		$data['brand'][]=$value;
	}
	}
	$data['role']="Brand";
	$data['pricing']=$cl->get_prices();
	}
	elseif($role=='Non Profit Organization'){
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
	$data=array();
	$data['profile']=array();
	$data['brand']=array();
	$data['npo']=array();
	
	$final_resp= $cl->get_userdata($uid);
	$final = $cl->get_all_brands();
	$final_response = $cl->get_all_npo();
	$data['role']="Member";
	$success=1;
	
	if($final){
	foreach($final as $key=>$value){
		$data['brand'][]=$value;
	}}
	
	if($final_response){
	foreach($final_response as $key=>$value){
		$data['npo'][]=$value;
	}}
	
	if($final_resp){
	foreach($final_resp as $key=>$value){
		$data['profile'][]=$value;
	}}
	
	}
	
	}
	else{
	$success='0';
	$msg='Invalid Username';
	}
	

	
	}	



// +-----------------------------------+
// + STEP 4: send json data			   +
// +-----------------------------------+

echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
?>