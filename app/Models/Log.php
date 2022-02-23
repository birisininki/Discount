<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'affected_model_name',
        'affected_model_id',
        'user_type',
        'user_id',
        'type',
        'old_values',
        'new_values'
    ];

    public function user(){
        return $this->belongsTo("App\Models\\". $this->user_type, 'user_id')->withTrashed();
    }

    public function affected_on(){
        return $this->belongsTo("App\Models\\". $this->affected_model_name, 'affected_model_id')->withTrashed();
    }

    public function getReadableAttribute(){
        switch($this->type){
            case 'create_employee':
                return "<b>". $this->user->name. "</b>". ', <b>'. $this->affected_on->name. '</b> için <b>' . $this->affected_on->username. '</b> kullanıcı adı ile bir hesap oluşturdu.';
                break;
            case 'update_employee':
                return "<b>". $this->user->name. "</b>". ', bir çalışan hesabının bilgilerini güncelledi. Kullanıcı adı: <del>'.
                json_decode($this->old_values)->username. '</del>, -> <b>'. json_decode($this->new_values)->username. 
                '</b>, İsim: <del>'. json_decode($this->old_values)->name. '</del>, -> <b>'. json_decode($this->new_values)->name. "</b>";
                break;
            case 'delete_employee':
                return "<b>". $this->user->name. "</b>". ', <b>'. $this->affected_on->name. '</b> isimli kullanıcının hesabını sildi.';
                break; 
        }
    }
}
