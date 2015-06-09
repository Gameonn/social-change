<?php

class Users{
	
	public static function get_brand_profile($role,$uid){
	// returns profile and hash data of brand based on user_id
		
		global $conn;
	$sql="select users.id,users.fbid,users.twitterid,users.googleid,users.instagram_id,users.username,users.email,users.contact_number,users.paypal_email,users.brand_name,users.pic,users.verified, hash_tags.title, hash_tags.description, hash_tags.users,hash_tags.set_cap,hash_tags.created_on, budget.price_id,(select pricing.price from pricing where pricing.id=budget.price_id ) as price,(select sum(count) from social_provider where social_provider.hash_id=hash_tags.id) as sum,
	CASE 
                  WHEN DATEDIFF(NOW(),hash_tags.created_on) != 0 THEN CONCAT(DATEDIFF(NOW(),hash_tags.created_on) ,'d ago')
                  WHEN HOUR(TIMEDIFF(NOW(),hash_tags.created_on)) != 0 THEN CONCAT(HOUR(TIMEDIFF(NOW(),hash_tags.created_on)) ,'h ago')
                  WHEN MINUTE(TIMEDIFF(NOW(),hash_tags.created_on)) != 0 THEN CONCAT(MINUTE(TIMEDIFF(NOW(),hash_tags.created_on)) ,'m ago')
                  ELSE
                     CONCAT(SECOND(TIMEDIFF(NOW(),hash_tags.created_on)) ,' s ago')
                END as time_since
from users LEFT join hash_tags on hash_tags.user_id=users.id LEFT join budget on budget.hash_id=hash_tags.id and budget.user_id=users.id where users.role=:role and users.id=:uid order by created_on DESC ";
	
	$sth=$conn->prepare($sql);
	$sth->bindValue("role",$role);
	$sth->bindValue("uid",$uid);
	try{$sth->execute();}
	catch(Exception $e){}
	$res=$sth->fetchAll(PDO::FETCH_ASSOC);
		
		
		foreach($res as $key=>$value){
		if(empty($final[$value['id']])){
		$final[$value['id']]=array("user_id"=>$value['id'],
				"username"=>$value['username'],
				"email"=>$value['email'],
				"contact_number"=>$value['contact_number'],
				"paypal_email"=>$value['paypal_email'],
				"brand_name"=>$value['brand_name'],
				"role"=>'Brand',
				"verified"=>$value['verified'],
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"hashes"=>array());
		}
		
		if(!empty($value['title'])){		
		$final[$value['id']]['hashes'][]=array("hash_title"=>$value['title'],
				"hash_description"=>$value['description']?$value['description']:"",
				"actual_count"=>$value['users']?$value['users']:"",
				"setcap"=>'1000',
				"created_on"=>$value['created_on'],
				"price"=>$value['price'],
				"time_since"=>$value['time_since'],
				"total_hash_count"=>$value['sum']?$value['sum']:"");		
				
				}
	}
	
	return $final;
		
	
	}
	
