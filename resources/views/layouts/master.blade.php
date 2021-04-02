<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    	@yield('title')
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/assets/css/now-ui-dashboard.css?v=1.3.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="/assets/demo/demo.css" rel="stylesheet" />
  <link href="/assets/css/style.css" rel="stylesheet" />

  <script src="/js/app.js" defer></script>
  <script src="/assets/js/custom.js" defer></script>
</head>

<body class="">
  <div class="wrapper " id="app">


  	<!-- sidebar star -->
    <div class="sidebar" data-color="orange"><!--Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red |yellow"-->
      <div class="logo">
        
        <!--<img src="{{ URL::to('/assets/img/log.jpg') }}" width="100" height="100">
        --><h4>Admin-Panel </h4>
        <!--<a href="http://www.creative-tim.com" class="simple-text logo-mini">
          CT
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Creative Tim
        </a> -->
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <!--how to set active menu link ternary operator class="{{ 'role-register' == request()->path() ? 'active' : ''}}" -->
          <li class="{{ 'dashboard' == request()->path() ? 'active' : ''}}">
            <a href="/use/admin">
              <i class="fas fa-columns"></i>
              <p>Dashboard</p>
            </a>
          </li>
         <li >
            <a href="/admin/products">
              <i class="fab fa-product-hunt"></i>
              <p>Products</p>
            </a>
          </li>
          <li>
         <li>
            <a href="/admin/order">
              <i class="fas fa-shopping-basket"></i>
              <p>Oreder</p>
            </a>
          </li>
          <li>
            <a href="/admin/chat">
              <i class="far fa-envelope"></i>
              <p>Messages</p>
            </a>
          </li>
          <li>
            <a href="/admin/category">
              <i class="far fa-plus-square"></i>
              <p>Category</p>
            </a>
          </li>  
          <li class="{{ 'role-register' == request()->path() ? 'active' : ''}}">
            <a href="/admin/role-register"> <!--edit here for user profile -->
              <i class="fa fa-users" aria-hidden="true"></i>
              <p>User Profile</p>
            </a>
          </li>
       
        </ul>
      </div>
    </div>



    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Table List</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fa fa-search" aria-hidden="true"></i>

                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              {{-- <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li> --}}
              
              <!-- here we paste or write logout code -->

              <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }} 
                      </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>


              <!--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons location_world"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li> -->
              {{-- <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li> --}}
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->


      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
      	@yield('content')

        
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav>
            <ul>
              <li>
                <a href="https://digitalcrm.com/">
                  Digital-CRM
                </a>
              </li>
              <li>
                <a href="https://digitalcrm.com/about-us/">
                  About Us
                </a>
              </li>
              <li>
                <a href="https://digitalcrm.com/category/crm-blog/">
                  Blog
                </a>
              </li>
            </ul>
          </nav>
          {{-- <div class="copyright" id="copyright">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Designed by
            <a href="https://digitalcrm.com/" target="_blank">CRM</a>. Coded by
            <a href="https://digitalcrm.com/what-is-crm/" target="_blank">digital-CRM</a>.
          </div> --}}
        </div>
      </footer>
    </div>
  </div>


  
  <!--   Core JS Files   -->
  <script src="/assets/js/core/jquery.min.js"></script>
  <script src="/assets/js/core/popper.min.js"></script>
  <script src="/assets/js/core/bootstrap.min.js"></script>
  <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
  <!-- Chart JS -->
  <script src="/assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/assets/js/now-ui-dashboard.min.js?v=1.3.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="/assets/demo/demo.js"></script>
  <script src="/assets/js/custom.js"></script>

  @yield('scripts')
</body>

</html>