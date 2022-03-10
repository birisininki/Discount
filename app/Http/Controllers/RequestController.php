<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\RequestRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Interfaces\UserTypeRepositoryInterface;
use App\Interfaces\RequestTypeRepositoryInterface;
use App\Interfaces\LogRepositoryInterface;
use App\Traits\LogTrait;
use Carbon\Carbon;

class RequestController extends Controller
{
    use LogTrait;

    private RequestRepositoryInterface $requestRepository;
    private UserRepositoryInterface $userRepository;
    private EmployeeRepositoryInterface $employeeRepository;
    private UserTypeRepositoryInterface $userTypeRepository;
    private RequestTypeRepositoryInterface $requestTypeRepository;
    private LogRepositoryInterface $logRepository;

    public function __construct(
        RequestRepositoryInterface $requestRepository,
        UserRepositoryInterface $userRepository,
        EmployeeRepositoryInterface $employeeRepository,
        UserTypeRepositoryInterface $userTypeRepository,
        LogRepositoryInterface $logRepository,
        RequestTypeRepositoryInterface $requestTypeRepository

    ){
        $this->requestRepository = $requestRepository;
        $this->userRepository = $userRepository;
        $this->employeeRepository = $employeeRepository;
        $this->userTypeRepository = $userTypeRepository;
        $this->logRepository = $logRepository;
        $this->requestTypeRepository = $requestTypeRepository;
    }

    public function index(){
        $requests = $this->requestRepository->getNew();
        return view('admin.dashboard', ['requests' => $requests]);
    }

    public function updatedRequests(){
        $requests = $this->requestRepository->getNew();
        return view('admin.components.dashboard-table-content-component', ['requests' => $requests]);
    }

