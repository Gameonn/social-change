<?php
//this is an api concerned with payout

// +-----------------------------------+
// + STEP 1: include required files    +
// +-----------------------------------+
require_once("../php_include/db_connection.php");
require_once('classes/AllClasses.php');
$success=$msg="0";$data=array();

?>
<div class="modal fade" id="payout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
  <div class="modal-content">
	<form action="eventHandler.php" method="post" enctype="multipart/form-data">
	<div class="modal-body">
	
		<h4 class="modal-title" id="myModalLabel">Are you sure?</h4>
<input type="hidden" name="user_id" id="userid" value="">
	</div>
		<div class="modal-footer">
		 <button type="submit" class="btn btn-primary">YES</button>
		 <button type="button" data-dismiss="modal" class="btn">Cancel</button>
	   </div>
	   <input type="hidden" name="event" value="payout">
	   




	 </form>

 </div>
</div>
</div>