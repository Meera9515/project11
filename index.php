<!DOCTYPE html>
<html lang="en">

<head>
	  <?php
     include "confing.php" ;
		 $logedin=false;
	      if(logdein() == true){
	      $logedin=true;// i need it in next every page
	    }
     ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Task Tracking</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="homePage/css/bootstrap.min.css" />

	<!-- Owl Carousel -->
	<link type="text/css" rel="stylesheet" href="homePage/css/owl.carousel.css" />
	<link type="text/css" rel="stylesheet" href="homePage/css/owl.theme.default.css" />

	<!-- Magnific Popup -->
	<link type="text/css" rel="stylesheet" href="homePage/css/magnific-popup.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="homePage/css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="homePage/css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<!-- Header -->
	<header id="home">
		<!-- Background Image -->
		<div class="bg-img" style="background-image: url('./homePage/img/aa1.jpeg');">
			<div class="overlay"></div>
		</div>
		<!-- /Background Image -->

		<!-- Nav -->
		<nav id="nav" class="navbar nav-transparent">
			<div class="container">

				<div class="navbar-header">
					<!-- Logo -->
					<div class="navbar-brand">
						<a href="index.html"></a>
							<img class="logo" src="homePage/img/logo1.png" alt="logo">
							<img class="logo-alt" src="homePage/img/logo1.png" alt="logo">

					</div>
					<!-- /Logo -->

					<!-- Collapse nav button -->
					<div class="nav-collapse">
						<span></span>
					</div>
					<!-- /Collapse nav button -->
				</div>

				<!--  Main navigation  -->
				<ul class="main-nav nav navbar-nav navbar-right">
					<li><a href="#home">Home</a></li>
					<li><a href="#about">About</a></li>
					<?php if($logedin):?>
					<li><a href="logout.php">logout</a></li>
					<?php endif?>
				</ul>
				<!-- /Main navigation -->

			</div>
		</nav>
		<!-- /Nav -->

		<!-- home wrapper -->
		<div class="home-wrapper">
			<div class="container">
				<div class="row">

					<!-- home content -->
					<div class="col-md-10 col-md-offset-1">
						<div class="home-content">
							<h1 class="white-text">Task Tracking System</h1>
							<p class="white-text">
								System to tracking and evaluation
							</p>
							<?php
								$Utype=isset($_SESSION['type'])?$_SESSION['type']:"";

						      if($Utype == "info")
									   $url ="info.php";
						       else if($Utype == "manager")
						          $url ="manager.php";
						        else if($Utype == "employee")
						          $url ="employee.php";
						      	else
						      		$url ="login.php";
							?>
							<a href="<?php echo $url?>" class="white-btn">Get Started!</a>

						</div>
					</div>
					<!-- /home content -->

				</div>
			</div>
		</div>
		<!-- /home wrapper -->

	</header>
	<!-- /Header -->

	<!-- About -->
	<div id="about" class="section md-padding">

		<!-- Container -->
		<div class="container">

			<!-- Row -->
			<div class="row">

				<!-- Section header -->
				<div class="section-header text-center">
					<h2 class="title">Welcome to Task Tracking System</h2>
				</div>
				<!-- /Section header -->

				<!-- about -->
				<div class="col-md-12">
					<div class="about">
						<i class="fa fa-cogs"></i>
						<h3>ABOUT US</h3>
						<p>A project management system that manages project operations in terms of planning, monitoring and controlling the tasks and times of the project, It supports project management electronically according to the project life cycle, which begins by dividing the project's to define tasks, And then the time planning of the project, according to the detailed estimates of the tasks, To proceed to the phase of implementation control and measure the level of achievement to achieve effective interconnection between monitoring and control up to the delivery stage and the extraction of reports that reflect.</p>

					</div>
				</div>
				<!-- /about -->





			</div>
			<!-- /Row -->

		</div>
		<!-- /Container -->

	</div>
	<!-- /About -->







	<!-- Footer -->

	<!-- /Footer -->

	<!-- Back to top -->
	<div id="back-to-top"></div>
	<!-- /Back to top -->

	<!-- Preloader -->
	<div id="preloader">
		<div class="preloader">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>
	<!-- /Preloader -->

	<!-- jQuery Plugins -->
	<script type="text/javascript" src="homePage/js/jquery.min.js"></script>
	<script type="text/javascript" src="homePage/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="homePage/js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="homePage/js/jquery.magnific-popup.js"></script>
	<script type="text/javascript" src="homePage/js/main.js"></script>

</body>

</html>