    public function create(Request $request){
        $request->validate([
            'type_id' => 'required',
            'promotion_code' => 'filled'
        ], [
            'type_id.required' => 'Lütfen bir promosyon seçiniz!',
            'promotion_code.filled' => 'Lütfen bir kod girin!']);
        
        if($this->userRepository->getById($request->user_id)->banned_at){
            session()->forget('loggedInUser');
            return back()->withErrors($this->userRepository->getById($request->user_id)->ban_reason. ' nedeniyle girişiniz engellenmiş! Daha fazla detay için canlı destek ile görüşün.');
        }
 
        foreach($this->userRepository->getById($request->user_id)->active_requests as $active_request){
            if($active_request->type_id == $request->type_id) return back()->withErrors('Zaten bu promosyon için beklemede olan bir talebiniz var!');
        }
            
        
        if($new_request = $this->requestRepository->create([
            'user_id' => $request->user_id,
            'type_id' => $request->type_id,
            'promotion_code' => $request->promotion_code,
            'status' => 0,
        ])){
            $this->log('create_request', 'Request', $new_request->id, 'User', $request->user_id, $new_request);
            return back()->with('success', 'Talebiniz alındı! Sıra numaranıza göre işleminiz gerçekleşecektir.');
        }else{
            return back()->withErrors('Talep oluştururken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function handleForm($id){
        $request = $this->requestRepository->getById($id);
        $types = $this->userTypeRepository->get();
        $user_type = $this->userTypeRepository->getById($request->user->type->id);
        if(!$types->contains($user_type)) $types->push($user_type);
        if($request->status != 0 || $request->employee){
            if($request->employee_id != auth()->id())
            return "<div class='alert alert-warning text-center' style='margin:40px 10px; font-size:20px;'><i class='fa fa-exclamation-triangle' style='font-size:48px'></i><br><br>Bu talep ile <b>". $request->employee->name. "</b> ilgileniyor.<br></div><a href='javascript:;' class='btn btn-primary btn-lg' style='margin-right:50px; margin-bottom:20px; float:right;' data-dismiss='modal'>Tamam</a>";
        }
        if($request->status == 0){
            $old = clone $request;
            if($this->requestRepository->update(['status' => 1, 'employee_id' => auth()->id(), 'process_datetime' => Carbon::now()->format('Y-m-d H:i:s')], $request)){
                $this->log('update_request', 'Request', $request->id, 'Employee', auth()->id(), $request, $old);
                return view('admin.components.request-handle-form-modal-component', ['request' => $request, 'user_types' => $types]);
            }else{
                return "Bir hata oluştu. Lütfen tekrar deneyin!";
            }
        }else{
            return view('admin.components.request-handle-form-modal-component', ['request' => $request, 'user_types' => $types]);
        }
        
    }

    public function cancelHandle($id){
        $request = $this->requestRepository->getById($id);
        $old = clone $request;
        if($request->employee_id == auth()->id()){
            if($this->requestRepository->update(['employee_id' => null, 'status' => 0, 'process_datetime' => null], $request)){
                $this->log('update_request', 'Request', $request->id, 'Employee', auth()->id(), $request, $old);

            }
        }
    }

    public function update(Request $request){

        $handling_request = $this->requestRepository->getById($request->request_id);
        if($handling_request->employee_id != auth()->id()) return back()->withErrors('Bu talep ile <b>'. $handling_request->employee->name.'</b> ilgileniyor. Yaptığınız işlem iptal edildi.');
        $old = clone $handling_request;

        switch($request->result){
            case 0:
                if($this->requestRepository->update(['status' => 3, 'message' => $request->message, 'handle_datetime' => ($handling_request->status == 1 ? Carbon::now()->format('Y-m-d H:i:s') : $handling_request->handle_datetime)], $handling_request)){
                    $this->log('update_request', 'Request', $handling_request->id, 'Employee', auth()->id(), $handling_request, $old);
                    return back()->with('success', 'İşlem Tamamlandı');
                }else{
                    return back()->withErrors('İşlem sırasında bir sorun oluştu. Lütfen tekrar deneyin.');
                }
                break;
            case 1:
                if(!is_null($request->deposit)){
                    $message = "Kampanya kuralları dahilinde ". $request->deposit. "₺ yatırımınız ";

                    if(!is_null($request->draw)){
                        $message .= 've '. $request->draw. '₺ çekiminiz bulunmaktadır. ';
                    }else{
                        $message .= 'bulunmaktadır. ';
                    }

                    if(!is_null($request->casino) || !is_null($request->sport)){
                        $message .= "Kaybınızın ";

                        if(!is_null($request->casino) && is_null($request->sport)){
                            $message .= $request->casino . "₺'si casinodur. ";
                        }

                        if(is_null($request->casino) && !is_null($request->sport)){
                            $message .= $request->sport . "₺'si spordur. ";
                        }

                        if(!is_null($request->casino) && !is_null($request->sport)){
                            $message .= $request->sport . "₺'si spor ve ". $request->casino. "₺'si casinodur. ";
                        }
                    }

                    $message .= "Talebiniz üzerinden ". $request->amount ."₺ tanımlama yapılmıştır.";
                }else{
                    $message = "Talebiniz üzerinden ". $request->amount ."₺ tanımlama yapılmıştır.";
                }
                if($this->requestRepository->update(['status' => 2, 'message' => $message, 'amount' => $request->amount, 'handle_datetime' => ($handling_request->status == 1 ? Carbon::now()->format('Y-m-d H:i:s') : $handling_request->handle_datetime)], $handling_request)){
                    $this->log('update_request', 'Request', $handling_request->id, 'Employee', auth()->id(), $handling_request, $old);
                    return back()->with('success', 'İşlem Tamamlandı');
                }else{
                    return back()->withErrors('İşlem sırasında bir sorun oluştu. Lütfen tekrar deneyin.');
                }
                break;
        }
    }

    public function oldRequests(Request $request){
        if(!auth()->user()->hasPermissionOn('view_old_requests')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');
        
        $filters = [];
        if($request->has('username') && $request->username != null) $filters['user_id'] = $this->userRepository->getByUserName($request->username)->id;
        if($request->has('employee') && $request->employee != null && $request->employee != 'all') $filters['employee_id'] = $request->employee;
        if($request->has('user_type') && $request->user_type != null && $request->user_type != 'all') $filters['user_ids'] = $this->userRepository->getByTypeId($request->user_type)->pluck('id');
        if($request->has('request_type') && $request->request_type != null && $request->request_type != 'all') $filters['request_type'] = $request->request_type;
        if($request->has('status') && $request->status != null && $request->status != 'all') $filters['status'] = $request->status;
        if($request->has('start_date') && $request->start_date != null) $filters['start_date'] = $request->start_date;
        if($request->has('end_date') && $request->end_date != null) $filters['end_date'] = $request->end_date;

        $requests = $this->requestRepository->getAll($filters)->filter(function($item){ return $item->status != 0;});
        $request_types = $this->requestTypeRepository->get();
        $user_types = $this->userTypeRepository->get();
        $employees = $this->employeeRepository->all();
        return view('admin.old-requests', ['requests' => $requests, 'user_types' => $user_types, 'request_types' => $request_types, 'employees' => $employees]);
    }
}
