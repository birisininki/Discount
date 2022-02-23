<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\MessageTemplateRepositoryInterface;
use App\Interfaces\LogRepositoryInterface;
use App\Interfaces\RequestTypeRepositoryInterface;
use App\Traits\LogTrait;

class MessageTemplateController extends Controller
{
    use LogTrait;
    private MessageTemplateRepositoryInterface $messageTemplateRepository;
    private LogRepositoryInterface $logRepository;
    private RequestTypeRepositoryInterface $requestTypeRepository;

    public function __construct(
        MessageTemplateRepositoryInterface $messageTemplateRepository,
        LogRepositoryInterface $logRepository,
        RequestTypeRepositoryInterface $requestTypeRepository
        )
    {
        $this->messageTemplateRepository = $messageTemplateRepository;
        $this->logRepository = $logRepository;
        $this->requestTypeRepository = $requestTypeRepository;
    }

    public function index(){
        if(!auth()->user()->hasPermissionOn('view_message_templates')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        $message_templates = $this->messageTemplateRepository->get();
        $request_types = $this->requestTypeRepository->get();
        return view('admin.message-templates', ['message_templates' => $message_templates, 'request_types' => $request_types]);
    }

    public function create(Request $request){
        if(!auth()->user()->hasPermissionOn('create_message_template')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request->validate(['message' => 'required', 'request_type_id' => 'required']);      
        if($message_template = $this->messageTemplateRepository->create($request->all())){
            $this->log('create_message_template', 'MessageTemplate', $message_template->id, 'Employee', auth()->id(), $message_template);
            return back()->with('success', 'Mesaj şablonu oluşturuldu');
        }else{
            return back()->withErrors('Mesaj şablonu oluştururken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function updateForm($id){
        if(!auth()->user()->hasPermissionOn('update_message_template')) return back()->withErrors('Bu sayfayı görüntüleme yetkiniz bulunmamaktadır!');

        $message_template = $this->messageTemplateRepository->getById($id);
        $request_types = $this->requestTypeRepository->get();
        return view('admin.components.message-template-form-modal-component', ['message_template' => $message_template, 'request_types' => $request_types]);
    }

    public function update(Request $request){
        if(!auth()->user()->hasPermissionOn('update_message_template')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $request->validate(['message' => 'required']);
        $message_template = $this->messageTemplateRepository->getById($request->message_template_id);
        $old_message = $message_template->message;
        if($this->messageTemplateRepository->update($request->all(), $message_template)){
            $this->log('update_message_template', 'MessageTemplate', $message_template->id, 'Employee', auth()->id(), ['message' => $message_template->message], ['message' => $old_message]);
            return back()->with('success', 'Mesaj şablonu güncellendi');
        }else{
            return back()->withErrors('Mesaj şablonu güncellenirken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

    public function delete($id){
        if(!auth()->user()->hasPermissionOn('delete_message_template')) return back()->withErrors('Bu işlem için yetkiniz bulunmamaktadır!');

        $message_template = $this->messageTemplateRepository->getById($id);
        if($this->messageTemplateRepository->delete($message_template)){
            $this->log('delete_message_template', 'MessageTemplate', $message_template->id, 'Employee', auth()->id());
            return back()->with('success', 'Mesaj şablonu silindi');
        }else{
            return back()->withErrors('Mesaj şablonu silinirken bir sorun oluştu. Lütfen tekrar deneyin.');
        }
    }

}
