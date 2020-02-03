@extends('layouts.app')
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
@section('content')

  <div class="middle-box text-center loginscreen animated fadeInDown">
         <div>
            <div>

                <h1 class="logo-name">NERU</h1>

            </div>
            <h3>Bienvenido a NERU</h3>
            <p>Sistema de Administración.
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p></p>
            <form class="m-t" role="form" method="POST" action="{{ url('/login') }}">
             {!! csrf_field() !!}
                {{-- <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email" placeholder="Correo Electrónico" required autofocus>
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                           <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                </div> --}}
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" name="username" placeholder="Usuario" required autofocus>
                    @if ($errors->has('username'))
                        <div class="alert alert-danger">
                           <strong>{{ $errors->first('username') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
                    <!-- @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif-->
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b"><i class="fa fa-sign-in" aria-hidden="true"></i>   Iniciar sesión</button>

            </form>

           <p class="m-t"> <small> &copy; 2019</small> </p>
    </div>

@endsection

@section('localscripts')
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
@endsection
