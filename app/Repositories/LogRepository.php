<?php

namespace App\Repositories;

use App\Interfaces\LogRepositoryInterface;
use App\Models\Log;

class LogRepository implements LogRepositoryInterface
{

    public function createLog(array $details)
    {
        return Log::create($details);
    }

}