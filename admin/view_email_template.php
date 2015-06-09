<?php session_start();?>
<?php require_once "../php_include/db_connection.php"; ?>
<?php require_once "../php_include/header.php"; ?>
<?php
$tid=$_REQUEST['type']; 
$sql="select * from email_temp where id=:type";
$sth=$conn->prepare($sql);
$sth->bindValue('type',$tid);
try{$sth->execute();}
catch(Exception $e){}

$res=$sth->fetchAll();
?>
<!--CSS DATA TABLES -->
<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php require_once "../php_include/leftmenu.php"; ?>
			<!-- right-side -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       <a href="email_template.php"><i class="fa fa-arrow-circle-left"></i></a>  Email Template
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Email Template</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					<?php //error div
					if(isset($_REQUEST['success']) && isset($_REQUEST['msg']) && $_REQUEST['msg']){ ?>
						<div style="margin:0px 0px 10px 0px;" class="alert alert-<?php if($_REQUEST['success']) echo "success"; else echo "danger"; ?> alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $_REQUEST['msg']; ?>
						</div>
					<?php } // --./ error -- ?>
                	
                	 
               <div class="content-wrapper">
    

        <!-- Main content -->
        <section class="content">
          <div class="row">
    
            <div class="col-md-8 col-md-offset-2">
              <div class="">
                <div class="box-header with-border">
                  <h3 class="box-title">Sample Mail</h3>
                 
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="mailbox-read-info">
                    <h3><?php echo $res[0]['subject_mail']; ?></h3>
                    <h5>From: example@abc.com <span class="mailbox-read-time pull-right">15 Feb. 2015 11:03 PM</span></h5>
                  </div><!-- /.mailbox-read-info -->
                
                  <div class="mailbox-read-message">
                    <p>Hello,</p>
                    <p><?php echo $res[0]['body_mail']; ?></p>
                    
                     <p>Please follow the link below to verify your account:</p>
                <p><a href="#" >Form url</a></p>
                <p>For questions or technical assistance, please email SocialChange technical support: <?php echo $res[0]['support_email']; ?></p>
                <br>
                <p>Thank you,</p>
                <p>SocialChange</p>
                <p><a href='<?php echo $res[0]['url']; ?>'> <?php echo $res[0]['url']; ?></a></p>
                  </div><!-- /.mailbox-read-message -->
                </div><!-- 
               
                <div class="box-footer">
                  <div class="pull-right">
                    <button class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                    <button class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
                  </div>
                  <button class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
                  <button class="btn btn-default"><i class="fa fa-print"></i> Print</button>-->
                </div><!-- /.box-footer -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
                	
                	
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) 
        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script> -->    
        
        <!-- AdminLTE for demo purposes 
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>-->
        
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function(){

$('.email_temp_update').on('change',function(){

$('.verify_div').hide();
$('.reset_div').hide();

$f=$(this).val();
if($f=='2')
$('.reset_div').show();
else
$('.verify_div').show();
});
});
</script>


    </body>
</html>