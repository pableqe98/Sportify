<!doctype html>
<html>
    <head>
        <title>Sportify @yield('title')</title>

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Página inicial TFG Pablo Delgado" />
        <meta name="author" content="Pablo Delgado" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        
        
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/footer.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/profile.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/eventos.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/inicio_usuario.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
        

        @yield('css')

        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>               
       
       

    </head>
    <body>

        <!-- NavBar -->
        
        
        @include('inc.navbar')
        <div class="overlay"></div>
        <div class="main-container">
         
          
          @yield('content')
          

          <!-- Footer -->
          <div class="page-footer font-small ">

              <!-- Footer Links -->
              <div class="container-fluid text-center text-md-left" style="width:80%;">

                <!-- Footer links -->
                <div class="row text-center text-md-left mt-3 pb-3">

                  <!-- Grid column -->
                  <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Sportify</h6>
                    <p>Sportify es un servicio web pensado para conectar a la gente con aficiones deportivas similares, 
                      facilitando así la organización de eventos y conectando gente afín.
                    </p>
                  </div>
                  <!-- Grid column -->

                  <hr class="w-100 clearfix d-md-none">

                  <!-- Grid column -->
                  <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Origen</h6>
                    <p>
                      Se trata de un Proyecto Fin de Grado del alumno de Ingeniería Informática Pablo Delgado García.
                    </p>
                    
                  </div>
                  <!-- Grid column -->

                  <hr class="w-100 clearfix d-md-none">

                  <!-- Grid column -->
                  <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Sobre Nosotros</h6>
                    <p>
                      <a href="https://www.ugr.es/" target="_blank">Página UGR</a>
                    </p>
                    <p>
                      <a href="http://etsiit.ugr.es/" target="_blank">Página ETSIIT</a>
                    </p>
                    <p>
                      <a href="https://www.linkedin.com/in/pablo-delgado-114029199/" target="_blank">¿Quién es Pablo Delgado?</a>
                    </p>
                    
                  </div>

                  <!-- Grid column -->
                  <hr class="w-100 clearfix d-md-none">

                  <!-- Grid column -->
                  <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Contacto</h6>
                    <p>
                      <i class="fas fa-home mr-3"></i>  C/Periodista Daniel Saucedo Aranda, s/n, Granada</p>
                    <p>
                      <i class="fas fa-envelope mr-3"></i> sportify.ugr@gmail.com</p>
                    
                  </div>
                  <!-- Grid column -->

                </div>
                <!-- Footer links -->

                <hr>

                

              </div>
              <!-- Footer Links -->

            </div>
          
          <!-- Dark Overlay element -->
         

        </div>

        <!-- Scripts de Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

        <!-- jQuery Custom Scroller CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>


    
    

        <script src="{{ asset('js/sidebar.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/map.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/tabla_participantes.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/apuntar_equipo.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/filtro_home.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/buscador.js') }}"></script>


        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
        @yield('script')

          <!-- Codigos tablas bootstrap -->
          
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    </body>
</html>