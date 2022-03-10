@foreach($requests as $request)
<tr style="background-color:{{$request->user->type->color}}">
    <td width="1%" class="f-s-600 text-inverse">{{$loop->iteration}}</td>
    <td>{{$request->user->username}}</td>
    <td>{{$request->user->type->name}}</td>
    <td style="background-color:{{$request->type->color}};font-size:13px;font-weight:500"><div class="btn btn-default btn-sm">{{$request->type->name}}</div></td>
    <td>{{$request->created_at->format('H:i')}}</td>
    <td> <a href="#handle_request" data-toggle="modal" data-backdrop="static" onclick="handle_request({{$request->id}})" type="button" class="btn btn-success"><i class="fa fa-edit"></i></a></td>
</tr>
@endforeach