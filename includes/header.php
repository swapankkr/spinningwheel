<?php require_once './script/includes/start.php'; check_loged_in()?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme" content="black">
  <title>Spinning Wheel | Dashboard</title>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style>
    .toast{
      opacity: 1 !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-collapse">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-light">

      <!-- <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul> -->

      <ul class="navbar-nav ml-auto">
        <!-- <li class="nav-item">
          <h5 class="pt-2">Hello, <?php echo admin()->name; ?></h5>
        </li> -->
        <li class="nav-item">
          <a class="nav-link text-danger" href="/script/logout.php">
            Log out <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>

    <!-- <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image text-center">
            <img src="dist/img/logo.png" class="img-circle" alt="Logo" style="width: 50%;">
          </div>
        </div>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="dashboard.php" class="nav-link <?php echo $page=="dashboard" ? 'active': ''?>">
                <i class="nav-icon fas fa-cubes"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="active.php" class="nav-link <?php echo $page=="active" ? 'active': ''?>">
                <i class="nav-icon fas fa-spinner"></i>
                <p>
                  Active Wheels
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="result.php" class="nav-link <?php echo $page=="result" ? 'active': ''?>">
                <i class="nav-icon fas fa-circle-notch"></i>
                <p>
                  Spinning Results
                </p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside> -->