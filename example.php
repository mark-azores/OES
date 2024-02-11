<!DOCTYPE html>
<html lang="en">
<!--divinectorweb.com-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Enrollement System</title>
    <link rel="icon" href="assets/logo.jpg" type="image/ico">
    
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500&display=swap" rel="stylesheet">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css" rel="stylesheet">
	<!-- <link href="style.css" rel="stylesheet"> -->
  
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: poppins;
        }
        ul, ul.nav {
            list-style: none;
        }
        a {
            text-decoration: none;
            cursor: pointer;
            color: inherit;
        }
        header {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            width: 100%;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
            padding: 35px 100px 0;
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
            }
            header h2 {
                margin-bottom: 15px;
            }
            header ul.nav li {
                margin: 0 7px;
            }
            .about-right p {
                display: none;
            }
        }

        /*banner area*/
        section {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 110px 100px;
            color: #000;
        }
        @media (max-width:1000px) {
            section {
                padding: 100px 50px;
            }
        }
        @media (max-width:600px) {
            section {
                padding: 125px 30px;
            }
        }
        section p {
            max-width: 800px;
            text-align: center;
            margin-bottom: 35px;
            padding: 0 20px;
            line-height: 2;
        }
        .banner-area {
            position: relative;
            justify-content: center;
            min-height: 100vh;
            color: #fff;
            text-align: center;
        }
        .banner-area .banner-img {
            background-image: url(assets/bg.jpg);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            -webkit-background-size: cover;
            background-size: cover;
            z-index: -1;
            background-position: center center;
        }
        .banner-area .banner-img::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000;
            opacity: .7;
        }
        .banner-area h1 {
            margin-bottom: 15px;
            font-size: 65px;
            text-transform: uppercase;
        }
        .banner-area h1 span {
            color: #bf0a30;
        }
        .banner-area h3 {
            font-size: 25px;
            font-weight: 100;
            text-transform: uppercase;
        }
        .banner-area a.banner-btn {
            padding: 15px 35px;
            background: #bf0a30;
            text-transform: uppercase;
        }
        @media (max-width:800px) {
            /* .banner-area {
                min-height: 600px;
            } */
            .banner-area h1 {
                font-size: 27px;
            }
            .banner-area h3 {
                font-size: 20px;
            }
            .banner-area a.banner-btn {
                padding: 8px 20px;
            }
        }

        /*about area*/
        ul.about-content {
            width: 100%;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .about-content li {
            padding: 20px;
            height: 500px;
            background-clip: content-box;
            -webkit-background-size: cover;
            background-size: cover;
            background-position: center;
        }
        .about-left {
            flex-basis: 30%;
            background-image: url(assets/bg.jpg);
        }
        .about-right {
            flex-basis: 70%;
        }
        .about-right h2 {
            font-size: 35px;
        }
        .about-area p {
            max-width: 800px;
            margin-bottom: 35px;
            line-height: 1.5;
            text-align: left;
            padding-left: 0;
        }
        .section-title {
            text-transform: uppercase;
            font-size: 50px;
            margin-bottom: 5%;
        }
        .section-title span {
            color: #bf0a30;
        }
        .about-right h2 {
            margin-bottom: 3%;
        }
        .about-btn {
            padding: 15px 35px;
            background: #bf0a30;
            border-radius: 50px;
            text-transform: uppercase;
            color: #fff;
        }
        @media (max-width: 1000px) {
            .section-title {
                font-size: 35px;
            }
            .about-left, .about-right {
                flex-basis: 100%;
            }
            .about-content li {
                padding: 8px;
            }
        }

        /*msg area*/
        .msg-area {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(assets/bg.jpg);
            -webkit-background-size: cover;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            color: #fff;
            text-align: center;
        }

        /*service area*/
        ul.services-content {
            width: 100%;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .services-content li {
            padding: 0 30px;
            flex-basis: 33%;
            text-align: center;
        }
        .services-content img {
            width: 100%;
            margin-bottom: 20px;
        }
        .services-content li h4 {
            font-size: 20px;
            margin-bottom: 25px;
            text-transform: uppercase;
            font-weight: 500;
            letter-spacing: 3px;
        }
        .services-content li p {
            margin: 0;
        }
        @media (max-width:1000px) {
            .services-content li {
                flex-basis: 100%;
                margin-bottom: 65px;
            }
            .services-content li:last-child {
                margin-bottom: 0;
            }
            .services-content li p {
                padding: 0;
            }
        }

        /*contact area*/
        ul.contact-content {
            width: 100%;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .contact-content li {
            padding: 0 30px;
            flex-basis: 33%;
            text-align: center;
        }
        .contact-content li i {
            font-size: 50px;
            color: #bf0a30;
            margin-bottom: 25px;
        }
        .contact-content li p {
            margin: 0;
        }
        @media (max-width: 1000px) {
            .contact-content li {
                flex-basis: 100%;
                margin-bottom: 65px;
            }
            .contact-content li:last-child {
                margin-bottom: 0;
            }
            .contact-content li p {
                padding: 0;
            }
        }

        /*footer*/
        footer {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: #fff;
            background-color: #000;
            padding: 60px 0;
        }

    </style>
</head>
<body>
	<header>
		<h2><a href="#"><img alt="Logo" src="assets/logo.jpg"></a></h2>
		<ul class="nav">
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#about">About</a>
			</li>
			<!-- <li>
				<a href="#services">Services</a>
			</li> -->
			<li>
				<a href="#contact">Contact</a>
			</li>
		</ul>
	</header>
	<section class="banner-area">
		<div class="banner-img"></div>
		<h3>We Help to get things Done</h3>
		<h1>God is <span>Almigthy</span></h1><a class="banner-btn" href="#">More Info</a>
	</section>
	<section class="about-area" id="about">
		<h3 class="section-title">About <span>Us</span></h3>
		<ul class="about-content">
			<li class="about-left"></li>
			<li class="about-right">
				<h2>We are Taking Small Steps to Make Earth Better Planet of the universe</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam excepturi, similique aut nesciunt, illo tenetur deleniti ab soluta nisi impedit ipsam consectetur magni! Atque sunt voluptate fuga, perspiciatis corrupti maiores dignissimos deserunt cupiditate, nihil inventore. Lorem ipsum dolor sit amet</p>
				<p><i class="fa fa-arrow-right"></i> Lorem ipsum dolor sit amet</p>
				<p><i class="fa fa-arrow-right"></i> deleniti ab soluta nisi impedit</p>
				<p><i class="fa fa-arrow-right"></i> maiores dignissimos deserunt cupiditate</p>
				<p><i class="fa fa-arrow-right"></i> illo tenetur deleniti ab soluta nisi</p>
			</li>
		</ul>
	</section>
	<section class="msg-area">
		<div class="msg-content">
			<h2>Quote of the day</h2>
			<p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam excepturi, similique aut nesciunt, illo tenetur deleniti ab soluta"</p>
		</div>
	</section>
	<section class="services-area" id="services">
		<h3 class="section-title">Our <span>Offers</span></h3>
		<ul class="services-content">
			<li>
				<img alt="" src="assets/bg.jpg">
				<h4>Prayer</h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, reprehenderit.</p>
			</li>
			<li>
				<img alt="" src="assets/bg.jpg">
				<h4>offerings</h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, reprehenderit.</p>
			</li>
			<li>
				<img alt="" src="assets/bg.jpg">
				<h4>Blessings</h4>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, reprehenderit.</p>
			</li>
		</ul>
	</section>
	<section class="contact-area" id="contact">
		<h3 class="section-title">Our <span>Contact</span></h3>
		<ul class="contact-content">
			<li>
				<i class="fa fa-map-marker"></i>
				<p>129, New York<br>
				United States</p>
			</li>
			<li>
				<i class="fa fa-phone"></i>
				<p>+123 456 789<br>
				+789 456 123</p>
			</li>
			<li>
				<i class="fa fa-envelope"></i>
				<p>info@bishop.com<br>
				yourdomain@website.com</p>
			</li>
		</ul>
	</section>
	<footer>
		<p>All Right Reserved by Your Website</p>
	</footer>
</body>
</html>
