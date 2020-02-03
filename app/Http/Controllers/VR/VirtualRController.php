<?php

namespace App\Http\Controllers\VR;
use App\Http\Controllers\Controller;
use App\Models\VR\Videos;
//Helpers
use Auth;
use DB;
use Illuminate\Http\Request;

class VirtualRController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function index() {
		return view('Virtual_R.index');
	}

	public function pagos() {
		return view('Virtual_R.pagos');
	}

	public function listado() {
    	$results = DB::table('realidad_virtual')
			->select('id_video', 'descripcion', 'url_video', 'status_video','created_at')
			->get();
		  return response()->json(['data' => $results]);
	}

	 public function store(Request $request) {
 		$cat_video = new Videos(array_merge($request->all()));
		DB::beginTransaction();
 		try {
 			if ($cat_video->save()) {
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
		$results = Videos::where('id_video', $id)->get();
		return response()->json($results);
	}

	public function update(Request $request, $id) {
		$cat_video = Videos::findOrFail($id);
		DB::beginTransaction();
		try {
			$cat_video->update($request->all());
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
		$cat_video = Videos::find($id);
		DB::beginTransaction();
		try {
			if ($cat_video->delete()) {
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

}

