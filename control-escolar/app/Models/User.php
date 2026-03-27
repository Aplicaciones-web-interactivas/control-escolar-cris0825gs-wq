<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Inscripcion;
use App\Models\Calificacion;
use App\Models\Grupo;
use App\Models\Horario;
use App\Models\Tarea;
use App\Models\Entrega;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'clave_institucional',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relaciones
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function gruposACargo()
    {
        return $this->hasManyThrough(Grupo::class, Horario::class, 'user_id', 'horario_id');
    }

    public function tareasAsignadas()
    {
        return $this->hasMany(Tarea::class, 'maestro_id');
    }

    public function tareasEntregadas()
    {
        return $this->hasMany(Entrega::class, 'alumno_id');
    }
}