	public static function get_npo_profile($role,$uid){
	// returns profile and hash data of npo based on user_id
		global $conn;
		
$sql="select users.id,users.fbid,users.twitterid,users.googleid,users.instagram_id,users.username,users.email,users.contact_number,users.paypal_email,users.brand_name,users.pic,users.verified,payout.amount_earned as earned, hash_tags.title, hash_tags.description, hash_tags.users,hash_tags.set_cap,hash_tags.created_on,(select sum(count) from social_provider where social_provider.hash_id=hash_tags.id) as sum,
		CASE 
                  WHEN DATEDIFF(NOW(),hash_tags.created_on) != 0 THEN CONCAT(DATEDIFF(NOW(),hash_tags.created_on) ,'d ago')
                  WHEN HOUR(TIMEDIFF(NOW(),hash_tags.created_on)) != 0 THEN CONCAT(HOUR(TIMEDIFF(NOW(),hash_tags.created_on)) ,'h ago')
                  WHEN MINUTE(TIMEDIFF(NOW(),hash_tags.created_on)) != 0 THEN CONCAT(MINUTE(TIMEDIFF(NOW(),hash_tags.created_on)) ,'m ago')
                  ELSE
                     CONCAT(SECOND(TIMEDIFF(NOW(),hash_tags.created_on)) ,' s ago')
                END as time_since
 from users left join hash_tags on hash_tags.user_id=users.id left join payout on payout.user_id=users.id  where users.role=:role and users.id=:uid order by created_on DESC" ;
	
	$sth=$conn->prepare($sql);
	$sth->bindValue("role",$role);
	$sth->bindValue("uid",$uid);
	try{$sth->execute();}
	catch(Exception $e){

	}
	$res=$sth->fetchAll(PDO::FETCH_ASSOC);
		
	foreach($res as $key=>$value){
		if(empty($final[$value['id']])){
		$final[$value['id']]=array("user_id"=>$value['id'],
				"username"=>$value['username'],
				"email"=>$value['email'],
				"contact_number"=>$value['contact_number'],
				"paypal_email"=>$value['paypal_email'],
				"tax_id"=>$value['tax_id']?$value['tax_id']:"",
				"role"=>'Non Profit Organization',
				"verified"=>$value['verified'],
				"amount_earned"=>$value['earned']?$value['earned']:"",
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"hashes"=>array()
				);
		}
			if(!empty($value['title'])){	
		$final[$value['id']]['hashes'][]=array("hash_title"=>$value['title'],
				"hash_description"=>$value['description']?$value['description']:"",
				"actual_count"=>$value['users']?$value['users']:"",
				"setcap"=>'1000',
				"created_on"=>$value['created_on']?$value['created_on']:"",
				"time_since"=>$value['time_since']?$value['time_since']:"",
				"total_hash_count"=>$value['sum']?$value['sum']:""
				);
				}		
				
	}
	return $final;
		
	}
	
	
	public static function get_all_brands(){
		$data =array();
		// returns all brands alongwith their hash tags	
		global $conn;	
		$sql="select users.id,users.fbid,users.twitterid,users.googleid,users.instagram_id,users.username,users.email,users.contact_number,users.paypal_email,users.brand_name,users.pic,users.verified, hash_tags.title, hash_tags.description, hash_tags.users,hash_tags.set_cap,hash_tags.created_on, budget.price_id,(select pricing.price from pricing where pricing.id=budget.price_id ) as price,(select sum(count) from social_provider where social_provider.hash_id=hash_tags.id) as sum,
		CASE 
                  WHEN DATEDIFF(NOW(),hash_tags.created_on) != 0 THEN CONCAT(DATEDIFF(NOW(),hash_tags.created_on) ,'d ago')
                  WHEN HOUR(TIMEDIFF(NOW(),hash_tags.created_on)) != 0 THEN CONCAT(HOUR(TIMEDIFF(NOW(),hash_tags.created_on)) ,'h ago')
                  WHEN MINUTE(TIMEDIFF(NOW(),hash_tags.created_on)) != 0 THEN CONCAT(MINUTE(TIMEDIFF(NOW(),hash_tags.created_on)) ,'m ago')
                  ELSE
                     CONCAT(SECOND(TIMEDIFF(NOW(),hash_tags.created_on)) ,' s ago')
                END as time_since
from users left join hash_tags on hash_tags.user_id=users.id left join budget on budget.hash_id=hash_tags.id and budget.user_id=users.id where users.role=:role order by hash_tags.users DESC";
		$sth=$conn->prepare($sql);
		$sth->bindValue("role",'Brand');
		try{$sth->execute();}
		catch(Exception $e){}
		$res=$sth->fetchAll(PDO::FETCH_ASSOC);
		//
		foreach($res as $key=>$value){
		if(empty($final[$value['id']])){
		$final[$value['id']]=array("user_id"=>$value['id'],
				"username"=>$value['username'],
				"email"=>$value['email'],
				"contact_number"=>$value['contact_number'],
				"paypal_email"=>$value['paypal_email'],
				"brand_name"=>$value['brand_name'],
				"role"=>'Brand',
				"verified"=>$value['verified'],
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"hashes"=>array());
		}
			if(!empty($value['title'])){	
		$final[$value['id']]['hashes'][]=array("hash_title"=>$value['title']?$value['title']:"",
				"hash_description"=>$value['description']?$value['description']:"",
				"actual_count"=>$value['users']?$value['users']:"",
				"setcap"=>'1000',
				"created_on"=>$value['created_on']?$value['created_on']:"",
				"time_since"=>$value['time_since']?$value['time_since']:"",
				"price"=>$value['price']?$value['price']:"",
				"total_hash_count"=>$value['sum']?$value['sum']:"");		
				}
	}
		
		return $final;	
	}
	
	public static function get_all_npo(){
	// returns all npo along with their hash tags and amount earned
		global $conn;
		
	$sql="select users.id,users.fbid,users.twitterid,users.googleid,users.instagram_id,users.username,users.email,users.contact_number,users.paypal_email,users.brand_name,users.pic,users.verified,payout.amount_earned as earned, hash_tags.title, hash_tags.description, hash_tags.users,hash_tags.set_cap,hash_tags.created_on,(select sum(count) from social_provider where social_provider.hash_id=hash_tags.id) as sum,
	CASE 
                  WHEN DATEDIFF(NOW(),hash_tags.created_on) != 0 THEN CONCAT(DATEDIFF(NOW(),hash_tags.created_on) ,'d ago')
                  WHEN HOUR(TIMEDIFF(NOW(),hash_tags.created_on)) != 0 THEN CONCAT(HOUR(TIMEDIFF(NOW(),hash_tags.created_on)) ,'h ago')
                  WHEN MINUTE(TIMEDIFF(NOW(),hash_tags.created_on)) != 0 THEN CONCAT(MINUTE(TIMEDIFF(NOW(),hash_tags.created_on)) ,'m ago')
                  ELSE
                     CONCAT(SECOND(TIMEDIFF(NOW(),hash_tags.created_on)) ,' s ago')
                END as time_since
	 from users left join hash_tags on hash_tags.user_id=users.id left join payout on payout.user_id=users.id  where users.role=:role order by hash_tags.users DESC" ;
	
	$sth=$conn->prepare($sql);
	$sth->bindValue("role",'Non Profit Organization');
	try{$sth->execute();}
	catch(Exception $e){
	//echo $e->getMessage();
	}
	$r1=$sth->fetchAll(PDO::FETCH_ASSOC);
	
		foreach($r1 as $key=>$value){
		if(empty($final_response[$value['id']])){
		$final_response[$value['id']]=array("user_id"=>$value['id'],
				"username"=>$value['username'],
				"email"=>$value['email'],
				"contact_number"=>$value['contact_number'],
				"paypal_email"=>$value['paypal_email']?$value['paypal_email']:"",
				"tax_id"=>$value['tax_id']?$value['tax_id']:"",
				"role"=>'Non Profit Organization',
				"verified"=>$value['verified'],
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
				"time_since"=>$value['time_since'],
				"total_hash_count"=>$value['sum']?$value['sum']:""
				);		
				}
	}
	
	return $final_response;	
	}
	
