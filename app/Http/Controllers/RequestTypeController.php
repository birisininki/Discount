<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\RequestTypeRepositoryInterface;
use App\Interfaces\LogRepositoryInterface;
use App\Traits\LogTrait;

class RequestTypeController extends Controller
{
    use LogTrait;
    private RequestTypeRepositoryInterface $requestTypeRepository;
    private LogRepositoryInterface $logRepository;

    public function __construct(RequestTypeRepositoryInterface $requestTypeRepository, LogRepositoryInterface $logRepository){
        $this->requestTypeRepository = $requestTypeRepository;
        $this->logRepository = $logRepository;
    }

    public function index(Request $request){
        if(!auth()->user()->hasPermissionOn('view_request_types')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        if($request->has('archived') && $request->archived == 'true')
        $request_types = $this->requestTypeRepository->getAll();
        else
        $request_types = $this->requestTypeRepository->get();

        return view('admin.request-types', ['request_types' => $request_types]);
    }

    public function create(Request $request){
        if(!auth()->user()->hasPermissionOn('create_request_type')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request->validate([
            'name' => 'required',
            'code_required' => 'required',
            'rules' => 'required'
        ]);

        if($request_type = $this->requestTypeRepository->create($request->all())){
            $this->log('create_request_type', 'RequestType', $request_type->id, 'Employee', auth()->id(), $request_type);
            return back()->with('success', 'Talep türü oluşturuldu');
        }else{
            return back()->withErrors('Talep türü oluştururken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function updateForm($id){
        if(!auth()->user()->hasPermissionOn('update_request_type')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        $request_type = $this->requestTypeRepository->getById($id);
        return view('admin.components.request-type-form-modal-component', ['request_type' => $request_type]);
    }

    public function update(Request $request){
        if(!auth()->user()->hasPermissionOn('update_request_type')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request->validate([
            'name' => 'required',
            'code_required' => 'required',
            'rules' => 'required'
        ]);

        $request_type = $this->requestTypeRepository->getById($request->request_type_id);
        $old = clone $request_type;
        if($this->requestTypeRepository->update($request->all(), $old)){
            $this->log('update_request_type', 'RequestType', $request_type->id, 'Employee', auth()->id(), $request->all() ,$request_type);
            return back()->with('success', 'Talep türü güncellendi');
        }else{
            return back()->withErrors('Talep türü güncellerken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function archive($id){
        if(!auth()->user()->hasPermissionOn('archive_request_type')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request_type = $this->requestTypeRepository->getById($id);
        if($this->requestTypeRepository->archive($request_type)){
            $this->log('archive_request_type', 'RequestType', $request_type->id, 'Employee', auth()->id());
            return back()->with('success', 'Talep türü arşivlendi');
        }else{
            return back()->withErrors('Talep türü arşivlenirken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function unarchive($id){
        if(!auth()->user()->hasPermissionOn('archive_request_type')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request_type = $this->requestTypeRepository->getById($id);
        if($this->requestTypeRepository->unarchive($request_type)){
            $this->log('unarchive_request_type', 'RequestType', $request_type->id, 'Employee', auth()->id());
            return back()->with('success', 'Talep türü arşivden çıkarıldı');
        }else{
            return back()->withErrors('Talep türü arşivden çıkarılırken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }
    
}
