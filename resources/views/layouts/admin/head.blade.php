<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Discount Panel</title> 
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="@yield('admindescription')" name="description" />
	<meta content="@yield('adminauthor')" name="author" />
	<link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon-16x16.png') }}" type="image/x-icon" />

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/animate/animate.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/css/apple/style.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/css/apple/style-responsive.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/css/apple/theme/default.css') }}" rel="stylesheet" id="theme" />
	<link href="{{ asset('admin/assets/css/apple/theme/discount.css') }}" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('admin/assets/plugins/pace/pace.min.js') }}"></script>
	<!-- ================== END BASE JS ================== -->

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

	@stack('css')
</head>