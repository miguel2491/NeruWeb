<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variables extends Model
{
	protected $primaryKey = 'id_variable';
    protected $table= 'variables';
    protected $fillable  = ['id_variable', 'nombre', 'descripcion', 'subtitulo', 'ejemplo', 'status', 'updated_at'];
}
