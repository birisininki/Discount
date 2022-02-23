<form class="form-horizontal" method="POST" data-parsley-validate="true" action="{{isset($message_template) ? route('admin.message-templates.update') : route('admin.message-templates.create')}}">
    @csrf
    <div class="modal-body">
        <p>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" for="website">Mesaj</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" name="message" value="{{isset($message_template) ? $message_template->message : ''}}" placeholder="Mesaj Girin" data-parsley-required="true"/>
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" for="website">Talep Türü</label>
                <div class="col-md-8 col-sm-8">
                    <select name="request_type_id" class="form-control">
                        @foreach($request_types as $request_type)
                         <option value="{{$request_type->id}}" {{isset($message_template) && $message_template->request_type_id == $request_type->id ? 'selected' : ''}}>{{$request_type->name}}</option>
                        @endforeach
                    </select>
                 </div>
            </div>
            @isset($message_template)
            <input type="hidden" name="message_template_id" value="{{$message_template->id}}">
            @endisset
        </p>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">İptal</a>
        <button type="submit" class="btn btn-success">{{isset($message_template) ? 'Güncelle' : 'Oluştur'}}</button>
    </div>
</form>