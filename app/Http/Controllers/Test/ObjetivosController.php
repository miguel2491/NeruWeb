<?php

namespace App\Http\Controllers\Test;
use App\Http\Controllers\Controller;
use App\Models\Test\Objetivo;
//Helpers
use Auth;
use DB;
use Illuminate\Http\Request;

class ObjetivosController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function index() {
		return view('Test/objetivos.index');
	}

	public function listado() {
		$results = DB::table('objetivo')
			->select('objetivo.*', 'u.nombre')
			->leftjoin('users as u', 'u.id', '=', 'objetivo.id_usuario')
			->get();
		  return response()->json(['data' => $results]);
	}

	 public function store(Request $request) {
 		$cat_variable = new Objetivo(array_merge($request->all()));
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
		$results = Objetivo::find($id);
		return response()->json($results);
	}

	public function update(Request $request, $id) {
		$cat_variable = Objetivo::findOrFail($id);
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
		$cat_variable = Objetivo::find($id);
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

	public function listado_variables() {
		$results = DB::table('variables')->where('status', 1)->get();
		return response()->json($results);
	}

	
	
}
