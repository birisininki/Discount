@extends('layouts.front.main')

@section('content')
    @if(session()->has('loggedInUser'))
    <section class="section only-desktop">
        <div class="form-area">
            <h1 class="form_title text-center">Promosyon Seçimi</h1>
            <form action="{{route('create-request')}}" method="post">
                @csrf
                <div class="form">
                    <select class="form__select" name="type_id" id="type_id">
                        <option value="" selected>Promosyon Seçiniz</option>
                        @foreach($request_types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="form__button" id="request_button">TALEP ET</button>
                </div>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <div id="promotion_code"></div>
            </form>
        </div>
    </section>
    <section class="section only-desktop">
        <div class="textbox">
            <div class="rules-area">
            <div class="rules-content" style="padding:10px" id="rules">
                
            </div>
        </div>
        </div>
    </section>
    @foreach($user->active_requests as $active_request)
    <section class="section only-desktop">
        <div class="lottery">
            <div class="lottery-col">
                <div class="lottery__total-prize lottery-col-inner">
                    <p class="lottery__total-prize__title">Discount</p>
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
                <div class="lottery__total-prize lottery-col-inner">
                    <p class="lottery__total-prize__amount">
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
    </section>
    @endforeach
    <section class="section only-desktop">
        <div class="requests-area">
            <h1 class="text-center text-white">Geçmiş Taleplerim</h1>
            <table>
              <thead>
                <tr>
                  <th class="text-center">Talep Türü</th>
                  <th class="text-center">Talep Tarih/Saat</th>
                  <th class="text-center">Talep Durumu</th>
                  <th class="text-center">Açıklama</th>
                  <th class="text-center">Onaylanan Miktar</th>
                </tr>
              </thead>  
              <tbody>
                  @foreach($user->old_requests as $request)
                    @if($request->status == 3)
                    <tr>
                    <td><b>{{$request->type->name}}</b></td>
                    <td>{{$request->created_at->format('d.m.Y - H:i')}}</td>
                    <td><div class="reguest_alert text-center" style="background: #9c0000;color:#fff;">Ret</div></td>
                    <td>{{$request->message}}</td>
                    <td></td> 
                    </tr> 
                    @elseif($request->status == 2)
                    <tr>
                    <td><b>{{$request->type->name}}</b></td>
                    <td>{{$request->created_at->format('d.m.Y - H:i')}}</td>
                    <td><div class="reguest_alert text-center" style="background: #027a00;color:#fff;">Onay</div></td>
                    <td>{{$request->message}}</td>
                    <td>{{$request->amount}}</td> 
                    </tr>
                    @endif
                @endforeach
              </tbody>
            </table> 
        </div>
    </section>  
    @else
    <section class="section only-desktop">
        <div class="form-area">
            <h1 class="form_title text-center">Discount Talep</h1>
            <form action="{{route('user-login')}}" method="post">
                @csrf
                <div class="form">
                    <input type="text" name="username" class="form__email" placeholder="Kullanıcı Adınız">
                    <button type="submit" class="form__button">Giriş Yap</button>
                </div>
            </form>
        </div>
    </section> 
    @endif
@endsection

@section('js')
    @if(session()->has('loggedInUser'))
    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-app.js";
        import { getDatabase, ref, set, remove } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-database.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries
      
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
          apiKey: "AIzaSyBBr9aGgv17d5rb5JT5B-eE3cvwcT2_gSs",
          authDomain: "discount-4253a.firebaseapp.com",
          databaseURL: "https://discount-4253a-default-rtdb.europe-west1.firebasedatabase.app",
          projectId: "discount-4253a",
          storageBucket: "discount-4253a.appspot.com",
          messagingSenderId: "159828899470",
          appId: "1:159828899470:web:35cfd551aa56001c377bdf",
          measurementId: "G-FTN1X7TS4Y"
        };
      
        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const db = getDatabase();
        let button = document.getElementById('request_button');
        button.addEventListener('click', function(e){

            if(document.getElementById('type_id').value){
                e.preventDefault();
                e.disabled=true;
                set(ref(db, 'discount'), {
                    new_data: 'true',
                }).then(() =>{
                    remove(ref(db,'discount'));
                    e.target.form.submit();
                }
                ).catch(() => {
                    alert('Birşeyler ters gitti! Lütfen tekrar deneyin!');
                    window.location.reload();
                });
            }
            
        });          

      </script>

      <script>
          let type_select = document.getElementById('type_id');
          let types = {!! json_encode($request_types) !!};
          type_select.addEventListener('change', function(){
              if(!type_select.value) return false;
              let type = types.filter(function(item){
                return item.id == type_select.value;
              })[0];
              document.getElementById('rules').innerHTML = type.rules;
              document.getElementById('promotion_code').innerHTML = '';
              if(type.code_required){
                document.getElementById('promotion_code').innerHTML = `Kupon Kodu:<input type="text" name="promotion_code">`;
              }
          })
      </script>

    @endif
@endsection