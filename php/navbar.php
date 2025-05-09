<!-- navbar.php -->
<style>
  * {
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
  }

  body {
    width: 100%;
  }

  #header {
    display: flex;
    justify-content: space-between;
    align-items: center; 
    background: linear-gradient(to right, lightgreen, cyan);
    box-shadow: 0 40px 60px rgba(0, 0, 0, 0.1);
    padding: 8px 95px;
    position: sticky;
    top: 0;
    z-index: 999;
    height: 70px;
  }

  .logo {
    height: 55px;
    display: flex;
    align-items: center;
  }

  .imglogo {
    width: 100%;
    height: 100%;
  }

  #navbar {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    background: none;
    height: 100%;
    margin: 0;
    padding: 0;
  }

  #navbar li {
    list-style: none;
    padding: 0 20px;
    position: relative;
    display: flex;
    align-items: center;
    height: 100%;
    margin: 0;
  }

  #navbar li a {
    color: black;
    font-size: 1.2rem;
    font-weight: 600;
    letter-spacing: 1.5px;
    text-decoration: none;
    transition: 0.5s ease;
    display: flex;
    align-items: center;
    height: 100%;
  }

  #navbar li a:hover {
    background: #ceffff;
    border-radius: 4px;
    padding: 2px 10px;
    color: black;
  }

  #navbar li a.active,
  #navbar li a:hover::after {
    color: black;
    background-color: transparent;
    bottom: -4px;
    content: "";
    height: 2px;
    left: 20px;
    position: absolute;
    width: 30%;
  }

  .fa-solid {
    background: none;
  }

  #mobile {
    display: none;
  }

  .pmo {
    display: flex; 
    flex-direction: row;
    align-items: center;
    height: 100%;
    margin: 0;
    padding: 0;
  }

  /* Cart icon specific styles */
  #shopbag {
    color: #2c3e50;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
  }

  #shopbag:hover {
    color: #00CED1;
    transform: scale(1.1);
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
    #header {
      padding: 0.5rem 3%;
    }

    #navbar li a {
      font-size: 0.9rem;
      padding: 0.5rem 0.8rem;
    }
  }

  @media (max-width: 768px) {
    #header {
      padding: 0.5rem 2%;
    }

    #navbar {
      display: none;
      position: absolute;
      top: 80px;
      left: 0;
      width: 100%;
      background: white;
      flex-direction: column;
      padding: 1rem 0;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #navbar.active {
      display: flex;
    }

    #navbar li {
      width: 100%;
      padding: 0.5rem 0;
    }

    #navbar li a {
      width: 100%;
      padding: 0.8rem 2rem;
      justify-content: flex-start;
    }

    #mobile {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .mobile-icon {
      font-size: 1.5rem;
      color: #2c3e50;
      cursor: pointer;
    }
  }
</style>

<section id="header">
  <div class="logo">
    <a href="home.php">
      <img src="AJ_Logo.png" alt="Logo" class="imglogo" />
    </a>
  </div>

  <div class="pmo">
    <ul id="navbar">
      <li><a href="home.php">Home</a></li>
      <li><a href="select_category.php">Products</a></li>
      <li><a href="gallery.php">Gallery</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact</a></li>
      <?php if (isset($_SESSION['logged_in'])): ?>
      <?php if ($_SESSION['username'] === 'admin'): ?>
      <li><a href="admin.php">Admin</a></li>
      <?php else: ?>
      <li><a href="account.php">Account</a></li>
      <li>
        <a href="cart.php"><i id="shopbag" class="fa-sharp fa-solid fa-cart-shopping js-cart-click"></i></a>
      </li>
      <?php endif; ?>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Signup</a></li>
        
      <?php endif; ?>


      
    </ul>
  </div>

  <div id="mobile">
    <a href="cart.php">
      <i class="fa-sharp fa-solid fa-cart-shopping js-cart-click"></i>
    </a>
    <i id="bar" class="fas fa-bars mobile-icon" onclick="toggleMenu()"></i>
  </div>
</section>

<script>
function toggleMenu() {
  const navbar = document.getElementById('navbar');
  navbar.classList.toggle('active');
}
</script>
