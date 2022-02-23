<form class="form-horizontal" method="POST" data-parsley-validate="true" action="{{route('admin.users.ban')}}">
    @csrf
    <div class="modal-body">
        <p>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" for="website">Ban Nedeni</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" name="message" placeholder="Ban Nedeni Girin" data-parsley-required="true"/>
                </div>
            </div>
            <input type="hidden" name="id" value="{{$user->id}}">
        </p>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">İptal</a>
        <button type="submit" class="btn btn-success" onclick="must_confirmed_form('{{$user->username}} kullanıcısını engellemek istediğinize emin misiniz?')">Engelle</button>
    </div>
</form>