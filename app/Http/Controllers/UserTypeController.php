<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\LogRepositoryInterface;
use App\Interfaces\UserTypeRepositoryInterface;
use App\Traits\LogTrait;

class UserTypeController extends Controller
{
    use LogTrait;
    private UserTypeRepositoryInterface $userTypeRepository;
    private LogRepositoryInterface $logRepository;

    public function __construct(UserTypeRepositoryInterface $userTypeRepository, LogRepositoryInterface $logRepository){
        $this->userTypeRepository = $userTypeRepository;
        $this->logRepository = $logRepository;
    }

    public function index(Request $request){
        if(!auth()->user()->hasPermissionOn('view_user_types')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        if($request->has('archived') && $request->archived == 'true')
        $user_types = $this->userTypeRepository->getAll();
        else
        $user_types = $this->userTypeRepository->get();

        return view('admin.user-types', ['user_types' => $user_types]);
    }

    public function create(Request $request){
        if(!auth()->user()->hasPermissionOn('create_user_type')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request->validate([
            'name' => 'required',
            'message' => 'required',
        ]);

        if($user_type = $this->userTypeRepository->create($request->all())){
            $this->log('create_user_type', 'UserType', $user_type->id, 'Employee', auth()->id(), $user_type);
            return back()->with('success', 'Kullanıcı türü oluşturuldu');
        }else{
            return back()->withErrors('Kullanıcı türü oluştururken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function updateForm($id){
        if(!auth()->user()->hasPermissionOn('update_user_type')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        $user_type = $this->userTypeRepository->getById($id);
        return view('admin.components.user-type-form-modal-component', ['user_type' => $user_type]);
    }

    public function update(Request $request){
        if(!auth()->user()->hasPermissionOn('update_user_type')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request->validate([
            'name' => 'required',
            'message' => 'required',
        ]);

        $user_type = $this->userTypeRepository->getById($request->user_type_id);
        $old = clone $user_type;
        if($this->userTypeRepository->update($request->all(), $old)){
            $this->log('update_user_type', 'UserType', $user_type->id, 'Employee', auth()->id(), $request->all() ,$user_type);
            return back()->with('success', 'Kullanıcı türü güncellendi');
        }else{
            return back()->withErrors('Kullanıcı türü güncellerken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function archive($id){
        if(!auth()->user()->hasPermissionOn('archive_user_type')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $user_type = $this->userTypeRepository->getById($id);
        if($this->userTypeRepository->archive($user_type)){
            $this->log('archive_user_type', 'UserType', $user_type->id, 'Employee', auth()->id());
            return back()->with('success', 'Kullanıcı türü arşivlendi');
        }else{
            return back()->withErrors('Kullanıcı türü arşivlenirken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function unarchive($id){
        if(!auth()->user()->hasPermissionOn('archive_user_type')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $user_type = $this->userTypeRepository->getById($id);
        if($this->userTypeRepository->unarchive($user_type)){
            $this->log('unarchive_user_type', 'UserType', $user_type->id, 'Employee', auth()->id());
            return back()->with('success', 'Kullanıcı türü arşivden çıkarıldı');
        }else{
            return back()->withErrors('Kullanıcı türü arşivden çıkarılırken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }
}
