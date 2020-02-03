<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objetivo extends Model
{
	protected $primaryKey = 'id_objetivo';
    protected $table= 'objetivo';
    protected $fillable  = ['id_objetivo', 'id_usuario', 'objetivo', 'status', 'created_at'];
}
