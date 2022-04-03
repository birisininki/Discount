@extends('layouts.admin.main')

@push('css')
<link href="{{asset('admin/assets/plugins/parsley/src/parsley.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet" />

@endpush

@section('content')
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="#filters" class="btn btn-lg btn-primary " data-toggle="modal">Filtrele</a></li>
</ol>


<h1 class="page-header">Eski Talepler <small>Eski talepleri bu sayfada görebilirsiniz.</small></h1>
@if(request()->has('username'))<a href = '{{route('admin.old-requests')}}'>Filtreleri Kaldır</a>@endif
<!-- begin panel -->
<div class="panel panel-inverse">
    <!-- begin panel-heading -->

    <!-- end panel-heading -->
    <!-- begin panel-body -->
    <div class="panel-body" style="margin-top:30px;">
        <table id="data-table-{{auth()->user()->hasPermissionOn('export_old_requests') ? 'buttons' : 'default'}}" class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-nowrap"><i class="fa fa-user"></i> Personel</th>
                    <th class="text-nowrap"><i class="fa fa-user"></i> K. Adı</th>
                    <th class="text-nowrap"><i class="fa fa-list"></i> K. Türü</th>
                    <th class="text-nowrap"><i class="fa fa-list-alt"></i> Talep Türü</th>
                    <th class="text-nowrap"><i class="fa fa-check"></i> Durum</th>
                    <th class="text-nowrap"><i class="fa fa-calculator"></i> Miktar</th>
                    
                    <th class="text-nowrap"><i class="fa fa-calendar"></i> Talep Tarihi</th>
                    <th class="text-nowrap"><i class="fa fa-calendar"></i> İşleme Alınma</th>
                    <th class="text-nowrap"><i class="fa fa-calendar"></i> Sonuçlanma</th>

                    <th class="text-nowrap">İşlem S.</th>
                    <th class="text-nowrap">Toplam S.</th>
                    -->
                    <th class="text-nowrap"><i class="fa fa-edit"></i> Açıklama</th>
                </tr>
            </thead>
            <tbody id="request_content">
                @foreach($requests as $request)
                <tr style="background-color:{{$request->user->type->color}}">
                    <td>{{$request->employee->name}}</td>
                    <td>{{$request->user->username}}</td>
                    <td>{{$request->user->type->name}}</td>
                    <td style="background-color:{{$request->type->color}}"><div class="btn btn-default btn-sm">{{$request->type->name}}</div></td>
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

                    <td>{{$request->created_at->format('d-m-Y H:i:s')}}</td>
                    <td>{{$request->process_datetime->format('d-m-Y H:i:s')}}</td>
                    <td>{{$request->handle_datetime?->format('d-m-Y H:i:s')}}</td>
                    <!--
                    <td>{{$request->handle_datetime?->diffInHours($request->process_datetime)}}:{{$request->handle_datetime?->diff($request->process_datetime)?->format('%I:%S')}}</td>
                    <td>{{$request->handle_datetime?->diffInHours($request->created_at)}}:{{$request->handle_datetime?->diff($request->created_at)?->format('%I:%S')}}</td>
                    -->
                    <td>{{$request->message}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>


<div class="modal fade" id="filters">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filtreler</h4>
                </div>
                <form action="{{route('admin.old-requests')}}" method="GET">
                <div class="modal-body">
                    <p>
                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Kullanıcı adına göre</label>
                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" type="text" value="{{request()->has('username') ? request()->username : ''}}" name="username" placeholder="Kullanıcı Adı Girin" data-parsley-required="true" />
                            </div>
                        </div>

                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Kullanıcı türüne göre</label>
                            <div class="col-md-8 col-sm-8">
                                <select name="user_type" class="form-control">
                                    <option value="all">Tümü</option>
                                    @foreach($user_types as $type)
                                    <option value="{{$type->id}}" {{request()->has('user_type') && request()->user_type == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Personele göre</label>
                            <div class="col-md-8 col-sm-8">
                                <select name="employee" class="form-control">
                                    <option value="all">Tümü</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" {{request()->has('employee') && request()->employee == $employee->id ? 'selected' : ''}}>{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Talep türüne göre</label>
                            <div class="col-md-8 col-sm-8">
                                <select name="request_type" class="form-control">
                                    <option value="all">Tümü</option>
                                    @foreach($request_types as $type)
                                    <option value="{{$type->id}}" {{request()->has('request_type') && request()->request_type == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Duruma göre</label>
                            <div class="col-md-8 col-sm-8">
                                <select name="status" class="form-control">
                                    <option value="all">Tümü</option>
                                    <option value="1" {{request()->has('status') && request()->status == 1 ? 'selected' : ''}}>İşlemde</option>
                                    <option value="2" {{request()->has('status') && request()->status == 2 ? 'selected' : ''}}>Onaylananlar</option>
                                    <option value="3" {{request()->has('status') && request()->status == 3 ? 'selected' : ''}}>Reddedilenler</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Bu Tarihten İtibaren</label>
                            <div class="col-md-8 col-sm-8">
                                <input type="text" class="form-control filter-date" readonly style="background-color:white;"  placeholder="Tarih Seçin" value="{{request()->has('start_date') ? request()->start_date : ''}}" name="start_date">
                            </div>
                        </div>

                        <div class="form-group row m-b-15">
                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Bu Tarihe Kadar</label>
                            <div class="col-md-8 col-sm-8">
                                <input type="text" class="form-control filter-date" readonly style="background-color:white;" placeholder="Tarih Seçin" value="{{request()->has('end_date') ? request()->end_date : ''}}" name="end_date">
                            </div>
                        </div>

                    </p>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">İptal</a>
                    <button type="submit" class="btn btn-success">Filtrele</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="{{asset('admin/assets/plugins/parsley/dist/parsley.js')}}"></script>
<script src="{{asset('admin/assets/plugins/highlight/highlight.common.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/render.highlight.js')}}"></script>
<script src="{{asset('admin/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>


<script src="{{asset('admin/assets/plugins/DataTables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
@if(auth()->user()->hasPermissionOn('export_old_requests'))
<script src="{{asset('admin/assets/js/demo/table-manage-buttons.demo.min.js')}}"></script>
@else
<script src="{{asset('admin/assets/js/demo/table-manage-default.demo.min.js')}}"></script>
@endif

<script>
    $(document).ready(function() {
        Highlight.init();
        @if(auth()->user()->hasPermissionOn('export_old_requests'))
		TableManageButtons.init();
        @else
		TableManageDefault.init();
        @endif
    });

    $(".filter-date").datepicker({
        todayHighlight: !0,
        autoclose: !0,
        clearBtn: !0,
        todayBtn: !0,
        format: 'yyyy-mm-dd',
    });
</script>

@endpush
