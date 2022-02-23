<?php

namespace App\Repositories;

use App\Interfaces\RequestRepositoryInterface;
use App\Models\Request;

class RequestRepository implements RequestRepositoryInterface
{
    public function getNew()
    {
        return Request::where('status', 0)->orderBy('created_at', 'ASC')->get();
    }

    public function getAll($filters = null)
    {
        return Request::when(isset($filters['status']), function($query) use ($filters){
            $query->where('status', $filters['status']);
        })
        ->when(isset($filters['user_id']), function($query) use ($filters){
            $query->where('user_id', $filters['user_id']);
        })
        ->when(isset($filters['employee_id']), function($query) use ($filters){
            $query->where('employee_id', $filters['employee_id']);
        })
        ->when(isset($filters['user_ids']), function($query) use ($filters) {
            $query->whereIn('user_id', $filters['user_ids']);
        })
        ->when(isset($filters['request_type']), function($query) use ($filters) {
            $query->where('type_id', $filters['request_type']);
        })
        ->when(isset($filters['start_date']), function($query) use ($filters) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        })
        ->when(isset($filters['end_date']), function($query) use ($filters) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        })
        ->get();
    }

    public function getById($id)
    {
        return Request::where('id', $id)->firstOrFail();
    }

    public function create(array $details)
    {
        return Request::create($details);
    }

    public function update(array $details, Request $request)
    {
        return $request->update($details);
    }

    public function delete(Request $request)
    {
        return $request->delete();
    }

}