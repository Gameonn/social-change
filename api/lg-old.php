<?php
//this is an api to login users

// +-----------------------------------+
// + STEP 1: include required files    +
// +-----------------------------------+
require_once("../php_include/db_connection.php");
require_once('../classes/AllClasses.php');
/*$profile = $user->get_user_profile($user_id);
	$categories = $user->get_user_categories($user_id);*/
$success=$msg="0";$data=array();
// +-----------------------------------+
// + STEP 2: get data				   +
// +-----------------------------------+

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];

if(!($username && $password )){
	$success="0";
	$msg="Incomplete Parameters";
	$data=array();
}
else{

// +-----------------------------------+
// + STEP 3: perform operations		   +
// +-----------------------------------+
	$sql="select * from users where username=:username and password=:password";
	$sth=$conn->prepare($sql);
	$sth->bindValue("username",$username);
	$sth->bindValue("password",md5($password));
	try{$sth->execute();}catch(Exception $e){}
	$result=$sth->fetchAll(PDO::FETCH_ASSOC);
	$role=$result[0]['role'];
	$uid=$result[0]['id'];
	if(count($result)){
	$code=md5($username.rand(1,9999999));
	$sql="insert into tokens values(DEFAULT,:token_key)";
		$sth=$conn->prepare($sql);
		$sth->bindValue('token_key',$code);
		$count2=0;
		try{$count2=$sth->execute();
		//$tid=$conn->lastInsertId();
		}
		catch(Exception $e){echo $e->getMessage();}

	if($role=='brand'){
	
	$sql="select users.id,users.fbid,users.twitterid,users.username,users.email,users.contact_number,users.paypal_email,users.brand_name,users.pic, hash_tags.title, hash_tags.description, hash_tags.users,hash_tags.set_cap,hash_tags.created_on, budget.price_id,(select pricing.price from pricing where pricing.id=budget.price_id ) as price,(select sum(count) from social_provider where social_provider.hash_id=hash_tags.id) as sum from users join hash_tags on hash_tags.user_id=users.id join budget on budget.hash_id=hash_tags.id and budget.user_id=users.id where users.role=:role and users.id=:uid";
	
	$sth=$conn->prepare($sql);
	$sth->bindValue("role",$role);
	$sth->bindValue("uid",$uid);
	try{$sth->execute();}
	catch(Exception $e){}
	$res=$sth->fetchAll(PDO::FETCH_ASSOC);

	$success=1;
	
	foreach($res as $key=>$value){
		if(empty($final[$value['id']])){
		$final[$value['id']]=array("user_id"=>$value['id'],
				"username"=>$value['username'],
				"email"=>$value['email'],
				"contact_number"=>$value['contact_number'],
				"paypal_email"=>$value['paypal_email'],
				"brand_name"=>$value['brand_name'],
				"role"=>'Brand',
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"hashes"=>array());
		}
				
		$final[$value['id']]['hashes'][]=array("hash_title"=>$value['title'],
				"hash_description"=>$value['description'],
				"users"=>$value['users'],
				"setcap"=>'1000',
				"created_on"=>$value['created_on'],
				"price"=>$value['price'],
				"total_hash_count"=>$value['sum']);		
				
	}
	
	
	
	
	$data=array();
	foreach($final as $key=>$value){
		$data['brand'][]=$value;
	}
	
	
	
	$data['role']="Brand";
	
	}
	
	
	elseif($role=='npo'){
	
	$sql="select users.id,users.fbid,users.twitterid,users.username,users.email,users.contact_number,users.paypal_email,users.brand_name,users.pic,payout.amount_earned as earned, hash_tags.title, hash_tags.description, hash_tags.users,hash_tags.set_cap,hash_tags.created_on,(select sum(count) from social_provider where social_provider.hash_id=hash_tags.id) as sum from users join hash_tags on hash_tags.user_id=users.id join payout on payout.user_id=users.id  where users.role=:role and users.id=:uid" ;
	
	$sth=$conn->prepare($sql);
	$sth->bindValue("role",$role);
	$sth->bindValue("uid",$uid);
	try{$sth->execute();}
	catch(Exception $e){echo $e->getMessage();}
	$res=$sth->fetchAll(PDO::FETCH_ASSOC);
	$success=1;
	foreach($res as $key=>$value){
		if(empty($final[$value['id']])){
		$final[$value['id']]=array("user_id"=>$value['id'],
				"username"=>$value['username'],
				"email"=>$value['email'],
				"contact_number"=>$value['contact_number'],
				"paypal_email"=>$value['paypal_email'],
				"tax_id"=>$value['tax_id'],				
				"amount_earned"=>$value['earned'],
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"hashes"=>array()
				);
		}
				
		$final[$value['id']]['hashes'][]=array("hash_title"=>$value['title'],
				"hash_description"=>$value['description'],
				"users"=>$value['users'],
				"setcap"=>'1000',
				"created_on"=>$value['created_on'],
				"total_hash_count"=>$value['sum']
				);		
				
	}
	
	
	
	
	$data=array();
	foreach($final as $key=>$value){
		$data['npo'][]=$value;
	}
	$data['role']="Non Profit Organization";
	
	}
	else{
	
	$sql="select users.id,users.fbid,users.twitterid,users.username,users.email,users.contact_number,users.paypal_email,users.brand_name,users.pic, hash_tags.title, hash_tags.description, hash_tags.users,hash_tags.set_cap,hash_tags.created_on, budget.price_id,(select pricing.price from pricing where pricing.id=budget.price_id ) as price,(select sum(count) from social_provider where social_provider.hash_id=hash_tags.id) as sum from users left join hash_tags on hash_tags.user_id=users.id left join budget on budget.hash_id=hash_tags.id and budget.user_id=users.id where users.role=:role";
	
	$sth=$conn->prepare($sql);
	$sth->bindValue("role",'brand');
	try{$sth->execute();}
	catch(Exception $e){}
	$res=$sth->fetchAll(PDO::FETCH_ASSOC);
	$success=1;
	
	$sql="select users.id,users.fbid,users.twitterid,users.username,users.email,users.contact_number,users.paypal_email,users.brand_name,users.pic,payout.amount_earned as earned, hash_tags.title, hash_tags.description, hash_tags.users,hash_tags.set_cap,hash_tags.created_on,(select sum(count) from social_provider where social_provider.hash_id=hash_tags.id) as sum from users left join hash_tags on hash_tags.user_id=users.id left join payout on payout.user_id=users.id  where users.role=:role" ;
	
	$sth=$conn->prepare($sql);
	$sth->bindValue("role",'npo');
	try{$sth->execute();}
	catch(Exception $e){echo $e->getMessage();}
	$r1=$sth->fetchAll(PDO::FETCH_ASSOC);
	
	
		$sql="select users.*, (select group_concat(social_provider.provider) from social_provider where social_provider.user_id=:user_id) as provider,(select group_concat(hash_tags.title)  from hash_tags left join social_provider on social_provider.hash_id=hash_tags.id where social_provider.user_id=:user_id) as hash,payout.* from users left join payout on payout.user_id=users.id where users.id=:user_id" ;
	
	$sth=$conn->prepare($sql);
	$sth->bindValue("user_id",$uid);
	try{$sth->execute();}
	catch(Exception $e){echo $e->getMessage();}
	$r2=$sth->fetchAll(PDO::FETCH_ASSOC);

	
	foreach($res as $key=>$value){
		if(empty($final[$value['id']])){
		$final[$value['id']]=array("user_id"=>$value['id'],
				"username"=>$value['username'],
				"email"=>$value['email'],
				"contact_number"=>$value['contact_number'],
				"paypal_email"=>$value['paypal_email'],
				"brand_name"=>$value['brand_name'],
				"role"=>'Brand',
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"hashes"=>array());
		}
			if(!empty($value['title'])){	
		$final[$value['id']]['hashes'][]=array("hash_title"=>$value['title']?$value['title']:"",
				"hash_description"=>$value['description']?$value['description']:"",
				"actual_count"=>$value['users']?$value['users']:"",
				"setcap"=>'1000',
				"created_on"=>$value['created_on']?$value['created_on']:"",
				"price"=>$value['price']?$value['price']:"",
				"total_hash_count"=>$value['sum']?$value['sum']:"");		
				}
	}
	
	
	
	
	$data=array();
	$data['profile']=array();
	foreach($r2 as $key=>$value){
		$data['profile'][]=array("user_id"=>$uid?$uid:"",
				"fbid"=>$value['fbid']?$value['fbid']:"",
				"twitterid"=>$value['twitterid']?$value['twitterid']:"",
				"username"=>$value['username'] ,
				"email"=>$value['email'],
				"created_on"=>$value['created_on'],
				"contact"=>$value['contact']?$value['contact']:"",
				"paypal"=>$value['paypal_email']?$value['paypal_email']:"",
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"verified"=>$value['verified']?$value['verified']:"",
				"provider"=>$value['provider']?$value['provider']:"",
				"hash"=>$value['hash']?$value['hash']:"",
				"amount_earned"=>$value['amount_earned']?$value['amount_earned']:"",
				"status"=>$value['status']?$value['status']:""
				);		
				}
	
	$data['brand']=array();
	$data['npo']=array();
	foreach($final as $key=>$value){
		$data['brand'][]=$value;
	}
	
	foreach($r1 as $key=>$value){
		if(empty($final_response[$value['id']])){
		$final_response[$value['id']]=array("user_id"=>$value['id'],
				"username"=>$value['username'],
				"email"=>$value['email'],
				"contact_number"=>$value['contact_number'],
				"paypal_email"=>$value['paypal_email']?$value['paypal_email']:"",
				"tax_id"=>$value['tax_id']?$value['tax_id']:"",
				"role"=>'npo',
				"amount_earned"=>$value['earned']?$value['earned']:"",
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"hashes"=>array()
				);
		}
			if(!empty($value['title'])){	
		$final_response[$value['id']]['hashes'][]=array("hash_title"=>$value['title']?$value['title']:"",
				"hash_description"=>$value['description']?$value['description']:"",
				"actual_count"=>$value['users']?$value['users']:"",
				"setcap"=>'1000',
				"created_on"=>$value['created_on']?$value['created_on']:"",
				"total_hash_count"=>$value['sum']?$value['sum']:""
				);		
				}
	}
	
	
	
	
	foreach($final_response as $key=>$value){
		$data['npo'][]=$value;
	}
	
	
	
	}
	

		}
	else{
		$success="0";
		$msg="Invalid email or password";
	}
}
// +-----------------------------------+
// + STEP 4: send json data			   +
// +-----------------------------------+

echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
?>