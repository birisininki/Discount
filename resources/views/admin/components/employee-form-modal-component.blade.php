<form class="form-horizontal" method="POST" data-parsley-validate="true" action="{{isset($employee) ? route('admin.employees.update') : route('admin.employees.create')}}">
    @csrf
    <div class="modal-body">
        <p>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" for="fullname">İsim Soyisim :</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" value="{{isset($employee) ? $employee->name : ''}}" name="name" placeholder="İsim Girin" data-parsley-required="true" />
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" for="website">Kullanıcı Adı :</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="text" value="{{isset($employee) ? $employee->username : ''}}" name="username" data-parsley-required="true"  placeholder="Kullanıcı Adı Girin" />
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-4 col-sm-4 col-form-label" for="message">Şifre :</label>
                <div class="col-md-8 col-sm-8">
                    <input class="form-control" type="password" name="password" placeholder="Şifre" data-parsley-required="true" />
                </div>
            </div>
            <hr>

            <div class="form-group row m-b-15">
                <label class="col-md-12 col-sm-12 col-form-label text-center" for="message">İzinler</label>
                <div class="col-md-2 col-sm-2">
                    <b><u>Çalışan Hesapları</u></b><br>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('view_employees') ? 'checked' : ''}} name="view_employees" class="form-check-input" id="view_employee{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="view_employee{{isset($employee) ? $employee->id : ''}}">Görüntüle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('create_employee') ? 'checked' : ''}} name="create_employee" class="form-check-input" id="create_employee2{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="create_employee2{{isset($employee) ? $employee->id : ''}}">Oluştur<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('update_employee') ? 'checked' : ''}} name="update_employee" class="form-check-input" id="update_employee2{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="update_employee2{{isset($employee) ? $employee->id : ''}}">Düzenle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('delete_employee') ? 'checked' : ''}} name="delete_employee" class="form-check-input" id="delete_employee{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="delete_employee{{isset($employee) ? $employee->id : ''}}">Sil<label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2">
                    <b><u>Kullanıcılar</u></b><br>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('view_users') ? 'checked' : ''}} name="view_users" class="form-check-input" id="view_user{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="view_user{{isset($employee) ? $employee->id : ''}}">Görüntüle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('update_user') ? 'checked' : ''}} name="update_user" class="form-check-input" id="update_user{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="update_user{{isset($employee) ? $employee->id : ''}}">Düzenle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('ban_user') ? 'checked' : ''}} name="ban_user" class="form-check-input" id="ban_user{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="ban_user{{isset($employee) ? $employee->id : ''}}">Engelle<label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2">
                    <b><u>Talep Geçmişi</u></b><br>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('view_old_requests') ? 'checked' : ''}} name="view_old_requests" class="form-check-input" id="view_old_requests{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="view_old_requests{{isset($employee) ? $employee->id : ''}}">Görüntüle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('export_old_requests') ? 'checked' : ''}} name="export_old_requests" class="form-check-input" id="export_old_requests{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="export_old_requests{{isset($employee) ? $employee->id : ''}}">Dışa Aktar<label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2">
                    <b><u>Kullanıcı Türleri</u></b><br>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('view_user_types') ? 'checked' : ''}} name="view_user_types" class="form-check-input" id="view_user_type{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="view_user_type{{isset($employee) ? $employee->id : ''}}">Görüntüle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('create_user_type') ? 'checked' : ''}} name="create_user_type" class="form-check-input" id="create_user_type{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="create_user_type{{isset($employee) ? $employee->id : ''}}">Oluştur<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('update_user_type') ? 'checked' : ''}} name="update_user_type" class="form-check-input" id="update_user_type{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="update_user_type{{isset($employee) ? $employee->id : ''}}">Düzenle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('archive_user_type') ? 'checked' : ''}} name="archive_user_type" class="form-check-input" id="archive_user_type{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="archive_user_type{{isset($employee) ? $employee->id : ''}}">Arşivle<label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2">
                    <b><u>Talep Türleri</u></b><br>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('view_request_types') ? 'checked' : ''}} name="view_request_types" class="form-check-input" id="view_request_type{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="view_request_type{{isset($employee) ? $employee->id : ''}}">Görüntüle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('create_request_type') ? 'checked' : ''}} name="create_request_type" class="form-check-input" id="create_request_type{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="create_request_type{{isset($employee) ? $employee->id : ''}}">Oluştur<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('update_request_type') ? 'checked' : ''}} name="update_request_type" class="form-check-input" id="update_request_type{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="update_request_type{{isset($employee) ? $employee->id : ''}}">Düzenle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('archive_request_type') ? 'checked' : ''}} name="archive_request_type" class="form-check-input" id="archive_request_type{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="archive_request_type{{isset($employee) ? $employee->id : ''}}">Arşivle<label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2">
                    <b><u>Mesaj Şablonları</u></b><br>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('view_message_templates') ? 'checked' : ''}} name="view_message_templates" class="form-check-input" id="view_template{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="view_template{{isset($employee) ? $employee->id : ''}}">Görüntüle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('create_message_template') ? 'checked' : ''}} name="create_message_template" class="form-check-input" id="create_template{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="create_template{{isset($employee) ? $employee->id : ''}}">Oluştur<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('update_message_template') ? 'checked' : ''}} name="update_message_template" class="form-check-input" id="update_template{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="update_template{{isset($employee) ? $employee->id : ''}}">Düzenle<label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" {{isset($employee) && $employee->hasPermissionOn('delete_message_template') ? 'checked' : ''}} name="delete_message_template" class="form-check-input" id="archive_template{{isset($employee) ? $employee->id : ''}}" />
                        <label class="form-check-label" for="archive_template{{isset($employee) ? $employee->id : ''}}">Sil<label>
                    </div>
                </div>
            </div>

            @isset($employee)
            <input type="hidden" name="employee_id" value="{{$employee->id}}">
            @endisset
        </p>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">İptal</a>
        <button type="submit" class="btn btn-success">{{isset($employee) ? 'Güncelle' : 'Oluştur'}}</button>
    </div>
</form>