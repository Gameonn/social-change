<?php 
//require_once "phpInclude/header.php";
require_once "../php_include/db_connection.php";
//total
$whereClause1_0=""; 
$whereClause2_0=""; 
$whereClause3_0="";
$registered_users=$active_users=$total_requests=$videos_received=$avg_bid=$total_revenue=$highest_bid=$registered_vips=$open_vips=$avg_donation_per=$avg_price_suggestion=$total_charities=$total_money_donated=$open_requests=0;$preferred_charity="";

$sql="SELECT count(fanid) as total,sum(case when status>0 then 1 else 0 end) as confirmed from fan $whereClause1";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_users=$result[0][0];
if($result[0][1]) $active_users=$result[0][1];

$sql="SELECT count(booking.id) as total, round(max(booking.offer),0) as max_bid, sum(case when status=0 then 1 else 0 end) as open_requests from booking $whereClause2";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_requests=$result[0][0];
if($result[0][1]) $highest_bid=$result[0][1];
if($result[0][2]) $open_requests=$result[0][2];

$sql="SELECT count(greeting.id) as total,round(sum(booking.offer),0) as total_offerred,round(sum(booking.offer*vip.donation_share/100),0) as total_money_donated,round(avg(booking.offer),0) as average_bid from greeting left join booking on booking.id=greeting.booking_id left join vip on vip.vipid=greeting.vipid $whereClause3";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $videos_received=$result[0][0];
if($result[0][1]) $total_offerred=$result[0][1];
if($result[0][2]) $total_money_donated=$result[0][2];
$total_revenue=$total_offerred-$total_money_donated;
if($result[0][3]) $avg_bid=$result[0][3];

$sql="SELECT count(vipid) as total, sum(case when status>0 then 1 else 0 end) as open from vip $whereClause1";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_vips=$result[0][0];
if($result[0][1]) $open_vips=$result[0][1];

$sql="SELECT round(avg(donation_share),0) as avg_donation,round(avg(price_suggestion),0) as avg_price from vip $whereClause1 and status>0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $avg_donation_per=$result[0][0];
if($result[0][1]) $avg_price_suggestion=$result[0][1];

$sql="select count(id) from charity $whereClause1";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_charities=$result[0][0];
$total_registrations=$registered_vips+$registered_users;
$unique_visitors=$total_registrations;
$codes_requested=$total_requests;

//last year
$whereClause1_0="where DATE_FORMAT(registered_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y')-1"; 
$whereClause2_0="where DATE_FORMAT(booking.requested_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y')-1"; 
$whereClause3_0="where DATE_FORMAT(greeting.sent_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y')-1";

$registered_users_0=$active_users_0=$total_requests_0=$videos_received_0=$avg_bid_0=$total_revenue_0=$highest_bid_0=$registered_vips_0=$open_vips_0=$avg_donation_per_0=$avg_price_suggestion_0=$total_charities_0=$total_money_donated_0=$open_requests_0=0;$preferred_charity_0="";

$sql="SELECT count(fanid) as total,sum(case when status>0 then 1 else 0 end) as confirmed from fan $whereClause1_0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_users_0=$result[0][0];
if($result[0][1]) $active_users_0=$result[0][1];

$sql="SELECT count(booking.id) as total, round(max(booking.offer),0) as max_bid, sum(case when status=0 then 1 else 0 end) as open_requests from booking $whereClause2_0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_requests_0=$result[0][0];
if($result[0][1]) $highest_bid_0=$result[0][1];
if($result[0][2]) $open_requests_0=$result[0][2];

$sql="SELECT count(greeting.id) as total,round(sum(booking.offer),0) as total_offerred,round(sum(booking.offer*vip.donation_share/100),0) as total_money_donated,round(avg(booking.offer),0) as average_bid from greeting left join booking on booking.id=greeting.booking_id left join vip on vip.vipid=greeting.vipid $whereClause3_0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $videos_received_0=$result[0][0];
if($result[0][1]) $total_offerred_0=$result[0][1];
if($result[0][2]) $total_money_donated_0=$result[0][2];
$total_revenue_0=$total_offerred_0-$total_money_donated_0;
if($result[0][3]) $avg_bid_0=$result[0][3];

