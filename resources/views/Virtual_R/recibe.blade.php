@extends('layouts.admin')
@section('main-title')
   Pagos Neru
@endsection
@section('main-css')
<link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection
@section('main-content')
<input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token">
<input type="hidden" id="url_actualizar" value="{{ url('pago/actualizar') }}">
<input type="hidden" id="buscar" value="{{ url('pago/listado') }}">
<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<div class="row">
						<div class="col-md-7">
							<h5><i class="glyphicon glyphicon-align-justify"></i> Data Pago</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--formularios-->

<div>
	<!--forma datos pagos-->
	<div class="row" id="data" style="display: none;">
		<div class="col-md-4">
			<div class="form-group">
				<label for="descripcion-field">Folio Pago</label>
				<?php
					$id=$_GET['collection_id'];
					//$id="5819816429";
					//$url='https://api.mercadopago.com/v1/payments/search?id='.$id.'&access_token=APP_USR-104262097525406-121106-97d90022f6c0f656c2f1be7c476f7b55-499279878';
					$url='https://api.mercadopago.com/v1/payments/search?id='.$id.'&access_token=APP_USR-7626992358892349-011717-eca4e780bea376ff5859b1ac90ab739a-331107277';
					
					$array=json_decode(file_get_contents($url),true);
					//se extraen los valores status, folio y mail del cliente
					$status=$array['results'][0]['status'];
					//echo "El estatus de pago es: ".$status."<br />";
					$mail=$array['results'][0]['collector']['email'];
					//$mail="susylaonda94@gmail.com";
				?>
				<input type="text" id="folio" name="folio" class="form-control" value="<?php echo $id;?>" >
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="descripcion-field">estado_pago</label>
				
				<input type="text" id="estado" name="estado" class="form-control" value="<?php echo $status;?>">
			</div>
		</div>
		<div class="col-md-4">
			<label for="descripcion-field">Correo</label>
			<input type="email" id="correo" name="correo" class="form-control" value="<?php echo $mail;?>">
		</div>

		<div class="col-md-4">
			<label for="descripcion-field">Dato recibido de consulta script</label>
			<input type="email" id="mail" name="mail" class="form-control">
		</div>
		
	</div>
	<!--form email busqueda-->
	<div class="row" id="form" style="display: none;">
		
		<div class="col-md-4">
			<div class="form-group" id="primera" style="display: none;">
				<h4>El correo de pago no coincide con nuestros datos</h4>
				<h4>Ingresa tu correo de Neru</h4>
				
			</div>
			<div class="form-group" id="segunda" style="display: none;">
				<h4>El correo ingresado es incorrecto. Vuelve a intentarlo</h4>
				<h4>Ingresa tu correo de Neru</h4>
				
			</div>
		</div>
		<div class="col-md-4">
			<input type="email" id="email2" name="email2" class="form-control" placeholder="tucorreo@servidor.com">
		</div>
		<div class="col-md-4">
			<div class="modal-footer">
				<button class="btn btn-success" id="validar"><li class="fa fa-check"></li> Aceptar</button>
			</div>		
		</div>
		
	</div>

</div>



@endsection
@section('main-scripts')
	<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('js/plugins/toastr/toastr.min.js')}}"></script>
	<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
	<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
	<script src="{{ asset('js/plugins/autonumeric/autoNumeric.js') }}"></script>
	<script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
	<script src="{{ asset('js/plugins/summernote/summernote.min.js') }}"></script>
	<script src="{{ asset('js/VR/pagos/pagos2.js') }}"></script>
@endsection
