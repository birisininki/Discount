@push('css')
<link href="{{asset('admin/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css')}}" rel="stylesheet" />

<style>
    .colorpicker {
	z-index: 9999 !important;
}
</style>
@endpush

<form class="form-horizontal" method="POST" data-parsley-validate="true" action="{{isset($user_type) ? route('admin.user-types.update') : route('admin.user-types.create')}}">
    @csrf
    <div class="modal-body">
        <p>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label">İsim :</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" value="{{isset($user_type) ? $user_type->name : ''}}" name="name" placeholder="İsim Girin" data-parsley-required="true" />
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label">Açıklama :</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" value="{{isset($user_type) ? $user_type->message : ''}}" name="message" placeholder="Açıklama Girin" data-parsley-required="true" />
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label">Renk :</label>
                <div class="col-md-8 col-sm-8">
                    <input type="text" class="form-control colorpickers" name="color" value="{{isset($user_type) ? $user_type->color : ''}}" readonly style="background-color:white;">
                </div>
            </div>
            @isset($user_type)
            <input type="hidden" name="user_type_id" value="{{$user_type->id}}">
            @endisset
        </p>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">İptal</a>
        <button type="submit" class="btn btn-success">{{isset($user_type) ? 'Güncelle' : 'Oluştur'}}</button>
    </div>
</form>

@push('js')
<script src="{{asset('admin/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js')}}"></script>
<script src="{{asset('admin/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>

<script>
    $('.colorpickers').colorpicker({format:"hex"});

</script>
@endpush