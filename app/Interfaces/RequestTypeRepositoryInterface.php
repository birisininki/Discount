<?php

namespace App\Interfaces;
use App\Models\RequestType;

interface RequestTypeRepositoryInterface 
{
    public function get();
    public function getAll();
    public function getById($id);
    public function create(array $details);
    public function update(array $details, RequestType $request_type);
    public function archive(RequestType $request_type);
    public function unarchive(RequestType $request_type);
}