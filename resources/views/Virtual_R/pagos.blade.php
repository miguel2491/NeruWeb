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
				<div class="ibox-content">
					<p><?php
print_r($_GET);  // for all GET variables
?></p>
<p>
<?php
print_r($_POST); // for all POST variables
?></p>
					<!-- Inicia Cuerpo  de la Vista -->
					<a mp-mode="dftl" href="https://www.mercadopago.com.mx/checkout/v1/redirect?pref_id=499268549-86c391c0-a801-41e2-b3fc-a0338990bb30" name="MP-payButton" class='blue-ar-l-rn-none'>Pagar</a>
					<script type="text/javascript">
					(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
					</script>
					<!-- Fin Cuerpo de la Vista -->
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
