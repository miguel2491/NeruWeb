<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instruccion extends Model
{
	public $timestamps = false;
	protected $primaryKey = 'id_instrucciones';
    protected $table= 'instrucciones';
    protected $fillable  = ['id_instrucciones', 'id_actividad', 'descripcion', 'audio', 'status'];
}
