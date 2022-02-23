@foreach ($logs as $log)
    @if(str_contains($log->type, 'create'))
        <div class="alert alert-success">
            <small style="float:right">{{$log->created_at->format('d-m-Y H:i')}}</small><br>
            {!!$log->readable!!}
        </div>
    @endif

    @if(str_contains($log->type, 'update'))
        <div class="alert alert-warning">
            <small style="float:right">{{$log->created_at->format('d-m-Y H:i')}}</small><br>
            {!!$log->readable!!}
        </div>
    @endif

    @if(str_contains($log->type, 'delete'))
    <div class="alert alert-danger">
        <small style="float:right">{{$log->created_at->format('d-m-Y H:i')}}</small><br>
        {!!$log->readable!!}
    </div>
    @endif

    @if(str_contains($log->type, 'confirm'))
        <div class="alert alert-info">
            <small style="float:right">{{$log->created_at->format('d-m-Y H:i')}}</small><br>
            {!!$log->readable!!}
        </div>
    @endif

    @if(str_contains($log->type, 'ban'))
    <div class="alert alert-secondary">
        <small style="float:right">{{$log->created_at->format('d-m-Y H:i')}}</small><br>
        {!!$log->readable!!}
    </div>
@endif
@endforeach