<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Enrollement System</title>
    <link rel="icon" href="assets/logo.jpg" type="image/ico">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    
    <!-- daterange picker -->
    <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">

    <!--jQuery Magnify-->
    <link rel="stylesheet" href="assets/css/jquery.magnify.css">

    <style>
        .hidden
        {
            display: none;
        }
        .image-upload > input 
        {
            visibility:hidden;
            width: 0;
            height: 0;
        }
        .magnify-button-close, 
        .magnify-button-maximize, 
        .magnify-button-rotateRight, 
        .magnify-button-actualSize, 
        .magnify-button-next, 
        .magnify-button-fullscreen, 
        .magnify-button-prev, 
        .magnify-button-zoomIn, 
        .magnify-button-zoomOut
        {
            color: white;
        }
        .btn-success
        {
            background-color: #007343;
            border-color: #007343;
        }
        .bg-success, .card-success:not(.card-outline)>.card-header, .navbar-success, .sidebar-dark-success .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-success .nav-sidebar>.nav-item>.nav-link.active
        {
            background-color: #007343!important;
        }
        .border-success
        {
            border-color: #007343!important;
        }
        .text-success
        {
            color: #007343!important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-success navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-light" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item dropdown">

                <a class="nav-link text-bold text-white" data-toggle="dropdown" href="#">
                    <i class="fa fa-user-circle"></i> Admin
                </a>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer "><i class="fa fa-lock mr-2"></i> Change Password</a>

                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item dropdown-footer text-danger"><i class="fa fa-sign-out-alt mr-2"></i>Logout</a>

                </div>
            </li> -->

            <li class="nav-item">
                <a class="nav-link text-white" href="#" data-toggle="modal" data-target="#profileModal">
                    <i class="fas fa-user-circle"></i> <?php echo $_SESSION["user_name"];?>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-white" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </nav>