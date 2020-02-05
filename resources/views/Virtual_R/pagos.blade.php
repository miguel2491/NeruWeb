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
<div class="wrapper wrapper-content animated fadeInRight">	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<div class="row">
						<div class="col-md-7">
							<h5><i class="glyphicon glyphicon-align-justify"></i> Pagos Neru</h5>
						</div>
            			<div class="col-md-5">
							<div class="pull-right">
					        </div>
						</div>
					</div>
				</div>
				<div class="form-group" id="" style="display:block;">
				<h4>Suscripción Mensual</h4>
				<a mp-mode="dftl" href="https://www.mercadopago.com.mx/checkout/v1/redirect?pref_id=331107277-0f85f42c-999f-4faa-becb-8164c95e9cd6" name="MP-payButton" class='blue-ar-l-rn-none'>Pagar</a>
				<script type="text/javascript">
				(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
				</script>
				
			</div>
			<div class="form-group" id="" style="display:block ;">
				<h4>Suscripción Semestral</h4>
				<a mp-mode="dftl" href="https://www.mercadopago.com.mx/checkout/v1/redirect?pref_id=331107277-d6d63364-8d89-4d2e-b57f-c556f1edca53" name="MP-payButton" class='blue-ar-l-rn-none'>Pagar</a>
				<script type="text/javascript">
				(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
				</script>

			</div>
			</div>
		</div>
	</div>
</div>
<!--Modal guardar y editar-->
@endsection
@section('main-scripts')
	<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('js/plugins/toastr/toastr.min.js')}}"></script>
	<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
	<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
	<script src="{{ asset('js/plugins/autonumeric/autoNumeric.js') }}"></script>
	<script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
	<script src="{{ asset('js/plugins/summernote/summernote.min.js') }}"></script>
	<script src="{{ asset('js/VR/videos.js') }}"></script>
@endsection
