<?php
	ob_start();
	session_start();
	ini_set("expose_php", "Off");

	//request trim minus query string
	$reqURI = $_SERVER['REQUEST_URI'];
	if(strlen($_SERVER['QUERY_STRING']) > 0){
		$reqURI = substr($_SERVER['REQUEST_URI'], 0, - strlen($_SERVER['QUERY_STRING'])??1);
	}

	$approot = 'smartpark';

	//trimming ? and /
	$reqURI =  rtrim(rtrim($reqURI, "/"), "?");

	define('URLROOT', '/smartpark/');

	//removing application name from path
	$appNamePath = 'smartpark';
	if(strripos($reqURI, $appNamePath) != false){
		$reqURI = substr_replace($reqURI, "", strripos($reqURI, $appNamePath), strlen($appNamePath));
	}


	//constants and basic libraries
	define('DB_DATE_FORMAT', 'Y-m-d H:i:s');
	define('STANDARD_DATE_FORMAT', 'd-m-Y');
	define('STANDARD_TIME_FORMAT', 'd-m-Y h:i:s');
	define('STANDARD_TIMETEXT_FORMAT', 'd M Y h:i:s');
	define('PROJECT_NAME', 'ParkSmart');

	include_once '../core/conn.php';
	include_once '../core/functions.php';

	//getting requested pages
	//checking the page
	$req_parts = explode("/", trim($reqURI, '/'));
	
	$req_parts = array_values($req_parts);
	$current_page_action = $base_page = $req_parts[0]??'dashboard'; #base required page
	if(empty($current_page_action))
		$current_page_action = $base_page = 'dashboard';

	if($base_page == 'login' || $base_page == 'accountinvitationconfirm'){
		include_once "pages/$base_page.php";
		die();
	}

	
	require '../core/web.php';
	require_once '../core/user.php';


	//list of core classes to load
	$listToLoad = array('parking', 'movements');

	foreach ($listToLoad as $key => $class) {
		require "../core/$class.php";
	}
	$Parking = new parking();
	require '../core/auth.php';
	
	$user_name = $user_data['name']??"";
	$current_user_pic = $user_data['profilePicture'];
	$standard_date = "d/m/Y";
	$standard_time = $standard_date." H:i";

	//Check requested route existence
	$pageFile = "pages/$base_page.php";
	if(!file_exists($pageFile)){
		$pageFile = "pages/404.php";
	}

	$jsFiles = array();
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
	<?php
		$title = "Welcome $user_name";
		include_once "modules/head.php";
	?>
	<script type="text/javascript">
		const currentUserId = "<?php echo $currentUserId; ?>";
		const apiLink = "/api/index.php";
	</script>
</head>

		<body class=" sidebar-mini ">
			<div class="wrapper ">
				<div class="sidebar" data-color="orange">
					<?php include 'modules/sidebar.php' ?>
				</div>


				<div class="main-panel">
					<!-- Navbar -->
					<?php include 'modules/menu.php'; ?>
					<!-- End Navbar -->

					<div class="page-container">
						<!-- Start Page content -->
						<?php include_once "$pageFile"; ?>
						<!-- End Page content -->
					</div>

					<footer class="footer" >
						<div class="container-fluid">
								<nav>
									<ul>
										<li>
											<a href="/">About Us</a>
										</li>
										<li>
											<a href="/">Blog</a>
										</li>
									</ul>
								</nav>
								<div class="copyright" id="copyright">
										&copy; <script>document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))</script> Developed by Placide.
								</div>
						</div>
					</footer>
				</div>
			</div>
				
			<div class="fixed-plugin">
				<div class="dropdown show-dropdown">
					<a href="#" data-toggle="dropdown">
					<i class="fa fa-cog fa-2x"> </i>
					</a>
					<ul class="dropdown-menu">
						<li class="header-title"> Sidebar Background</li>
						<li class="adjustments-line">
							<a href="javascript:void(0)" class="switch-trigger background-color">
								<div class="badge-colors text-center">
									<span class="badge filter badge-yellow" data-color="yellow"></span>
									<span class="badge filter badge-blue" data-color="blue"></span>
									<span class="badge filter badge-green" data-color="green"></span>
									<span class="badge filter badge-orange active" data-color="orange"></span>
									<span class="badge filter badge-red" data-color="red"></span>
								</div>
								<div class="clearfix"></div>
							</a>
						</li>

						
						<li class="header-title">
								Sidebar Mini
						</li>
						<li class="adjustments-line">

							<div class="togglebutton switch-sidebar-mini">
								<span class="label-switch">OFF</span>
								<input type="checkbox" name="checkbox" checked class="bootstrap-switch"
									data-on-label=""
									data-off-label=""
									/>
								<span class="label-switch label-right">ON</span>
							</div>
						</li>
					</ul>
				</div>
			</div>
			
<!--   Core JS Files   -->
<script src="assets/js/core/jquery.min.js" ></script>
<script src="assets/js/core/popper.min.js" ></script>
<script src="assets/js/core/bootstrap.min.js" ></script>
<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js" ></script>
<script src="assets/js/plugins/moment.min.js"></script>

<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="assets/js/plugins/bootstrap-switch.js"></script>

<!--  Plugin for Sweet Alert -->
<script src="assets/js/plugins/sweetalert2.min.js"></script>

<!-- Forms Validations Plugin -->
<script src="assets/js/plugins/jquery.validate.min.js"></script>

<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>

