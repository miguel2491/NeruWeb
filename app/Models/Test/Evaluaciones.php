<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluaciones extends Model
{
	protected $primaryKey = 'id_evaluacion';
    protected $table= 'evaluacion';
    protected $fillable  = ['id_evaluacion', 'id_variable', 'pregunta', 'status'];
}
