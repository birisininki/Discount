<body>
	<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
<!-- begin #header -->
<div id="header" class="header navbar-default" style="background: #000;border-bottom:3px solid #ffbc00">
  <!-- begin navbar-header -->
  <div class="navbar-header">
    <a href="#" class="navbar-brand"> 
        <img src="{{asset('admin/assets/img/logo/logo-admin.png')}}" height="23px">
    </a>
    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span> 
    </button>
  </div>
  <!-- end navbar-header -->

  <!-- begin header-nav -->
  <ul class="navbar-nav navbar-right">

    <li class="dropdown navbar-user">
      <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
        <img src="{{ asset('admin/assets/img/user/user.png') }}" alt="" />
        <span class="d-none d-md-inline text-white">{{auth()->user()->name}}</span> <b class="caret text-white"></b>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="{{route('logout')}}" class="dropdown-item">Güvenli Çıkış</a>
      </div>
    </li>

  </ul>
  <!-- end header navigation right -->
</div>
<!-- end #header -->
