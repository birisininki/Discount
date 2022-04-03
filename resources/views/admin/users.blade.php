@extends('layouts.admin.main')

@push('css')
<link href="{{asset('admin/assets/plugins/parsley/src/parsley.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet" />
@endpush

@section('content')

<h1 class="page-header">Kullanıcılar <small>Bu sayfada tüm kullanıcıları yönetebilirsiniz.</small></h1>
@if (request()->has('show_banned'))
 <a href="{{route('admin.users.list')}}">Tümünü Göster</a>
@else
<a href="{{route('admin.users.list')}}?show_banned=true">Sadece Engellenenleri Göster</a>
@endif
<!-- begin panel -->
<div class="panel panel-inverse">
    <!-- begin panel-heading -->

    <!-- end panel-heading -->
    <!-- begin panel-body -->
    <div class="panel-body" style="margin-top:30px;">
        <table id="data-table-default" class="table  table-bordered">
            <thead>
                <tr>
                    <th width="1%"></th>
                    <th class="text-nowrap"><i class="fa fa-user"></i> Kullanıcı Adı</th>
                    <th class="text-nowrap"><i class="fa fa-list-ol"></i> Kullanıcı IDsi</th>
                    <th class="text-nowrap"><i class="fa fa-list"></i> Kullanıcı Türü</th>
                    <th class="text*nowrap"><i class="fa fa-ban"></i> Engellenme Zamanı/Nedeni</th>
                    <th class="text-nowrap" data-orderable="false"><i class="fa fa-edit"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="background-color:{{$user->type->color}}">
                    <td width="1%" class="f-s-600 text-inverse">{{$loop->iteration}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->user_id}}</td>
                    <td>{{$user->type->name}}</td>
                    <td>{{$user->banned_at?->format('d-m-Y H:i')}} {{is_null($user->banned_at) ? 'Engelli Değil' : '/'}} {{$user->ban_reason}}</td>
                    <td>
                        <a href="#user_logs" data-toggle="modal" onclick="view_logs('{{$user->id}}')" type="button" class="btn btn-info"><i class="fa fa-eye"></i></a>
                        @if(auth()->user()->hasPermissionOn('update_user'))
                        <a href="#update_user" data-toggle="modal" onclick="update_user('{{$user->id}}')" type="button" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        @endif
                        @if(auth()->user()->hasPermissionOn('ban_user'))
                            @if($user->banned_at)
                            <a href="{{route('admin.users.unban', $user->id)}}" type="button" class="btn btn-secondary"><i class="fa fa-backward"></i></a>
                            @else
                            <a href="#ban_user" data-toggle="modal" onclick="ban_user('{{$user->id}}')" type="button" class="btn btn-danger"><i class="fa fa-ban"></i></a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
                @php unset($user) @endphp
            </tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>

<div class="modal fade" id="update_user">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kullanıcı Güncelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="update_content">

                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ban_user">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kullanıcı Engelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="ban_content">

                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="user_logs">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">İşlem Geçmişi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="log_content" class="p-20">

                </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{asset('admin/assets/plugins/parsley/dist/parsley.js')}}"></script>
<script src="{{asset('admin/assets/plugins/highlight/highlight.common.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/render.highlight.js')}}"></script>

<script>
    $(document).ready(function() {
        Highlight.init();
		TableManageDefault.init();
    });

    function update_user(id){
        let url = "{{route('admin.users.update-form','0')}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('update_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
        fetch(url)
        .then(response => response.text())
        .then(data => document.getElementById('update_content').innerHTML = data)
        .catch(err => document.getElementById('update_content').innerHTML = "Birşeyler ters gitti. Lütfen Tekrar Dene!");   
    }

    function ban_user(id){
        let url = "{{route('admin.users.ban-form','0')}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('ban_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
        fetch(url)
        .then(response => response.text())
        .then(data => document.getElementById('ban_content').innerHTML = data)
        .catch(err => document.getElementById('ban_content').innerHTML = "Birşeyler ters gitti. Lütfen Tekrar Dene!");   
    }

    function view_logs(id){
        let url = "{{route('admin.users.activities','0')}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('log_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
        fetch(url)
        .then(response => response.text())
        .then(data => document.getElementById('log_content').innerHTML = data)
        .catch(err => document.getElementById('log_content').innerHTML = "Birşeyler ters gitti. Lütfen Tekrar Dene!");   
    }


</script>

<script src="{{asset('admin/assets/plugins/DataTables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/table-manage-default.demo.min.js')}}"></script>
@endpush