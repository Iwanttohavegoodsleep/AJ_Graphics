<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AJ Graphics</title>
    <link rel="stylesheet" href="contact.css" />

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
    <div class="container">
        <h1>Contact Us</h1>
        
        <div class="contact-info">
            <h4>Contact Information</h4>
            <p><strong>Address:</strong> Cayawan, Malimono, Surigao del Norte<br>
                00372 Vasquez St., Surigao City</p>
            <p><strong>Phone:</strong> +63 912 666 9209 / +63 948 676 0479<br>
                Tel: (086) 827-1080</p>
            <p><strong>Email:</strong> ajgraphics.surigao2023@gmail.com</p>
        </div>

        <form class="contact-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="your@email.com" required>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Subject" required>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Your message here..." required></textarea>
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</body>
</html>