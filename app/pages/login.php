<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?=URLROOT?>assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Parking login</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

	<link href="assets/css/fontawesome-all.css" rel="stylesheet">

	<!-- CSS Files -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/now-ui-dashboard.min69ea.css?v=1.1.2" rel="stylesheet" />

	<link rel="icon" href="logo.png">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<!-- <link href="assets/demo/demo.css" rel="stylesheet" /> -->
</head>
<body class=" sidebar-mini ">
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary ">
		<div class="container-fluid">
			<div class="navbar-wrapper">
				<div class="navbar-toggle">
					<button type="button" class="navbar-toggler">
						<span class="navbar-toggler-bar bar1"></span>
						<span class="navbar-toggler-bar bar2"></span>
						<span class="navbar-toggler-bar bar3"></span>
					</button>
				</div>
				<a class="navbar-brand" href="#">Login</a>
			</div>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-bar navbar-kebab"></span>
				<span class="navbar-toggler-bar navbar-kebab"></span>
				<span class="navbar-toggler-bar navbar-kebab"></span>
			</button>

			<!-- <div class="collapse navbar-collapse justify-content-end" id="navigation">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a href="../dashboard.html" class="nav-link">
							<i class="now-ui-icons design_app"></i>
							Dashboard
						</a>
					</li>
					<li class= "nav-item ">
						<a href="register.html" class="nav-link">
							<i class="now-ui-icons tech_mobile"></i>
							Register
						</a>
					</li>
					<li class= "nav-item  active ">
						<a href="login.html" class="nav-link">
							<i class="now-ui-icons users_circle-08"></i>
							Login
						</a>
					</li>

					<li class= "nav-item ">
						<a href="lock.html" class="nav-link">
							<i class="now-ui-icons ui-1_lock-circle-open"></i>
							Lock
						</a>
					</li>
				</ul>
			</div> -->
		</div>
	</nav>
	<!-- End Navbar -->

	<div class="wrapper wrapper-full-page ">
		<div class="full-page login-page section-image" filter-color="green" data-image="assets/img/bg4.jpg">
			<!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
			<div class="content">
				<div class="container">
					<div class="col-md-4 ml-auto mr-auto">
						<form class="form" method="POST" action="/login">
							<?php
								if(!empty($_POST)){
									$username = $_POST['username']??"";
									$pwd = $_POST['password']??"";

									if(login($username, $pwd)){
										header("location:dashboard");
									}else{
										?>
											<p class="alert text-warning">Invalid username/password</p>
										<?php
									}
								}
							?>
							<div class="card card-login card-plain">
								
								<div class="card-header ">
									<div class="logo-container">
										<img src="assets/img/logo.png" alt="">
									</div>
								</div>
								
								<div class="card-body ">
									<div class="input-group no-border form-control-lg">
										<span class="input-group-prepend">
										  <div class="input-group-text">
											<i class="now-ui-icons users_circle-08"></i>
										  </div>
										</span>
										<input type="text" name="username" class="form-control" placeholder="email or phone...">
									</div>

									<div class="input-group no-border form-control-lg">
										<div class="input-group-prepend">
										  <div class="input-group-text">
											<i class="now-ui-icons text_caps-small"></i>
										  </div>
										</div>
										<input type="password" name="password" placeholder="Password..." class="form-control">
									</div>
								</div>

								<div class="card-footer ">
									<button type="submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">Login</button>
									<div class="pull-left">
										<h6><a href="signup" class="link footer-link">Create Account</a></h6>
									</div>

									<div class="pull-right">
									   <h6><a href="#help" class="link footer-link">Need Help?</a></h6>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<footer class="footer" >
				<div class="container-fluid">
					<div class="copyright" id="copyright">
						&copy; <script>document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))</script>, Designed by Placide</a>.
					</div>
				</div>
			</footer>

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
	<script async defer src="../assets/js/github-buttons.js"></script>


	<!-- Chart JS -->
	<script src="assets/js/plugins/chartjs.min.js"></script>

	<!--  Notifications Plugin    -->
	<script src="assets/js/plugins/bootstrap-notify.js"></script>

	<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
	<script src="assets/js/now-ui-dashboard.min69ea.js?v=1.1.2" type="text/javascript"></script>
	<script src="assets/demo/demo.js"></script>

	<script>
	  $(document).ready(function(){
		demo.checkFullPageBackgroundImage();
	  });
	</script>
</body>
</html>
