<!DOCTYPE html>
<html>

@section('htmlheader')
    @include('layouts.htmlheader')
@show

<body class="skin-1">
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="page-wrapper" class="gray-bg">
             <div class="row border-bottom">
              @include('layouts.navbar')
             </div>

              @yield('main-content')

              @include('layouts.footer')
        </div>
    </div>

@section('scripts')
    @include('layouts.scripts')
    @yield('localscripts')
@show

</body>
</html>