<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="assets/js/plugins/bootstrap-selectpicker.js" ></script>

<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="assets/js/plugins/bootstrap-datetimepicker.js"></script>

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="assets/js/plugins/jquery.dataTables.min.js"></script>

<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="assets/js/plugins/bootstrap-tagsinput.js"></script>

<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="assets/js/plugins/jasny-bootstrap.min.js"></script>

<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="assets/js/plugins/fullcalendar.min.js"></script>

<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="assets/js/plugins/jquery-jvectormap.js"></script>

<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="assets/js/plugins/nouislider.min.js" ></script>

<!--  Google Maps Plugin    -->
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="assets/js/github-buttons.js"></script>


<!-- Chart JS -->
<script src="assets/js/plugins/chartjs.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>

<!-- Control Center: parallax effects, scripts for the example pages etc -->
<script src="assets/js/now-ui-dashboard.min69ea.js?v=1.1.2" type="text/javascript"></script>
<script src="assets/demo/demo.js"></script>
<script>
	$(document).ready(function(){
		$().ready(function(){
				$sidebar = $('.sidebar');
				$sidebar_img_container = $sidebar.find('.sidebar-background');

				$full_page = $('.full-page');

				$sidebar_responsive = $('body > .navbar-collapse');
				sidebar_mini_active = true;

				window_width = $(window).width();

				fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

				// if( window_width > 767 && fixed_plugin_open == 'Dashboard' ){
				//     if($('.fixed-plugin .dropdown').hasClass('show-dropdown')){
				//         $('.fixed-plugin .dropdown').addClass('show');
				//     }
				//
				// }

				$('.fixed-plugin a').click(function(event){
					// Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
						if($(this).hasClass('switch-trigger')){
								if(event.stopPropagation){
										event.stopPropagation();
								}
								else if(window.event){
									 window.event.cancelBubble = true;
								}
						}
				});

				$('.fixed-plugin .background-color span').click(function(){
						$(this).siblings().removeClass('active');
						$(this).addClass('active');

						var new_color = $(this).data('color');

						if($sidebar.length != 0){
								$sidebar.attr('data-color',new_color);
						}

						if($full_page.length != 0){
								$full_page.attr('filter-color',new_color);
						}

						if($sidebar_responsive.length != 0){
								$sidebar_responsive.attr('data-color',new_color);
						}
				});

				$('.fixed-plugin .img-holder').click(function(){
						$full_page_background = $('.full-page-background');

						$(this).parent('li').siblings().removeClass('active');
						$(this).parent('li').addClass('active');


						var new_image = $(this).find("img").attr('src');

						if( $sidebar_img_container.length !=0 && $('.switch-sidebar-image input:checked').length != 0 ){
								$sidebar_img_container.fadeOut('fast', function(){
									 $sidebar_img_container.css('background-image','url("' + new_image_full_page + '")');
									 $sidebar_img_container.fadeIn('fast');
								});
						}

						if($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0 ) {
								var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

								$full_page_background.fadeOut('fast', function(){
									 $full_page_background.css('background-image','url("' + new_image_full_page + '")');
									 $full_page_background.fadeIn('fast');
								});
						}

						if( $('.switch-sidebar-image input:checked').length == 0 ){
								var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
								var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

								$sidebar_img_container.css('background-image','url("' + new_image + '")');
								$full_page_background.css('background-image','url("' + new_image_full_page + '")');
						}

						if($sidebar_responsive.length != 0){
								$sidebar_responsive.css('background-image','url("' + new_image + '")');
						}
				});

				$('.switch-sidebar-image input').on("switchChange.bootstrapSwitch", function(){
						$full_page_background = $('.full-page-background');

						$input = $(this);

						if($input.is(':checked')){
								if($sidebar_img_container.length != 0){
										$sidebar_img_container.fadeIn('fast');
										$sidebar.attr('data-image','#');
								}

								if($full_page_background.length != 0){
										$full_page_background.fadeIn('fast');
										$full_page.attr('data-image','#');
								}

								background_image = true;
						} else {
								if($sidebar_img_container.length != 0){
										$sidebar.removeAttr('data-image');
										$sidebar_img_container.fadeOut('fast');
								}

								if($full_page_background.length != 0){
										$full_page.removeAttr('data-image','#');
										$full_page_background.fadeOut('fast');
								}

								background_image = false;
						}
				});

				$('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function(){
					var $btn = $(this);

					if(sidebar_mini_active == true){
							$('body').removeClass('sidebar-mini');
							sidebar_mini_active = false;
							nowuiDashboard.showSidebarMessage('Sidebar mini deactivated...');
					}else{
							$('body').addClass('sidebar-mini');
							sidebar_mini_active = true;
							nowuiDashboard.showSidebarMessage('Sidebar mini activated...');
					}

					// we simulate the window Resize so the charts will get updated in realtime.
					var simulateWindowResize = setInterval(function(){
							window.dispatchEvent(new Event('resize'));
					},180);

					// we stop the simulation of Window Resize after the animations are completed
					setTimeout(function(){
							clearInterval(simulateWindowResize);
					},1000);
				});
		});
	});
</script>
<?php
	for($n=0; !empty($jsFiles) && $n<count($jsFiles) && is_array($jsFiles); $n++){
		$pfile = $jsFiles[$n];
		?>
			<script type="text/javascript" src="<?php echo $pfile ?>"></script>
		<?php
	}
?>
</body>
</html>
