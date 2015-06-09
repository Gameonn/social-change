  <?php
  //this is an api concerned with social sharing

  // +-----------------------------------+
  // + STEP 1: include required files    +
  // +-----------------------------------+
  require_once("../php_include/db_connection.php");
  require_once('../classes/AllClasses.php');
  $cl = new Users;
  $success=$msg="0";$data=array();
  // +-----------------------------------+
  // + STEP 2: get data          +
  // +-----------------------------------+

  $uid=$_REQUEST['user_id'];
  $provider=$_REQUEST['provider'];
  $title=$_REQUEST['title'];


  if(!($title && $provider)){
    $success="0";
    $msg="Incomplete Parameters";
    $data=array();
  }
  else{
  
    global $conn;
    $sth=$conn->prepare("select * from hash_tags where title LIKE :title");
    $sth->bindParam(':title', $title, PDO::PARAM_STR);
    try{$sth->execute();}
    catch(Exception $e){ echo $e->getMessage();}
    $result=$sth->fetchAll(PDO::FETCH_ASSOC);
    $hid=$result[0]['id'];
    $cid=$result[0]['user_id'];//creator id for that hash tag
    //$huser=$result[0]['users'];
    //print_r($hid);print_r($cid);print_r($huser);die;
    //print_r($result);die;
     if(count($result)){
    $sth=$conn->prepare("select * from users where id=:id");
    $sth->bindValue("id",$cid);
    try{$sth->execute();}
    catch(Exception $e){echo $e->getMessage();}
    $r=$sth->fetchAll(PDO::FETCH_ASSOC);
    $role=$r[0]['role'];
    //print_r($r);print_r($role);
   
    
    //finding price of hash tag
	    if($role=="Brand"){
	      $sth=$conn->prepare("select * from budget where hash_id=:hash_id");
	      $sth->bindValue("hash_id",$hid);
	      try{$sth->execute();}
	      catch(Exception $e){echo $e->getMessage();}
	      $r1=$sth->fetchAll(PDO::FETCH_ASSOC);
	      $price_id=$r1[0]['price_id'];
	      
	      $sth=$conn->prepare("select * from pricing where id=:id");
	      $sth->bindValue("id",$price_id);
	      try{$sth->execute();}
	      catch(Exception $e){
	      //echo $e->getMessage();
	      }
	      $r1=$sth->fetchAll(PDO::FETCH_ASSOC);
	      $price=$r1[0]['price'];
	      
	    }
	    
	    else{ $price='0';}
	 // got the price of hash tag   
	    
    
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
    $success='1';
      $sql="update social_provider set count=count+1,created_on=NOW() where hash_id=:hash_id and provider=:provider and user_id=:user_id";
      $sth=$conn->prepare($sql);
      $sth->bindValue('hash_id',$hid);
      $sth->bindValue('provider',$provider);
      $sth->bindValue('user_id',$uid);
    //  $sth->bindValue('created_on',date('Y-m-d H:i:s'));
      
      $count2=0;
      try{$count2=$sth->execute(); }
      catch(Exception $e){
      echo $e->getMessage();
        }

    }
    
    //else new entry in social provider table for that hash tag
    else{
      $success='1';
      $sql="insert into social_provider values(DEFAULT,:user_id,:provider,:hash_id,1,NOW())";
      $sth=$conn->prepare($sql);
      $sth->bindValue("user_id",$uid);
      $sth->bindValue("provider",$provider);
      $sth->bindValue("hash_id",$hid);

      $count1=0;
      
      try{$count1=$sth->execute();}
      catch(Exception $e){
        echo $e->getMessage();
      }
      
      //increment count of hash tag users
      $sql="update hash_tags set users=users+1 where id=:id";
      $sth=$conn->prepare($sql);
      $sth->bindValue('id',$hid);
      $count3=0;  
      try{$count3=$sth->execute();}
      catch(Exception $e){
        echo $e->getMessage();
            }
      
   //checking if entry of user exists in payout table
   $sth=$conn->prepare("select * from payout where user_id=:user_id" );
    $sth->bindValue("user_id",$uid);
    try{$sth->execute();}
    catch(Exception $e){ }
    $pay=$sth->fetchAll(PDO::FETCH_ASSOC);
      $pr=(0.5*$price);
    if(count($pay)){
      $sql="update payout set amount_earned=amount_earned+:amount where user_id=:user_id";
      $sth=$conn->prepare($sql);
      $sth->bindValue('amount',$pr);
      $sth->bindValue('user_id',$uid);
      
      try{$sth->execute();}
      catch(Exception $e){
        echo $e->getMessage();
      }
    }
    else{
      $sql="insert into payout values(DEFAULT,:user_id,:amount_earned,:amount_paid,:status)";
      $sth=$conn->prepare($sql);
      $sth->bindValue('user_id',$uid);
      $sth->bindValue('amount_earned',$pr);
      $sth->bindValue("amount_paid",'0');
      $sth->bindValue("status",0);
      
      try{$sth->execute();}
      catch(Exception $e){
        echo $e->getMessage();
      }
    }   
      
    }
    }
    else{
    $success=0;
    $msg="Invalid Hashtag";
    }
    

    
    if($success=='1'){
      $final_resp= $cl->get_userdata($uid);
	$data['price']=$pr?$pr:0;
	
	if($final_resp){	
      foreach($final_resp as $key=>$value){
        $data['profile'][]=$value;
      }
      }
      $data['brand']=array();
	$data['npo']=array();
	
	$final = $cl->get_all_brands();
	$final_response = $cl->get_all_npo();
	
	if($final){
	foreach($final as $key=>$value){
		$data['brand'][]=$value;
	}}
	
	if($final_response){
	foreach($final_response as $key=>$value){
		$data['npo'][]=$value;
	}}
      $data['role']="Member";
    }
    
    
  }

  // +-----------------------------------+
  // + STEP 4: send json data        +
  // +-----------------------------------+

  echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
  ?>