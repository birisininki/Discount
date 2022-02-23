<?php

namespace App\Repositories;

use App\Interfaces\MessageTemplateRepositoryInterface;
use App\Models\MessageTemplate;

class MessageTemplateRepository implements MessageTemplateRepositoryInterface
{

    public function get(){
        return MessageTemplate::all();
    }

    public function getById($id){
        return MessageTemplate::where('id', $id)->firstOrFail();
    }

    public function create(array $details)
    {
        return MessageTemplate::create($details);
    }

    public function update(array $details, MessageTemplate $messageTemplate)
    {
        return $messageTemplate->update($details);
    }

    public function delete(MessageTemplate $messageTemplate)
    {
        return $messageTemplate->delete();
    }

}