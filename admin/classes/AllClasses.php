<?php
class AllClasses{

public static function get_sum_earned($user_id){
		global $conn;
		$row=array();
		$sql="SELECT sum(count),sum(amount_earned) from social_provider where user_id=$user_id ";
		$result=$conn->query($sql);
		$row=$result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
}
?>