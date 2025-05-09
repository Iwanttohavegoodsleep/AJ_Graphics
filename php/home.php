<?php 
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AJ Graphics</title>
    <link rel="stylesheet" href="styles.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/eedbcd0c96.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
   
  <?php include_once "navbar.php";?>
    <section id="hero">
      <h2>Welcome to AJ Graphics</h2>
      <h1>High Quality Printing & Designing</h1>
      <p>I dont know what to put</p>
      <button>Place Order Now</button>
    </section>

    <section id="feature" class="section-p1">
      <div class="featurebox">
        <img src="imgs/fs.png" alt="" class="fsimg" />
        <h5>Order Online</h5>
      </div>
      <div class="featurebox">
        <img src="imgs/oo.png" alt="" class="fsimg" />
        <h5>Pick-up & Delivery</h5>
      </div>
      <div class="featurebox">
        <img src="imgs/pp.png" alt="" class="fsimg" />
        <h5>Promotions</h5>
      </div>
      <div class="featurebox">
        <img src="imgs/hs.png" alt="" class="fsimg" />
        <h5>Customization</h5>
      </div>
      <div class="featurebox">
        <img src="imgs/tss.png" alt="" class="fsimg" />
        <h5>Support</h5>
      </div>
    </section>

    <section id="product1" class="section-p1">
      <h2>POPULAR SERVICES</h2>
      <p>High Quality Printing and Graphics</p>
      <div class="pro-cont js-pro-cont"></div>
    </section>
    
    <!-- this can be used for banners later on like announcements -->
    <!-- <section id="banner">
      <h2>First <span>25 Customers</span> to use the code on our Facebook gets <span>5% off!</span></h2>
      <button class="button-normal">ORDER NOW</button>
    </section> -->

    <section id="chotu1banner" class="section-p1">
      <div class="bannerbox">
        <h4>Printing</h4>
        <h3>Tarpaulines, T-Shirts, Souvenirs, Documents & More!</h3>
        <span>Request for prints here!</span>
        <button class="button-transparent">See More</button>
      </div>

      <div class="bannerbox">
        <h4>Designing</h4>
        <h3>Graphic Design, Logo Design, Invitations & More!</h3>
        <span>Choose from a template or request one here!</span>
        <button class="button-transparent">See More</button>
      </div>
    </section>

    <!-- <section id="banner3" class="section-p1">
      <div class="bannerbox">
        <h2>Tarpaulines & Documents</h2>
        <h3>Convenient Printing</h3>
      </div>

      <div class="bannerbox">
        <h2>T-shirts & Accessories</h2>
        <h3>Customized Vanity</h3>
      </div>

      <div class="bannerbox">
        <h2>Design</h2>
        <h3>Quality Designs</h3>
      </div>
    </section> -->

    <footer class="section-p1">
      <div class="col">
        <img src="#" alt="" class="footlogo" />
        <h4>Contact</h4>
        <p>
          <strong>Address : </strong> Cayawan, Malimono, Surigao dN 00372 Vasquez st., Surigao City
        </p>
        <p><strong>Phone : </strong>+63 09126669209/09486760479/tel. 086-827-1080</p>
        <p><strong>Email : </strong>ajgraphics.surigao2023@gmail.com</p>

        <div class="follow">
          <h4>Follow Us</h4>
          <div class="icon">
            <i class="fab fa-facebook"></i>
            <i class="fab fa-instagram"></i>
            <i class="fab fa-youtube"></i>
          </div>
        </div>
      </div>

      <div class="col">
        <h4>About</h4>
        <a href="#">About Us</a>
        <a href="#">Delivery Information</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Terms & Conditions</a>
        <a href="#">Contact Us</a>
      </div>

      <div class="col">
        <h4>Secured payment Gateways</h4>
        <img src="imgs/ppay.png" alt="" class="footlogo3" />
        <a href="">Bank</a>
        <a href="">G Cash</a>
        <a href="">QR Ph</a>
        <a href="">MayaPay</a>
      </div>

      <div class="copyright">
        <p>Copyright @ 2025 by AJ Graphics</p>
      </div>
    </footer>

    <script src="scripts/cart.js"></script>
    <script src="scripts/products.js"></script>
    <script src="home.js"></script>
  </body>
</html>
