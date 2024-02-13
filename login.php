<?php

include('config.php');

if ($connect == null) {
    echo "Create a database then reload this page.";
    return;
} else {
    if (isset($_SESSION['user_type'])) {
        header("location:home.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Enrollement System</title>
    <link rel="icon" href="assets/logo.jpg" type="image/ico">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">

    <style type="text/css">
        .hidden {
            display: none;
        }

        .image-upload>input {
            visibility: hidden;
            width: 0;
            height: 0;
            border-radius: 100;
        }

        header {
            /* position: absolute;
            top: 0;
            left: 0;
            z-index: 10; */
            width: 100%;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
            /* padding: 35px 100px 0; */
            padding: 0 100px 0;
            position: fixed;
            z-index: 10;
            background: #fff;
        }

        header a {
            text-decoration: none;
            cursor: pointer;
            color: inherit;
        }

        header a:hover {
            color: #28a745;
        }

        header h2 span {
            color: #bf0a30;
        }

        header ul.nav {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
        }

        header ul.nav li {
            margin: 0 15px;
        }

        header ul.nav li:first-child {
            margin-left: 0;
        }

        header ul.nav li:last-child {
            margin-right: 0;
        }

        @media(max-width:1000px) {
            header {
                padding: 20px 50px;
            }
        }

        @media (max-width:700px) {
            header {
                flex-direction: column;
                padding: 20px 0 0 0;
            }

            header h2 {
                margin-bottom: 15px;
                display: none;
            }

            header ul.nav li {
                margin: 0 7px;
            }

            .about-right p {
                display: none;
            }
        }

        .logo {
            height: 70px;
        }

        #carouselExampleIndicators .carousel-indicators li {
            cursor: pointer;
            background: #000;
            overflow: hidden;
            border: 0;
            width: 20px;
            height: 20px;
            border-radius: 50px;
            opacity: 0.6;
            transition: 0.3s;
        }

        #carouselExampleIndicators .carousel-indicators li.active {
            opacity: 1;
            background: #28a745;
        }

        .carousel-size {
            height: 50vh;
            width: 80vh;
        }

        @media (max-width:700px) {
            .carousel-size {
                width: 100%;
            }
        }

        .btn-success {
            background-color: #007343;
            border-color: #007343;
        }

        .bg-success,
        .card-success:not(.card-outline)>.card-header,
        .navbar-success,
        .sidebar-dark-success .nav-sidebar>.nav-item>.nav-link.active,
        .sidebar-light-success .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #007343 !important;
        }

        .border-success {
            border-color: #007343 !important;
        }

        .text-success {
            color: #007343 !important;
        }

        /* CSS to remove arrow up and down controls */
        .no-spinners {
            -moz-appearance: textfield;
            appearance: textfield;
        }

        .no-spinners::-webkit-outer-spin-button,
        .no-spinners::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

