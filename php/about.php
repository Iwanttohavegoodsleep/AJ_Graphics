<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />

    <script
      src="https://kit.fontawesome.com/eedbcd0c96.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <?php include_once "navbar.php"; ?>

    <section id="pageheader" class="aboutheader">
      
    </section>

    <div id="aboutdiv" class="section-p1">
      <img src="aboutUs.jpg" alt="" />
      <div>
        <h2>Who are we ?</h2>
        <p>
          At AJ Graphics Printing Services, we help bring your ideas to life with high-quality printing. Whether you need business cards, flyers, posters, or custom items, we make sure every print looks great.
          Our team is passionate about creating prints that stand out. We use the latest technology to give you clear, vibrant, professional results, quickly and at a fair price.
          From design to final print, we ensure every project meets the highest standards. Let's make your vision a reality, because when it comes to printing, quality matters.
        </p>

        <marquee behavior="" direction=""
          >Print with Quality, Stand Out with Style!
        </marquee
        >
      </div>
    </div>

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

    <script src="scripts/cart.js"></script>
    <script src="scripts/products.js"></script>
    <script src="home.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <?php include_once "footer.php"?>
  </body>
</html>
