<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Oke</title>
	<link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/plugins/toastr/toastr.min.css') }}">
	<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('admin/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
	<script src="{{ asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('admin/js/inspinia.js') }}"></script>
	<script src="{{ asset('admin/js/plugins/pace/pace.min.js') }}"></script>
</head>
<body class="pace-done">
	<base href="{{ asset('path') }}">
	<div class="wrapper">
		@include('admin.layouts.sidebar')
		<div id="page-wrapper" class="gray-bg">
			@include('admin.layouts.header')
			@yield('content')
		</div>
	</div>
	<link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
</body>
</html>