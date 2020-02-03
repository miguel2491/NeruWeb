<?php

namespace App\Models\VR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Videos extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_video';
    protected $table= 'realidad_virtual';
    protected $fillable  = ['id_video', 'descripcion', 'url_video', 'status_video', 'created_at'];
}
