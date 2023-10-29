@inject('menus', 'App\Services\segAsignacionOpcionServicio')
@inject('opciones', 'App\Services\segAsignacionOpcionRolServicio')
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>InvGestor</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="icono" href="{{asset('img/icono.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/styleslg.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/cssPrincipal.css')}}">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="{{asset('img/muser2-160x160.jpg')}}" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
            <!-- Logo -->
          <div class="logoDash">
              <img src="{{asset('img/favicon-32x32.png')}}"> 
          </div>
                 <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown user user-menu">
                <a href="/" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-power-off"> </i>
                  <span class="hidden-xs">Usuario: {{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu" class="dropdown-menu-right">               
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="{{route('logout') }}" class="btn btn-danger ">Cerrar Sesión</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <li class="header">
              MENU
            </li>
            @foreach($menus->get(Auth::user()->idrol) as $menu)
            <li class="treeview">
              <a href="#">
                <i class="{{$menu->iconomenu}}"></i>
                <span>{{$menu->descripcionmenu}}</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @foreach($opciones->get($menu->idrol,$menu->idmenu) as $opcion)
                  <li><a href="{{url ($opcion->ruta)}}"><i class="{{$opcion->iconoopcion}}"></i>{{$opcion->descripcionopcion}}</a></li>
                @endforeach
              </ul>
            </li>
            @endforeach
          </ul>
        </section>
      </aside>



       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Contenido Principal -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-solid box-success" >
                <div class="box-header with-border">
                  <h2 class="box-title text_dash"> Administración de Inventario</h2>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                      <div class="box-body">
                  	    <div class="row">
	                  	      <div class="col-md-12">
		                          <!--Contenido-->
                              @yield ('contenido')
		                          <!--Fin Contenido-->
                            </div>
                        </div>
                  		</div>
                  	</div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <footer class="main-footer">
              <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
              </div>
              <!-- <strong>Copyright &copy; 2021 <a href="/">InvGestor</a> - </strong> Todos los derechos reservados. -->
            </footer>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('dist/js/jquery.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{asset('js/myEvents.js')}}"></script>
    
  </body>
</html>