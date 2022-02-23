@extends('layouts.admin.main')

@push('css')
<link href="{{asset('admin/assets/plugins/parsley/src/parsley.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
@if(auth()->user()->hasPermissionOn('create_message_template'))
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="#create_template" class="btn btn-lg btn-primary " data-toggle="modal">Yeni Şablon Oluştur</a></li>
</ol>
@endif

<h1 class="page-header">Mesaj Şablonları <small>Mesaj şablonlarını bu sayfada yönetebilirsiniz.</small></h1>

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
                    <th class="text-nowrap">Talep Türü</th>
                    <th class="text-nowrap">Mesaj</th>
                    <th class="text-nowrap" data-orderable="false">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($message_templates as $template)
                <tr>
                    <td width="1%" class="f-s-600 text-inverse">{{$loop->iteration}}</td>
                    <td>{{$template->request_type->name}}</td>
                    <td>{{$template->message}}</td>
                    <td>
                        @if(auth()->user()->hasPermissionOn('update_message_template'))
                        <a href="#update_template" data-toggle="modal" onclick="update_template('{{$template->id}}')" type="button" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        @endif
                        @if(auth()->user()->hasPermissionOn('delete_message_template'))
                        <a href="{{route('admin.message-templates.delete', $template->id)}}" onclick="must_confirmed_link('Şablonu silmek, şablonu kullandığınız talepleri etkilemez. Fakat yeni taleplerde bu şablonu kullanamazsınız. <b>{{$template->message}}</b> şablonunu silmek istediğinize emin misiniz?')" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @php unset($template) @endphp
            </tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>


<div class="modal fade" id="create_template">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Şablon Oluştur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                @include('admin.components.message-template-form-modal-component')
        </div>
    </div>
</div>

<div class="modal fade" id="update_template">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Şablon Güncelle</h4>
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

    function update_template(id){
        let url = "{{route('admin.message-templates.update-form','0')}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('update_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
        fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('update_content').innerHTML = data;
        })
        .catch(err => document.getElementById('update_content').innerHTML = "Birşeyler ters gitti. Lütfen Tekrar Dene!");   
    }



</script>

<script src="{{asset('admin/assets/plugins/DataTables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/table-manage-default.demo.min.js')}}"></script>
@endpush