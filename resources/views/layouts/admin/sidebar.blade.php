<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
  <!-- begin sidebar scrollbar -->
  <div data-scrollbar="true" data-height="100%">
    <!-- begin sidebar user -->
    <ul class="nav">

      <li>

    <!-- begin sidebar nav -->
            <ul class="nav sidebar-nav">

            <li class="nav-header">Talepler</li>
          <!--module management-->
            <li>
                <a href="{{route('admin.dashboard')}}">
                <div class="icon-img">
                    <i class="fa fa-list bg-{{request()->route()->getName() == 'admin.dashboard' ? 'yellow' : 'gradient-blue' }}"></i>
                    </div>
                    <span>Aktif Talepler</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.my-requests')}}">
                <div class="icon-img">
                    <i class="fa fa-edit bg-{{request()->route()->getName() == 'admin.my-requests' ? 'yellow' : 'gradient-blue' }}"></i>
                    </div>
                    <span>İşleme Aldıklarım</span>
                </a>
            </li>
            @if(auth()->user()->hasPermissionOn('view_old_requests'))
            <li>
                <a href="{{route('admin.old-requests')}}">
                <div class="icon-img">
                    <i class="fa fa-suitcase bg-{{request()->route()->getName() == 'admin.old-requests' ? 'yellow' : 'gradient-blue' }}"></i>
                    </div>
                    <span>Eski Talepler</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermissionOn('view_request_types'))
            <li>
                <a href="{{route('admin.request-types.list')}}">
                <div class="icon-img">
                    <i class="fas fa-random bg-{{request()->route()->getName() == 'admin.request-types.list' ? 'yellow' : 'gradient-blue' }}"></i>
                    </div>
                    <span>Promosyonlar</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermissionOn('view_message_templates'))
            <li>
                <a href="{{route('admin.message-templates.list')}}">
                <div class="icon-img">
                    <i class="fas fa-envelope bg-{{request()->route()->getName() == 'admin.message-templates.list' ? 'yellow' : 'gradient-blue' }}"></i>
                    </div>
                    <span>Promosyon Mesajları</span>
                </a>
            </li>
            @endif
            <li class="nav-header">Üyeler</li>
            @if(auth()->user()->hasPermissionOn('view_users'))
            <li>
                <a href="{{route('admin.users.list')}}">
                <div class="icon-img">
                    <i class="fas fa-users bg-{{request()->route()->getName() == 'admin.users.list' ? 'yellow' : 'gradient-blue' }}"></i>
                    </div>
                    <span>Kayıtlı Üyeler</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->hasPermissionOn('view_user_types'))
            <li>
              <a href="{{route('admin.user-types.list')}}">
              <div class="icon-img">
                  <i class="fas fa-user-plus bg-{{request()->route()->getName() == 'admin.user-types.list' ? 'yellow' : 'gradient-blue' }}"></i>
                  </div>
                  <span>Kullanıcı Türleri</span>
              </a>
            </li>
            @endif
            <li class="nav-header">Personel</li>
            @if(auth()->user()->hasPermissionOn('view_employees'))
            <li>
                <a href="{{route('admin.employees.list')}}">
                <div class="icon-img">
                    <i class="fas fa-id-badge bg-{{request()->route()->getName() == 'admin.employees.list' ? 'yellow' : 'gradient-blue' }}"></i>
                    </div>
                    <span>Çalışan Yönetimi</span>
                </a>
            </li>
            @endif
          <!--#module management-->

          <!--sidebar routes-->
          <li class="nav-header"><i class="fa fa-cubes"></i> Version 1.5.3</li>

			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i> <span>Küçült</span></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
      </li>
    </ul>
    <!-- end sidebar user -->
    <!-- begin sidebar nav -->

    <!-- end sidebar nav -->
  </div>
  <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->
