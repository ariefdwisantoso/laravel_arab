<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ url('satner/css/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ url('satner/vendors/linericon/style.css') }}">
	<link rel="stylesheet" href="{{ url('satner/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ url('satner/vendors/owl-carousel/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ url('satner/css/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ url('satner/vendors/nice-select/css/nice-select.csss') }}">
	<!-- main css -->
	<link rel="stylesheet" href="{{ url('satner/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" integrity="sha512-v8QQ0YQ3H4K6Ic3PJkym91KoeNT5S3PnDKvqnwqFD1oiqIl653crGZplPdU5KKtHjO0QKcQ2aUlQZYjHczkmGw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css" integrity="sha512-DzC7h7+bDlpXPDQsX/0fShhf1dLxXlHuhPBkBo/5wJWRoTU6YL7moeiNoej6q3wh5ti78C57Tu1JwTNlcgHSjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

	<!--================ Start Header Area =================-->
	<header class="header_area">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="{{ url('/') }}"><img src="{{ url('satner/img/education.png') }}" alt="" style="width: 15%;"></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav justify-content-end">
							<li class="nav-item active"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ url('theme/details') }}">Materi</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ url('/front/profil') }}">Profil</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ url('/juknis') }}">Petunjuk Penggunaan</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('login') }}">Login</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</header>
	<!--================ End Header Area =================-->

	<!--================ Start Home Banner Area =================-->
	<section class="home_banner_area">
		<div class="banner_inner">
			<div class="container">
                @yield("content")
			</div>
		</div>
	</section>
	<!--================ End Home Banner Area =================-->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="{{ url('satner/js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ url('satner/js/popper.js') }}"></script>
	<script src="{{ url('satner/js/bootstrap.min.js') }}"></script>
	<script src="{{ url('satner/js/stellar.js') }}"></script>
	<script src="{{ url('satner/js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ url('satner/vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
	<script src="{{ url('satner/vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{ url('satner/vendors/isotope/isotope-min.js') }}"></script>
	<script src="{{ url('satner/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
	<script src="{{ url('satner/js/jquery.ajaxchimp.min.js') }}"></script>
	<script src="{{ url('satner/js/mail-script.js') }}"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="{{ url('satner/js/gmaps.min.js') }}"></script>
	<script src="{{ url('satner/js/theme.js') }}"></script>
    <!-- Load DataTables -->
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    @yield("script")
</body>

</html>