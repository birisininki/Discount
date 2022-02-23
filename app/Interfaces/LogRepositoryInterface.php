<?php

namespace App\Interfaces;

interface LogRepositoryInterface 
{
    public function createLog(array $details);
}