@extends('layouts.admin.main')

@push('css')
<link href="{{asset('admin/assets/plugins/parsley/src/parsley.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" />
<link href="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css')}}" rel="stylesheet" />
@endpush



@section('content')
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item">
        <div class="btn-group">
        <a href="#" class="btn btn-lg btn-default" id="notif_button" onclick="toggle_notif()"></a>
        <a href="#" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown"></a>
        <ul class="dropdown-menu pull-right">
            <li><a href="#" onclick="change_audio('kisa')" id="kisa_button">Kısa</a></li>
            <li><a href="#" onclick="change_audio('orta')" id="orta_button">Orta</a></li>
            <li><a href="#" onclick="change_audio('orta2')" id="orta2_button">Orta 2</a></li>
            <li><a href="#" onclick="change_audio('uzun')" id="uzun_button">Uzun</a></li>
        </ul>
        </div>
    </li>
</ol>

<h1 class="page-header">Aktif Talepler <small>Henüz yanıtlanmamış talepleri bu sayfada görebilirsiniz.</small></h1>
        
<!-- begin panel -->
<div class="panel panel-inverse">
    <!-- begin panel-heading -->

    <!-- end panel-heading -->
    <!-- begin panel-body -->
    <div class="panel-body" style="margin-top:30px;">
        <table id="data-table-default" class="table table-bordered">
            <thead>
                <tr>
                    <th width="1%"></th>
                    <th class="text-nowrap"><i class="fa fa-user"></i> Kullanıcı Adı</th>
                    <th class="text-nowrap"><i class="fa fa-list"></i> Kullanıcı Türü</th>
                    <th class="text-nowrap"><i class="fa fa-check"></i> Talep Türü</th>
                    <th class="text-nowrap"><i class="far fa-clock"></i> Talep Saati</th>
                    <th class="text-nowrap" data-orderable="false"><i class="fa fa-edit"></i> İşlemler</th>
                </tr>
            </thead>
            <tbody id="request_content">
                @include('admin.components.dashboard-table-content-component')
            </tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>
@php unset($request) @endphp


<div class="modal fade" id="handle_request">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Talebi Değerlendir</h4>
                </div>
                <div id="handle_content">

                </div>
        </div>
    </div>
</div>


@endsection

@push('js')
<script src="{{asset('admin/assets/plugins/parsley/dist/parsley.js')}}"></script>
<script src="{{asset('admin/assets/plugins/highlight/highlight.common.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/render.highlight.js')}}"></script>

