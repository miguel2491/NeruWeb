<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" width="48px" height="48px" src="img/AppLogo.png" />
                         </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name .' '. Auth::user()->last_name .' ' . Auth::user()->last_name_mother }}</strong>
                         </span> <span class="text-muted text-xs block"><b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Perfil</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Salir
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    GTOS+
                </div>
            </li>
            @php
              use App\Models\RolesUser;
              $idU = Auth::user()->id;
              $roles = RolesUser::where('id_user', $idU)->first();
            @endphp
            <input type="hidden" id="rol" value="{{ $roles->id_rol }}">
            @php
                if($roles->id_rol==1){
            @endphp
            <li {{{ (Request::is('usuario','grupo') ? 'class=active' : '') }}}>
                <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Catálogos</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level" collapse {{{ (Request::is('usuario','grupo') ? 'in' : '') }}}">
                    <li>
                        <a href="{{ URL::to('usuario') }}">
                            <i class="fa fa-user" aria-hidden="true"></i> Usuarios
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('grupo') }}">
                            <i class="fa fa-users" aria-hidden="true"></i> Grupos
                        </a>
                    </li>
                </ul>
            </li>
            <li {{{ (Request::is('variables','evaluaciones','objetivos','actividades','instrucciones') ? 'class=active' : '') }}}>
                <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Tests</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level" collapse {{{ (Request::is('variables','evaluaciones','objetivos','actividades','instrucciones') ? 'in' : '') }}}">
                    <li>
                        <a href="{{ URL::to('variables') }}">
                            <i class="fa fa-user" aria-hidden="true"></i> Variables
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('evaluaciones') }}">
                            <i class="fas fa-file-alt" aria-hidden="true"></i> Evaluaciones
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('objetivos') }}">
                            <i class="fa fa-user" aria-hidden="true"></i> Objetivos
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('actividades') }}">
                            <i class="fa fa-palette" aria-hidden="true"></i> Actividades
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::to('instrucciones') }}">
                            <i class="fas fa-file-signature" aria-hidden="true"></i> Instrucciones
                        </a>
                    </li>
                </ul>
            </li>
            <li {{{ (Request::is('video') ? 'class=active' : '') }}}>
                <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Realidad Virtual</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level" collapse {{{ (Request::is('video') ? 'in' : '') }}}">
                    <li>
                        <a href="{{ URL::to('video') }}">
                            <i class="fa fa-play" aria-hidden="true"></i> Videos
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li {{{ (Request::is('pago') ? 'class=active' : '') }}}>
                <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Realidad Virtual</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level" collapse {{{ (Request::is('pago') ? 'in' : '') }}}">
                    <li>
                        <a href="{{ URL::to('pago') }}">
                            <i class="fa fa-cash" aria-hidden="true"></i> Pagos
                        </a>
                    </li>
                   
                </ul>
            </li>
            @php
                }
            @endphp
            @php
                if($roles->id_rol==2){
            @endphp
            <li {{{ (Request::is('rv') ? 'class=active' : '') }}}>
                <a href="{{ URL::to('rv')}}">
                    <i class="fa fa-vr-cardboard"></i>
                    <span class="nav-label">Realidad Virtual</span>
                </a>
            </li>
            <li {{{ (Request::is('pagar') ? 'class=active' : '') }}}>
                <a href="{{ URL::to('pagar')}}">
                    <i class="fa fa-cart-plus"></i>
                    <span class="nav-label">Pagos</span>
                </a>
            </li>
            @php
                }
            @endphp
        </ul>
    </div>
</nav>
