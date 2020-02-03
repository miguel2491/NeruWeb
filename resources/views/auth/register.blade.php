@extends('layouts.app')
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
@section('content')
   <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
             <h1 class="logo-name">SC+</h1>
            </div>
            <h3>Registro SC+</h3>

            <form class="m-t" role="form" action"{{ url('/register') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"  placeholder="Nombre(s)" required="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="paterno" value="{{ old('paterno') }}"  placeholder="Apellido Paterno" required="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="materno" value="{{ old('materno') }}"  placeholder="Apellido Materno" required="">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electronico" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Contraseña" name="password" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Repetir Contraseña" name="password_confirmation" required="">
                </div>

               <!-- <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
                </div>-->

                <button type="submit" class="btn btn-primary block full-width m-b">Registrar</button>

                <!--  <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ url('login') }}">Login</a>-->
            </form>
            <p class="m-t"> <small> &copy; 2016</small> </p>
        </div>
    </div>
@endsection
@section('localscripts')
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
@endsection
