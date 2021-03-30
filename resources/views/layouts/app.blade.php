<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ThewayShop</title>
    <link rel="shortcut icon" href="/front/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="./front/images/apple-touch-icon.png">

    <link rel="stylesheet" href="/front/css/style.css">
    <link rel="stylesheet" href="/front/css/responsive.css">
    <link rel="stylesheet" href="/front/css/custom.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/app.js" defer></script>
</head>
<body >

    <span id="app">

        <div >
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Online Shop
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                         <a class="dropdown-item" href="/profile/{{Auth::user()->id}}">
                                         {{ __('Profile') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

        </div>
        <header class="main-header" >
            <!-- Start Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
                <div class="container-fluid">
                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button class="navbar-toggler float-right"  id="app_btn"type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                        <a class="navbar-brand" href="/"><img src="/front/images/logo.png" class="logo" alt=""></a>
                    </div>
                    <!-- End Header Navigation -->
                    <?php  $cart = json_decode(Cookie::get('cart_products'))  ?>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                            <li class="nav-item  {{ Request::path() === '/'? 'active' : '' }}">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item  {{ Request::path() === 'all'? 'active' : '' }}">
                                <a class="nav-link" href="/all#/all">All Products</a>
                            </li>
                            <li class="nav-item" {{ Request::path() === '/prod/about'? 'active' : '' }}>
                                <a class="nav-link" href="/prod/about">About Us</a>
                            </li>
                            <li class="nav-item" >
                                <div class="panel-body1 ">
                                    <auto-complete> </auto-complete>
                                </div>
                            </li>
                            {{-- <li class="nav-item" {{ Request::path() === 'whishlist'? 'active' : '' }}><a class="nav-link" href="/whishlist">Whishlist</a></li> --}}
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->

                    <!-- Start Atribute Navigation -->
                    <div class="attr-nav">
                        <ul>
                            <li class="side-menu">
                                <a href="/prod/whishlist" style="color: black">
                                    <i class="fa fa-heart"></i>
                                    <span class="badge">
                                        {{-- {{ isset($cart)? count($cart) : 0 }} --}}
                                        @{{whishlist.length}}
                                    </span>
                                </a>
                            </li>
                            <li class="side-menu">
                                <a href="/prod/cart" style="color: black">
                                    <i class="fa fa-shopping-bag"></i>
                                    <span class="badge">
                                        {{-- {{ isset($cart)? count($cart) : 0 }} --}}
                                        @{{product_count}}
                                    </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="panel-body">

                        <auto-complete> </auto-complete>
                        
                    </div>
                    <!-- End Atribute Navigation -->
                </div>

            </nav>
            <div class="container" v-if="status!= ''">
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 alert alert-success w-25 align-center ">

                        <p >  @{{ status}}</p>
                    </div>
                    </div>
                    <div class="col-sm-1"></div>
            </div>
            <!-- End Navigation -->
        </header>
    <div class="container-fluid" >
        <div class="row">
            <div class="col-sm-12" style="padding: 0; ">

                @yield('content')
            </div>
        </div>
    </div>
    
    @auth
        @if (auth()->user()->usertype != 'admin')
        <div class="chat" v-on:click="openchat">
            <i class="fas fa-comment"></i>
        </div>
        @endif                           
    @endauth
    
    
    </span>





    
    <!-- Start Footer  -->
    <footer>
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>About ThewayShop</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </p>
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link">
                            <h4>Information</h4>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Customer Service</a></li>
                                <li><a href="#">Our Sitemap</a></li>
                                <li><a href="#">Terms &amp; Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Delivery Information</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link-contact">
                            <h4>Contact Us</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Address: Michael I. Days 3756 <br>Preston Street Wichita,<br> KS 67213 </p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">+1-888 705 770</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="mailto:contactinfo@gmail.com">contactinfo@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    {{-- <!-- Start copyright  -->
    <div class="footer-copyright">
        <p class="footer-company">All Rights Reserved. &copy; 2018 <a href="#">ThewayShop</a> Design By :
            <a href="https://html.design/">html design</a></p>
    </div> --}}
    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>



    <script src="/front/js/jquery-3.2.1.min.js"></script>
    <script src="/front/js/jquery.superslides.min.js"></script>
    <script src="/front/js/custom.js"></script>
</body>
</html>