<body>

    <div class="wrapper">

        <header>
            <h2>
                <a href="#"><img alt="Logo" src="assets/logo.png" class="logo"></a>
            </h2>
            <ul class="nav text-lg text-success text-bold ">
                <!-- <li>
                    <a href="#">About</a>
                </li> -->
                <li>
                    <a href="#admission">Admission</a>
                </li>
                <li>
                    <a href="#scholarship">Scholarship</a>
                </li>
            </ul>
        </header>

        <!-- <section class="row pt-5">
            <div class="col-12  pt-4 pb-5 ">
                <div class="row ">
                    <div class="col-12 col-md-4 ">
                        <div class="row d-flex justify-content-center p-sm-0 p-2">
                            <div class="col-12 col-md-8 pt-2">
                                <form method="post" >
                                    <div class="card elevation-2" style="border-radius: 20px;">
                                        <div class="card-header bg-success " style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                            <div class="text-xl text-bold"><i class="fa fa-user-circle"></i> Portal</div> 
                                        </div>
                                        <div class="card-body text-lg pb-0">
                                            <div class="row  ">  
                                                <div class="form-group col-12 ">
                                                    <input type="text" class="form-control" placeholder="Username" required />
                                                </div>
                                                <div class="form-group col-12 ">
                                                    <input type="password" class="form-control" placeholder="Password" required />
                                                </div> 
                                                <div class="form-group col-12 col-md-12">
                                                    <button type="button" class="btn btn-success btn-block elevation-2 pl-3 pr-3 " 
                                                    style="border-radius: 20px;" ><i class="fa fa-sign-in-alt text-white"></i> Login</button>
                                                </div>
                                                <div class="form-group col-12 col-md-12 text-center ">
                                                    <a href="#" class="text-md">Forgot Password?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 col-md-8 ">
                                <div class="card card-outline elevation-2" style="border-radius: 20px;">
                                    <div class="card-header bg-success pb-0"  style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                        <h5><i class="fab fa-font-awesome-flag"></i> Mission</h5>
                                    </div>
                                    <div class="card-body pt-3 pr-3 pl-3 pb-0">
                                        <p>Lake Shore Educational Institution is committed to delivering excellent secondary education that cultivates globally competent 
                                            and socially responsive individuals who uphold excellence through leadership, and humility.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 ">
                                <div class="card card-outline elevation-2" style="border-radius: 20px;">
                                    <div class="card-header bg-success pb-0"  style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                        <h5><i class="fa fa-eye"></i> Vision</h5>
                                    </div>
                                    <div class="card-body pt-3 pr-3 pl-3 pb-0">
                                        <p>Lake Shore Educational Institution envisions itself as a premier institution servicing as a benchmark for delivering excellent, 
                                            innovate, and dynamic academic services for nation-building.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 ">
                                <div class="card card-outline elevation-2" style="border-radius: 20px;">
                                    <div class="card-header bg-success pb-0"  style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                        <h5><i class="fa fa-phone"></i> Contact Us</h5>
                                    </div>
                                    <div class="card-body p-3">
                                        <div><i class="fa fa-street-view text-success"></i> A. Bonifacio St. Canlalay, Biñan City Laguna</div>
                                        <div><i class="fa fa-phone text-success"></i> (049)-511-4328</div>
                                        <div>&nbsp;<i class="fa fa-mobile-alt text-success"></i>&nbsp; 0939-958-24311 / 0929-263-2963</div>
                                        <a href="https://www.facebook.com/lakeshore1931" target="_blank" class="text-dark"><i class="fab fa-facebook text-success"></i> Lake Shore Educational Institution</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 ">
                        <div id="carouselExampleIndicators"  class="carousel slide carousel-size w-100 h-75" data-ride="carousel" > -->
        <!-- <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                            </ol> -->
        <!-- <div class="carousel-inner " >
                                <div class="carousel-item active ">
                                    <img class="card-img-top carousel-size w-100 h-100" src="assets/carousel/Frame 1.png" alt="Carousel" >
                                </div>
                                <div class="carousel-item  ">
                                    <img class="card-img-top carousel-size w-100 h-100" src="assets/carousel/Frame 2.png" alt="Carousel" >
                                </div>
                                <div class="carousel-item  ">
                                    <img class="card-img-top carousel-size w-100 h-100" src="assets/carousel/Frame 3.png" alt="Carousel" >
                                </div>
                                <div class="carousel-item  ">
                                    <img class="card-img-top carousel-size w-100 h-100" src="assets/carousel/Frame 4.png" alt="Carousel" >
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="background-color: transparent; width: 100px;">
                                <span class="carousel-control-prev-icon" aria-hidden="true">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" style="background-color: transparent; width: 100px;">
                                <span class="carousel-control-next-icon" aria-hidden="true">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-12 p-3">
                <div class="row d-flex justify-content-around">
                    <div class="col-12 col-md-3">
                        <div class="card card-outline elevation-2" style="border-radius: 20px;">
                            <div class="card-header bg-success"  style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                <h1><i class="fab fa-font-awesome-flag"></i> Mission</h1>
                            </div>
                            <div class="card-body">
                                    <p>Lake Shore Educational Institution is committed to delivering excellent secondary education that cultivates globally competent 
                                        and socially responsive individuals who uphold excellence through leadership, and humility.
                                    </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card card-outline elevation-2" style="border-radius: 20px;">
                            <div class="card-header bg-success"  style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                <h1><i class="fa fa-eye"></i> Vision</h1>
                            </div>
                            <div class="card-body">
                                <p>Lake Shore Educational Institution envisions itself as a premier institution servicing as a benchmark for delivering excellent, 
                                    innovate, and dynamic academic services for nation-building.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card card-outline elevation-2" style="border-radius: 20px;">
                            <div class="card-header bg-success"  style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                <h1><i class="fa fa-phone"></i> Contact Us</h1>
                            </div>
                            <div class="card-body">
                                <div><i class="fa fa-street-view text-success"></i> A. Bonifacio St. Canlalay, Biñan City Laguna</div>
                                <div><i class="fa fa-phone text-success"></i> (049)-511-4328</div>
                                <div>&nbsp;<i class="fa fa-mobile-alt text-success"></i>&nbsp; 0939-958-24311 / 0929-263-2963</div>
                                <a href="https://www.facebook.com/lakeshore1931" target="_blank" class="text-dark"><i class="fab fa-facebook text-success"></i> Lake Shore Educational Institution</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        <!-- </section> -->

        <section class="pt-5 pt-sm-5" id="admission">
            <div class="col-12 d-flex justify-content-center">
                <div class="col-12 col-md-8 pt-5">
                    <form method="post" id="forms">
                        <div class="card" style="border-radius: 20px; border: none; box-shadow: none;">
                            <div class="card-header bg-success"
                                style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                <div class="text-xl text-bold"><i class="fa fa-info-circle"></i> Welcome to Lake Shore
                                    Admission.</div>
                            </div>
                            <div class="card-body text-lg">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="h3">Instructions:</div>
                                        <ol>
                                            <li>Students must fill-up the form.</li>
                                            <li>After filing the form, please wait for the status of your admission that
                                                will be send to your email.</li>
                                            <li><span class="text-danger">*</span> Indicates a required field.</li>
                                            <li>Upload soft copy of school requirements, allowed image types: .png,
                                                .jpg, .jpeg.</li>
                                            <!-- <li>Maximum image size is 5mb.</li> -->
                                            <!-- <li>Allowed image types: .png, .jpg</li> -->
                                        </ol>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <hr class="p-0 m-0">
                                    </div>
                                    <div class="col-12 page_one ">
                                        <div class="row">
                                            <div class="form-group col-12 col-md-12 text-center">
                                                <div class="image-upload">
                                                    <label for="file-input">
                                                        <img class="img-thumbnail img-profile "
                                                            src="assets/avatar/default.jpg"
                                                            style="cursor:pointer; width: 160px; height: 160px;" />
                                                    </label>
                                                    <input class="hidden" id="file-input" type="file"
                                                        accept=".png, .jpg, .jpeg" onchange="readURL(this);"
                                                        name="file" />
                                                </div>
                                                <i>Click above to upload a recent 2x2 photo.</i>
                                            </div>
                                            <div class="form-group col-12 col-md-12 mb-0 pb-0 ">
                                                <div class="form-group d-flex justify-content-around">
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="r2" id="New" required>
                                                        <label for="New">
                                                            New Student
                                                        </label>
                                                    </div>
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="r2" id="Old" required>
                                                        <label for="Old">
                                                            Old Student
                                                        </label>
                                                    </div>
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="r2" id="Transferee" required>
                                                        <label for="Transferee">
                                                            Transferee Student
                                                        </label>
                                                    </div>
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="r2" id="Returnee" required>
                                                        <label for="Returnee">
                                                            Returnee Student
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <hr class="p-0 m-0">
                                                <label class="mt-2 ml-2">Personal Details</label>
                                                <hr class="p-0 m-0">
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Last Name <span class="text-danger">*</span></span>
                                                <input type="text" name="last_name" id="last_name" class="form-control"
                                                    placeholder="Last Name" required />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>First Name <span class="text-danger">*</span></span>
                                                <input type="text" name="first_name" id="first_name"
                                                    class="form-control" placeholder="First Name" required />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Middle Name </span>
                                                <input type="text" name="middle_name" id="middle_name"
                                                    class="form-control" placeholder="Middle Name" />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Extension Name </span>
                                                <input type="text" name="extension_name" id="extension_name"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>LRN <span class="text-danger"></span>
                                                    <input type="text" name="lrn" id="lrn" class="form-control" />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Grade Level <span class="text-danger">*</span></span>
                                                <select name="grade_level" id="grade_level" class="form-control"
                                                    required>
                                                    <option value=""></option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Track <span class="text-danger">*</span></span>
                                                <select name="strand_id" id="strand_id" class="form-control" disabled>
                                                    <option value=""></option>
                                                    <?php
                                                    $output = '';
                                                    $rslt = fetch_all($connect, "SELECT * FROM $STRANDS_TABLE WHERE status = 'Active' ");
                                                    foreach ($rslt as $row) {
                                                        $output .= '<option value="' . $row["id"] . '">' . $row["strand"] . '</option>';
                                                    }
                                                    echo $output;
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Email <span class="text-danger">*</span></span>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    required />
                                            </div>
                                            <div class="form-group col-12 col-md-2">
                                                <span>Date of Birth <span class="text-danger">*</span></span>
                                                <div class="input-group date" id="date_births"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#date_births" name="date_birth" id="date_birth"
                                                        required placeholder="MM/DD/YY" />
                                                    <div class="input-group-append" data-target="#date_births"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-2">
                                                <span>Gender <span class="text-danger">*</span></span>
                                                <select name="sex" id="sex" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-2">
                                                <span>Citizenship <span class="text-danger">*</span></span>
                                                <select name="nationality" id="nationality" class="form-control"
                                                    required>
                                                    <option value=""></option>
                                                    <option value="Filipino">Filipino</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>School Last Attended <span class="text-danger">*</span></span>
                                                <input type="text" name="last_attended" id="last_attended"
                                                    class="form-control" placeholder="" required />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Contact Number<span class="text-danger">*</span></span>
                                                <input type="number" min="1" name="contact" id="contact"
                                                    class="form-control no-spinners" maxlength="11"
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                    placeholder="" required />
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <hr class="p-0 m-0">
                                                <label class="mt-2 ml-2">Current Address</label>
                                                <hr class="p-0 m-0">
                                            </div>
                                            <div class="form-group col-12 col-md-4">
                                                <span>House Number/ Block & Lot <span
                                                        class="text-danger">*</span></span>
                                                <input name="house" id="house" class="form-control" placeholder=""
                                                    required />
                                            </div>
                                            <div class="form-group col-12 col-md-4">
                                                <span>Street Name <span class="text-danger">*</span></span>
                                                <input name="street" id="street" class="form-control" placeholder=""
                                                    required />
                                            </div>
                                            <div class="form-group col-12 col-md-4">
                                                <span>Barangay<span class="text-danger">*</span></span>
                                                <input name="barangay" id="barangay" class="form-control" placeholder=""
                                                    required />
                                            </div>
                                            <div class="form-group col-12 col-md-4">
                                                <span>City/ Municipality <span class="text-danger">*</span></span>
                                                <input name="city" id="city" class="form-control" placeholder=""
                                                    required />
                                            </div>
                                            <div class="form-group col-12 col-md-4">
                                                <span>Province<span class="text-danger">*</span></span>
                                                <input name="province" id="province" class="form-control" placeholder=""
                                                    required />
                                            </div>
                                            <div class="form-group col-12 col-md-4">
                                                <span>ZIP Code<span class="text-danger">*</span></span>
                                                <input name="zip" id="zip" class="form-control" placeholder=""
                                                    required />
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <hr class="p-0 m-0">
                                                <label class="mt-2 ml-2">Survey</label>
                                                <hr class="p-0 m-0">
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <span>How do you know Lake Shore? <span
                                                        class="text-danger">*</span></span>
                                                <select name="survey" id="survey" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="Poster">Poster</option>
                                                    <option value="Advertisement">Advertisement</option>
                                                    <option value="Other People">Other People</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 page_two hidden">
                                        <div class="row">
                                            <div class="form-group col-12 col-md-12">
                                                <hr class="p-0 m-0">
                                                <label class="mt-2 ml-2">Guardian Details</label>
                                                <hr class="p-0 m-0">
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Name of Guardian <span class="text-danger">*</span></span>
                                                <input type="text" name="g_fullname" id="g_fullname"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Contact Number<span class="text-danger">*</span></span>
                                                <input type="number" min="1" name="g_contact" id="g_contact"
                                                    class="form-control no-spinners" maxlength="11"
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                    placeholder="" />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Relationship <span class="text-danger">*</span></span>
                                                <input type="text" name="g_relationship" id="g_relationship"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Occupation <span class="text-danger">*</span></span>
                                                <input type="text" name="g_occupation" id="g_occupation"
                                                    class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="checkboxPrimary1">
                                                    <label for="checkboxPrimary1">Same as student address</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <span>Current Address <span class="text-danger">*</span></span>
                                                <textarea name="g_address" id="g_address" class="form-control"
                                                    placeholder=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <hr class="p-0 m-0">
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <input type="hidden" name="student_status" id="student_status" />
                                        <input type="hidden" name="btn_action" id="btn_action"
                                            value="admission_student" />
                                        <button type="button" class="btn btn-success elevation-2 pl-3 pr-3 hidden "
                                            name="btn_prev" id="btn_prev" style="border-radius: 20px;"><i
                                                class="fa fa-arrow-left text-white"></i> Previous</button>
                                        <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 "
                                            name="action" id="action" style="border-radius: 20px;"><i
                                                class="fa fa-arrow-right text-white"></i> Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="pt-5" id="scholarship">
            <div class="col-12 d-flex justify-content-center">
                <div class="col-12 col-md-8 pt-5 pb-5">
                    <div class="row">
                        <div class="col-12 text-center bg-success p-2"
                            style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                            <span class="text-xl text-bold">Requirements for ESC</span>
                        </div>
                        <div class="col-12 mt-4 mt-sm-5 text-lg ">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="col-12 border border-dark p-2 p-sm-4" style="border-radius: 8px;">
                                        <label class="text-bold mt-2 mt-sm-0">*Requirements for Incoming Grade 7
                                            Only</label>
                                        <ol>
                                            <li>Accomplished ESC Application Form.</li>
                                            <li>Accomplished ESC Grantee Enrolment Contract.</li>
                                            <li>2 pieces 2X2 latest ID picture with white background.</li>
                                            <li>PSA Birth Certificate (original and photo copy)</li>
                                            <li>Proof of Income (Certificate of Employment)</li>
                                            <li>Income Tax Return (ITR)</li>
                                            <li>Affidavit of No Fixed Income (notarized)</li>
                                            <li>Affidavit of No Income (notarized)</li>
                                        </ol>
                                        <label class="mt-4">*Requirements for Incoming Grade 8 to 12 (Any
                                            Strand)</label>
                                        <ol>
                                            <li>Accomplished ESC Grantee Enrolment Contract.</li>
                                            <li>2 pieces 2X2 latest ID picture with white background.</li>
                                            <li>PSA Birth Certificate (original and photo copy)</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="col-12 border border-dark p-2 p-sm-4 mt-4 mt-sm-0"
                                        style="border-radius: 8px;">
                                        <label class="text-bold mt-2 mt-sm-0">*ELIGIBILITY</label>
                                        <ul>
                                            <li>Incoming Grade 7 student; Elementary (Grade 6) graduate from a Public or
                                                Private DepEd Recognized Elementary School</li>
                                            <li>Incoming Grade 8 to 10 who are ESC Grantees (Grade 7) from the previous
                                                school</li>
                                            <li>Filipino citizen</li>
                                        </ul>
                                        <label class="">*The grant is subject to termination if a grantee does any of
                                            the following conditions:</label>
                                        <ul>
                                            <li>Drops out for non-health reasons in the middle of the school year;</li>
                                            <li>Does not re-enroll for the coming school year;</li>
                                            <li>Fails to be promoted to the next grade level or is retained at the same
                                                grade level;</li>
                                            <li>Is suspended for more than two (2) weeks, dismissed or expelled by the
                                                school for disciplinary reasons; or</li>
                                            <li>Transfers to a non-ESC-participating JHS.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <footer style="background-color: #007343; color: whitesmoke; padding: 20px 0 20px 0; text-align: center; ">
        &copy; Copyright <a href="#" name="btn_login" id="btn_login" data-toggle="modal" data-target="#loginModal"
            class="text-white"><strong>Lake Shore Educational Institution</strong></a>. All Right Reserved 2023
    </footer>


    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- InputMask -->
    <script src="assets/plugins/moment/moment.min.js"></script>
    <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="assets/plugins/toastr/toastr.min.js"></script>

    <div id="loginModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
        <div class="modal-dialog">
            <form method="post" id="forms_login">
                <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header bg-success"
                        style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                        <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12 col-md-12">
                                <input type="username" name="username" id="username" class="form-control"
                                    placeholder="Username" required />
                            </div>
                            <div class="form-group col-12 col-md-12">
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Password" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <input type="hidden" name="btn_action" id="btn_action_login" />
                        <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action"
                            id="action_login" style="border-radius: 20px;"><i class="fa fa-plus text-white"></i>
                            Add</button>
                        <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal"
                            style="border-radius: 20px;"><i class="fa fa-times-circle"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('.img-profile').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function () {
            // $('[data-mask]').inputmask();
            // $("#nationality").inputmask({mask:"[A][99]-[999999]"});
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                width: '12em'
            });

            // checkboxPrimary1

            $('#checkboxPrimary1').click(function () {
                if ($('#checkboxPrimary1').is(':checked')) {
                    $('#g_address').val($('#address').val());
                }
                else {
                    $('#g_address').val('');
                }
            });

            $('#btn_login').click(function () {
                $('#forms_login')[0].reset();
                $('.modal-title').html("<i class='fa fa-sign-in-alt'></i> Login");
                $('#action_login').html("<i class='fa fa-sign-in-alt '></i> Login");
                $('#action_login').val('login');
                $('#btn_action_login').val('login');
            });

            $(document).ready(function () {
                $('input').keypress(function (event) {
                    var inputValue = event.which;
                    // Check if the pressed key is a single quotation symbol
                    if (inputValue == 39) {
                        event.preventDefault();
                    }
                });
            });


            $(document).on('submit', '#forms_login', function (event) {
                event.preventDefault();
                $('#action_login').attr('disabled', 'disabled');
                var form_data = $(this).serialize();
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: form_data,
                    dataType: "json",
                    success: function (data) {
                        $('#action_login').attr('disabled', false);
                        if (data.status == true) {
                            window.location.href = "home.php";
                        }
                        else {
                            Toast.fire({
                                icon: 'error',
                                title: data.message
                            });
                        }
                    }, error: function () {
                        $('#action_login').attr('disabled', false);
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong.'
                        });
                    }
                })
            });

            $('#New').click(function () {
                $('#student_status').val('New');
                enable()

            });

            function enable() {
                $('#checkboxPrimary1').attr('disabled', false);
                $('#last_name').attr('required', true).attr('disabled', false);
                $('#first_name').attr('required', true).attr('disabled', false);
                $('#middle_name').attr('required', false).attr('disabled', false);
                $('#extension_name').attr('required', false).attr('disabled', false);
                $('#date_birth').attr('required', true).attr('disabled', false);
                $('#sex').attr('required', true).attr('disabled', false);
                $('#nationality').attr('required', true).attr('disabled', false);
                $('#last_attended').attr('required', true).attr('disabled', false);
                $('#survey').attr('required', true).attr('disabled', false);
                $('#contact').attr('required', true).attr('disabled', false);
                $('#house').attr('required', true).attr('disabled', false);
                $('#street').attr('required', true).attr('disabled', false);
                $('#barangay').attr('required', true).attr('disabled', false);
                $('#city').attr('required', true).attr('disabled', false);
                $('#province').attr('required', true).attr('disabled', false);
                $('#zip').attr('required', true).attr('disabled', false);
                $('#g_fullname').attr('disabled', false); // .attr('required', true)
                $('#g_contact').attr('disabled', false);
                $('#g_relationship').attr('disabled', false);
                $('#g_occupation').attr('disabled', false);
                $('#g_address').attr('disabled', false);
            }

            function disable() {
                $('#checkboxPrimary1').attr('disabled', true);
                $('#last_name').attr('required', false).attr('disabled', true);
                $('#first_name').attr('required', false).attr('disabled', true);
                $('#middle_name').attr('required', false).attr('disabled', true);
                $('#extension_name').attr('required', false).attr('disabled', true);
                $('#date_birth').attr('required', false).attr('disabled', true);
                $('#sex').attr('required', false).attr('disabled', true);
                $('#nationality').attr('required', false).attr('disabled', true);
                $('#last_attended').attr('required', false).attr('disabled', true);
                $('#survey').attr('required', false).attr('disabled', true);
                $('#contact').attr('required', false).attr('disabled', true);
                $('#house').attr('required', false).attr('disabled', true);
                $('#street').attr('required', false).attr('disabled', true);
                $('#barangay').attr('required', false).attr('disabled', true);
                $('#city').attr('required', false).attr('disabled', true);
                $('#province').attr('required', false).attr('disabled', true);
                $('#zip').attr('required', false).attr('disabled', true);
                $('#g_fullname').attr('disabled', true); // .attr('required', false)
                $('#g_contact').attr('disabled', true);
                $('#g_relationship').attr('disabled', true);
                $('#g_occupation').attr('disabled', true);
                $('#g_address').attr('disabled', true);
            }

            $('#Old').click(function () {
                $('#student_status').val('Old');
                disable()
            });

            $('#Transferee').click(function () {
                $('#student_status').val('Transferee');
                enable()
            });

            $('#Returnee').click(function () {
                $('#student_status').val('Returnee');
                disable()
            });



            $("#grade_level").change(function () {
                if (this.value > 10) {
                    $('#strand_id').removeAttr('disabled', 'disabled').attr('required', 'required');
                }
                else {
                    $('#strand_id').attr('disabled', 'disabled').removeAttr('required', 'required').val('');
                }
            });

            $(document).ready(function () {
                $("#nationality, #survey").change(function () {
                    if ($(this).val() === 'Others') {
                        var $nationalitySelect = $(this);
                        var placeholder = "Please Specify";

                        var $nationalityInput = $("<input>")
                            .attr("name", $nationalitySelect.attr("name"))
                            .attr("id", $nationalitySelect.attr("id"))
                            .attr("class", $nationalitySelect.attr("class"))
                            .attr("required", $nationalitySelect.attr("required"))
                            .attr("placeholder", placeholder);

                        $nationalitySelect.replaceWith($nationalityInput);
                    }
                });
            });



            $(document).on('submit', '#forms', function (event) {
                event.preventDefault();
                // Collect input values
                var house = $('#house').val();
                var street = $('#street').val();
                var barangay = $('#barangay').val();
                var city = $('#city').val();
                var province = $('#province').val();
                var zip = $('#zip').val();

                var address = {
                    house,
                    street,
                    barangay,
                    city,
                    province,
                    zip
                };


                // Set name and id attributes to 'address'
                var addressStr = `${address.house} ${address.street} ${address.barangay} ${address.city}, ${address.province}, ${address.zip}`;
                $('<input>').attr({
                    type: 'hidden',
                    id: 'address',
                    name: 'address',
                    value: addressStr
                }).appendTo('form');
            });



            $('#btn_prev').click(function () {
                if (steps == 1) {
                    $('#btn_prev').addClass('hidden');
                    $('.page_one').removeClass('hidden');
                    $('.page_two').addClass('hidden');
                    steps = 0;
                    $('#action').html('<i class="fa fa-arrow-right text-white"></i> Next');

                    $('#g_fullname').removeAttr('required', 'required');
                    $('#g_contact').removeAttr('required', 'required');
                    $('#g_relationship').removeAttr('required', 'required');
                    $('#g_occupation').removeAttr('required', 'required');
                    $('#g_address').removeAttr('required', 'required');
                }
            });

            let steps = 0;
            $(document).on('submit', '#forms', function (event) {
                event.preventDefault();
                if (steps == 0) {
                    $('.page_one').addClass('hidden');
                    $('.page_two').removeClass('hidden');
                    $('#btn_prev').removeClass('hidden');
                    steps = 1;
                    $('#action').html('<i class="fa fa-save text-white"></i> Submit');
                    $('#g_fullname').attr('required', 'required');
                    $('#g_contact').attr('required', 'required');
                    $('#g_relationship').attr('required', 'required');
                    $('#g_occupation').attr('required', 'required');
                    $('#g_address').attr('required', 'required');
                } else {
                    $('#action').attr('disabled', 'disabled');
                    $.ajax({
                        url: "action.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            $('#action').attr('disabled', false);
                            if (data.status == true) {
                                $('.img-profile').attr('src', 'assets/avatar/default.jpg');
                                $('#forms')[0].reset();
                                $('#strand_id').attr('disabled', 'disabled').removeAttr('required', 'required').val('');
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message
                                });
                                steps = 0;
                                $('#action').html('<i class="fa fa-arrow-right text-white"></i> Next');
                                $('#btn_prev').addClass('hidden');
                                $('.page_one').removeClass('hidden');
                                $('.page_two').addClass('hidden');
                                // required
                                // $('#lrn').attr('required','required');
                                $('#grade_level').attr('required', 'required');
                                $('#email').attr('required', 'required');
                                $('#last_name').attr('required', 'required');
                                $('#first_name').attr('required', 'required');
                                $('#date_birth').attr('required', 'required');
                                $('#sex').attr('required', 'required');
                                $('#nationality').attr('required', 'required');
                                $('#last_attended').attr('required', 'required');
                                $('#contact').attr('required', 'required');

                                $('#g_fullname').removeAttr('required', 'required');
                                $('#g_contact').removeAttr('required', 'required');
                                $('#g_relationship').removeAttr('required', 'required');
                                $('#g_occupation').removeAttr('required', 'required');
                                $('#g_address').removeAttr('required', 'required');
                            }
                            else {
                                Toast.fire({
                                    icon: 'error',
                                    title: data.message
                                });
                            }
                        }, error: function () {
                            $('#action').attr('disabled', false);
                            Toast.fire({
                                icon: 'error',
                                title: 'Something went wrong3.'
                            });
                        }
                    })
                }
            });

            $('#date_births').datetimepicker({
                format: 'MM-DD-YYYY'
            });

            bsCustomFileInput.init();

        });
    </script>

</body>

</html>