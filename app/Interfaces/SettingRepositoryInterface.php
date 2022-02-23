<?php

namespace App\Interfaces;
use App\Models\Setting;

interface SettingRepositoryInterface 
{
    public function create(array $details);
    public function update(array $details, Setting $setting);
    public function delete(Setting $setting);
}