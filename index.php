<!--connect file-->
<?php

include('D:\Restaurantly\Restaurantly\includes\connect.php');
include('D:\Restaurantly\Restaurantly\Admin\functions\common_function.php');
session_start(); // Start the session
?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pre Cooked</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

   <!-- 
    - preload images
  -->
  
<link rel="preload" as="image" href="assets/img/image.jpeg">
<link rel="preload" as="image" href="assets/img/image.jpeg">
<link rel="preload" as="image" href="assets/img/image.jpeg">
  <!-- Favicons -->
 <!--search bar-->
 <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Restaurantly
  * Template URL: https://bootstrapmade.com/restaurantly-restaurant-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header fixed-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">wanjikul598@gmail.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+254 796776208</span></i>
        </div>
        <div class="languages d-none d-md-flex align-items-center">
          <ul>
            <li>En</li>
            <li><a href="#">De</a></li>
          </ul>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename">Pre Cooked</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="active">Home<br></a></li>
            <li><a href="#foods-section">Foods</a></li>
            <li><a href="#gallery">Gallary</a></li>
            <li><a href="#testimonials">Testimonials</a></li>
            <li><a href="#why-us">About</a></li>
            <li><a href="#contact">Contact</a></li>
           
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-book-a-table d-none d-xl-block" href="#foods-section">Order Now</a>
        <a  href="cart.php" class="cart-icon d-none d-xl-inline-block">
          <!-- SVG version -->
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
          </svg>
          <sup><?php cart_item(); ?></sup>
        </a>
        <li class="nav-item"><a class="nav-link" href="#">Total Price kshs
             <?php
          total_cart_price();
          ?>/-</a>
        </li>
      </div>

    </div>

  </header>
  <?php
    cart();
    ?>

  <main class="main">

   <!-- 
        - #HERO
      -->

      <section class="hero text-center" aria-label="home" id="home">

        <ul class="hero-slider" data-hero-slider>

          

         <li class="slider-item active" data-hero-slider-item>

            <div class="slider-bg">
              <img src="assets\img\imageHomepage.jpeg" width="500px" height="550px" alt="" class="img-cover">
            </div>
          
            <p class="label-2 section-subtitle slider-reveal">Fresh & Nutritious</p>
          
            <h1 class="display-1 hero-title slider-reveal">
              Convenience in Every <br>
              Bite of Health
            </h1>
          
            <p class="body-2 hero-text slider-reveal">
              Enjoy the wholesome goodness of pre-cooked cereals & legumes <br>
              delivered to your doorstep—saving you time, effort, and energy.
            </p>
          
            <a href="#foods-section" class="btn btn-primary slider-reveal">
              <span class="text text-1">Order Now</span>
          
              <span class="text text-2" aria-hidden="true">Order Now</span>
            </a>
          
          </li>
          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="assets\img\imageHomepage.jpeg" width="500px" height="550px" alt="" class="img-cover">
            </div>
          
            <p class="label-2 section-subtitle slider-reveal">Fresh & Nutritious</p>
          
            <h1 class="display-1 hero-title slider-reveal">
              Convenience in Every <br>
              Bite of Health
            </h1>
          
            <p class="body-2 hero-text slider-reveal">
              Enjoy the wholesome goodness of pre-cooked cereals & legumes <br>
              delivered to your doorstep—saving you time, effort, and energy.
            </p>
          
            <a href="#foods-section" class="btn btn-primary slider-reveal">
              <span class="text text-1">Order Now</span>
          
              <span class="text text-2" aria-hidden="true">Order Now</span>
            </a>
          
          </li>
          
          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="assets\img\imageHomepage.jpeg" width="500px" height="550px" alt="" class="img-cover">
            </div>
          
            <p class="label-2 section-subtitle slider-reveal">Fresh & Nutritious</p>
          
            <h1 class="display-1 hero-title slider-reveal">
              Convenience in Every <br>
              Bite of Health
            </h1>
          
            <p class="body-2 hero-text slider-reveal">
              Enjoy the wholesome goodness of pre-cooked cereals & legumes <br>
              delivered to your doorstep—saving you time, effort, and energy.
            </p>
          
            <a href="#" class="btn btn-primary slider-reveal">
              <span class="text text-1">Order Now</span>
          
              <span class="text text-2" aria-hidden="true">Order Now</span>
            </a>
          
          </li>
          
          

        </ul>

        <button class="slider-btn prev" aria-label="slide to previous" data-prev-btn>
          <ion-icon name="chevron-back"></ion-icon>
        </button>

        <button class="slider-btn next" aria-label="slide to next" data-next-btn>
          <ion-icon name="chevron-forward"></ion-icon>
        </button>

        

      </section>


     


