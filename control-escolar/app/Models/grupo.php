<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grupo extends Model
{
    protected $fillable = ['horario_id', 'nombre'];

    public function horario()
    {
        return $this->belongsTo(horario::class);
    }
}
