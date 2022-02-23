@extends('layouts.admin.main')

@push('css')
<link href="{{asset('admin/assets/plugins/parsley/src/parsley.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
@if(auth()->user()->hasPermissionOn('create_request_type'))
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="#create_type" class="btn btn-lg btn-primary " data-toggle="modal">Yeni Tür Oluştur</a></li>
</ol>
@endif

<h1 class="page-header">Talep Türleri <small>Talep türlerini bu sayfada yönetebilirsiniz.</small></h1>
@if(request()->has('archived') && request()->archived == 'true')
<a href="{{route('admin.request-types.list')}}">Arşivdekileri gizle</a>
@else
<a href="{{route('admin.request-types.list')}}?archived=true">Arşivdekileri göster</a>
@endif       
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
                    <th class="text-nowrap">İsim</th>
                    <th class="text-nowrap">Renk</th>
                    <th class="text-nowrap">Kod Gerekli mi?</th>
                    <th class="text-nowrap">Kurallar</th>
                    <th class="text-nowrap" data-orderable="false">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($request_types as $type)
                <tr>
                    <td width="1%" class="f-s-600 text-inverse">{{$loop->iteration}}</td>
                    <td>{{$type->name}}</td>
                    <td><div style="width:100px; height:50px; background-color:{{$type->color}}; border:solid 1px"></div></td>
                    <td>{{$type->code_required ? 'Evet' : 'Hayır'}}</td>
                    <td>{!! $type->rules !!}</td>
                    <td>
                        @if(auth()->user()->hasPermissionOn('update_request_type'))
                        <a href="#update_type" data-toggle="modal" onclick="update_type('{{$type->id}}')" type="button" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        @endif
                        @if(auth()->user()->hasPermissionOn('archive_request_type'))
                            @if($type->is_archived)
                            <a href="{{route('admin.request-types.unarchive', $type->id)}}" type="button" class="btn btn-secondary"><i class="fa fa-backward"></i></a>
                            @else
                            <a href="{{route('admin.request-types.archive', $type->id)}}" onclick="must_confirmed_link('<b>{{$type->name}}</b> isimli talep tipini arşivlemek istediğinize emin misiniz?')" type="button" class="btn btn-danger"><i class="fas fa-folder"></i></a>
                            @endif
                        @endif
                    </td>
                </tr>
                @endforeach
                @php unset($type) @endphp
            </tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>


<div class="modal fade" id="create_type">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Talep Türü Oluştur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                @include('admin.components.request-type-form-modal-component')
        </div>
    </div>
</div>

<div class="modal fade" id="update_type">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Talep Türü Güncelle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div id="update_content">

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

    function update_type(id){
        let url = "{{route('admin.request-types.update-form','0')}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('update_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
        fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('update_content').innerHTML = data;
            $('.colorpickers').colorpicker({format:"hex"});
            document.getElementById('rules_container').innerHTML="<textarea name='rules' class='wysihtml5'></textarea>";
            $(".wysihtml5").wysihtml5()
        })
        .catch(err => document.getElementById('update_content').innerHTML = "Birşeyler ters gitti. Lütfen Tekrar Dene!");   
    }



</script>

<script src="{{asset('admin/assets/plugins/DataTables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/table-manage-default.demo.min.js')}}"></script>
@endpush