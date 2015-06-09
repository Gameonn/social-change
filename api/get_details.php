<?php
//this is an api to login users

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

$user_id=$_REQUEST['user_id'];
$uid=$user_id;
if(!($user_id)){
	$success="0";
	$msg="Incomplete Parameters";
	$data=array();
}
else{

// +-----------------------------------+
// + STEP 3: perform operations		   +
// +-----------------------------------+
	$sql="select * from users where id=:id";
	$sth=$conn->prepare($sql);
	$sth->bindValue("id",$user_id);
	
	try{$sth->execute();}
	catch(Exception $e){
	//echo $e->getMessage();
	}
	$result=$sth->fetchAll(PDO::FETCH_ASSOC);
	$role=$result[0]['role'];
	$is_live=$result[0]['is_live'];
	
	if(count($result)){

	if($role=='Brand'){
	
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
	
	
	if($final_response ){
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
		$success="0";
		$msg="Invalid user";
	}
	

}
// +-----------------------------------+
// + STEP 4: send json data			   +
// +-----------------------------------+

echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
?>