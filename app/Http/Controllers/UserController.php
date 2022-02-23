<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserTypeRepositoryInterface;
use App\Interfaces\LogRepositoryInterface;
use App\Traits\LogTrait;

class UserController extends Controller
{
    use LogTrait;

    private UserRepositoryInterface $userRepository;
    private UserTypeRepositoryInterface $userTypeRepository;
    private LogRepositoryInterface $logRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        LogRepositoryInterface $logRepository,
        UserTypeRepositoryInterface $userTypeRepository,
        ){
        $this->userRepository = $userRepository;
        $this->userTypeRepository = $userTypeRepository;
        $this->logRepository = $logRepository;
    }

    public function logout(){
        session()->forget('loggedInUser');
        return back();
    }

    public function login(Request $request){
        $request->validate(['username' => 'required'],['username.required' => 'Kullanıcı adı boş olamaz!']);
        if(!$user = $this->userRepository->getByUserName($request->username)){
            $user = $this->userRepository->create([
                'username' => $request->username,
                'ip_address' => $request->getClientIp(),
                'type_id' => 1,
            ]);
            $this->log('create_user', 'User', $user->id, 'User', $user->id, $user);
        }
        $old = clone $user;
        if($user->ip_address != $request->getClientIp()) $user->update(['ip_address' => $request->getClientIp()]);

        if($user->banned_at){
            $this->log('banned_login', 'User', $user->id, 'User', $user->id, ['ip_address' => $user->ip_address], ['ip_address' => $old->ip_address]);
            return back()->withErrors($user->ban_reason. ' nedeniyle girişiniz engellenmiş! Daha fazla detay için canlı destek ile görüşün.');
        }
        $this->log('login', 'User', $user->id, 'User', $user->id, ['ip_address' => $user->ip_address], ['ip_address' => $old->ip_address]);
        session(['loggedInUser' => $user->username]);
        return back();    
    }

    public function index(){
        if(!auth()->user()->hasPermissionOn('view_users')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        if(request()->has('show_banned'))
        $users = $this->userRepository->getBanned();
        else
        $users = $this->userRepository->get();
        return view('admin.users', ['users' => $users]);
    }

    public function ban(Request $request){
        if(!auth()->user()->hasPermissionOn('ban_user')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $user = $this->userRepository->getById($request->id);
        if($this->userRepository->ban($user, $request->message ?? 'Gereksiz Talep')){
            $this->log('ban_user', 'User', $user->id, 'Employee', auth()->id());
            return back()->with('success', 'Kullanıcı engellendi');
        }else{
            return back()->withErrors('Kullanıcı engellenirken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function unBan($id){
        if(!auth()->user()->hasPermissionOn('ban_user')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $user = $this->userRepository->getById($id);
        if($this->userRepository->unban($user)){
            $this->log('unban_user', 'User', $user->id, 'Employee', auth()->id());
            return back()->with('success', 'Kullanıcının engeli kaldırıldı');
        }else{
            return back()->withErrors('Kullanıcının engeli kaldırılırken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function update(Request $request){
        if(!auth()->user()->hasPermissionOn('update_user')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request->validate([
                            'type_id' => 'filled',
                            'user_id' => 'nullable|unique:users,user_id,'.$request->id,
                            ]);
        $user = $this->userRepository->getById($request->id);
        $old_type_name = $user->type->name;
        $old_user_id = $user->user_id;
        $new_type_name = $this->userTypeRepository->getById($request->type_id)->name;
        if($this->userRepository->update($request->all(), $user)){
            $this->log('update_user', 'User', $user->id, 'Employee', auth()->id(), ['user_type' => $new_type_name, 'user_id' => $request->user_id], ['user_type' => $old_type_name, 'user_id' => $old_user_id]);
            return back()->with('success', 'Kullanıcı bilgileri güncellendi');
        }else{
            return back()->withErrors('Kullanıcı bilgileri güncellerken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function updateForm($id){
        if(!auth()->user()->hasPermissionOn('update_user')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        $user = $this->userRepository->getById($id);
        $types = $this->userTypeRepository->get();
        $user_type = $this->userTypeRepository->getById($user->type->id);
        if(!$types->contains($user_type)) $types->push($user_type);
        return view('admin.components.user-form-modal-component', ['user' => $user, 'types' => $types]);
    }

    public function banForm($id){
        if(!auth()->user()->hasPermissionOn('ban_user')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        $user = $this->userRepository->getById($id);
        return view('admin.components.user-ban-form-modal-component', ['user' => $user]);
    }

    public function logs($id){
        $user = $this->userRepository->getById($id);
        $logs = $user->logs->take(10);
        return view('admin.components.log-modal', ['logs' => $logs]);
    }

    public function activities($id){
        $user = $this->userRepository->getById($id);
        return view('admin.components.user-activity-modal', ['user' => $user]);
    }

}
