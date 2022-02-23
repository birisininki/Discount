<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Interfaces\EmployeePermissionRepositoryInterface;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\LogRepositoryInterface;
use App\Traits\LogTrait;

class EmployeeController extends Controller
{

    use LogTrait;
    private EmployeeRepositoryInterface $employeeRepository;
    private EmployeePermissionRepositoryInterface $employeePermissionRepository;
    private LogRepositoryInterface $logRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository, EmployeePermissionRepositoryInterface $employeePermissionRepository, LogRepositoryInterface $logRepository){
        $this->employeeRepository = $employeeRepository;
        $this->employeePermissionRepository = $employeePermissionRepository;
        $this->logRepository = $logRepository;   
    }

    public function loginPage(){
        return view('admin.login');
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function index(){
        if(!auth()->user()->hasPermissionOn('view_employees')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        $employees = $this->employeeRepository->all();
        return view('admin.employees', ['employees' => $employees]);
    }

    public function updateForm($username){
        if(!auth()->user()->hasPermissionOn('update_employee')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        $employee = $this->employeeRepository->getByUsername($username);
        return view('admin.components.employee-form-modal-component', ['employee' => $employee]);
    }

    public function create(Request $request){
        if(!auth()->user()->hasPermissionOn('create_employee')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:employees',
            'password' => 'required|min:6'
        ]);

        if($employee = $this->employeeRepository->createEmployee([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ])){
            $this->log('create_employee', 'Employee', $employee->id, 'Employee', auth()->id(), $employee);
            $permissions = [];
            if($request->has('view_employees')) $permissions[] = ['permission' => 'view_employees'];
            if($request->has('create_employee')) $permissions[] = ['permission' => 'create_employee'];
            if($request->has('update_employee')) $permissions[] = ['permission' => 'update_employee'];
            if($request->has('delete_employee')) $permissions[] = ['permission' => 'delete_employee'];
            if($request->has('view_users')) $permissions[] = ['permission' => 'view_users'];
            if($request->has('update_user')) $permissions[] = ['permission' => 'update_user'];
            if($request->has('ban_user')) $permissions[] = ['permission' => 'ban_user'];
            if($request->has('view_old_requests')) $permissions[] = ['permission' => 'view_old_requests'];
            if($request->has('export_old_requests')) $permissions[] = ['permission' => 'export_old_requests'];
            if($request->has('view_user_types')) $permissions[] = ['permission' => 'view_user_types'];
            if($request->has('create_user_type')) $permissions[] = ['permission' => 'create_user_type'];
            if($request->has('update_user_type')) $permissions[] = ['permission' => 'update_user_type'];
            if($request->has('archive_user_type')) $permissions[] = ['permission' => 'archive_user_type'];
            if($request->has('view_request_types')) $permissions[] = ['permission' => 'view_request_types'];
            if($request->has('create_request_type')) $permissions[] = ['permission' => 'create_request_type'];
            if($request->has('update_request_type')) $permissions[] = ['permission' => 'update_request_type'];
            if($request->has('archive_request_type')) $permissions[] = ['permission' => 'archive_request_type'];
            if($request->has('view_message_templates')) $permissions[] = ['permission' => 'view_message_templates'];
            if($request->has('create_message_template')) $permissions[] = ['permission' => 'create_message_template'];
            if($request->has('update_message_template')) $permissions[] = ['permission' => 'update_message_template'];
            if($request->has('delete_message_template')) $permissions[] = ['permission' => 'delete_message_template'];

            $old_permissions = $employee->permissions;
            if($this->employeePermissionRepository->set($permissions, $employee)){
                $this->log('set_permissions', 'Employee', $employee->id, 'Employee', auth()->id(), $employee->permissions, $old_permissions);
                return back()->with('success', 'Çalışan hesabı oluşturuldu.');
            }
            return back()->with('warning', 'Çalışan hesabı oluşturuldu, izinler ayarlanırken bir sorun oluştu!');
        }else{
            return back()->withErrors('Çalışan hesabı oluştururken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function update(Request $request){
        if(!auth()->user()->hasPermissionOn('update_employee')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');
        
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:employees,username,'.$request->employee_id,
        ]);

        $employee = $this->employeeRepository->getById($request->employee_id);
        $old = clone $employee;
        $details = ['username' => $request->username, 'name' => $request->name];
        if($request->password) $details = array_merge($details, ['password' => Hash::make($request->password)]);
        if($this->employeeRepository->updateEmployee($details, $old)){
            $this->log('update_employee', 'Employee', $employee->id, 'Employee', auth()->id(), $details ,$employee);
            $permissions = [];
            if($request->has('view_employees')) $permissions[] = ['permission' => 'view_employees'];
            if($request->has('create_employee')) $permissions[] = ['permission' => 'create_employee'];
            if($request->has('update_employee')) $permissions[] = ['permission' => 'update_employee'];
            if($request->has('delete_employee')) $permissions[] = ['permission' => 'delete_employee'];
            if($request->has('view_users')) $permissions[] = ['permission' => 'view_users'];
            if($request->has('update_user')) $permissions[] = ['permission' => 'update_user'];
            if($request->has('ban_user')) $permissions[] = ['permission' => 'ban_user'];
            if($request->has('view_old_requests')) $permissions[] = ['permission' => 'view_old_requests'];
            if($request->has('export_old_requests')) $permissions[] = ['permission' => 'export_old_requests'];
            if($request->has('view_user_types')) $permissions[] = ['permission' => 'view_user_types'];
            if($request->has('create_user_type')) $permissions[] = ['permission' => 'create_user_type'];
            if($request->has('update_user_type')) $permissions[] = ['permission' => 'update_user_type'];
            if($request->has('archive_user_type')) $permissions[] = ['permission' => 'archive_user_type'];
            if($request->has('view_request_types')) $permissions[] = ['permission' => 'view_request_types'];
            if($request->has('create_request_type')) $permissions[] = ['permission' => 'create_request_type'];
            if($request->has('update_request_type')) $permissions[] = ['permission' => 'update_request_type'];
            if($request->has('archive_request_type')) $permissions[] = ['permission' => 'archive_request_type'];
            if($request->has('view_message_templates')) $permissions[] = ['permission' => 'view_message_templates'];
            if($request->has('create_message_template')) $permissions[] = ['permission' => 'create_message_template'];
            if($request->has('update_message_template')) $permissions[] = ['permission' => 'update_message_template'];
            if($request->has('delete_message_template')) $permissions[] = ['permission' => 'delete_message_template'];

            $old_permissions = $employee->permissions;
            if($this->employeePermissionRepository->set($permissions, $employee)){
                $this->log('set_permissions', 'Employee', $employee->id, 'Employee', auth()->id(), $employee->permissions, $old_permissions);
                return back()->with('success', 'Hesap bilgileri güncellendi.');
            }
            return back()->with('warning', 'Hesap bilgileri güncellendi, izinler ayarlanırken bir sorun oluştu!');
        }else{
            return back()->withErrors('Hesap güncellerken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function logs($username){
        $employee = $this->employeeRepository->getByUsername($username);
        $logs = $employee->logs->take(10);
        return view('admin.components.log-modal', ['logs' => $logs]);
    }

    public function activities($username){
        $employee = $this->employeeRepository->getByUsername($username);
        return view('admin.components.employee-activity-modal', ['employee' => $employee]);
    }

    public function delete($id){
        if(!auth()->user()->hasPermissionOn('delete_employee')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır.');

        if($id == auth()->id()) return back()->withErrors('Kendi hesabınızı silemezsiniz!');
        $employee = $this->employeeRepository->getById($id);
        if($this->employeeRepository->deleteEmployee($employee)){
            $this->log('delete_employee', 'Employee', $id, 'Employee', auth()->id(),null, $employee);
            return back()->with('success', 'Hesap silindi');
        }else{
            return back()->withErrors('Hesap silinirken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function myRequests(){
        $requests = auth()->user()->requests()->orderBy('created_at', 'DESC')->get();
        return view('admin.my-requests', ['requests' => $requests]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
