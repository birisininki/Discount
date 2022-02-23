@extends('layouts.admin.main')

@push('css')
<link href="{{asset('admin/assets/plugins/parsley/src/parsley.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet" />

@endpush

@section('content')

<h1 class="page-header">Loglar <small>Veri tabanında yapılan her değişiklik bu sayfada listelenir</small></h1>

<!-- begin panel -->
<div class="panel panel-inverse">
    <!-- begin panel-heading -->

    <!-- end panel-heading -->
    <!-- begin panel-body -->
    <div class="panel-body" style="margin-top:30px;">
        <table id="data-table-default" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-nowrap">Log Türü</th>
                    <th class="text-nowrap">Model</th>
                    <th class="text-nowrap">Model Id</th>
                    <th class="text-nowrap">Kullanıcı Türü</th>
                    <th class="text-nowrap">Kullanıcı Id</th>
                    <th class="text-nowrap">Eski Değerler</th>
                    <th class="text-nowrap">Yeni Değerler</th>
                    <th class="text-nowrap">Log Tarihi</th>
                </tr>
            </thead>
            <tbody >
                @foreach($logs as $log)
                <tr>
                    <td>{{$log->type}}</td>
                    <td>{{$log->affected_model_name}}</td>
                    <td>{{$log->affected_model_id}}</td>
                    <td>{{$log->user_type}}</td>
                    <td>{{$log->user_id}}</td>
                    <td>{{$log->old_values}}</td>
                    <td>{{$log->new_values}}</td>
                    <td>{{$log->created_at->format('d-m-Y H:i:s')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>


@endsection

@push('js')
<script src="{{asset('admin/assets/plugins/parsley/dist/parsley.js')}}"></script>
<script src="{{asset('admin/assets/plugins/highlight/highlight.common.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/render.highlight.js')}}"></script>
<script src="{{asset('admin/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>


<script src="{{asset('admin/assets/plugins/DataTables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>

<script src="{{asset('admin/assets/js/demo/table-manage-default.demo.min.js')}}"></script>


<script>
    $(document).ready(function() {
        Highlight.init();
		TableManageDefault.init();

    });
</script>

@endpush