$sql="SELECT count(vipid) as total, sum(case when status>0 then 1 else 0 end) as open from vip $whereClause1_0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_vips_0=$result[0][0];
if($result[0][1]) $open_vips_0=$result[0][1];

$sql="SELECT round(avg(donation_share),0) as avg_donation,round(avg(price_suggestion),0) as avg_price from vip $whereClause1_0 and status>0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $avg_donation_per_0=$result[0][0];
if($result[0][1]) $avg_price_suggestion_0=$result[0][1];

$sql="select count(id) from charity $whereClause1_0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_charities_0=$result[0][0];
$total_registrations_0=$registered_vips_0+$registered_users_0;
$unique_visitors_0=$total_registrations_0;
$codes_requested_0=$total_requests_0;

//year  to date
$whereClause1_1="where DATE_FORMAT(registered_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y')"; 
$whereClause2_1="where DATE_FORMAT(booking.requested_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y')"; 
$whereClause3_1="where DATE_FORMAT(greeting.sent_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y')";

$registered_users_1=$active_users_1=$total_requests_1=$videos_received_1=$avg_bid_1=$total_revenue_1=$highest_bid_1=$registered_vips_1=$open_vips_1=$avg_donation_per_1=$avg_price_suggestion_1=$total_charities_1=$total_money_donated_1=$open_requests_1=0;$preferred_charity_1="";

$sql="SELECT count(fanid) as total,sum(case when status>0 then 1 else 0 end) as confirmed from fan $whereClause1_1";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_users_1=$result[0][0];
if($result[0][1]) $active_users_1=$result[0][1];

$sql="SELECT count(booking.id) as total, round(max(booking.offer),0) as max_bid, sum(case when status=0 then 1 else 0 end) as open_requests from booking $whereClause2_1";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_requests_1=$result[0][0];
if($result[0][1]) $highest_bid_1=$result[0][1];
if($result[0][2]) $open_requests_1=$result[0][2];

$sql="SELECT count(greeting.id) as total,round(sum(booking.offer),0) as total_offerred,round(sum(booking.offer*vip.donation_share/100),0) as total_money_donated,round(avg(booking.offer),0) as average_bid from greeting left join booking on booking.id=greeting.booking_id left join vip on vip.vipid=greeting.vipid $whereClause3_1";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $videos_received_1=$result[0][0];
if($result[0][1]) $total_offerred_1=$result[0][1];
if($result[0][2]) $total_money_donated_1=$result[0][2];
$total_revenue_1=$total_offerred_1-$total_money_donated_1;
if($result[0][3]) $avg_bid_1=$result[0][3];

$sql="SELECT count(vipid) as total, sum(case when status>0 then 1 else 0 end) as open from vip $whereClause1_1";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_vips_1=$result[0][0];
if($result[0][1]) $open_vips_1=$result[0][1];

$sql="SELECT round(avg(donation_share),0) as avg_donation,round(avg(price_suggestion),0) as avg_price from vip $whereClause1_1 and status>0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $avg_donation_per_1=$result[0][0];
if($result[0][1]) $avg_price_suggestion_1=$result[0][1];

$sql="select count(id) from charity $whereClause1_1";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_charities_1=$result[0][0];
$total_registrations_1=$registered_vips_1+$registered_users_1;
$unique_visitors_1=$total_registrations_1;
$codes_requested_1=$total_requests_1;
	
//last month
$whereClause1_2="where DATE_FORMAT(registered_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y') and DATE_FORMAT(registered_on,'%c')=DATE_FORMAT(CURDATE(),'%c')-1"; 
$whereClause2_2="where DATE_FORMAT(booking.requested_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y') and DATE_FORMAT(booking.requested_on,'%c')=DATE_FORMAT(CURDATE(),'%c')-1"; 
$whereClause3_2="where DATE_FORMAT(greeting.sent_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y') and DATE_FORMAT(greeting.sent_on,'%c')=DATE_FORMAT(CURDATE(),'%c')-1";

$registered_users_2=$active_users_2=$total_requests_2=$videos_received_2=$avg_bid_2=$total_revenue_2=$highest_bid_2=$registered_vips_2=$open_vips_2=$avg_donation_per_2=$avg_price_suggestion_2=$total_charities_2=$total_money_donated_2=$open_requests_2=0;$preferred_charity_2="";

