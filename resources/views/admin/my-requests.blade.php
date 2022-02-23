@extends('layouts.admin.main')

@push('css')
<link href="{{asset('admin/assets/plugins/parsley/src/parsley.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet" />
@endpush

@section('content')


<h1 class="page-header">Taleplerim <small>İşleme aldığınız talepleri bu sayfada görebilirsiniz.</small></h1>
        
<!-- begin panel -->
<div class="panel panel-inverse">
    <!-- begin panel-heading -->

    <!-- end panel-heading -->
    <!-- begin panel-body -->
    <div class="panel-body" style="margin-top:30px;">
        <table id="data-table-default" class="table table-bordered">
            <thead>
                <tr>
                    <th width="1%"></th>
                    <th class="text-nowrap">Kullanıcı Adı</th>
                    <th class="text-nowrap">Kullanıcı Türü</th>
                    <th class="text-nowrap">Talep Türü</th>
                    <th class="text-nowrap">Durum</th>
                    <th class="text-nowrap">Miktar</th>
                    <th class="text-nowrap">Açıklama</th>
                    <th class="text-nowrap">Talep Tarihi</th>
                    <th class="text-nowrap">Sonuçlanma Tarihi</th>
                    <th class="text-nowrap" data-orderable="false">Tekrar Düzenle</th>
                </tr>
            </thead>
            <tbody id="request_content">
                @foreach($requests as $request)
                <tr style="background-color:{{$request->user->type->color}}">
                    <td width="1%" class="f-s-600 text-inverse">{{$loop->iteration}}</td>
                    <td>{{$request->user->username}}</td>
                    <td>{{$request->user->type->name}}</td>
                    <td style="background-color:{{$request->type->color}}">{{$request->type->name}}</td>
                    <td>
                        @php
                        switch($request->status){
                            case 1:
                                echo "<span class='badge badge-secondary'>İşlemde</span>";
                                break;
                            case 2:
                            echo "<span class='badge badge-success'>Onaylandı</span>";
                                break;
                            case 3:
                                echo "<span class='badge badge-danger'>Reddedildi</span>";
                                break;
                        }
                        @endphp
                    </td>
                    <td>{{$request->amount}}</td>
                    <td>{{$request->message}}</td>
                    <td>{{$request->created_at->format('d-m-Y H:i')}}</td>
                    <td>{{$request->handle_datetime?->format('d-m-Y H:i')}}</td>
                    <td> <a href="#handle_request" data-toggle="modal" data-backdrop="static" onclick="handle_request({{$request->id}})" type="button" class="btn btn-success"><i class="fa fa-edit"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>
@php unset($request) @endphp


<div class="modal fade" id="handle_request">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Talebi Değerlendir</h4>
                </div>
                <div id="handle_content">

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

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });


    function ban_user(){
        let id = document.getElementById('current_user_id').value;
        let reason = document.getElementById('ban_reason').value;
        let url = "{{route('admin.users.ban')}}";
        document.getElementById('ban_button').style.display="none";
        document.getElementById('ban_loading_button').style.display="inline-block";
        fetch(url, {
            headers: { "Content-Type": "application/json; charset=utf-8" },
            method: 'POST',
            body: JSON.stringify({
                id: id,
                message: reason,
                _token: '{{csrf_token()}}'
            })
        }).then(response => response.status)
        .then(data => {
            if(data == 200){
                document.getElementById('ban_loading_button').style.display="none";
                document.getElementById('unban_button').style.display="inline-block";
                Toast.fire({
                    icon: 'success',
                    title: 'Kullanıcı engellendi'
                })
            }else{
                document.getElementById('ban_loading_button').style.display="none";
                document.getElementById('ban_button').style.display="inline-block";
                Toast.fire({
                    icon: 'error',
                    title: 'Kullanıcı engellenirken bir sorun oluştu. Lütfen tekrar deneyin.'
                })
            }
        })
        .catch(err => {
            document.getElementById('ban_loading_button').style.display="none";
            document.getElementById('ban_button').style.display="inline-block";
            Toast.fire({
                icon: 'error',
                title: 'Kullanıcı engellenirken bir sorun oluştu. Lütfen tekrar deneyin.'
            })
        });
    }

    function unban_user(){
        let id = document.getElementById('current_user_id').value;
        let url = "{{route('admin.users.unban', 0)}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('unban_button').style.display="none";
        document.getElementById('ban_loading_button').style.display="inline-block";
        fetch(url)
        .then(response => response.status)
        .then(data => {
            if(data == 200){
                document.getElementById('ban_loading_button').style.display="none";
                document.getElementById('ban_button').style.display="inline-block";
                Toast.fire({
                    icon: 'success',
                    title: 'Kullanıcının engeli kaldırıldı!'
                })
            }else{
                document.getElementById('ban_loading_button').style.display="none";
                document.getElementById('unban_button').style.display="inline-block";
                Toast.fire({
                    icon: 'error',
                    title: 'Kullanıcının engeli kaldırılırken bir sorun oluştu. Lütfen tekrar deneyin.'
                })
            }
        })
        .catch(err => {
            document.getElementById('ban_loading_button').style.display="none";
            document.getElementById('unban_button').style.display="inline-block";
            Toast.fire({
                icon: 'error',
                title: 'Kullanıcının engeli kaldırılırken bir sorun oluştu. Lütfen tekrar deneyin.'
            })
        })
    }

    function update_user(){
        let id = document.getElementById('current_user_id').value;
        console.log(id);
        let user_id = document.getElementById('user_id').value;
        let type_id = document.getElementById('type_id').value;
        let url = "{{route('admin.users.update')}}";
        document.getElementById('update_user_button').innerHTML="<i class='fas fa-spinner fa-spin'></i>";
        fetch(url, {
            headers: { "Content-Type": "application/json; charset=utf-8" },
            method: 'POST',
            body: JSON.stringify({
                id: id,
                user_id: user_id,
                type_id: type_id,
                _token: '{{csrf_token()}}'
            })
        }).then(response => response.status)
        .then(data => {
            if(data == 200){
                document.getElementById('update_user_button').innerHTML="<i class='fa fa-edit'></i>";
                Toast.fire({
                    icon: 'success',
                    title: 'Kullanıcı güncellendi'
                })
            }else{
                document.getElementById('update_user_button').innerHTML="<i class='fa fa-edit'></i>";
                Toast.fire({
                    icon: 'error',
                    title: 'Kullanıcı güncellenirken bir sorun oluştu. Lütfen tekrar deneyin.'
                })
            }
        })
        .catch(err => {
            document.getElementById('update_user_button').innerHTML="<i class='fa fa-edit'></i>";
            Toast.fire({
                icon: 'error',
                title: 'Kullanıcı güncellenirken bir sorun oluştu. Lütfen tekrar deneyin.'
            })
        });
    }

    function handle_request(id){
        let url = "{{route('admin.requests.handle-form','0')}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('handle_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
        fetch(url)
        .then(response => response.text())
        .then(data => document.getElementById('handle_content').innerHTML = data)
        .catch(err => document.getElementById('handle_content').innerHTML = "Birşeyler ters gitti. Lütfen Tekrar Dene!");
    }

    function cancel_handle(id){

    }

</script>


<script src="{{asset('admin/assets/plugins/DataTables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/table-manage-default.demo.min.js')}}"></script>
@endpush