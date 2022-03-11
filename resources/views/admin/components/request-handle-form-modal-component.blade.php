
<form class="form-horizontal" method="POST" data-parsley-validate="true" action="{{route('admin.requests.update')}}">
    @csrf
    <div class="modal-body">
        <p>
            <div class="row">
                <div class="col-8">
                    <input type="hidden" value="{{$request->user->id}}" id="current_user_id">
                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Kullanıcı Adı</label>
                        <div class="col-md-8 col-sm-8">
                            <b>{{$request->user->username}}</b>
                        </div>
                    </div>
                    @if(auth()->user()->hasPermissionOn('ban_user'))
                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Kullanıcıyı Engelle</label>
                        <div class="col-md-6 col-sm-6">
                            <input class="form-control" id="ban_reason" type="text"placeholder="Ban Nedeni Girin"/>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <a href="javascript:ban_user();" class="btn btn-danger" id="ban_button"><i class="fa fa-ban"></i></a>
                            <a href="javascript:unban_user();" class="btn btn-secondary" id="unban_button" style="display:none"><i class="fa fa-backward"></i></a>
                            <a href="javascript:;" class="btn btn-danger" id="ban_loading_button" style="display:none"><i class="fas fa-spinner fa-spin"></i></a>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-8"><small>Engelleme mesajı girmeden kullanıcıyı engellerseniz, varsayılan olarak gereksiz talep mesajı kullanıcıya gösterilecektir.</small></div>
                    </div>
                    @endif
                    
                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Kullanıcı ID / Tür</label>
                        <div class="col-md-3 col-sm-3">
                            <input class="form-control" id="user_id" value="{{$request->user->user_id}}" type="text" placeholder="Kullanıcı Id Girin" {{auth()->user()->hasPermissionOn('update_user') ? '' : 'disabled'}}/>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="form-control" id="type_id" {{auth()->user()->hasPermissionOn('update_user') ? '' : 'disabled'}}>
                                @foreach($user_types as $type)
                                    <option value="{{$type->id}}" {{$request->user->type_id == $type->id ? 'selected' : ''}}>{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->hasPermissionOn('update_user'))
                        <div class="col-md-2 col-sm-2">
                            <a href="javascript:update_user()" type="button" class="btn btn-success" id="update_user_button"><i class="fa fa-edit"></i></a>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-8"><small>Bu kısımda yaptığınız değişiklikte yandaki yeşil butona basmanız gerektiğini unutmayın!</small></div>
                        @endif
                    </div>
        
                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Promosyon Türü</label>
                        <div class="col-md-8 col-sm-8">
                            <b>{{$request->type->name}}</b>
                        </div>
                    </div>
                    @if($request->type->code_required)
                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Kupon Kodu</label>
                        <div class="col-md-8 col-sm-8">
                            <b>{{$request->promotion_code}}</b>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Yüklenen Miktar</label>
                        <div class="col-md-8 col-sm-8">
                            <input class="form-control" name="amount" type="number" placeholder="Yüklenen Miktar"/>
                        </div>
                    </div>
        
                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Ret Mesajı</label>
                        <div class="col-md-8 col-sm-8">
                            <select class="form-control" name="message">
                                @foreach($request->type->messages as $message)
                                    <option value="{{$message->message}}">{{$message->message}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
        
                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Onay Mesajı</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="number" class="form-control" name="deposit" placeholder="Yatırım">
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <input type="number" class="form-control" name="draw" placeholder="Çekim">
                        </div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-md-4 col-sm-4 col-form-label" for="website">Onay Mesajı</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="number" class="form-control" name="casino" placeholder="Casino">
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <input type="number" class="form-control" name="sport" placeholder="Spor">
                        </div>
                    </div>
                    <input type="hidden" name="request_id" value="{{$request->id}}">
                </div>
                <div class="col-4">
                    <h3>Kullanıcı Geçmişi</h3>
                    @foreach($request->user->old_requests->take(3) as $old_request)
                        
                        <div class="alert alert-{{$old_request->status == 2 ? 'success' : 'danger'}}">
                            Talebi Alan: <b>{{$old_request->employee->name}}</b><br>
                            Talep Tarihi: <b>{{$old_request->created_at->format('d-m-Y H:i')}}</b><br>
                            Talep Türü: <b>{{$old_request->type->name}}</b><br>
                            @if($old_request->type->code_required)
                            Kupon Kodu: <b>{{$old_request->promotion_code}}</b><br>
                            @endif
                            Durumu: <b>{{$old_request->status == 2 ? 'Onaylandı' : 'Reddedildi'}}</b><br>
                            @if($old_request->status == 2)
                            Yüklenen Miktar: <b>{{$old_request->amount}}</b><br>
                            @endif
                            Açıklama: <b>{{$old_request->message}}</b>
                        </div>
                    @endforeach
                </div>
            </div>
           
        </p>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" onclick='cancel_handle({{$request->id}})' class="btn btn-warning" data-dismiss="modal">İptal</a>
        <button type="submit" name="result" value='0' class="btn btn-danger">Reddet</button>
        <button type="submit" name="result" value='1' class="btn btn-success">Onayla</button>
    </div>
</form>

