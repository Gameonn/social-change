<?php
session_start();
if(isset($_SESSION['admin'])){
header('location:dashboard.php');
}
require_once("../php_include/db_connection.php"); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>SocialChange| Login</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header" style="  background: rgb(47,71,95);">
			<img src='../uploads/Icon-Small-40.png' style='width:42px;'>
			Sign In</div>
			<form action="eventHandler.php" method="post">
                <div class="body bg-gray">
                	<?php //error div
                	if(isset($_REQUEST['success']) && isset($_REQUEST['msg']) && $_REQUEST['msg']){ ?>
                		<div style="margin:0px 0px 10px 0px;" class="alert alert-<?php if($_REQUEST['success']) echo "success"; else echo "danger"; ?> alert-dismissable">
			            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			            	<?php echo $_REQUEST['msg']; ?>
			            </div>
			        <?php } // --./ error -- ?>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username/Email" required/>
					</div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn btn-block" style="  background: rgb(47,71,95);color:#fff;">Sign me in</button>
                      <p><a href="forgot_password.php">Forgot Password</a></p>
                </div>
                <!-- hidden -->
                <input type="hidden" name="event" value="signin">
                <input type="hidden" name="redirect" value="dashboard.php">
            </form>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>