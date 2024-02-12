<?php

include('config.php');

if ($connect == null)
{
    echo "Create a database then reload this page.";
    return;
}
else 
{
    if (isset($_SESSION['user_type']))
    {
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
        .hidden
        {
            display:none;
        }
        .image-upload > input 
        {
            visibility:hidden;
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
                display:none;
            }
            header ul.nav li {
                margin: 0 7px;
            }
            .about-right p {
                display: none;
            }
        }

        .logo
        {
            height : 70px;
        }
        #carouselExampleIndicators .carousel-indicators li 
        {
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
        #carouselExampleIndicators .carousel-indicators li.active 
        {
            opacity: 1;
            background: #28a745;
        }
        .carousel-size
        {
            height: 50vh; 
            width: 80vh;
        }
        @media (max-width:700px) {
            .carousel-size
            {
                width: 100%;
            }
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

<body>
  
    <div class="wrapper"> 

        <header >
            <h2 >
                <a href="#"><img alt="Logo" src="assets/logo.png" class="logo" ></a>
            </h2>
            <ul class="nav text-lg text-success text-bold ">
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#admission">Admission</a>
                </li>
                <li>
                    <a href="#scholarship">Scholarship</a>
                </li>
            </ul>
        </header>

        <section class="row pt-5">
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
                        <div id="carouselExampleIndicators"  class="carousel slide carousel-size w-100 h-75" data-ride="carousel" >
                            <!-- <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                            </ol> -->
                            <div class="carousel-inner " >
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
            </div>
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
        </section>

        <section class="pt-2 pt-sm-2" id="admission">
            <div class="col-12 d-flex justify-content-center">
                <div class="col-12 col-md-8 pt-5">
                    <form method="post" id="forms">
                        <div class="card elevation-2" style="border-radius: 20px;">
                            <div class="card-header bg-success " style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                <div class="text-xl text-bold"><i class="fa fa-info-circle"></i> Welcome to Lake Shore Admission.</div> 
                            </div>
                            <div class="card-body text-lg">
                                <div class="row">  
                                    <div class="col-12">
                                        <div class="h3">Instructions:</div>
                                        <ol>
                                            <li>Students must fill-up the form.</li>
                                            <li>After filing the form, please wait for the status of your admission that will be send to your email.</li>
                                            <li><span class="text-danger">*</span> Indicates a required field.</li>
                                            <li>Upload soft copy of school requirements, allowed image types: .png, .jpg, .jpeg.</li>
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
                                                <div class="image-upload" >
                                                    <label for="file-input">
                                                        <img class="img-thumbnail img-profile " src="assets/avatar/default.jpg" style="cursor:pointer; width: 160px; height: 160px;"/>
                                                    </label>
                                                    <input class="hidden" id="file-input" type="file" accept=".png, .jpg, .jpeg" onchange="readURL(this);" name="file" />
                                                </div>
                                                <i>Click above to upload a recent school ID.</i>
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
                                                <span>LRN <span class="text-danger">*</span></span>
                                                <input type="number" name="lrn" id="lrn" class="form-control" required />
                                            </div>   
                                            <div class="form-group col-12 col-md-3">
                                                <span>Grade Level <span class="text-danger">*</span></span>
                                                <select name="grade_level" id="grade_level" class="form-control" required>
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
                                                <select name="strand_id" id="strand_id" class="form-control" disabled >
                                                    <option value=""></option>
                                                    <?php
                                                        $output = '';
                                                        $rslt = fetch_all($connect,"SELECT * FROM $STRANDS_TABLE WHERE status = 'Active' " );
                                                        foreach($rslt as $row)
                                                        {
                                                            $output .= '<option value="'.$row["id"].'">'.$row["strand"].'</option>';
                                                        }
                                                        echo $output;
                                                    ?>
                                                </select>
                                            </div>    
                                            <div class="form-group col-12 col-md-3">
                                                <span>Email <span class="text-danger">*</span></span>
                                                <input type="email" name="email" id="email" class="form-control" required />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Last Name <span class="text-danger">*</span></span>
                                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" required />
                                            </div>  
                                            <div class="form-group col-12 col-md-3">
                                                <span>First Name <span class="text-danger">*</span></span>
                                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" required />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Middle Name </span>
                                                <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Extension Name </span>
                                                <input type="text" name="extension_name" id="extension_name" class="form-control" placeholder="" />
                                            </div>
                                            <div class="form-group col-12 col-md-2">
                                                <span>Date of Birth <span class="text-danger">*</span></span>
                                                <div class="input-group date" id="date_births" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#date_births" name="date_birth" id="date_birth" required placeholder=""/>
                                                    <div class="input-group-append" data-target="#date_births" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-2">
                                                <span>Sex <span class="text-danger">*</span></span>
                                                <select name="sex" id="sex" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Nationality <span class="text-danger">*</span></span>
                                                <input type="text"  name="nationality" id="nationality" class="form-control" placeholder="" required />
                                            </div>
                                            <div class="form-group col-12 col-md-2">
                                                <span>S.Y. Last Attended <span class="text-danger">*</span></span>
                                                <input type="text" name="last_attended" id="last_attended" class="form-control" placeholder="" required />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Contact <span class="text-danger">*</span></span>
                                                <input type="number" min="1" name="contact" id="contact" class="form-control" maxlength = "11" 
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="" required />
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <span>Complete Address <span class="text-danger">*</span></span>
                                                <textarea name="address" id="address" class="form-control" placeholder="" required ></textarea>
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
                                                <input type="text" name="g_fullname" id="g_fullname" class="form-control" placeholder=""  />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Contact <span class="text-danger">*</span></span>
                                                <input type="number" min="1" name="g_contact" id="g_contact" class="form-control" maxlength = "11" 
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder=""  />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Relationship <span class="text-danger">*</span></span>
                                                <input type="text" name="g_relationship" id="g_relationship" class="form-control" placeholder=""  />
                                            </div>
                                            <div class="form-group col-12 col-md-3">
                                                <span>Occupation <span class="text-danger">*</span></span>
                                                <input type="text" name="g_occupation" id="g_occupation" class="form-control" placeholder=""  />
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="checkboxPrimary1" >
                                                    <label for="checkboxPrimary1">Same as student address</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <span>Complete Address <span class="text-danger">*</span></span>
                                                <textarea name="g_address" id="g_address" class="form-control" placeholder=""  ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 page_three hidden">
                                        <div class="row">
                                            <div class="form-group col-12 col-md-12">
                                                <hr class="p-0 m-0">
                                                <label class="mt-2 ml-2">School Requirements</label>
                                                <hr class="p-0 m-0">
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <span>SF9 (Report Card) from prev. school <span class="text-danger">*</span></span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="report_card1" name="report_card1" accept=".png, .jpg, .jpeg"  >
                                                    <label class="custom-file-label" for="report_card1">Choose image (Page 1)</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <span><span class="text-danger">*</span></span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="report_card2" name="report_card2" accept=".png, .jpg, .jpeg"  >
                                                    <label class="custom-file-label" for="report_card2">Choose image (Page 2)</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <span>SF10 (Form 137) </span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="form_1371" name="form_1371" accept=".png, .jpg, .jpeg" >
                                                    <label class="custom-file-label" for="form_1371">Choose image (Page 1)</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <span>&nbsp;</span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="form_1372" name="form_1372" accept=".png, .jpg, .jpeg" >
                                                    <label class="custom-file-label" for="form_1372">Choose image (Page 2)</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <span>PSA Birth Certificate <span class="text-danger">*</span></span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="psa" name="psa" accept=".png, .jpg, .jpeg"  >
                                                    <label class="custom-file-label" for="psa">Choose image</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <span>Good Moral Certificate </span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="good_moral" name="good_moral" accept=".png, .jpg, .jpeg" >
                                                    <label class="custom-file-label" for="good_moral">Choose image</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <span>Certificate of No Financial Obligation <span class="text-danger">*</span></span>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="certificate" name="certificate" accept=".png, .jpg, .jpeg"  >
                                                    <label class="custom-file-label" for="certificate">Choose image</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 page_four hidden">
                                        <div class="row">
                                            <div class="form-group col-12 col-md-12">
                                                <hr class="p-0 m-0">
                                                <label class="mt-2 ml-2">Payment Details</label>
                                                <hr class="p-0 m-0">
                                            </div>
                                            <div class="form-group col-12 col-md-4">
                                                <select name="payment_method" id="payment_method" class="form-control" >
                                                    <option value="">Payment Method</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Installment">Installment</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-4 installment hidden">
                                                <select name="school_fees" id="school_fees" class="form-control"  >
                                                    <option value="">School Fees</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-4 installment hidden">
                                                <select name="modules_ebook" id="modules_ebook" class="form-control"  >
                                                    <option value="">Modules & E-Books</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 col-md-12 tuition hidden">
                                                <hr class="p-0 m-0">
                                            </div>
                                            <div class="col-12 col-md-3 tuition hidden">
                                                <table class="table table-hover table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center">School Fees</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>One Year</td>
                                                            <th class="sf_one_year">0</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table table-hover table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center">Modules & E-Books</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>One Year</td>
                                                            <th class="me_one_year">0</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12 col-md-9 installment hidden">
                                                <table class="table table-hover table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="6" class="text-center">PAYMENT OPTIONS</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4" class="text-center">SCHOOL FEES</th>
                                                            <th colspan="2" class="text-center">Modules and E-Books</th>
                                                        </tr>
                                                        <tr>
                                                            <th></th>
                                                            <th>A</th>
                                                            <th>B</th>
                                                            <th>C</th>
                                                            <th>A</th>
                                                            <th>B</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Upon Enrollment</td>
                                                            <td class="sf_ue_a">0</td>
                                                            <td class="sf_ue_b">0</td>
                                                            <td class="sf_ue_c">0</td>
                                                            <td class="me_ue_a">0</td>
                                                            <td class="me_ue_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>AUGUST</td>
                                                            <td class="sf_aug_a">0</td>
                                                            <td class="sf_aug_b">0</td>
                                                            <td class="sf_aug_c">0</td>
                                                            <td class="me_aug_a">0</td>
                                                            <td class="me_aug_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>SEPTEMBER</td>
                                                            <td class="sf_sep_a">0</td>
                                                            <td class="sf_sep_b">0</td>
                                                            <td class="sf_sep_c">0</td>
                                                            <td class="me_sep_a">0</td>
                                                            <td class="me_sep_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>OCTOBER</td>
                                                            <td class="sf_oct_a">0</td>
                                                            <td class="sf_oct_b">0</td>
                                                            <td class="sf_oct_c">0</td>
                                                            <td class="me_oct_a">0</td>
                                                            <td class="me_oct_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>NOVEMBER</td>
                                                            <td class="sf_nov_a">0</td>
                                                            <td class="sf_nov_b">0</td>
                                                            <td class="sf_nov_c">0</td>
                                                            <td class="me_nov_a">0</td>
                                                            <td class="me_nov_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>DECEMBER</td>
                                                            <td class="sf_dec_a">0</td>
                                                            <td class="sf_dec_b">0</td>
                                                            <td class="sf_dec_c">0</td>
                                                            <td class="me_dec_a">0</td>
                                                            <td class="me_dec_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>JANUARY</td>
                                                            <td class="sf_jan_a">0</td>
                                                            <td class="sf_jan_b">0</td>
                                                            <td class="sf_jan_c">0</td>
                                                            <td class="me_jan_a">0</td>
                                                            <td class="me_jan_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>FEBRUARY</td>
                                                            <td class="sf_feb_a">0</td>
                                                            <td class="sf_feb_b">0</td>
                                                            <td class="sf_feb_c">0</td>
                                                            <td class="me_feb_a">0</td>
                                                            <td class="me_feb_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>MARCH</td>
                                                            <td class="sf_mar_a">0</td>
                                                            <td class="sf_mar_b">0</td>
                                                            <td class="sf_mar_c">0</td>
                                                            <td class="me_mar_a">0</td>
                                                            <td class="me_mar_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>APRIL</td>
                                                            <td class="sf_apr_a">0</td>
                                                            <td class="sf_apr_b">0</td>
                                                            <td class="sf_apr_c">0</td>
                                                            <td class="me_apr_a">0</td>
                                                            <td class="me_apr_b">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>MAY</td>
                                                            <td class="sf_mar_a">0</td>
                                                            <td class="sf_mar_b">0</td>
                                                            <td class="sf_mar_c">0</td>
                                                            <td class="me_mar_a">0</td>
                                                            <td class="me_mar_b">0</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <hr class="p-0 m-0">
                                                <label class="mt-2 ml-2">Visitor Form</label>
                                                <hr class="p-0 m-0">
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <span class="text-danger text-bold">Reminder: This will serve as your entrance pass.</span>
                                            </div>
                                            <div class="form-group col-12 col-md-12">
                                                <span>Visitor's Fullname <span class="text-danger">*</span></span>
                                                <input type="text" name="visitor_name" id="visitor_name" class="form-control" placeholder="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <hr class="p-0 m-0">
                                    </div>
                                    <div class="form-group col-12 col-md-12">
                                        <input type="hidden" name="student_status" id="student_status" />
                                        <input type="hidden" name="btn_action" id="btn_action" value="admission_student"/>
                                        <button type="button" class="btn btn-success elevation-2 pl-3 pr-3 hidden " name="btn_prev" id="btn_prev" 
                                        style="border-radius: 20px;" ><i class="fa fa-arrow-left text-white"></i> Previous</button>
                                        <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action" id="action" 
                                        style="border-radius: 20px;" ><i class="fa fa-arrow-right text-white"></i> Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="pt-2" id="scholarship">
            <div class="col-12 d-flex justify-content-center">
                <div class="col-12 col-md-8 pt-5 pb-5">
                    <div class="row"> 
                        <div class="col-12 text-center bg-success p-2" style="border-radius: 8px;">
                            <span class="text-xl text-bold">Requirements for ESC</span>
                        </div>
                        <div class="col-12 mt-4 mt-sm-5 text-lg ">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="col-12 border border-dark p-2 p-sm-4" style="border-radius: 8px;">
                                        <label class="text-bold mt-2 mt-sm-0">*Requirements for Incoming Grade 7 Only</label>
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
                                        <label class="mt-4">*Requirements for Incoming Grade 8 to 12 (Any Strand)</label>
                                        <ol>
                                            <li>Accomplished ESC Grantee Enrolment Contract.</li>
                                            <li>2 pieces 2X2 latest ID picture with white background.</li>
                                            <li>PSA Birth Certificate (original and photo copy)</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="col-12 border border-dark p-2 p-sm-4 mt-4 mt-sm-0" style="border-radius: 8px;">
                                        <label class="text-bold mt-2 mt-sm-0">*ELIGIBILITY</label>
                                        <ul>
                                            <li>Incoming Grade 7 student; Elementary (Grade 6) graduate from a Public or Private DepEd Recognized Elementary School</li>
                                            <li>Incoming Grade 8 to 10 who are ESC Grantees (Grade 7) from the previous school</li>
                                            <li>Filipino citizen</li>
                                        </ul>
                                        <label class="">*The grant is subject to termination if a grantee does any of the following conditions:</label>
                                        <ul>
                                            <li>Drops out for non-health reasons in the middle of the school year;</li>
                                            <li>Does not re-enroll for the coming school year;</li>
                                            <li>Fails to be promoted to the next grade level or is retained at the same grade level;</li>
                                            <li>Is suspended for more than two (2) weeks, dismissed or expelled by the school for disciplinary reasons; or</li>
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
    &copy; Copyright <a href="#" name="btn_login" id="btn_login" data-toggle="modal" data-target="#loginModal" class="text-white"><strong>Lake Shore Educational Institution</strong></a>. All Right Reserved 2023
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
            <div class="modal-content" style="border-radius: 20px;" >
                <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-12">
                            <input type="username" name="username" id="username" class="form-control" placeholder="Username" required />
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <input type="hidden" name="btn_action" id="btn_action_login"/>
                    <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action" id="action_login" style="border-radius: 20px;" ><i class="fa fa-plus text-white"></i> Add</button>
                    <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
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
        
        $('#checkboxPrimary1').click(function(){
            if($('#checkboxPrimary1').is(':checked'))
            {
                $('#g_address').val($('#address').val());
            }
            else
            {
                $('#g_address').val('');
            }
        });
        
        $('#btn_login').click(function(){
            $('#forms_login')[0].reset();
            $('.modal-title').html("<i class='fa fa-sign-in-alt'></i> Login");
            $('#action_login').html("<i class='fa fa-sign-in-alt '></i> Login");
            $('#action_login').val('login');
            $('#btn_action_login').val('login');
        });
    
        $(document).on('submit','#forms_login', function(event){
            event.preventDefault();
            $('#action_login').attr('disabled','disabled');
            var form_data = $(this).serialize();
            $.ajax({
                url:"action.php",
                method:"POST",
                data:form_data,
                dataType:"json",
                success:function(data)
                {
                    $('#action_login').attr('disabled', false);
                    if (data.status == true)
                    {
                        window.location.href = "home.php";
                    }
                    else 
                    {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                },error:function()
                {
                    $('#action_login').attr('disabled', false);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });
        
        $('#New').click(function(){
            $('#student_status').val('New');
            enable()

        });

        function enable()
        {
            $('#checkboxPrimary1').attr('disabled', false);
            $('#last_name').attr('required', true).attr('disabled', false);
            $('#first_name').attr('required', true).attr('disabled', false);
            $('#middle_name').attr('required', false).attr('disabled', false);
            $('#extension_name').attr('required', false).attr('disabled', false);
            $('#date_birth').attr('required', true).attr('disabled', false);
            $('#sex').attr('required', true).attr('disabled', false);
            $('#nationality').attr('required', true).attr('disabled', false);
            $('#last_attended').attr('required', true).attr('disabled', false);
            $('#contact').attr('required', true).attr('disabled', false);
            $('#address').attr('required', true).attr('disabled', false);
            $('#g_fullname').attr('disabled', false); // .attr('required', true)
            $('#g_contact').attr('disabled', false);
            $('#g_relationship').attr('disabled', false);
            $('#g_occupation').attr('disabled', false);
            $('#g_address').attr('disabled', false);
        }

        function disable()
        {
            $('#checkboxPrimary1').attr('disabled', true);
            $('#last_name').attr('required', false).attr('disabled', true);
            $('#first_name').attr('required', false).attr('disabled', true);
            $('#middle_name').attr('required', false).attr('disabled', true);
            $('#extension_name').attr('required', false).attr('disabled', true);
            $('#date_birth').attr('required', false).attr('disabled', true);
            $('#sex').attr('required', false).attr('disabled', true);
            $('#nationality').attr('required', false).attr('disabled', true);
            $('#last_attended').attr('required', false).attr('disabled', true);
            $('#contact').attr('required', false).attr('disabled', true);
            $('#address').attr('required', false).attr('disabled', true);
            $('#g_fullname').attr('disabled', true); // .attr('required', false)
            $('#g_contact').attr('disabled', true);
            $('#g_relationship').attr('disabled', true);
            $('#g_occupation').attr('disabled', true);
            $('#g_address').attr('disabled', true);
        }
        
        $('#Old').click(function(){
            $('#student_status').val('Old');
            disable()
        });
        
        $('#Transferee').click(function(){
            $('#student_status').val('Transferee');
            enable()
        });
        
        $('#Returnee').click(function(){
            $('#student_status').val('Returnee');
            disable()
        });

        $("#grade_level").change(function(){
            if (this.value > 10)
            {
                $('#strand_id').removeAttr('disabled','disabled').attr('required','required');
            }
            else
            {
                $('#strand_id').attr('disabled','disabled').removeAttr('required','required').val('');
            }
            if ($("#payment_method").val() == 'Installment' || $("#payment_method").val() == 'Cash')
            {
                if (this.value !== '')
                {
                    if (this.value > 10)
                    {
                        loadData('Senior');
                    }
                    else
                    {
                        loadData('Junior');
                    }
                    if ($("#payment_method").val() == 'Cash')
                    {
                        $('.installment').addClass('hidden');
                        $('#school_fees').removeAttr('required','required');
                        $('#modules_ebook').removeAttr('required','required');
                    }
                    else
                    {
                        $('.installment').removeClass('hidden');
                        $('#school_fees').attr('required','required');
                        $('#modules_ebook').attr('required','required');
                    }
                    $('.tuition').removeClass('hidden');
                }
                else
                {
                    $("#payment_method").val('');
                    $('.tuition').addClass('hidden');
                    $('.installment').addClass('hidden');
                    $('#school_fees').removeAttr('required','required');
                    $('#modules_ebook').removeAttr('required','required');
                }
            }
        });

        $("#payment_method").change(function(){
            if (this.value == 'Installment' || this.value == 'Cash')
            {
                if ($("#grade_level").val() !== '')
                {
                    $('.tuition').removeClass('hidden');
                    if (this.value == 'Cash')
                    {
                        $('.installment').addClass('hidden');
                        $('#school_fees').removeAttr('required','required');
                        $('#modules_ebook').removeAttr('required','required');
                    }
                    else
                    {
                        $('.installment').removeClass('hidden');
                        $('#school_fees').attr('required','required');
                        $('#modules_ebook').attr('required','required');
                    }
                    if ($("#grade_level").val() > 10)
                    {
                        loadData('Senior');
                    }
                    else
                    {
                        loadData('Junior');
                    }
                }
                else
                {
                    $("#payment_method").val('');
                    Toast.fire({
                        icon: 'error',
                        title: 'Please select grade level.'
                    });
                }
            }
            else
            {
                $('.tuition').addClass('hidden');
                $('.installment').addClass('hidden');
                $('#school_fees').removeAttr('required','required');
                $('#modules_ebook').removeAttr('required','required');
            }
        });

        function loadData(high_school)
        {
            var btn_action = 'fetch_tuition_plan';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{btn_action:btn_action, high_school:high_school},
                dataType:"json",
                success:function(data)
                {
                    
                    $('.sf_one_year').html( (parseFloat(data.sf_one_year) ).toFixed(2) );
                    
                    $('.me_one_year').html( (parseFloat(data.me_one_year) ).toFixed(2) );
                    
                    $('.sf_ue_a').html(data.sf_ue_a);
                    $('.sf_aug_a').html(data.sf_aug_a);
                    $('.sf_sep_a').html(data.sf_sep_a);
                    $('.sf_oct_a').html(data.sf_oct_a);
                    $('.sf_nov_a').html(data.sf_nov_a);
                    $('.sf_dec_a').html(data.sf_dec_a);
                    $('.sf_jan_a').html(data.sf_jan_a);
                    $('.sf_feb_a').html(data.sf_feb_a);
                    $('.sf_mar_a').html(data.sf_mar_a);
                    $('.sf_apr_a').html(data.sf_apr_a);
                    $('.sf_may_a').html(data.sf_may_a);
                    
                    $('.sf_ue_b').html(data.sf_ue_b);
                    $('.sf_aug_b').html(data.sf_aug_b);
                    $('.sf_sep_b').html(data.sf_sep_b);
                    $('.sf_oct_b').html(data.sf_oct_b);
                    $('.sf_nov_b').html(data.sf_nov_b);
                    $('.sf_dec_b').html(data.sf_dec_b);
                    $('.sf_jan_b').html(data.sf_jan_b);
                    $('.sf_feb_b').html(data.sf_feb_b);
                    $('.sf_mar_b').html(data.sf_mar_b);
                    $('.sf_apr_b').html(data.sf_apr_b);
                    $('.sf_may_b').html(data.sf_may_b);
                    
                    $('.sf_ue_c').html(data.sf_ue_c);
                    $('.sf_aug_c').html(data.sf_aug_c);
                    $('.sf_sep_c').html(data.sf_sep_c);
                    $('.sf_oct_c').html(data.sf_oct_c);
                    $('.sf_nov_c').html(data.sf_nov_c);
                    $('.sf_dec_c').html(data.sf_dec_c);
                    $('.sf_jan_c').html(data.sf_jan_c);
                    $('.sf_feb_c').html(data.sf_feb_c);
                    $('.sf_mar_c').html(data.sf_mar_c);
                    $('.sf_apr_c').html(data.sf_apr_c);
                    $('.sf_may_c').html(data.sf_may_c);
                    
                    $('.me_ue_a').html(data.me_ue_a);
                    $('.me_aug_a').html(data.me_aug_a);
                    $('.me_sep_a').html(data.me_sep_a);
                    $('.me_oct_a').html(data.me_oct_a);
                    $('.me_nov_a').html(data.me_nov_a);
                    $('.me_dec_a').html(data.me_dec_a);
                    $('.me_jan_a').html(data.me_jan_a);
                    $('.me_feb_a').html(data.me_feb_a);
                    $('.me_mar_a').html(data.me_mar_a);
                    $('.me_apr_a').html(data.me_apr_a);
                    $('.me_may_a').html(data.me_may_a);
                    
                    $('.me_ue_b').html(data.me_ue_b);
                    $('.me_aug_b').html(data.me_aug_b);
                    $('.me_sep_b').html(data.me_sep_b);
                    $('.me_oct_b').html(data.me_oct_b);
                    $('.me_nov_b').html(data.me_nov_b);
                    $('.me_dec_b').html(data.me_dec_b);
                    $('.me_jan_b').html(data.me_jan_b);
                    $('.me_feb_b').html(data.me_feb_b);
                    $('.me_mar_b').html(data.me_mar_b);
                    $('.me_apr_b').html(data.me_apr_b);
                    $('.me_may_b').html(data.me_may_b);

                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        }
        
        $('#btn_prev').click(function(){
            if (steps == 1)
            {
                $('#btn_prev').addClass('hidden'); 
                $('.page_one').removeClass('hidden');
                $('.page_two').addClass('hidden');
                steps = 0;

                $('#g_fullname').removeAttr('required','required');
                $('#g_contact').removeAttr('required','required');
                $('#g_relationship').removeAttr('required','required');
                $('#g_occupation').removeAttr('required','required');
                $('#g_address').removeAttr('required','required');
            }
            else if (steps == 2)
            {
                $('.page_two').removeClass('hidden');
                $('.page_three').addClass('hidden');
                steps = 1;
                $('#report_card1').removeAttr('required','required');
                $('#report_card2').removeAttr('required','required');
                $('#psa').removeAttr('required','required');
                $('#certificate').removeAttr('required','required');
            }
            else if (steps == 3)
            {
                $('.page_three').removeClass('hidden');
                $('.page_four').addClass('hidden');
                steps = 2;
                $('#action').html('<i class="fa fa-arrow-right text-white"></i> Next');
                $('#payment_method').removeAttr('required','required');
                $('#visitor_name').removeAttr('required','required');
            }
        });
    
        let steps = 0;
        $(document).on('submit','#forms', function(event){
            event.preventDefault();
            if (steps == 0)
            {
                var btn_action = 'lrn_validation';
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{btn_action:btn_action, lrn:$('#lrn').val(), email:$('#email').val(), student_status:$('#student_status').val()
                        , last_name:$('#last_name').val(), first_name:$('#first_name').val(), middle_name:$('#middle_name').val()
                        , extension_name:$('#extension_name').val()},
                    dataType:"json",
                    success:function(data)
                    {
                        if (data.status)
                        {
                            status = true;
                            Toast.fire({
                                icon: 'error',
                                title: data.message
                            });
                        }
                        else
                        {
                            $('.page_one').addClass('hidden');
                            $('.page_two').removeClass('hidden');
                            $('#btn_prev').removeClass('hidden');
                            steps = 1;

                            $('#g_fullname').attr('required','required');
                            $('#g_contact').attr('required','required');
                            $('#g_relationship').attr('required','required');
                            $('#g_occupation').attr('required','required');
                            $('#g_address').attr('required','required');
                        }
                    },error:function()
                    {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong.'
                        });
                    }
                })
            }
            else if (steps == 1)
            {
                $('.page_two').addClass('hidden');
                $('.page_three').removeClass('hidden');
                steps = 2;
                $('#report_card1').attr('required','required');
                $('#report_card2').attr('required','required');
                $('#psa').attr('required','required');
                $('#certificate').attr('required','required');
            }
            else if (steps == 2)
            {
                $('.page_three').addClass('hidden');
                $('.page_four').removeClass('hidden');
                steps = 3;
                $('#action').html('<i class="fa fa-save text-white"></i> Submit');
                $('#payment_method').attr('required','required');
                $('#visitor_name').attr('required','required');
            }
            else
            {
                $('#action').attr('disabled','disabled');
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    dataType:"json",
                    success:function(data)
                    {
                        $('#action').attr('disabled', false);
                        if (data.status == true)
                        {
                            $('.img-profile').attr('src', 'assets/avatar/default.jpg');
                            $('#forms')[0].reset();
                            $('#strand_id').attr('disabled','disabled').removeAttr('required','required').val('');
                            $('.tuition').addClass('hidden');
                            $('.installment').addClass('hidden');
                            $('#school_fees').removeAttr('required','required');
                            $('#modules_ebook').removeAttr('required','required');
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                            steps = 0;
                            $('#action').html('<i class="fa fa-arrow-right text-white"></i> Next');
                            $('#btn_prev').addClass('hidden');
                            $('.page_one').removeClass('hidden');
                            $('.page_two').addClass('hidden');
                            $('.page_three').addClass('hidden');
                            $('.page_four').addClass('hidden');
                            // required
                            $('#lrn').attr('required','required');
                            $('#grade_level').attr('required','required');
                            $('#email').attr('required','required');
                            $('#last_name').attr('required','required');
                            $('#first_name').attr('required','required');
                            $('#date_birth').attr('required','required');
                            $('#sex').attr('required','required');
                            $('#nationality').attr('required','required');
                            $('#last_attended').attr('required','required');
                            $('#contact').attr('required','required');

                            $('#g_fullname').removeAttr('required','required');
                            $('#g_contact').removeAttr('required','required');
                            $('#g_relationship').removeAttr('required','required');
                            $('#g_occupation').removeAttr('required','required');
                            $('#g_address').removeAttr('required','required');

                            $('#report_card1').removeAttr('required','required');
                            $('#report_card2').removeAttr('required','required');
                            $('#psa').removeAttr('required','required');
                            $('#certificate').removeAttr('required','required');

                            $('#payment_method').removeAttr('required','required');
                            $('#visitor_name').removeAttr('required','required');
                        }
                        else 
                        {
                            Toast.fire({
                                icon: 'error',
                                title: data.message
                            });
                        }
                    },error:function()
                    {
                        $('#action').attr('disabled', false);
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong.'
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