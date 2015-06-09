<?php session_start();?>
<?php require_once "../php_include/db_connection.php"; ?>
<?php require_once "../php_include/header.php"; ?>
<?php 
$sql="select * from email_temp where id=1";
$sth=$conn->prepare($sql);
try{$sth->execute();}
catch(Exception $e){}

$res=$sth->fetchAll();

$sql="select * from email_temp where id=2";
$sth=$conn->prepare($sql);
try{$sth->execute();}
catch(Exception $e){}

$result=$sth->fetchAll();

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
                        Email Template
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
                	
                	 <form action="eventHandler.php" id="school_form" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
		  <div class="row">
		  
          <div class="col-sm-12">
        <div class="form-group" style="margin-top:20px;">
			<label for="name" class="col-sm-2 control-label">Type</label>
			<div class="col-sm-10">
			<select name="type" class="form-control email_temp_update">
			<option value="1"> Verify Account </option>
			<option value='2'> Reset Password </option>
			
			</select>
			</div>
		</div>
          </div>
		   <div class="verify_div" > 
		   <div class="col-sm-12">
        <div class="form-group" style="margin-top:20px;">
			<label for="name" class="col-sm-2 control-label">Subject Line</label>
			<div class="col-sm-10">
			<input type="text" class="form-control" id="subj_mail" name="subject_mail" value="<?php echo $res[0]['subject_mail']; ?>" placeholder="Subject Line of email" data-toggle="tooltip" data-placement="right" title="SocialChange - Recover Password/ SocialChange - User Verification" required>
			</div>
		</div>
          </div>
		  
		 <div class="col-sm-12">
        <div class="form-group" style="margin-top:20px;">
			<label for="name" class="col-sm-2 control-label">Mail Content</label>
			<div class="col-sm-10">
			<textarea name="body_mail" class="form-control" id="bd_mail" rows="4" placeholder="Mail Content"  data-toggle="tooltip" data-placement="right" title="We have received your SocialChange account request or reset password request." required><?php echo $res[0]['body_mail']; ?>
			</textarea>
			</div>
		</div>
          </div> 

	 <div class="col-sm-12">
        <div class="form-group" style="margin-top:20px;">
			<label for="name" class="col-sm-2 control-label">Support Email</label>
			<div class="col-sm-10">
		<input type="text" class="form-control" name="support_email" id="sp_mail" value="<?php echo $res[0]['support_email']; ?>" placeholder="Support Email" data-toggle="tooltip" data-placement="right" title="info@socialchange.media" required>
			</div>
		</div>
          </div>

	 <div class="col-sm-12">
        <div class="form-group" style="margin-top:20px;">
			<label for="name" class="col-sm-2 control-label">Website URL</label>
			<div class="col-sm-10">
			<input type="text" class="form-control" name="url" id="web_url" placeholder="Website URL" value="<?php echo $res[0]['url']; ?>" data-toggle="tooltip" data-placement="right" title="www.socialchange.media" required>
			</div>
		</div>
          </div>  
	</div>
	
		
		</div>
      
           <div class="col-sm-10 col-sm-offset-2 submit-btn-con" style="margin-top:20px;">
            <button type="submit" class="load-btn btn btn-primary btn-block "> Save Changes</button>
          </div>
            </div>
          </div>
         
              <!-- hidden -->
              <input type="hidden" name="event" value="email_template">
            </form>

                	
                	
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
var f=$(this).val();
 var event1='get_template'
       
$.post("eventHandler.php",
        
    {
    event: event1,
    type: f
    },
    
    function(data){
//alert(data);
    console.log(data);
$('#subj_mail').attr('value','');
$('#bd_mail').empty();
$('#sp_mail').empty();
$('#web_url').empty();
      $.each(data, function(index,v) {
	 
    $('#subj_mail').attr('value',v.subject_mail);
	  $('#sp_mail').attr('value',v.support_email);
	    $('#web_url').attr('value',v.url);
		  $('#bd_mail').append(v.body_mail);
   });   
    },'json'
    );

	});
});
</script>


    </body>
</html>