<?php

namespace App\Interfaces;
use App\Models\MessageTemplate;

interface MessageTemplateRepositoryInterface 
{
    public function get();
    public function getById($id);
    public function create(array $details);
    public function update(array $details, MessageTemplate $messageTemplate);
    public function delete(MessageTemplate $messageTemplate);
}