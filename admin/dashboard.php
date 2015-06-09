<?php session_start();?>
<?php require_once "../php_include/db_connection.php"; ?>
<?php require_once "../php_include/header.php"; ?>

<?php 

$sql="SELECT count(id) as bid from users where role='Brand'";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $bid=$result[0][0];

$sql="SELECT count(id) as oid from users where role='Non Profit Organization'";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $oid=$result[0][0];

$sql="SELECT count(id) as uid from users where role='Member'";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $uid=$result[0][0];

$sql="SELECT count(id) as hid from hash_tags";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $hid=$result[0][0];

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Social Change| Dashboard</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
	</head>
	<!--CSS DATA TABLES -->
<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<body>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php require_once "../php_include/leftmenu.php"; ?>
			<!-- right-side -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        
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
					
  <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                       <?php echo $uid; ?>
                                    </h3>
                                    <p>
                                        Users
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="users.php" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                     <?php echo $oid; ?>
                                    </h3>
                                    <p>
                                        NPOs
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-help-buoy"></i>
                                </div>
                                <a href="npo.php" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                       <?php echo $bid; ?>
                                    </h3>
                                    <p>
                                        Brands
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-social-bitcoin"></i>
                                </div>
                                <a href="brands.php" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                      <?php echo $hid; ?>
                                    </h3>
                                    <p>
                                        Hash Tags
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pricetags"></i>
                                </div>
                                <a href="hash.php" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->

		   <div class="box-body well" style='padding-top:25px;'>
                       <div class="row">
                                        <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                                            <input type="text" class="knob" value="<?php echo $uid; ?>" data-width="90" data-height="90" data-fgColor="#3c8dbc" data-readonly="true"/>
                                            <div class="knob-label">Members</div>
                                        </div><!-- ./col -->
                                        <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                                            <input type="text" class="knob" value="<?php echo $oid; ?>" data-width="90" data-height="90" data-fgColor="#f56954" data-readonly="true"/>
                                            <div class="knob-label">Non Profit Organization</div>
                                        </div><!-- ./col -->
                                        <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                                            <input type="text" class="knob" value="<?php echo $bid; ?>" data-width="90" data-height="90" data-fgColor="#00a65a" data-readonly="true"/>
                                            <div class="knob-label">Brands</div>
                                        </div><!-- ./col -->
                                        <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                                            <input type="text" class="knob" value="<?php echo $hid; ?>" data-width="90" data-height="90" data-fgColor="#00c0ef" data-readonly="true"/>
                                            <div class="knob-label">Hash Tags</div>
                                        </div><!-- ./col -->
                                    </div><!-- /.row -->
                                </div><!-- /.box-body -->
		
			
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
        <!-- jvectormap -->
        <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
		
		<!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	<script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
	<script type="text/javascript">
	       $(".knob").knob({
                    /*change : function (value) {
                     //console.log("change : " + value);
                     },
                     release : function (value) {
                     console.log("release : " + value);
                     },
                     cancel : function () {
                     console.log("cancel : " + this.value);
                     },*/
                    draw: function() {

                        // "tron" case
                        if (this.$.data('skin') == 'tron') {

                            var a = this.angle(this.cv)  // Angle
                                    , sa = this.startAngle          // Previous start angle
                                    , sat = this.startAngle         // Start angle
                                    , ea                            // Previous end angle
                                    , eat = sat + a                 // End angle
                                    , r = true;

                            this.g.lineWidth = this.lineWidth;

                            this.o.cursor
                                    && (sat = eat - 0.3)
                                    && (eat = eat + 0.3);

                            if (this.o.displayPrevious) {
                                ea = this.startAngle + this.angle(this.value);
                                this.o.cursor
                                        && (sa = ea - 0.3)
                                        && (ea = ea + 0.3);
                                this.g.beginPath();
                                this.g.strokeStyle = this.previousColor;
                                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                                this.g.stroke();
                            }

                            this.g.beginPath();
                            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                            this.g.stroke();

                            this.g.lineWidth = 2;
                            this.g.beginPath();
                            this.g.strokeStyle = this.o.fgColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                            this.g.stroke();

                            return false;
                        }
                    }
                });
	
	</script>
		
    </body>
</html>
       