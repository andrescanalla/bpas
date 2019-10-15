<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Demo</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}"> 

    <link rel="icon" href="{{asset('img/logo.png')}}">

    <!-- Datatable -->
    <!-- <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}"> -->
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <!-- Font Awesome  -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    
    <!-- Theme style -->
    @stack('style')
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
      
     <!-- jQuery 2.1.4 -->
     <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
     @stack('script')
     <!-- <script src="{{asset('js/datatables.min.js')}}"></script> -->
     <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
   
    <!-- Bootstrap 3.3.5  -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>

    <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>   
    
  </head>

  <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper.collapse.in">

      <header class="main-header">

        <!-- Logo -->
        <a href="/demo" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="/img/logo.png" style="margin-top:-5px ;width: 25px; height: 20px"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="/img/logo.png" style="margin-top:-5px ;width: 25px; height: 20px"> Demo</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
           
            
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a> 
            
         
          <div class="form-group" style="margin-bottom:-4px ; margin-top:5px ;font-size:25px;">
            @yield('titulo') 
          </div>
      
       </nav>  
             
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" >            
              <li class="treeview">
                  <a href="./visitas">
                    <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> <span>Listado</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>     
                  <ul class="treeview-menu">
                      <li><a href="/visitas"><i class="fa fa-circle-o"></i>Visitas</a></li>  
                      <li><a href="/localidades"><i class="fa fa-circle-o"></i> Localidades</a></li>                  
                    </ul>         
                </li>
    
            <li class="treeview">
              <a href="/departamentos">
                <i class="fa fa-globe" aria-hidden="true"></i>
                <span>API Google Maps</span>               
                <i class="fa fa-angle-left pull-right"></i>
                </a> 
                
                
              
              <ul class="treeview-menu">
                <li><a href="/demo/map/shapefile"><i class="fa fa-circle-o"></i>Show a Shape File </a></li>
                 <li><a href="/departamentos/3"><i class="fa fa-circle-o"></i> Belgrano</a></li>
                 <li><a href="/departamentos/2"><i class="fa fa-circle-o"></i> Caseros</a></li>
                 <li><a href="/departamentos/8"><i class="fa fa-circle-o"></i> Constitucion</a></li>
                 <li><a href="/departamentos/7"><i class="fa fa-circle-o"></i> General Lopez</a></li>
                 <li><a href="/departamentos/4"><i class="fa fa-circle-o"></i> Iriondo</a></li> 
                 <li><a href="/departamentos/6"><i class="fa fa-circle-o"></i> Rosario</a></li> 
                 <li><a href="/departamentos/5"><i class="fa fa-circle-o"></i> San Lorenzo</a></li>        
               
              </ul>              
            </li>

            <li class="treeview">
              <a href="#">
                  <i class="fa fa-folder-open" aria-hidden="true"></i>
                <span>Informe</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/informe/resumen"><i class="fa fa-circle-o"></i>Resumen</a></li>
                <li><a href="/informe/mensual"><i class="fa fa-circle-o"></i>Mensual</a></li>               
              </ul>
            </li>     

            
            <li class="treeview">
              <a href="/contactos">
                <i class="fa fa-address-book" aria-hidden="true"></i>
                <span>Contactos</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>                            
            </li>

            <li class="treeview">
              <a href="/setting">
              <i class="fa fa-cog" aria-hidden="true"></i>
                <span>Setting</span>
                <i class="fa fa-angle-left pull-right"></i>                
              </a> 
              <ul class="treeview-menu">
                <li><a href="/setting/localidad"><i class="fa fa-circle-o"></i>Localidades</a></li> 
                <li><a href="/setting/departamento"><i class="fa fa-circle-o"></i>Departamentos</a></li>                              
              </ul>                           
            </li>
            

            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Acceso</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">                
                <li><a href="/login"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                <li>
                      <a href="{{ url('/logout') }}"
                          onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                        <i class="fa fa-circle-o"></i>
                          Logout
                      </a>

                      <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                      </form>
                </li>
              </ul>
            </li>
             

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
           <div class="row">
            <div class="col-md-12">
              @yield('actualizacion')
                            
              <div class="panel panel-default" style="margin-bottom:0">                
                <div class="panel-body">
                  	<div class="row">
	                  	<div class="col-md-12">		                         
                              <!--Contenido-->
                              @yield('contenido')
		                          <!--Fin Contenido-->
                  		</div>
                  	</div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
       <!--<footer class="main-footer" style="padding:8px">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2017-2022 Wedelia</a>.</strong> All rights reserved.
      </footer>-->
    </div>


    
    
    @stack('scripts')
    @include('sweetalert::alert')
  </body>
</html>