$sql="SELECT count(fanid) as total,sum(case when status>0 then 1 else 0 end) as confirmed from fan $whereClause1_2";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_users_2=$result[0][0];
if($result[0][1]) $active_users_2=$result[0][1];

$sql="SELECT count(booking.id) as total, round(max(booking.offer),0) as max_bid, sum(case when status=0 then 1 else 0 end) as open_requests from booking $whereClause2_2";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_requests_2=$result[0][0];
if($result[0][1]) $highest_bid_2=$result[0][1];
if($result[0][2]) $open_requests_2=$result[0][2];

$sql="SELECT count(greeting.id) as total,round(sum(booking.offer),0) as total_offerred,round(sum(booking.offer*vip.donation_share/100),0) as total_money_donated,round(avg(booking.offer),0) as average_bid from greeting left join booking on booking.id=greeting.booking_id left join vip on vip.vipid=greeting.vipid $whereClause3_2";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $videos_received_2=$result[0][0];
if($result[0][1]) $total_offerred_2=$result[0][1];
if($result[0][2]) $total_money_donated_2=$result[0][2];
$total_revenue_2=$total_offerred_2-$total_money_donated_2;
if($result[0][3]) $avg_bid_2=$result[0][3];

$sql="SELECT count(vipid) as total, sum(case when status>0 then 1 else 0 end) as open from vip $whereClause1_2";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_vips_2=$result[0][0];
if($result[0][1]) $open_vips_2=$result[0][1];

$sql="SELECT round(avg(donation_share),0) as avg_donation,round(avg(price_suggestion),0) as avg_price from vip $whereClause1_2 and status>0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $avg_donation_per_2=$result[0][0];
if($result[0][1]) $avg_price_suggestion_2=$result[0][1];

$sql="select count(id) from charity $whereClause1_2";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_charities_2=$result[0][0];
$total_registrations_2=$registered_vips_2+$registered_users_2;
$unique_visitors_2=$total_registrations_2;
$codes_requested_2=$total_requests_2;

//month to date
$whereClause1_3="where DATE_FORMAT(registered_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y') and DATE_FORMAT(registered_on,'%c')=DATE_FORMAT(CURDATE(),'%c')"; 
$whereClause2_3="where DATE_FORMAT(booking.requested_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y') and DATE_FORMAT(booking.requested_on,'%c')=DATE_FORMAT(CURDATE(),'%c')"; 
$whereClause3_3="where DATE_FORMAT(greeting.sent_on,'%Y')=DATE_FORMAT(CURDATE(),'%Y') and DATE_FORMAT(greeting.sent_on,'%c')=DATE_FORMAT(CURDATE(),'%c')"; 

$registered_users_3=$active_users_3=$total_requests_3=$videos_received_3=$avg_bid_3=$total_revenue_3=$highest_bid_3=$registered_vips_3=$open_vips_3=$avg_donation_per_3=$avg_price_suggestion_3=$total_charities_3=$total_money_donated_3=$open_requests_3=0;$preferred_charity_3="";

$sql="SELECT count(fanid) as total,sum(case when status>0 then 1 else 0 end) as confirmed from fan $whereClause1_3";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_users_3=$result[0][0];
if($result[0][1]) $active_users_3=$result[0][1];

$sql="SELECT count(booking.id) as total, round(max(booking.offer),0) as max_bid, sum(case when status=0 then 1 else 0 end) as open_requests from booking $whereClause2_3";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_requests_3=$result[0][0];
if($result[0][1]) $highest_bid_3=$result[0][1];
if($result[0][2]) $open_requests_3=$result[0][2];

$sql="SELECT count(greeting.id) as total,round(sum(booking.offer),0) as total_offerred,round(sum(booking.offer*vip.donation_share/100),0) as total_money_donated,round(avg(booking.offer),0) as average_bid from greeting left join booking on booking.id=greeting.booking_id left join vip on vip.vipid=greeting.vipid $whereClause3_3";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $videos_received_3=$result[0][0];
if($result[0][1]) $total_offerred_3=$result[0][1];
if($result[0][2]) $total_money_donated_3=$result[0][2];
$total_revenue_3=$total_offerred_3-$total_money_donated_3;
if($result[0][3]) $avg_bid_3=$result[0][3];

$sql="SELECT count(vipid) as total, sum(case when status>0 then 1 else 0 end) as open from vip $whereClause1_3";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $registered_vips_3=$result[0][0];
if($result[0][1]) $open_vips_3=$result[0][1];

