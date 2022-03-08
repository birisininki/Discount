<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Personel Girişi | Betsmove</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/animate/animate.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/css/apple/style.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/css/apple/style-responsive.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/css/apple/theme/default.css')}}" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{asset('admin/assets/plugins/pace/pace.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<div class="login-cover">
	    <div class="login-cover-image" style="background-image: url({{asset('admin/assets/img/login-bg/login-bg-17.jpg')}})" data-id="login-cover-image"></div>
	    <div class="login-cover-bg"></div>
	</div>
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
					<img src="{{asset('admin/assets/img/logo/logo.png')}}" height="120px">
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="{{route('login')}}" method="POST" class="margin-bottom-0">
                    @csrf
                    <div class="form-group m-b-20">
                        <input name="username" type="text" class="form-control form-control-lg" placeholder="Kullanıcı Adınız" required />
                    </div>
                    <div class="form-group m-b-20">
                        <input name="password" type="password" class="form-control form-control-lg" placeholder="Şifreniz" required />
                    </div>

                    <div class="login-buttons">
                        <button type="submit" class="btn btn-block btn-lg" style="background:#ffbc00">Giriş Yap</button>
                    </div>

                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login -->
        
        <ul class="login-bg-list clearfix">
            <li class="active"><a href="javascript:;" data-click="change-bg" data-img="{{asset('admin/assets/img/login-bg/login-bg-17.jpg')}}" style="background-image: url({{asset('admin/assets/img/login-bg/login-bg-17.jpg')}})"></a></li>
            <li><a href="javascript:;" data-click="change-bg" data-img="{{asset('admin/assets/img/login-bg/login-bg-16.jpg')}}" style="background-image: url({{asset('admin/assets/img/login-bg/login-bg-16.jpg')}})"></a></li>
        </ul>
        
	</div> 
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{asset('admin/assets/plugins/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js')}}"></script>
	<!--[if lt IE 9]>
		<script src="{{asset('admin/assets/crossbrowserjs/html5shiv.js')}}"></script>
		<script src="{{asset('admin/assets/crossbrowserjs/respond.min.js')}}"></script>
		<script src="{{asset('admin/assets/crossbrowserjs/excanvas.min.js')}}"></script>
	<![endif]-->
	<script src="{{asset('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/js-cookie/js.cookie.js')}}"></script>
	<script src="{{asset('admin/assets/js/theme/apple.min.js')}}"></script>
	<script src="{{asset('admin/assets/js/apps.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{asset('admin/assets/js/demo/login-v2.demo.min.js')}}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			App.init();
			LoginV2.init();
		});
	</script>
    @include('sweetalert::alert')
</body>
</html>
