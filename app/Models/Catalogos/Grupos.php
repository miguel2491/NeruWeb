<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Grupos extends Model {
	protected $table = 'equipos';
	protected $primaryKey = 'id_equipo';
	public $timestamps = false;
	protected $fillable = ['id_equipo','id_jugador','nombre_equipo', 'nombre_entrenador', 'liga', 'numero_jugadores','codigo','imagenEquipo','status_equipo','created_at'];
}
