<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <!-- Tell the browser to be responsive to screen width -->
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <title>Laravel Vue.js SPA Admin Starter Kit</title>
	    <meta name="csrf-token" content="{{ csrf_token() }}" />
    	<link rel="shortcut icon" href="/images/favicon.png">
		<!-- Vendor CSS Files -->
		<link href="/assets/vendor/aos/aos.css" rel="stylesheet">
		<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
		<link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
		<link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
		<link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
		<link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
		 <!-- Template Main CSS File -->
		 <link href="/assets/css/style.css" rel="stylesheet">

		
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
		    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>

		<main id="main">

			<div id="root">
				<router-view></router-view>
			</div>
		
		</main><!-- End #main -->

		<!-- <div id="preloader"></div> -->
		<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

		<!-- Vendor JS Files -->
		<script src="/assets/vendor/purecounter/purecounter.js"></script>
		<script src="/assets/vendor/aos/aos.js"></script>
		<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="/assets/vendor/glightbox/js/glightbox.min.js"></script>
		<script src="/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
		<script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>
		<script src="/assets/vendor/php-email-form/validate.js"></script>

		<script src="/js/bundle.min.js"></script>

		<!-- Template Main JS File -->
		<script src="/assets/js/main.js"></script>

		</body>

		</html>