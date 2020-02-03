<?php

namespace App\Http\Controllers\Catalogos;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogos\UsuariosRequest;
use App\Models\Catalogos\Usuarios;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class UsuariosController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	/**
	 * Mostrar un listado de los recursos.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('Catalogos/usuarios.index');
	}

	/**
	 * Almacenar un nuevo Registro.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CuentaRequest $request) {
		$cat_cuenta = new Cuenta(array_merge($request->all(), ['id_usuario' => Auth::user()->id]));
		DB::beginTransaction();
		try {
			$cuentas = Cuenta::where('id', 1)->first();
			$saldo_cuenta = $cuentas->saldo_total;

			if ($cat_cuenta->save()) {
				$id = $cat_cuenta->id;
				$saldo_d = $cat_cuenta->saldo_disponible;
				$saldo_final = $saldo_cuenta + $saldo_d;
				Cuenta::where('id', 1)
					->update([
						'saldo_total' => $saldo_final,
					]);
				$msg = ['status' => 'ok', 'message' => 'Se ha guardado correctamente'];
				$bit = bitacora(Auth::user()->id, Auth::user()->name, $id, "Se agrego nuevo banco $id");
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
	 * Mostrar un registro en especifico.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$results = Usuarios::find($id);
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

	/**
	 * Eliminar un registro almacenado.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$msg = [];
		$cat_cuenta = Cuenta::find($id);
		DB::beginTransaction();
		try {
			if ($cat_cuenta->delete()) {
				$msg = ['status' => 'ok', 'message' => ''];
				$bit = bitacora(Auth::user()->id, Auth::user()->name, $id, "Se Elimino Cuenta $id");
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
    $results = DB::table('users')
			->select('id', 'id_grupo', 'nombre', 'app', 'apm', 'username', 'email', 'password', 'activo', 'fecha_nacimiento', 'stado_pago','status_variable')
			->get();
		  return response()->json(['data' => $results]);
	}

	public function listar_select_usuarios() {
		$results = DB::table('users as u')
		->select('u.id', 'u.nombre', 'u.app', 'u.apm')->get();
		return response()->json($results);
	}
}
