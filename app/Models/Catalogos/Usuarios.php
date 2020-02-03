<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model {
	public $timestamps = false;
	protected $table = 'users';
	protected $fillable = ['id_grupo','nombre', 'app', 'apm', 'username','email','password','activo','fecha_nacimiento','stado_pago','status_variable','updated_at'];
}
