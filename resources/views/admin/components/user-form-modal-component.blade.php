<form class="form-horizontal" method="POST" data-parsley-validate="true" action="{{isset($user) ? route('admin.users.update') : route('admin.users.create')}}">
    @csrf
    <div class="modal-body">
        <p>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" for="website">Kullanıcı ID :</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" value="{{isset($user) ? $user->user_id : ''}}" name="user_id" placeholder="Kullanıcı ID Girin" />
                </div>
            </div>

            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" for="website">Kullanıcı türü :</label>
                <div class="col-md-8 col-sm-8">
                    <select name="type_id" class="form-control">
                        @foreach ($types as $type)
                            <option {{isset($user) && $user->type->id == $type->id ? 'selected' : ''}} value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @isset($user)
            <input type="hidden" name="id" value="{{$user->id}}">
            @endisset
        </p>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">İptal</a>
        <button type="submit" class="btn btn-success">{{isset($user) ? 'Güncelle' : 'Oluştur'}}</button>
    </div>
</form>