<!--search bar-->
<div class="container">
  <br/>
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <form class="custom-search-form" action="searchproduct.php" method="get">
        <div class="input-group">
          <input type="search" class="form-control custom-search-input" placeholder="Search topics or keywords" name="search_data" aria-label="Search">
          
          <div class="input-group-append">
            <button class="btn custom-search-button" type="submit">Search</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!--calling cart function-->


  
<!--Product Card-->
<div id="foods-section" class="container">
  <h1>Our Pre-cooked Products</h1>
  <div class="products-grid">
      <?php getproducts(); 
      $get_ip_address = getIPAddress();
     ?>
      
  </div>
</div>

   



   

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Gallery</h2>
        <p>Some photos from Pre Cooked</p>
      </div><!-- End Section Title -->

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-0">

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/hero-slider-1.jpeg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/hero-slider-1.jpeg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/legum1.jpeg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/legum1.jpeg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/Typebeans.jpeg" class="glightbox" height="100"  data-gallery="images-gallery">
                <img src="assets/img/gallery/Typebeans.jpeg" height="100" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/hero-slider-3.jpeg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/hero-slider-3.jpeg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/beanswashing.jpeg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/beanswashing.jpeg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/blackbeans.jpeg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/blackbeans.jpeg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/Lugumes.jpg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/Lugumes.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/githeri.jpeg" class="glightbox" data-gallery="images-gallery">
                <img src="assets/img/gallery/githeri.jpeg" alt="" class="img-fluid">
              </a>
            </div>
          </div><!-- End Gallery Item -->

        </div>

      </div>

    </section><!-- /Gallery Section -->

   <!-- Testimonials Section -->
   <section id="testimonials" class="testimonials section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Testimonials</h2>
      <p>What they're saying about us</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="swiper init-swiper" data-speed="600" data-delay="5000" data-breakpoints="{ &quot;320&quot;: { &quot;slidesPerView&quot;: 1, &quot;spaceBetween&quot;: 40 }, &quot;1200&quot;: { &quot;slidesPerView&quot;: 3, &quot;spaceBetween&quot;: 40 } }">
        <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": "auto",
            "pagination": {
              "el": ".swiper-pagination",
              "type": "bullets",
              "clickable": true
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 1,
                "spaceBetween": 40
              },
              "1200": {
                "slidesPerView": 3,
                "spaceBetween": 20
              }
            }
          }
        </script>
        <div class="swiper-wrapper">

          <div class="swiper-slide">
            <div class="testimonial-item" "="">
          <p>
            <i class=" bi bi-quote quote-icon-left"></i>
              <span>Having pre-boiled beans and Ndengu ready to go has been such a time-saver for me. I can quickly prepare a delicious meal with minimal effort, and it tastes just like home-cooked food. I highly recommend these to anyone looking for convenience without sacrificing flavor!</span>
              <i class="bi bi-quote quote-icon-right"></i>
              </p>
              <img src="assets/img/testimonials/Testimony1.jpeg" class="testimonial-img" alt="">
              <h3>Saul Goodman</h3>
              <h4>Satisfied Customer  </h4>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>I’ve always loved Githeri, but boiling the beans and maize together was such a hassle. Thanks to these pre-boiled meals, I can skip all that and still enjoy the rich flavors. The convenience is unmatched, and the taste is fantastic!</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
              <img src="assets/img/testimonials/Testimony2.jpeg" class="testimonial-img" alt="">
              <h3>Sara Wilsson</h3>
              <h4>Delighted Customer</h4>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Boiling Ndengu used to take forever, but now I don’t have to worry about it. The pre-boiled version is a game-changer—so quick and easy to prepare. I can now enjoy my favorite meals with minimal effort and still get the same great taste!</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
              <img src="assets/img/testimonials/Testimony3.jpeg" class="testimonial-img" alt="">
              <h3>Jena Karlis</h3>
              <h4> Loyal Customer</h4>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>As someone with a busy lifestyle, I don’t have time to boil beans and prepare traditional meals from scratch. These pre-boiled options, like Githeri and Ndengu, have made it so much easier. I can enjoy authentic meals in no time, and the convenience is unbeatable!</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
              <img src="assets/img/testimonials/Testimony6.jpeg" class="testimonial-img" alt="">
              <h3>Matt Brandon</h3>
              <h4>Happy Customer</h4>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>I’ve never had such an easy way to enjoy Githeri and Beans! The pre-boiled meals are a huge time-saver, and they taste just as fresh as if I’d cooked them myself. This is perfect for when I want a quick, nutritious meal without spending hours in the kitchen</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
              <img src="assets/img/testimonials/Testimony5.jpg" class="testimonial-img" alt="">
              <h3>John Larson</h3>
              <h4>Satisfied Customer</h4>
            </div>
          </div><!-- End testimonial item -->

        </div>
        <div class="swiper-pagination"></div>
      </div>

    </div>

  </section><!-- /Testimonials Section -->

   <!-- Why Us Section -->
