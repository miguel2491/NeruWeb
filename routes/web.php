<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
	//return view('home');
	return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//=========================================================USUARIOS=========================
//----------------------------Usuarios
Route::resource('usuario', 'Catalogos\UsuariosController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show', 'GenerarPdf', 'Excel']]);
Route::get('usuario/listado', 'Catalogos\UsuariosController@listado');
Route::post('usuario/guardar', 'Catalogos\UsuariosController@store');
Route::get('usuario/datos/{id}', 'Catalogos\UsuariosController@edit');
Route::put('usuario/update/{id}', 'Catalogos\UsuariosController@update');
Route::delete('usuario/delete/{id}', 'Catalogos\UsuariosController@destroy');
Route::get('usuario/lista_select', 'Catalogos\UsuariosController@listar_select_usuarios');
//----------------------------Grupos
//Route::resource('grupo', 'Catalogos\GrupoController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show', 'GenerarPdf', 'Excel']]);
//------------Variables---------
Route::resource('variables', 'Test\VariablesController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show']]);
Route::get('variables/listado', 'Test\VariablesController@listado');
Route::post('variables/guardar', 'Test\VariablesController@store');
Route::get('variables/datos/{id}', 'Test\VariablesController@edit');
Route::put('variables/update/{id}', 'Test\VariablesController@update');
Route::delete('variables/delete/{id}', 'Test\VariablesController@destroy');
//----------Evaluaciones---------------
Route::resource('evaluaciones', 'Test\EvaluacionesController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show']]);
Route::get('evaluaciones/listado', 'Test\EvaluacionesController@listado');
Route::post('evaluaciones/guardar', 'Test\EvaluacionesController@store');
Route::get('evaluaciones/datos/{id}', 'Test\EvaluacionesController@edit');
Route::put('evaluaciones/update/{id}', 'Test\EvaluacionesController@update');
Route::delete('evaluaciones/delete/{id}', 'Test\EvaluacionesController@destroy');
Route::get('evaluaciones/tipo_variable', 'Test\EvaluacionesController@listado_variables');
//-----------Objetivos-----------
Route::resource('objetivos', 'Test\ObjetivosController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show']]);
Route::get('objetivos/listado', 'Test\ObjetivosController@listado');
Route::post('objetivos/guardar', 'Test\ObjetivosController@store');
Route::get('objetivos/datos/{id}', 'Test\ObjetivosController@edit');
Route::put('objetivos/update/{id}', 'Test\ObjetivosController@update');
Route::delete('objetivos/delete/{id}', 'Test\ObjetivosController@destroy');
Route::get('objetivos/tipo_variable', 'Test\ObjetivosController@listado_variables');
//=======Actividades============
Route::resource('actividades', 'Test\ActividadesController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show']]);
Route::get('actividades/listado', 'Test\ActividadesController@listado');
Route::post('actividades/guardar', 'Test\ActividadesController@store');
Route::get('actividades/datos/{id}', 'Test\ActividadesController@edit');
Route::put('actividades/update/{id}', 'Test\ActividadesController@update');
Route::delete('actividades/delete/{id}', 'Test\ActividadesController@destroy');
Route::get('actividades/tipo_variable', 'Test\ActividadesController@listado_variables');
//INSTRUCCIONES
Route::resource('instrucciones', 'Test\InstruccionesController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show']]);
Route::get('instrucciones/listado', 'Test\InstruccionesController@listado');
Route::post('instrucciones/guardar', 'Test\InstruccionesController@store');
Route::get('instrucciones/datos/{id}', 'Test\InstruccionesController@edit');
Route::put('instrucciones/update/{id}', 'Test\InstruccionesController@update');
Route::delete('instrucciones/delete/{id}', 'Test\InstruccionesController@destroy');
Route::get('instrucciones/tipo_actividad', 'Test\InstruccionesController@listado_actividad');
//GRUPOS
Route::resource('grupo', 'Catalogos\GruposController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show', 'GenerarPdf', 'Excel']]);
Route::get('grupo/listado', 'Catalogos\GruposController@listado');
Route::post('grupo/guardar', 'Catalogos\GruposController@store');
Route::get('grupo/datos/{id}', 'Catalogos\GruposController@edit');
Route::put('grupo/update/{id}', 'Catalogos\GruposController@update');
Route::delete('grupo/delete/{id}', 'Catalogos\GruposController@destroy');
//VR
Route::resource('video', 'VR\VirtualRController', ['except' => ['create', 'store', 'update', 'destroy', 'edit', 'show', 'GenerarPdf', 'Excel']]);
Route::get('video/listado', 'VR\VirtualRController@listado');
Route::post('video/guardar', 'VR\VirtualRController@store');
Route::get('video/datos/{id}', 'VR\VirtualRController@edit');
Route::put('video/update/{id}', 'VR\VirtualRController@update');
Route::delete('video/delete/{id}', 'VR\VirtualRController@destroy');
//
Route::get('pago', 'VR\VirtualRController@pagos');
Route::get('pago/listado/{email}', 'VR\PagosController@listado');
Route::put('pago/actualizar/{id}', 'VR\PagosController@update');