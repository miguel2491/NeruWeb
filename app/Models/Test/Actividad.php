<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
	protected $primaryKey = 'id_actividad';
    protected $table= 'actividad';
    protected $fillable  = ['id_actividad', 'id_variable', 'descripcion', 'valor_resultado', 'valor_minimo', 'status', 'duracion', 'created_at', 'updated_at'];
}
