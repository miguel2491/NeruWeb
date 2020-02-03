
<!DOCTYPE html>
<html>

@section('htmlheader')
    @include('layouts.htmlheader')
@show

<body class="top-navigation">
    <div id="wrapper">
         <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
               <br/>
               <h3 class="text-center"> Bienvenidos.</h3>
                <br/>
            </div>
            <ul class="nav navbar-top-links navbar-right">
              <li>
                @if (Route::has('login'))


                        @if (Auth::guest())
                            <a href="{{ url('/login') }}">
                                <i class="fa fa-sign-out"></i> Iniciar Sesión
                            </a>
                        @else
                            <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Cerrar Sesión
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        @endif

                @endif

                    <!-- <a href="{{ url('login')}}">
                        <i class="fa fa-sign-out"></i> Iniciar Sesión
                    </a> -->
                </li>
            </ul>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-3">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content text-center p-md">
                                    <h2><span class="text-navy">NERU</span> | Administración.</h2>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              @include('layouts.footer')
        </div>

    </div>

@section('scripts')
    @include('layouts.scripts')
    @yield('localscripts')
@show

</body>
</html>
