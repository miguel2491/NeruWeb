<?php

namespace App\Http\Controllers\VR;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Usuarios;
//Helpers
use Auth;
use DB;
use Illuminate\Http\Request;

class PagosController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	

	public function recibe() {
		return view('Virtual_R.recibe');
	}
	
	public function update(Request $request, $id) {
		$cat_cuenta = Usuarios::findOrFail($id);
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




	public function listado(Request $request,$email) {
		$results = DB::table('users')->where('email', $email)->get();
		
		return response()->json($results);
			
	}


	public function buscar(Request $request, $email){
		$results = DB::table('users')->where('email', $email)->get();
		return response()->json(['data' => $results]);
	}
	

}

