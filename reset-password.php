<?php
require_once "php_include/db_connection.php"; 
$token=$_REQUEST["token"];
$username=$_REQUEST['username'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Social Change| Reset Password</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header" style="  background: rgb(47,71,95);">
			<img src='../uploads/Icon-Small-40.png' style='width:42px;'>
			RESET PASSWORD</div>
			<form action="admin/eventHandler.php" method="post">
                <div class="body bg-gray">
                	<?php //error div
                	if(isset($_REQUEST['success']) && isset($_REQUEST['msg']) && $_REQUEST['msg']){ ?>
                		<div style="margin:0px 0px 10px 0px;" class="alert alert-<?php if($_REQUEST['success']) echo "success"; else echo "danger"; ?> alert-dismissable">
			            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			            	<?php echo $_REQUEST['msg']; ?>
			            </div>
			        <?php } // --./ error -- ?>
                    <div class="form-group">
                       <input class="form-control app-input" type="password" name="password" placeholder="Enter new password..">
					</div>
                    <div class="form-group">
                <input class="form-control app-input" type="password" name="confirm" placeholder="Confirm password..">
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn btn-block" style="  background: rgb(47,71,95);color:#fff;">Submit</button>
                   <!--   <input class="form-control app-button transparent" type="button" value="Cancel" onclick="window.location.href='index.php';"> -->
                </div>
    <!-- hidden values -->
    <input type="hidden" name="event" value="reset-password">
        <input type="hidden" name="username" value="<?php echo $username; ?>">
    <input type="hidden" name="token" value="<?php echo $token; ?>">
            </form>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="admin/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>