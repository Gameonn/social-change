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

  $d=date('Y-m-d');
  $d1=date('Y-m-d H:i:s');
  $uid=$_REQUEST['user_id'];
  $access_token=$_REQUEST['inst_access_token'];
  $title=$_REQUEST['title'];
  $uname=$_REQUEST['inst_username'];
  $cur_date=$_REQUEST['inst_time'];	
  $datetime=$_REQUEST['datetime'];

  if(!($title && $access_token && $uname)){
    $success="0";
    $msg="Incomplete Parameters";
    $data=array();
  }
  else{
  
    global $conn;
    $sth=$conn->prepare("select * from hash_tags where title LIKE :title");
    $sth->bindParam(':title', $title, PDO::PARAM_STR);
    try{$sth->execute();}
    catch(Exception $e){ 
	//echo $e->getMessage();
	}
    $result=$sth->fetchAll(PDO::FETCH_ASSOC);
    $hid=$result[0]['id'];
 
      $sql="insert into instagram values(DEFAULT,:user_id,:access_token,:hash_id,:uname,:date,0,NOW())";
      $sth=$conn->prepare($sql);
      $sth->bindValue('user_id',$uid);
      $sth->bindValue('access_token',$access_token);
      $sth->bindValue("hash_id",$hid);
	  $sth->bindValue("uname",$uname);
	  $sth->bindValue("date",$cur_date);
	  
	  //$sth->bindValue("datetime",$datetime);
      $count=0;
      try{$count=$sth->execute();}
      catch(Exception $e){
        //echo $e->getMessage();
      }  
   
    if($count){
	$success='1';
	$msg="Access Token Saved";
    }
    else{
    $success=0;
    $msg="Error Occured";
    }
    
    
  }

  // +-----------------------------------+
  // + STEP 4: send json data        +
  // +-----------------------------------+

  echo json_encode(array("success"=>$success,"msg"=>$msg,"data"=>$data));
  ?>