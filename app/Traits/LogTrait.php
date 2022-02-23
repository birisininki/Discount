<?php

namespace App\Traits;

trait LogTrait{
    public function log($type, $affected, $affected_id, $user_type, $user_id, $new_values = null, $old_values = null){
        $this->logRepository->createLog([
            'affected_model_name' => $affected,
            'affected_model_id' => $affected_id,
            'user_type' => $user_type,
            'user_id' => $user_id,
            'type' => $type,
            'old_values' => json_encode($old_values),
            'new_values' => json_encode($new_values)
        ]);
    }
}