<script>
    $(document).ready(function() {
        Highlight.init();
		TableManageDefault.init();
        if(localStorage.getItem('notif_on')){
            document.getElementById('notif_button').innerHTML = "<i style='font-size:30px;' class='fa fa-bell'></i>"
        }else{
            document.getElementById('notif_button').innerHTML = "<i style='font-size:30px;' class='fa fa-bell-slash'></i>"
        }

        switch(localStorage.getItem('notif_audio')){
            case null: 
                document.getElementById('kisa_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('kisa_button').innerHTML;
                break;
            case 'kisa': 
                document.getElementById('kisa_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('kisa_button').innerHTML;
                break;
            case 'orta': 
                document.getElementById('orta_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('orta_button').innerHTML;
                break;
            case 'orta2': 
                document.getElementById('orta2_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('orta2_button').innerHTML;
                break;
            case 'uzun': 
                document.getElementById('uzun_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('uzun_button').innerHTML;
                break;
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    function change_audio(audio){
        localStorage.setItem('notif_audio', audio);
        let kisa = new Audio("{{asset('admin/assets/audios/kisa-ses.mp3')}}");
        let orta = new Audio("{{asset('admin/assets/audios/orta-ses.mp3')}}");
        let orta2 = new Audio("{{asset('admin/assets/audios/orta-ses-2.mp3')}}");
        let uzun = new Audio("{{asset('admin/assets/audios/uzun-ses.mp3')}}");

        document.getElementById('kisa_button').innerHTML = 'Kısa';
        document.getElementById('orta_button').innerHTML = 'Orta';
        document.getElementById('orta2_button').innerHTML = 'Orta 2';
        document.getElementById('uzun_button').innerHTML = 'Uzun';

        switch(localStorage.getItem('notif_audio')){
            case null: 
                document.getElementById('kisa_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('kisa_button').innerHTML;
                break;
            case 'kisa': 
                document.getElementById('kisa_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('kisa_button').innerHTML;
                break;
            case 'orta': 
                document.getElementById('orta_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('orta_button').innerHTML;
                break;
            case 'orta2': 
                document.getElementById('orta2_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('orta2_button').innerHTML;
                break;
            case 'uzun': 
                document.getElementById('uzun_button').innerHTML = "<i class='fa fa-check'></i> " + document.getElementById('uzun_button').innerHTML;
                break;
        }

        eval(audio).play();
    }

    function toggle_notif(){
        if(!localStorage.getItem('notif_on')){
            localStorage.setItem('notif_on', 'true');
            document.getElementById('notif_button').innerHTML = "<i style='font-size:30px;' class='fa fa-bell'></i>"
        }else{
            localStorage.removeItem('notif_on');
            document.getElementById('notif_button').innerHTML = "<i style='font-size:30px;' class='fa fa-bell-slash'></i>"
        } 
    }


    function ban_user(){
        let id = document.getElementById('current_user_id').value;
        let reason = document.getElementById('ban_reason').value;
        let url = "{{route('admin.users.ban')}}";
        document.getElementById('ban_button').style.display="none";
        document.getElementById('ban_loading_button').style.display="inline-block";
        fetch(url, {
            headers: { "Content-Type": "application/json; charset=utf-8" },
            method: 'POST',
            body: JSON.stringify({
                id: id,
                message: reason,
                _token: '{{csrf_token()}}'
            })
        }).then(response => response.status)
        .then(data => {
            if(data == 200){
                document.getElementById('ban_loading_button').style.display="none";
                document.getElementById('unban_button').style.display="inline-block";
                Toast.fire({
                    icon: 'success',
                    title: 'Kullanıcı engellendi'
                })
            }else{
                document.getElementById('ban_loading_button').style.display="none";
                document.getElementById('ban_button').style.display="inline-block";
                Toast.fire({
                    icon: 'error',
                    title: 'Kullanıcı engellenirken bir sorun oluştu. Lütfen tekrar deneyin.'
                })
            }
        })
        .catch(err => {
            document.getElementById('ban_loading_button').style.display="none";
            document.getElementById('ban_button').style.display="inline-block";
            Toast.fire({
                icon: 'error',
                title: 'Kullanıcı engellenirken bir sorun oluştu. Lütfen tekrar deneyin.'
            })
        });
    }

    function unban_user(){
        let id = document.getElementById('current_user_id').value;
        let url = "{{route('admin.users.unban', 0)}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('unban_button').style.display="none";
        document.getElementById('ban_loading_button').style.display="inline-block";
        fetch(url)
        .then(response => response.status)
        .then(data => {
            if(data == 200){
                document.getElementById('ban_loading_button').style.display="none";
                document.getElementById('ban_button').style.display="inline-block";
                Toast.fire({
                    icon: 'success',
                    title: 'Kullanıcının engeli kaldırıldı!'
                })
            }else{
                document.getElementById('ban_loading_button').style.display="none";
                document.getElementById('unban_button').style.display="inline-block";
                Toast.fire({
                    icon: 'error',
                    title: 'Kullanıcının engeli kaldırılırken bir sorun oluştu. Lütfen tekrar deneyin.'
                })
            }
        })
        .catch(err => {
            document.getElementById('ban_loading_button').style.display="none";
            document.getElementById('unban_button').style.display="inline-block";
            Toast.fire({
                icon: 'error',
                title: 'Kullanıcının engeli kaldırılırken bir sorun oluştu. Lütfen tekrar deneyin.'
            })
        })
    }

    function update_user(){
        let id = document.getElementById('current_user_id').value;
        console.log(id);
        let user_id = document.getElementById('user_id').value;
        let type_id = document.getElementById('type_id').value;
        let url = "{{route('admin.users.update')}}";
        document.getElementById('update_user_button').innerHTML="<i class='fas fa-spinner fa-spin'></i>";
        fetch(url, {
            headers: { "Content-Type": "application/json; charset=utf-8" },
            method: 'POST',
            body: JSON.stringify({
                id: id,
                user_id: user_id,
                type_id: type_id,
                _token: '{{csrf_token()}}'
            })
        }).then(response => response.status)
        .then(data => {
            if(data == 200){
                document.getElementById('update_user_button').innerHTML="<i class='fa fa-edit'></i>";
                Toast.fire({
                    icon: 'success',
                    title: 'Kullanıcı güncellendi'
                })
            }else{
                document.getElementById('update_user_button').innerHTML="<i class='fa fa-edit'></i>";
                Toast.fire({
                    icon: 'error',
                    title: 'Kullanıcı güncellenirken bir sorun oluştu. Lütfen tekrar deneyin.'
                })
            }
        })
        .catch(err => {
            document.getElementById('update_user_button').innerHTML="<i class='fa fa-edit'></i>";
            Toast.fire({
                icon: 'error',
                title: 'Kullanıcı güncellenirken bir sorun oluştu. Lütfen tekrar deneyin.'
            })
        });
    }

</script>

<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-app.js";
    import { getDatabase, ref, set, remove, onValue } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-database.js";
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
    function play_audio(){
        if(!localStorage.getItem('notif_on')) return false;
        let audio = localStorage.getItem('notif_audio') ?? 'kisa';
        let kisa = new Audio("{{asset('admin/assets/audios/kisa-ses.mp3')}}");
        let orta = new Audio("{{asset('admin/assets/audios/orta-ses.mp3')}}");
        let orta2 = new Audio("{{asset('admin/assets/audios/orta-ses-2.mp3')}}");
        let uzun = new Audio("{{asset('admin/assets/audios/uzun-ses.mp3')}}");
        eval(audio).play();

    }
    onValue(ref(db, 'discount'), (snapshot) => {
        let old_table = document.getElementById('data-table-default').innerHTML;
        let old_rows = document.getElementById('data-table-default').rows.length;
        window.setTimeout(() => {
            const data = snapshot.val();
            if(data){
            let url = "{{route('admin.requests.updated-requests')}}";
            //document.getElementById('handle_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
            fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById('request_content').innerHTML = data;
                let new_rows = document.getElementById('data-table-default').rows.length;
                let new_table = document.getElementById('data-table-default').innerHTML;
                console.log(old_rows, new_rows);
                if(new_rows >= old_rows && old_table != new_table) play_audio();
            }).catch(err => console.log(err)); 
            }
        }, 200);
    }); 

    window.handle_request = function (id){
        set(ref(db, 'discount'), {
            new_data: 'true',
        }).then(() => remove(ref(db,'discount')));
        let url = "{{route('admin.requests.handle-form','0')}}";
        url = url.replace('/0', '/' + id);
        document.getElementById('handle_content').innerHTML = "<div class='width-full height-md text-center'><h1 style='margin-top:50%;'><i class='fas fa-spinner fa-spin'></i></h1></div>";
        fetch(url)
        .then(response => response.text())
        .then(data => document.getElementById('handle_content').innerHTML = data)
        .catch(err => document.getElementById('handle_content').innerHTML = "Birşeyler ters gitti. Lütfen Tekrar Dene!");
    }

    window.cancel_handle = function(id){
        set(ref(db, 'discount'), {
            new_data: 'true',
        }).then(() => remove(ref(db,'discount')));
        let url = "{{route('admin.requests.cancel-handle','0')}}";
        url = url.replace('/0', '/' + id);
        fetch(url);
    }
    
</script>


<script src="{{asset('admin/assets/plugins/DataTables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/assets/js/demo/table-manage-default.demo.min.js')}}"></script>
@endpush