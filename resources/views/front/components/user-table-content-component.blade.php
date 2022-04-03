@foreach($user->active_requests as $active_request) 
        <div class="lottery">
            <div class="lottery-col">
                <div class="lottery__total-prize lottery-col-inner">
                    <p class="lottery__total-prize__title">Discount Talebi</p>
                    <p class="lottery__total-prize__amount">
                        Sıra Numaranız
                    </p>
                </div> 
            </div>
            <div class="lottery-col">
                <div class="lottery__total-prize lottery-col-inner">
                    <div class="ticket">{{$active_request->queue}}</div>
                </div>
            </div>
            <div class="lottery-col">
                <div class="lottery__total-prize lottery-col-inner" style="padding-left:8px">
                    <p class="lottery__total-prize__amount" style="font-size:14px">
                        {{$active_request->type->name}}
                    </p>
                    <p class="lottery__total-prize__title"> {{$active_request->status == 0 ? 'Talep Beklemede' : 'Talebiniz işleme alındı.'}}</p>
                </div>
            </div>
            <div class="lottery-col">
                <div class="lottery__total-prize lottery-col-inner">
                    <p class="lottery__total-prize__subtitle" style="padding-left:15px">Talebiniz gerçekleştirilirken lütfen bekleyiniz...</p>
                </div>
            </div>
        </div>
        <br>
        @endforeach

        