$sql="SELECT round(avg(donation_share),0) as avg_donation,round(avg(price_suggestion),0) as avg_price from vip $whereClause1_3 and status>0";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $avg_donation_per_3=$result[0][0];
if($result[0][1]) $avg_price_suggestion_3=$result[0][1];

$sql="select count(id) from charity $whereClause1_3";
$sth=$conn->prepare($sql);
try{$sth->execute();}catch(Exception $e){}
$result=$sth->fetchAll();
if($result[0][0]) $total_charities_3=$result[0][0];
$total_registrations_3=$registered_vips_3+$registered_users_3;
$unique_visitors_3=$total_registrations_3;
$codes_requested_3=$total_requests_3;
 ?>
<!--CSS DATA TABLES -->
<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?//php require_once "phpInclude/leftmenu.php"; ?>
			<!-- right-side -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Overview
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Overview</a></li>
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
					<div class="row">
						<div class="col-md-9">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
									<li class="active" onclick="showCharts(-1);"><a href="#tab" data-toggle="tab">Total</a></li>
									<li onclick="showCharts(0);"><a href="#tab_0" data-toggle="tab">Last Year</a></li>
									<li onclick="showCharts(1);"><a href="#tab_1" data-toggle="tab">Year to date</a></li>
									<li onclick="showCharts(2);"><a href="#tab_2" data-toggle="tab">Last Month</a></li>
									<li onclick="showCharts(3);"><a href="#tab_3" data-toggle="tab">Month to date</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab">
                                        <table id="download-table" class="overview-table" width="100%">
											<tr><td>
												<table width="90%">
													<tr><td><h4>Overview users</h4></td><td></td></tr>
													<tr><td>Registered users total</td><td><?php echo $registered_users; ?></td></tr>
													<tr><td>Active users</td><td><?php echo $active_users; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Requests</h4></td><td></td></tr>
													<tr><td>Requests sent total</td><td><?php echo $total_requests; ?></td></tr>
													<tr><td>Videos received</td><td><?php echo $videos_received; ?></td></tr>
													<tr><td>Average money bid</td><td><?php echo $avg_bid; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Total Revenue</td><td><?php echo $total_revenue; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Highest Bid</td><td><?php echo $highest_bid; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview VIP's</h4></td><td></td></tr>
													<tr><td>Registered VIP's total</td><td><?php echo $registered_vips; ?></td></tr>
													<tr><td>Open for confirmation</td><td><?php echo $open_vips; ?></td></tr>
													<tr><td>Average % of donation</td><td><?php echo $avg_donation_per; ?> %</td></tr>
													<tr><td>Average price suggestion</td><td><?php echo $avg_price_suggestion; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
											</td><td>
												<table width="90%">
													<tr><td><h4>Conversion funnel</h4></td><td></td></tr>
													<tr><td>Unique visitors</td><td><?php echo $unique_visitors; ?></td></tr>
													<tr><td>Codes requested</td><td><?php echo $codes_requested; ?></td></tr>
													<tr><td>Registrations</td><td><?php echo $total_registrations; ?></td></tr>
													<tr><td>Video Requests</td><td><?php echo $total_requests; ?></td></tr>
													<tr><td>Video answered</td><td><?php echo $videos_received; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Charities</h4></td><td></td></tr>
													<tr><td>Total Charities</td><td><?php echo $total_charities; ?></td></tr>
													<tr><td>Money Donated Total</td><td><?php echo $total_money_donated; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Preferred Charity</td><td><?php echo $preferred_charity; ?></td></tr>
												</table>
											</td></tr>
										</table>
                                    </div><!-- /.tab-pane -->
									<div class="tab-pane" id="tab_0">
                                        <table id="download-table" class="overview-table" width="100%">
											<tr><td>
												<table width="90%">
													<tr><td><h4>Overview users</h4></td><td></td></tr>
													<tr><td>Registered users total</td><td><?php echo $registered_users_0; ?></td></tr>
													<tr><td>Active users</td><td><?php echo $active_users_0; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Requests</h4></td><td></td></tr>
													<tr><td>Requests sent total</td><td><?php echo $total_requests_0; ?></td></tr>
													<tr><td>Videos received</td><td><?php echo $videos_received_0; ?></td></tr>
													<tr><td>Average money bid</td><td><?php echo $avg_bid_0; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Total Revenue</td><td><?php echo $total_revenue_0; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Highest Bid</td><td><?php echo $highest_bid_0; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview VIP's</h4></td><td></td></tr>
													<tr><td>Registered VIP's total</td><td><?php echo $registered_vips_0; ?></td></tr>
													<tr><td>Open for confirmation</td><td><?php echo $open_vips_0; ?></td></tr>
													<tr><td>Average % of donation</td><td><?php echo $avg_donation_per_0; ?> %</td></tr>
													<tr><td>Average price suggestion</td><td><?php echo $avg_price_suggestion_0; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
											</td><td>
												<table width="90%">
													<tr><td><h4>Conversion funnel</h4></td><td></td></tr>
													<tr><td>Unique visitors</td><td><?php echo $unique_visitors_0; ?></td></tr>
													<tr><td>Codes requested</td><td><?php echo $codes_requested_0; ?></td></tr>
													<tr><td>Registrations</td><td><?php echo $total_registrations_0; ?></td></tr>
													<tr><td>Video Requests</td><td><?php echo $total_requests_0; ?></td></tr>
													<tr><td>Video answered</td><td><?php echo $videos_received_0; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Charities</h4></td><td></td></tr>
													<tr><td>Total Charities</td><td><?php echo $total_charities_0; ?></td></tr>
													<tr><td>Money Donated Total</td><td><?php echo $total_money_donated_0; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Preferred Charity</td><td><?php echo $preferred_charity_0; ?></td></tr>
												</table>
											</td></tr>
										</table>
                                    </div><!-- /.tab-pane -->
									<div class="tab-pane" id="tab_1">
                                        <table id="download-table" class="overview-table" width="100%">
											<tr><td>
												<table width="90%">
													<tr><td><h4>Overview users</h4></td><td></td></tr>
													<tr><td>Registered users total</td><td><?php echo $registered_users_1; ?></td></tr>
													<tr><td>Active users</td><td><?php echo $active_users_1; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Requests</h4></td><td></td></tr>
													<tr><td>Requests sent total</td><td><?php echo $total_requests_1; ?></td></tr>
													<tr><td>Videos received</td><td><?php echo $videos_received_1; ?></td></tr>
													<tr><td>Average money bid</td><td><?php echo $avg_bid_1; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Total Revenue</td><td><?php echo $total_revenue_1; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Highest Bid</td><td><?php echo $highest_bid_1; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview VIP's</h4></td><td></td></tr>
													<tr><td>Registered VIP's total</td><td><?php echo $registered_vips_1; ?></td></tr>
													<tr><td>Open for confirmation</td><td><?php echo $open_vips_1; ?></td></tr>
													<tr><td>Average % of donation</td><td><?php echo $avg_donation_per_1; ?> %</td></tr>
													<tr><td>Average price suggestion</td><td><?php echo $avg_price_suggestion_1; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
											</td><td>
												<table width="90%">
													<tr><td><h4>Conversion funnel</h4></td><td></td></tr>
													<tr><td>Unique visitors</td><td><?php echo $unique_visitors_1; ?></td></tr>
													<tr><td>Codes requested</td><td><?php echo $codes_requested_1; ?></td></tr>
													<tr><td>Registrations</td><td><?php echo $total_registrations_1; ?></td></tr>
													<tr><td>Video Requests</td><td><?php echo $total_requests_1; ?></td></tr>
													<tr><td>Video answered</td><td><?php echo $videos_received_1; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Charities</h4></td><td></td></tr>
													<tr><td>Total Charities</td><td><?php echo $total_charities_1; ?></td></tr>
													<tr><td>Money Donated Total</td><td><?php echo $total_money_donated_1; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Preferred Charity</td><td><?php echo $preferred_charity_1; ?></td></tr>
												</table>
											</td></tr>
										</table>
                                    </div><!-- /.tab-pane -->
									<div class="tab-pane" id="tab_2">
                                        <table id="download-table" class="overview-table" width="100%">
											<tr><td>
												<table width="90%">
													<tr><td><h4>Overview users</h4></td><td></td></tr>
													<tr><td>Registered users total</td><td><?php echo $registered_users_2; ?></td></tr>
													<tr><td>Active users</td><td><?php echo $active_users_2; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Requests</h4></td><td></td></tr>
													<tr><td>Requests sent total</td><td><?php echo $total_requests_2; ?></td></tr>
													<tr><td>Videos received</td><td><?php echo $videos_received_2; ?></td></tr>
													<tr><td>Average money bid</td><td><?php echo $avg_bid_2; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Total Revenue</td><td><?php echo $total_revenue_2; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Highest Bid</td><td><?php echo $highest_bid_2; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview VIP's</h4></td><td></td></tr>
													<tr><td>Registered VIP's total</td><td><?php echo $registered_vips_2; ?></td></tr>
													<tr><td>Open for confirmation</td><td><?php echo $open_vips_2; ?></td></tr>
													<tr><td>Average % of donation</td><td><?php echo $avg_donation_per_2; ?> %</td></tr>
													<tr><td>Average price suggestion</td><td><?php echo $avg_price_suggestion_2; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
											</td><td>
												<table width="90%">
													<tr><td><h4>Conversion funnel</h4></td><td></td></tr>
													<tr><td>Unique visitors</td><td><?php echo $unique_visitors_2; ?></td></tr>
													<tr><td>Codes requested</td><td><?php echo $codes_requested_2; ?></td></tr>
													<tr><td>Registrations</td><td><?php echo $total_registrations_2; ?></td></tr>
													<tr><td>Video Requests</td><td><?php echo $total_requests_2; ?></td></tr>
													<tr><td>Video answered</td><td><?php echo $videos_received_2; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Charities</h4></td><td></td></tr>
													<tr><td>Total Charities</td><td><?php echo $total_charities_2; ?></td></tr>
													<tr><td>Money Donated Total</td><td><?php echo $total_money_donated_2; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Preferred Charity</td><td><?php echo $preferred_charity_2; ?></td></tr>
												</table>
											</td></tr>
										</table>
                                    </div><!-- /.tab-pane -->
									<div class="tab-pane" id="tab_3">
                                        <table id="download-table" class="overview-table" width="100%">
											<tr><td>
												<table width="90%">
													<tr><td><h4>Overview users</h4></td><td></td></tr>
													<tr><td>Registered users total</td><td><?php echo $registered_users_3; ?></td></tr>
													<tr><td>Active users</td><td><?php echo $active_users_3; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Requests</h4></td><td></td></tr>
													<tr><td>Requests sent total</td><td><?php echo $total_requests_3; ?></td></tr>
													<tr><td>Videos received</td><td><?php echo $videos_received_3; ?></td></tr>
													<tr><td>Average money bid</td><td><?php echo $avg_bid_3; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Total Revenue</td><td><?php echo $total_revenue_3; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Highest Bid</td><td><?php echo $highest_bid_3; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview VIP's</h4></td><td></td></tr>
													<tr><td>Registered VIP's total</td><td><?php echo $registered_vips_3; ?></td></tr>
													<tr><td>Open for confirmation</td><td><?php echo $open_vips_3; ?></td></tr>
													<tr><td>Average % of donation</td><td><?php echo $avg_donation_per_3; ?> %</td></tr>
													<tr><td>Average price suggestion</td><td><?php echo $avg_price_suggestion_3; ?> <i class="fa fa-eur"></i></td></tr>
												</table>
											</td><td>
												<table width="90%">
													<tr><td><h4>Conversion funnel</h4></td><td></td></tr>
													<tr><td>Unique visitors</td><td><?php echo $unique_visitors_3; ?></td></tr>
													<tr><td>Codes requested</td><td><?php echo $codes_requested_3; ?></td></tr>
													<tr><td>Registrations</td><td><?php echo $total_registrations_3; ?></td></tr>
													<tr><td>Video Requests</td><td><?php echo $total_requests_3; ?></td></tr>
													<tr><td>Video answered</td><td><?php echo $videos_received_3; ?></td></tr>
												</table>
												<table width="90%">
													<tr><td><h4>Overview Charities</h4></td><td></td></tr>
													<tr><td>Total Charities</td><td><?php echo $total_charities_3; ?></td></tr>
													<tr><td>Money Donated Total</td><td><?php echo $total_money_donated_3; ?> <i class="fa fa-eur"></i></td></tr>
													<tr><td>Preferred Charity</td><td><?php echo $preferred_charity_3; ?></td></tr>
												</table>
											</td></tr>
										</table>
                                    </div><!-- /.tab-pane -->
                                </div><!-- /.tab-content -->
                            </div><!-- nav-tabs-custom -->
							<!--<label>Export: </label>
							<button class="btn btn-primary" name="">CSV</button>
							<button class="btn btn-primary" name="" onclick="window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#download-table').html()));e.preventDefault();">Excel</button>-->
                        </div>
						<div class="col-md-3">
							<!-- DONUT CHART -->
                            <div class="">
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
                                </div><!-- /.box-body -->
								<h4 style="text-align:center">Open requests Vs Videos received</h4>
                            </div><!-- /.box -->                           

						   <!-- LINE CHART -->
                            <div class=""> 
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="line-chart" style="height: 300px;"></div>
                                </div><!-- /.box-body -->
								<h4 style="text-align:center">Users</h4>
                            </div><!-- /.box -->

                           

                        </div><!-- /.col (RIGHT) -->
					</div>
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
		<script type="text/javascript">
			function showCharts(n){
				$('#sales-chart').html("");
				switch(n){
					case -1:
						var donut = new Morris.Donut({
							element: 'sales-chart',
							resize: true,
							colors: ["#3c8dbc", "#00a65a"],
							data: [
								{label: "Open Requests", value: <?php echo $open_requests; ?>},
								{label: "Videos Received", value: <?php echo $videos_received; ?>}
							],
							hideHover: 'auto'
						});
					break;
					case 0: 
						var donut = new Morris.Donut({
							element: 'sales-chart',
							resize: true,
							colors: ["#3c8dbc", "#00a65a"],
							data: [
								{label: "Open Requests", value: <?php echo $open_requests_0; ?>},
								{label: "Videos Received", value: <?php echo $videos_received_0; ?>}
							],
							hideHover: 'auto'
						});
					break;
					case 1: 
						var donut = new Morris.Donut({
							element: 'sales-chart',
							resize: true,
							colors: ["#3c8dbc", "#00a65a"],
							data: [
								{label: "Open Requests", value: <?php echo $open_requests_1; ?>},
								{label: "Videos Received", value: <?php echo $videos_received_1; ?>}
							],
							hideHover: 'auto'
						});
					break;
					case 2: 
						var donut = new Morris.Donut({
							element: 'sales-chart',
							resize: true,
							colors: ["#3c8dbc", "#00a65a"],
							data: [
								{label: "Open Requests", value: <?php echo $open_requests_2; ?>},
								{label: "Videos Received", value: <?php echo $videos_received_2; ?>}
							],
							hideHover: 'auto'
						});		
					break;
					case 3: 
						var donut = new Morris.Donut({
							element: 'sales-chart',
							resize: true,
							colors: ["#3c8dbc", "#00a65a"],
							data: [
								{label: "Open Requests", value: <?php echo $open_requests_3; ?>},
								{label: "Videos Received", value: <?php echo $videos_received_3; ?>}
							],
							hideHover: 'auto'
						});
					break;
				}
			}
		
           $(function() {
                "use strict";

                // LINE CHART
                var line = new Morris.Line({
                    element: 'line-chart',
                    resize: true,
                    data: [
                        {y: '2011 Q1', item1: 2666},
                        {y: '2011 Q2', item1: 2778},
                        {y: '2011 Q3', item1: 4912},
                        {y: '2011 Q4', item1: 3767},
                        {y: '2012 Q1', item1: 6810},
                        {y: '2012 Q2', item1: 5670},
                        {y: '2012 Q3', item1: 4820},
                        {y: '2012 Q4', item1: 15073},
                        {y: '2013 Q1', item1: 10687},
                        {y: '2013 Q2', item1: 8432}
                    ],
                    xkey: 'y',
                    ykeys: ['item1'],
                    labels: ['Item 1'],
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto'
                });

                //DONUT CHART
                var donut = new Morris.Donut({
                    element: 'sales-chart',
                    resize: true,
                    colors: ["#3c8dbc", "#00a65a"],
                    data: [
                        {label: "Open Requests", value: <?php echo $open_requests; ?>},
                        {label: "Videos Received", value: <?php echo $videos_received; ?>}
                    ],
                    hideHover: 'auto'
                });
            });
        </script>

    </body>
</html>