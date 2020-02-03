<?php

namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use App\Models\Test\Instruccion;
//Helpers
use Auth;
use DB;
use Illuminate\Http\Request;

class InstruccionesController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function index() {
		return view('Test/instrucciones.index');
	}

	public function listado() {
		$results = DB::table('instrucciones')
			->select('instrucciones.*', 'a.descripcion as actividad')
			->leftjoin('actividad as a', 'a.id_actividad', '=', 'instrucciones.id_actividad')
			->get();
		  return response()->json(['data' => $results]);
	}

	 public function store(Request $request) {
 		$cat_variable = new Instruccion(array_merge($request->all()));
		DB::beginTransaction();
 		try {
 			if ($cat_variable->save()) {
 				$msg = ['status' => 'ok', 'message' => 'Se ha guardado correctamente'];
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

 	public function edit($id) {
		$results = Instruccion::find($id);
		return response()->json($results);
	}

	public function update(Request $request, $id) {
		$cat_variable = Instruccion::findOrFail($id);
		DB::beginTransaction();
		try {
			$cat_variable->update($request->all());
			$msg = ['status' => 'ok', 'message' => 'Se ha actualizado correctamente'];
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

	public function destroy($id) {
		$msg = [];
		$cat_variable = Instruccion::find($id);
		DB::beginTransaction();
		try {
			if ($cat_variable->delete()) {
				$msg = ['status' => 'ok', 'message' => ''];
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

	public function listado_actividad() {
		$results = DB::table('actividad')->get();
		return response()->json($results);
	}

	
	
}
