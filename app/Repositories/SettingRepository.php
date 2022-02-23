<?php

namespace App\Repositories;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{

    public function create(array $details)
    {
        return Setting::create($details);
    }

    public function update(array $details, Setting $setting)
    {
        return $setting->update($details);
    }

    public function delete(Setting $setting)
    {
        return $setting->delete();
    }

}