<?php

namespace App\Repositories;

use App\Interfaces\RequestTypeRepositoryInterface;
use App\Models\RequestType;

class RequestTypeRepository implements RequestTypeRepositoryInterface
{
    public function get(){
        return RequestType::where('is_archived', false)->get();
    }

    public function getAll(){
        return RequestType::all();
    }

    public function getById($id){
        return RequestType::where('id', $id)->firstOrFail();
    }

    public function create(array $details)
    {
        return RequestType::create($details);
    }

    public function update(array $details, RequestType $request_type)
    {
        return $request_type->update($details);
    }

    public function archive(RequestType $request_type)
    {
        return $request_type->update(['is_archived' => true]);
    }

    public function unarchive(RequestType $request_type)
    {
        return $request_type->update(['is_archived' => false]);
    }

}