@extends('layouts.admin.main')

@push('css')
<link href="{{asset('admin/assets/plugins/parsley/src/parsley.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
@if(auth()->user()->hasPermissionOn('create_employee'))
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="#create_employee" class="btn btn-lg btn-primary " data-toggle="modal">Çalışan Hesabı Oluştur</a></li>
</ol>
@endif

<h1 class="page-header">Çalışan Hesapları <small>Panel kullanıcılarını bu sayfada yönetebilirsiniz.</small></h1>
        
<!-- begin panel -->
<div class="panel panel-inverse">
    <!-- begin panel-heading -->

    <!-- end panel-heading -->
    <!-- begin panel-body -->
    <div class="panel-body" style="margin-top:30px;">
        <table id="data-table-default" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="1%"></th>
                    <th class="text-nowrap"><i class="fa fa-user"></i> Ad Soyad</th>
                    <th class="text-nowrap"><i class="fa fa-user"></i> Kullanıcı Adı</th>
                    <th class="text-nowrap" data-orderable="false"><i class="fa fa-edit"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td width="1%" class="f-s-600 text-inverse">{{$loop->iteration}}</td>
                    <td>{{$employee->name}}</td>
                    <td>{{$employee->username}}</td>
                    <td>
                        <a href="#employee_logs" data-toggle="modal" onclick="view_logs('{{$employee->username}}')" type="button" class="btn btn-info"><i class="fa fa-eye"></i></a>
                        @if(auth()->user()->hasPermissionOn('update_employee'))
                        <a href="#update_employee" data-toggle="modal" onclick="update_employee('{{$employee->username}}')" type="button" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        @endif
                        @if(auth()->user()->hasPermissionOn('delete_employee'))
                        <a href="{{route('admin.employees.delete', $employee->id)}}" onclick="must_confirmed_link('<b>{{$employee->name}}</b> isimli kullanıcıyı silmek istediğinize emin misiniz?')" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @php unset($employee) @endphp
            </tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>


<div class="modal fade" id="create_employee">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hesap Oluştur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                @include('admin.components.employee-form-modal-component')
        </div>
    </div>
</div>

<div class="modal fade" id="update_employee">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hesap Güncelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="update_content">

                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="employee_logs">
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

    function update_employee(username){
        let url = "{{route('admin.employees.update-form','0')}}";
        url = url.replace('/0', '/' + username);
        document.getElementById('update_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
        fetch(url)
        .then(response => response.text())
        .then(data => document.getElementById('update_content').innerHTML = data)
        .catch(err => document.getElementById('update_content').innerHTML = "Birşeyler ters gitti. Lütfen Tekrar Dene!");   
    }

    function view_logs(username){
        let url = "{{route('admin.employees.activities','0')}}";
        url = url.replace('/0', '/' + username);
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