@push('css')
<link href="{{asset('admin/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />

<style>
    .colorpicker {
	z-index: 9999 !important;
}
</style>
@endpush

<form class="form-horizontal" method="POST" data-parsley-validate="true" action="{{isset($request_type) ? route('admin.request-types.update') : route('admin.request-types.create')}}">
    @csrf
    <div class="modal-body">
        <p>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label">İsim :</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" value="{{isset($request_type) ? $request_type->name : ''}}" name="name" placeholder="İsim Girin" data-parsley-required="true" />
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label">Renk :</label>
                <div class="col-md-8 col-sm-8">
                    <input type="text" class="form-control colorpickers" name="color" value="{{isset($request_type) ? $request_type->color : ''}}" readonly style="background-color:white;">
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" >Promosyon kodu gerekli mi? :</label>
                <div class="col-md-8 col-sm-8">
                    <div class="radio radio-css radio-inline">
                        <input type="radio" name="code_required" id="radioYes{{isset($request_type) ? $request_type->id : ''}}" {{isset($request_type) && $request_type->code_required ? 'checked' : '' }} value="1" />
                        <label for="radioYes{{isset($request_type) ? $request_type->id : ''}}">Evet</label>
                    </div>
                    <div class="radio radio-css radio-inline">
                        <input type="radio" name="code_required" id="radioNo{{isset($request_type) ? $request_type->id : ''}}" {{isset($request_type) && !$request_type->code_required ? 'checked' : (!isset($request_type) ? 'checked' : '') }} value="0" />
                        <label for="radioNo{{isset($request_type) ? $request_type->id : ''}}">Hayır</label>
                    </div>
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-12 col-sm-12 col-form-label text-center" ><h4>Kurallar</h4></label>
                <div class="col-md-12 col-sm-12" {{!isset($request_type) ? "id=rules_container" : ''}}>
                    <textarea name="rules" class="wysihtml5">{{isset($request_type) ? $request_type->rules : ''}}</textarea>
                </div>
            </div>
            @isset($request_type)
            <input type="hidden" name="request_type_id" value="{{$request_type->id}}">
            @endisset
        </p>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">İptal</a>
        <button type="submit" class="btn btn-success">{{isset($request_type) ? 'Güncelle' : 'Oluştur'}}</button>
    </div>
</form>

@push('js')
<script src="{{asset('admin/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js')}}"></script>
<script src="{{asset('admin/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>


<script>
    $('.colorpickers').colorpicker({format:"hex"});
    $(".wysihtml5").wysihtml5()

</script>
@endpush