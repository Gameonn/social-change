<?php session_start();?>
<?php require_once "../php_include/db_connection.php"; ?>
<?php require_once "../php_include/header.php"; ?>


<?php
$uid=$_REQUEST['track'];
$role=$_REQUEST['role'];
$limit = (int) (!isset($_GET["limit"]) ? 100 : $_GET["limit"]);
global $conn;
$searchKey="where 1";
if($_REQUEST['key']) $searchKey.=" and (hash_tags.title like '%{$_REQUEST['key']}%' or users.username like '%{$_REQUEST['key']}%' or users.brand_name like '%{$_REQUEST['key']}%')";

//fetch
if($role=='NPO'){
$sql="select hash_tags.title as title, hash_tags.description as d, hash_tags.users as users, users.username as username, users.brand_name as brand from hash_tags left join users on hash_tags.user_id=users.id $searchKey and hash_tags.user_id=:user_id limit $limit";
}
else{
$sql="select hash_tags.title as title, hash_tags.description as d, hash_tags.users as users, users.username as username, users.brand_name as brand,(select pricing.price from pricing join budget on pricing.id=budget.price_id where budget.hash_id=hash_tags.id) as price from hash_tags left join users on hash_tags.user_id=users.id left join budget on hash_tags.id=budget.hash_id $searchKey and hash_tags.user_id=:user_id limit $limit";
}

$sth=$conn->prepare($sql);
$sth->bindValue('user_id',$uid);
try{$sth->execute();}catch(Exception $e){
echo $e->getMessage();}
$result=$sth->fetchAll(PDO::FETCH_ASSOC);

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
                        Hash Tags
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <?php if($role=='brand'){?> <li><a href="brands.php">Brand</a></li> <?php } ?>
                          <?php if($role=='NPO') {?> <li><a href="npo.php">NPO</a></li> <?php } ?>
                        <li><a href="#">Hash Tags</a></li>
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
                	<div class="box">
                                <div class="box-header">                                  
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                	
                            		<div class="row">
										<div class="col-xs-6">
											<div id="example1_length" class="dataTables_length">
												<label>
													<select size="1" name="example1_length" aria-controls="example1" onchange="window.location.href='?&key=<?php echo $_REQUEST['key']; ?>&page=1&limit='+(this.options[this.selectedIndex].value);">
													<?php foreach(array(10,25,50,100) as $i){
														echo "<option value='$i' ";
														if($i==$limit) echo "selected";
														echo ">$i</option>";
													} ?>
													</select>
													 records per page
												</label>
											</div>
											
					<div class="btn-group" style="margin-left: 40px;margin-top: -4px;text-align: center;">
			<button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Table Data</button> 
					<ul class="dropdown-menu " role="menu">
						<li><a href="#" onclick="$('#example1').tableExport({type:'csv',escape:'false'});"><i class="fa fa-file"></i>CSV</a></li>				
						<li><a href="#" onclick="$('#example1').tableExport({type:'excel',escape:'false'});"><i class="fa fa-file-text-o"></i>XLS</a></li>
				<li><a href="#" onclick="$('#example1').tableExport({type:'pdf',pdfFontSize:'7',escape:'false'});"><i class="fa fa-file-text"></i>PDF</a></li> 
					</ul>
				</div>
				
										</div>
										<div class="col-xs-6"><div class="dataTables_filter" id="example1_filter" style="width:100%;">
											<label style="width:100%;">
												<form id="search-by-date-form" action="" style="float:left;width:46%;">
													<!-- Hidden -->
													<input type="hidden" name="limit" value="<?php echo $limit; ?>" />
													<input type="hidden" name="key" value="<?php echo $_GET['key']; ?>" />
													<!-- Date dd/mm/yyyy -->
													<div class="form-group">
														<div class="input-group" style="width:100%;">
															<select name="status" class="form-control" onchange="document.getElementById('search-by-date-form').submit();">
																<option value="" <?php if($_GET["status"]=="") echo "selected"; ?>>All</option>
															</select>
														</div><!-- /input-group -->
													</div><!-- /.form group -->
												</form>
												<div class="input-group">
													<input class="form-control" type="text" aria-controls="example1" 
														onkeyup="if(event.keyCode==13){ window.location.href='?limit=<?php echo $limit; ?>&status=<?php echo $_GET['status']; ?>&key='+this.value; }" placeholder="Search by Username/Hash/Brand" value="<?php echo $_GET['key']; ?>">
													<span class="input-group-btn"><button class="btn btn-default btn-flat" 
														onclick="window.location.href='?limit=<?php echo $limit; ?>&key=';">Reset</button></span>
												</div>
											</label>
										</div></div>
									</div><!-- ./row -->
									
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>                                            
                                                <th>Hash Title</th>
                                                <th>Description</th>
                                                <th>Users</th>
                                                <th>Brand</th>
                                             <?php if($role!='NPO') {?>  <th>Price(in $)</th> <?php } ?>
                                                
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php foreach($result as $row){ ?>
                                            <tr>
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['d']; ?></td>
                                                <td><?php if(!$row['users']) echo "-"; else echo $row['users']; ?></td>
                                                <td><?php if(!$row['brand']) echo "-"; else echo $row['brand']; ?></td>
                                              <?php if($role!='NPO') {?>  <td><?php if(!$row['price']) echo "-"; else echo $row['price']; ?></td> <?php } ?>
                                                
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    
									
									
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
							
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>     
        
        <!-- AdminLTE for demo purposes -->
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>
   <script type="text/javascript" src="js/html2canvas.js"></script>
		<script type="text/javascript" src="js/tableExport.js"></script>
		<script type="text/javascript" src="js/jquery.base64.js"></script>
		<script type="text/javascript" src="js/jspdf/libs/sprintf.js"></script>
		<script type="text/javascript" src="js/jspdf/jspdf.js"></script>
		<script type="text/javascript" src="js/jspdf/libs/base64.js"></script>			
		<!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>

    </body>
</html>