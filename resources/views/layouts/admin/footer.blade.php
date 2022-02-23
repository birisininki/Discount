<!-- begin theme-panel -->
<div class="theme-panel">
    <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="ion-ios-cog"></i></a>
    <div class="theme-panel-content">
        <h5 class="m-t-0">Color Theme</h5>
        <ul class="theme-list clearfix">
            <li><a href="javascript:;" class="bg-green" data-theme="green" data-theme-file="{{ asset('admin/assets/css/apple/theme/green.css') }}" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Green">&nbsp;</a></li>
            <li><a href="javascript:;" class="bg-red" data-theme="red" data-theme-file="{{ asset('admin/assets/css/apple/theme/red.css') }}" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Red">&nbsp;</a></li>
            <li class="active"><a href="javascript:;" class="bg-blue" data-theme="default" data-theme-file="{{ asset('admin/assets/css/apple/theme/default.css') }}" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Default">&nbsp;</a></li>
            <li><a href="javascript:;" class="bg-purple" data-theme="purple" data-theme-file="{{ asset('admin/assets/css/apple/theme/purple.css') }}" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Purple">&nbsp;</a></li>
            <li><a href="javascript:;" class="bg-orange" data-theme="orange" data-theme-file="{{ asset('admin/assets/css/apple/theme/orange.css') }}" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Orange">&nbsp;</a></li>
            <li><a href="javascript:;" class="bg-black" data-theme="black" data-theme-file="{{ asset('admin/assets/css/apple/theme/black.css') }}" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Black">&nbsp;</a></li>
        </ul>
        <div class="divider"></div>
        <div class="row m-t-10">
            <div class="col-md-5 control-label double-line">Header Styling</div>
            <div class="col-md-7">
                <select name="header-styling" class="form-control form-control-sm">
                    <option value="1">default</option>
                    <option value="2">inverse</option>
                </select>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-5 control-label">Header</div>
            <div class="col-md-7">
                <select name="header-fixed" class="form-control form-control-sm">
                    <option value="1">fixed</option>
                    <option value="2">default</option>
                </select>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-5 control-label double-line">Sidebar Styling</div>
            <div class="col-md-7">
                <select name="sidebar-styling" class="form-control form-control-sm">
                    <option value="1">default</option>
                    <option value="2">grid</option>
                </select>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-5 control-label">Sidebar</div>
            <div class="col-md-7">
                <select name="sidebar-fixed" class="form-control form-control-sm">
                    <option value="1">fixed</option>
                    <option value="2">default</option>
                </select>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-5 control-label double-line">Sidebar Gradient</div>
            <div class="col-md-7">
                <select name="content-gradient" class="form-control form-control-sm">
                    <option value="1">disabled</option>
                    <option value="2">enabled</option>
                </select>
            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md-12">
                <a href="javascript:;" class="btn btn-inverse btn-block btn-sm" data-click="reset-local-storage">Reset Local Storage</a>
            </div>
        </div>
    </div>
</div>
<!-- end theme-panel -->

<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->

</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="{{ asset('admin/assets/plugins/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js') }}"></script>
<!--[if lt IE 9]>
<script src="{{ asset('admin/assets/crossbrowserjs/html5shiv.js') }}"></script>
<script src="{{ asset('admin/assets/crossbrowserjs/respond.min.js') }}"></script>
<script src="{{ asset('admin/assets/crossbrowserjs/excanvas.min.js') }}"></script>
<![endif]-->
<script src="{{ asset('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('admin/assets/js/theme/apple.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/apps.min.js') }}"></script>
<!-- ================== END BASE JS ================== -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>

<script type="text/javascript">

    function must_confirmed_link(message = null){
        let redirect = event.target.href;

        event.preventDefault();
		Swal.fire({
            title: message ? message : "Bu işlemi yapmak istediğinize emin misiniz?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Evet",
            cancelButtonText: "İptal",
		}).then(response => {
            if(!response.isDismissed) window.location = redirect;
        });
    }

    function must_confirmed_form(message = null){
        let form = event.target.form;

        event.preventDefault();
		Swal.fire({
            title: message ? message : "Bu işlemi yapmak istediğinize emin misiniz?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Evet",
            cancelButtonText: "İptal",
		}).then(response => {
            if(!response.isDismissed) form.submit();
        });
    }
</script>
@stack('js')
@include('sweetalert::alert')
</body>
</html>