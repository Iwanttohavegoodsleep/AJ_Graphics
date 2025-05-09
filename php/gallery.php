<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AJ Graphics</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="gallery.css" />
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
    <?php include_once "navbar.php"; ?>

    <section class="gallery">
      <h2>Gallery</h2>
      <p>Here are some of our works. Click on the images to view them in full size.</p>
      <br>
      <div class="gallery-grid">
          <div class="gallery-item">
              <img src="placeholder.jpg" alt="Placeholder Image">
          </div>
          <div class="gallery-item">
              <img src="placeholder.jpg" alt="Placeholder Image">
          </div>
          <div class="gallery-item">
              <img src="placeholder.jpg" alt="Placeholder Image">
          </div>
          <div class="gallery-item">
              <img src="placeholder.jpg" alt="Placeholder Image">
          </div>
          <div class="gallery-item">
              <img src="placeholder.jpg" alt="Placeholder Image">
          </div>
          <div class="gallery-item">
              <img src="placeholder.jpg" alt="Placeholder Image">
          </div>
          <!-- Add more gallery items as needed -->
      </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <?php include_once "footer.php"?>
</body>
</html>
