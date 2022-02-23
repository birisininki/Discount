@foreach($user->old_requests->take(5) as $old_request)
                        
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

<a href="{{route('admin.old-requests')}}?username={{$user->username}}&user_type=all&employee=&request_type=all&status=all&start_date=&end_date=">Tümünü Gör</a>
