<?php

namespace App\Interfaces;
use App\Models\Request;

interface RequestRepositoryInterface 
{
    public function getNew();
    public function getAll(array $filters = null);
    public function getById($id);
    public function create(array $details);
    public function update(array $details, Request $request);
    public function delete(Request $request);
}