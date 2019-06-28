
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <title>oke-trip.com | ADMIN</title>
  <link rel="stylesheet" href="/css/app.css">
  <link rel="icon" href="dist/img/AdminLTELogo.png" type="image/gif" sizes="16x16">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    {{-- NAVBAR RIGHT --}}

    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/logout') }}" class="nav-link">
          <i class="fas fa-power-off"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">OKE-TRIP.COM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div style="overflow: hidden; white-space: nowrap;display: inline-block;padding: 5px 5px 5px 10px;transition: margin-left .3s linear,opacity .3s ease,visibility .3s ease;">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link ">
              <i class="nav-icon fas fa-home"></i>
              <p>Paket Tour</p>
            </a>
          </li>
          <li class="nav-item">
            <router-link to="/booking-list" class="nav-link ">
              <i class="nav-icon fas fa-list"></i>
              <p>Booking List</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a class="nav-link active" >
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Setting
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/group-menu" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Group Menu</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/menu-list" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu List</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/privilege" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Privilege</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a class="nav-link active" >
              <i class="nav-icon fab fa-product-hunt"></i>
              <p>
                Product
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/destination" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Destination</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/additional" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Additional</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/itinerary" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Itinerary</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/tour-leader" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tour Leader</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link to="/agent" class="nav-link ">
              <i class="nav-icon fas fa-users"></i>
              <p>Agent</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a class="nav-link active" >
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Finance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/income-report" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Income Report</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/income-statement" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Income Statement</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a class="nav-link active" >
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/customer-statistic" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Statistic</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/sales-statistic" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>sales statistics</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/customer-report" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Report</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/sales-report" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Report</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to ="/payment-report" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment Report</p>
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
              <li class="breadcrumb-item active" id="crumb"></li>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <v-app>
          <router-view></router-view>
        </v-app>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/js/app.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
