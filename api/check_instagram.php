<?php
require 'Inst/Instagram.php';
require 'Inst/InstagramException.php';
use MetzWeb\Instagram\Instagram;
  require_once("../php_include/db_connection.php");
// Initialize class
$instagram = new Instagram(array(
  'apiKey'      => 'd22e0acd30f1442aa09f6a6131845171',
  'apiSecret'   => '4ccbf331d26047d6b145c5f055d6a01d',
  'apiCallback' => 'socialchange.company/api/example/success.php'
));

// Receive OAuth code parameter
$code = $_REQUEST['instagram_token'];
$tagname=$_REQUEST['tag_name'];
$uname=$_REQUEST['inst_username'];
// Check whether the user has granted access

	 global $conn;
	 $provider='instagram';
	 $sql="SELECT instagram. * , instagram.id AS inst_id, hash_tags.title, ( SELECT pricing.price FROM pricing JOIN budget ON budget.price_id = pricing.id WHERE budget.hash_id = hash_tags.id ) AS price FROM instagram JOIN hash_tags ON hash_tags.id = instagram.hash_id WHERE instagram.cron_status =0 AND TIMESTAMPDIFF(MINUTE, instagram.created_on,NOW())<40";

	 //
    $sth=$conn->prepare($sql);
    try{$sth->execute();}
    catch(Exception $e){ 
	//echo $e->getMessage();
	}
    $res=$sth->fetchAll(PDO::FETCH_ASSOC);
	
    if(count($res)){
	foreach($res as $key=>$value){
    
		if (true == isset($value['access_token'])) {
		$tagname=ltrim($value['title'],"#");
		$url="https://api.instagram.com/v1/tags/{$tagname}/media/recent?access_token=".$value['access_token'];
		
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		$result=json_decode($output,true);
		curl_close($ch);
		//for loop on return of curl result
		foreach($result['data'] as $key=>$val){
		
			//checking whether tagname and username matches with our db entries
			if($val['caption']['text']==$value['title'] && $val['caption']['from']['username']==$value['inst_username']){
			$aaa[]=$val['caption']['text'];
			$uid=$value['user_id'];
			$hid=$value['hash_id'];
			$price=$value['price'];
			}
			
			//if(count($aaa=1)){
			$sth=$conn->prepare("select * from social_provider where hash_id=:hash_id and provider=:provider and user_id=:user_id");
			$sth->bindValue("hash_id",$hid);
			$sth->bindValue("provider",$provider);
			$sth->bindValue("user_id",$uid);
			try{$sth->execute();}
			catch(Exception $e){ 
			//echo $e->getMessage();
			}
			$m=$sth->fetchAll(PDO::FETCH_ASSOC);
		 
			//if hash tag is already shared on same social provider-- increment count
			if(count($m)){
			//$success='1';
			  $sql="update social_provider set count=count+1,created_on=NOW() where hash_id=:hash_id and provider=:provider and user_id=:user_id";
			  $sth=$conn->prepare($sql);
			  $sth->bindValue('hash_id',$hid);
			  $sth->bindValue('provider',$provider);
			  $sth->bindValue('user_id',$uid);
			 try{$sth->execute(); }
			  catch(Exception $e){}

			}
			
			//else new entry in social provider table for that hash tag
			else{
			  //$success='1';
			  $sql="insert into social_provider values(DEFAULT,:user_id,:provider,:hash_id,1,NOW())";
			  $sth=$conn->prepare($sql);
			  $sth->bindValue("user_id",$uid);
			  $sth->bindValue("provider",$provider);
			  $sth->bindValue("hash_id",$hid);
			  try{$sth->execute();}
			  catch(Exception $e){}
			  
			  //increment count of hash tag users
			  $sql="update hash_tags set users=users+1 where id=:id";
			  $sth=$conn->prepare($sql);
			  $sth->bindValue('id',$hid); 
			  try{$sth->execute();}
			  catch(Exception $e){}
			  
		   //checking if entry of user exists in payout table
		   $sth=$conn->prepare("select * from payout where user_id=:user_id" );
			$sth->bindValue("user_id",$uid);
			try{$sth->execute();}
			catch(Exception $e){ }
			$pay=$sth->fetchAll(PDO::FETCH_ASSOC);
			  $pr=(0.50*$price);
			if(count($pay)){
			  $sql="update payout set amount_earned=amount_earned+:amount where user_id=:user_id";
			  $sth=$conn->prepare($sql);
			  $sth->bindValue('amount',$pr);
			  $sth->bindValue('user_id',$uid);
			  
			  try{$sth->execute();}
			  catch(Exception $e){}
			}
			else{
			  $sql="insert into payout values(DEFAULT,:user_id,:amount_earned,0,0)";
			  $sth=$conn->prepare($sql);
			  $sth->bindValue('user_id',$uid);
			  $sth->bindValue('amount_earned',$pr);
			  
			  try{$sth->execute();}
			  catch(Exception $e){}
				}   
			  
			}
			
			//}//if loop for hashtag shared only once
				
		}//for loop curl result

	}// if loop checking whether there is any access token
		
			$sql="update instagram set cron_status=1 where id=:id";
			$sth=$conn->prepare($sql);
			$sth->bindValue('id',$value['inst_id']);
			try{$sth->execute();}
			catch(Exception $e){}
			
	}// foreach loop for db query


} //if structure whether any result lies for cron job to occur

?>