<section id="why-us" class="why-us section">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>About Us</h2>
  <p>Why Choose Pre-Boiled Foods</p>
</div><!-- End Section Title -->

<div class="container">

  <div class="row gy-4">

    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
      <div class="card-item">
        <span>01</span>
        <h4><a href="" class="stretched-link">Convenience</a></h4>
        <p>Our pre-boiled meals save you time in the kitchen, allowing you to enjoy traditional dishes like Githeri, Ndengu, and Beans without hours of cooking.</p>
      </div>
    </div><!-- Card Item -->

    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
      <div class="card-item">
        <span>02</span>
        <h4><a href="" class="stretched-link">Quality Ingredients</a></h4>
        <p>We source only the finest ingredients to ensure that every bite of our pre-boiled foods is fresh, nutritious, and full of flavor.</p>
      </div>
    </div><!-- Card Item -->

    
    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
        <div class="card-item">
          <span>03</span>
          <h4><a href="" class="stretched-link">Doorstep Delivery</a></h4>
          <p>We offer convenient doorstep delivery, bringing your pre-boiled meals right to your door, so you can enjoy delicious, home-style meals without leaving your home.</p>
        </div>
      </div><!-- Card Item -->

  </div>

</div>

</section>
<!-- /Why Us Section -->
    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Contact Us</p>
      </div><!-- End Section Title -->

     
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Location</h3>
                <p>Limuru,Kenya</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Open Hours</h3>
                <p>Monday-Saturday:<br>10:00 AM - 11:00 PM</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+!254 796776208</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>wanjikul598@gmail.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->
    

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Pre Cooked</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Limuru,Kenya</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+254 796776208</span></p>
            <p><strong>Email:</strong> <span>wanjikul598@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        
    <div class="col-lg-2 col-md-3 footer-links">
      <h4>Useful Links</h4>
      <ul>
      <li><a href="#hero" class="active">Home<br></a></li>
            <li><a href="#foods-section">Foods</a></li>
            <li><a href="#gallery">Gallary</a></li>
            <li><a href="#testimonials">Testimonials</a></li>
            <li><a href="#why-us">About</a></li>
            <li><a href="#contact">Contact</a></li>
      </ul>
    </div>

        <div class="col-lg-2 col-md-3 footer-links">
      <h4>Our Services</h4>
      <ul>
        <li><a href="#">Pre-Boiled Legumes </a></li>
        <li><a href="#">Doorstep Delivery</a></li>
        <li><a href="#">Bulk Orders</a></li>
       
      </ul>
    </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"  placeholder="Enter Email" ><input type="submit"value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Pre Cooked</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">Lucy Mwaura</a>
      </div>
    </div>

  </footer>



  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <!--search bar script-->
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>