	public static function get_prices(){
	
	global $conn;
	$sth=$conn->prepare("select * from pricing");
	
	try{$sth->execute();}
	catch(Exception $e){ echo $e->getMessage();}
	$pricing=$sth->fetchAll(PDO::FETCH_ASSOC);
	
	return $pricing;
	}
	
	public static function get_userdata($uid){
		//returns all userdata based on user id
		global $conn;
		
			/*$sql="select users.*, (select group_concat(social_provider.provider) from social_provider where social_provider.user_id=:user_id) as provider,(select group_concat(hash_tags.title)  from hash_tags left join social_provider on social_provider.hash_id=hash_tags.id where social_provider.user_id=:user_id) as hash,payout.* from users left join payout on payout.user_id=users.id where users.id=:user_id";*/
			
		$sql="select users.*, social_provider.provider,social_provider.created_on as shared_on ,hash_tags.*,payout.*,budget.price_id,(select pricing.price from pricing where pricing.id=budget.price_id ) as price,
			CASE 
                  WHEN DATEDIFF(NOW(),social_provider.created_on) != 0 THEN CONCAT(DATEDIFF(NOW(),social_provider.created_on) ,'d ago')
                  WHEN HOUR(TIMEDIFF(NOW(),social_provider.created_on)) != 0 THEN CONCAT(HOUR(TIMEDIFF(NOW(),social_provider.created_on)) ,'h ago')
                  WHEN MINUTE(TIMEDIFF(NOW(),social_provider.created_on)) != 0 THEN CONCAT(MINUTE(TIMEDIFF(NOW(),social_provider.created_on)) ,'m ago')
                  ELSE
                     CONCAT(SECOND(TIMEDIFF(NOW(),social_provider.created_on)) ,'s ago')
                END as time_since
 from users left join social_provider on social_provider.user_id=users.id left join hash_tags on hash_tags.id=social_provider.hash_id left join budget on budget.hash_id=hash_tags.id  left join payout on payout.user_id=users.id where users.id=:user_id order by shared_on DESC";
		
		$sth=$conn->prepare($sql);
		$sth->bindValue("user_id",$uid);
		try{$sth->execute();}
		catch(Exception $e){

		}
		$r2=$sth->fetchAll(PDO::FETCH_ASSOC);
		
		
		foreach($r2 as $key=>$value){
		if(empty($final_resp[$value['id']])){
		$final_resp[$value['id']]=array("user_id"=>$uid?$uid:"",
				"username"=>$value['username'],
				"email"=>$value['email'],
				"fbid"=>$value['fbid']?$value['fbid']:"",
				"twitterid"=>$value['twitterid']?$value['twitterid']:"",
				"googleid"=>$value['googleid']?$value['googleid']:"",
				"instagram_id"=>$value['instagram_id']?$value['instagram_id']:"",
				"created_on"=>$value['created_on']?$value['created_on']:"",
				"contact"=>$value['contact']?$value['contact']:"",
				"paypal"=>$value['paypal_email']?$value['paypal_email']:"",
				"pic"=>$value['pic'] ? BASE_PATH."/timthumb.php?src=uploads/".$value['pic'] : "",
				"verified"=>$value['verified'],
				//"provider"=>$value['provider']?$value['provider']:"",
				//"hash"=>$value['hash']?$value['hash']:"",
				"amount_earned"=>$value['amount_earned']?$value['amount_earned']:"",
				"status"=>$value['status']?$value['status']:"",
				"hashes"=>array()
				);
				}
				
			if(!empty($value['title'])){	
		$final_resp[$value['id']]['hashes'][]=array("hash_title"=>$value['title']?$value['title']:"",
				"hash_description"=>$value['description']?$value['description']:"",
				"shared_on"=>$value['shared_on']?$value['shared_on']:"",
				"provider"=>$value['provider']?$value['provider']:"",
				"price"=>$value['price']?$value['price']:0,
				"time_since"=>$value['time_since']
				);		
				}		
				}
				
				return $final_resp;
	
				}
	 
}