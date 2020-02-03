<?php

namespace App\Http\Controllers\Catalogos;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogos\UsuariosRequest;
use App\Models\Catalogos\Grupos;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class GruposController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	/**
	 * Mostrar un listado de los recursos.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('Catalogos/grupos.index');
	}

	/**
	 * Almacenar un nuevo Registro.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$cat_cuenta = new Grupos(array_merge($request->all(), ['id_usuario' => Auth::user()->id]));
		DB::beginTransaction();
		try {
			
			$cat_cuenta->save();
			$msg = ['status' => 'ok', 'message' => 'Se ha guardado correctamente'];
		} catch (\Illuminate\Database\QueryException $ex) {
			DB::rollback();
			$msg = ['status' => 'fail', 'message' => 'No se pudo guardar correctamente, por favor consulte con el administrador del sistema.', 'exception' => $ex->getMessage()];
			return response()->json($msg, 400);
		} catch (\Exception $ex) {
			DB::rollback();
			$msg = ['status' => 'fail', 'message' => 'No se pudo guardar correctamente, por favor consulte con el administrador del sistema.', 'exception' => $ex->getMessage()];
			return response()->json($msg, 400);
		} finally {
			DB::commit();
		}

		return response()->json($msg);
	}

	/**
	 * Mostrar un registro en especifico.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$results = Grupos::find($id);
		return response()->json($results);
	}

	/**
	 * Actualizar registro en especifico ya almacenado.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$cat_cuenta = Grupos::findOrFail($id);
		$cat_cuenta->fill($request->all());
		DB::beginTransaction();
		try {
			if ($cat_cuenta->save()) {
				$msg = ['status' => 'ok', 'message' => 'Se ha actualizado correctamente'];
			}
		} catch (\Illuminate\Database\QueryException $ex) {
			DB::rollback();
			$msg = ['status' => 'fail', 'message' => 'No se pudo guardar correctamente, por favor consulte con el administrador del sistema.', 'exception' => $ex->getMessage()];
			return response()->json($msg, 400);
		} catch (\Exception $ex) {
			DB::rollback();
			$msg = ['status' => 'fail', 'message' => 'No se pudo guardar correctamente, por favor consulte con el administrador del sistema.', 'exception' => $ex->getMessage()];
			return response()->json($msg, 400);
		} finally {
			DB::commit();
		}

		return response()->json($msg);
	}

	/**
	 * Eliminar un registro almacenado.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$msg = [];
		$cat_cuenta = Grupos::find($id);
		DB::beginTransaction();
		try {
			if ($cat_cuenta->delete()) {
				$msg = ['status' => 'ok', 'message' => ''];
				DB::table('users')
                ->where('id_grupo', $id)
                ->update(['id_grupo' => NULL]);
			}
		} catch (\Illuminate\Database\QueryException $ex) {
			DB::rollback();
			$msg = ['status' => 'fail', 'message' => 'No se pudo eliminar , por favor consulte con el administrador del sistema.', 'exception' => $ex->getMessage()];
			return response()->json($msg, 400);
		} catch (\Exception $e) {
			DB::rollback();
			$msg = ['status' => 'fail', 'message' => 'No se pudo eliminar, por favor consulte con el administrador del sistema.', 'exception' => $ex->getMessage()];
			return response()->json($msg, 400);
		} finally {
			DB::commit();
		}

		return response()->json($msg);
	}
	/**
	 * Listado de todas los Bancos existentes.
	 */
	public function listado() {
		
    	$results = DB::table('equipos')
			->select('id_equipo','id_jugador','nombre_equipo', 'nombre_entrenador', 'liga', 'numero_jugadores','codigo','imagenEquipo','status_equipo')
			->get();

		  return response()->json(['data' => $results]);
	}
}
