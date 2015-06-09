<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <ul class="sidebar-menu" id="leftmenu-ul">
						<li <?php if(stripos($_SERVER['REQUEST_URI'],"dashboard.php")) echo 'class="active"'; ?>>
                            <a href="dashboard.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
						<li <?php if(stripos($_SERVER['REQUEST_URI'],"users.php")) echo 'class="active"'; ?>>
                            <a href="users.php">
                                <i class="fa fa-user"></i> <span>Users</span>
                            </a>
                        </li>
                        <li <?php if(stripos($_SERVER['REQUEST_URI'],"npo.php")) echo 'class="active"'; ?>>
                            <a href="npo.php">
                                <i class="fa  fa-cog"></i> <span>NPOs</span>
                            </a>
                        </li>
                        
						<li <?php if(stripos($_SERVER['REQUEST_URI'],"brands.php")) echo 'class="active"'; ?>>
                            <a href="brands.php">
                                <i class="fa fa-btc"></i> <span>Brands</span>
                            </a>
                        </li>
                        
                        <li <?php if(stripos($_SERVER['REQUEST_URI'],"hash.php")) echo 'class="active"'; ?>>
                            <a href="hash.php">
                                <i class="fa fa-tags"></i> <span>Hash Tags</span>
                            </a>
                        </li>
						
						<li <?php if(stripos($_SERVER['REQUEST_URI'],"email_template.php")) echo 'class="active"'; ?>>
                            <a href="email_template.php">
                                <i class="fa fa-envelope"></i> <span>Email Template</span>
                            </a>
                        </li>
                      
						
                    </ul>
										
                </section>
                <!-- /.sidebar -->
            </aside>