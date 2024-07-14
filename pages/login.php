<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Group A Project</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
  <h2 class="logo">Group A</h2>
  <nav class="navigation">
    <a href="#" id="homeLink">Home</a>
    <a href="#" id="aboutLink">About Us</a>
    <a href="#">Services</a>
    <a href="#" id="contactLink">Contact Us</a>

    <button class="btnLogin-popup">Login</button>
  </nav>
</header>

<div class="wrapper">
    <span class="icon-close">
        <ion-icon name="close-outline"></ion-icon>
    </span>

  <!-- Login Form -->
  <div class="form-box login">
    <h2>Login</h2>
    <form action="#">
      <div class="input-box">
        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
        <input type="email" required>
        <label>Email</label>
      </div>
      <div class="input-box">
        <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
        <input type="password" required>
        <label>Password</label>
      </div>
      <div class="remember-forgot">
        <label><input type="checkbox"> Remember me</label>
        <a href="#" class="forgot-password-link">Forgot Password?</a>
      </div>
      <button type="submit" class="btn">Login</button>
      <div class="login-register">
        <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
      </div>
    </form>
  </div>

  <!-- Registration Form -->
  <div class="form-box register">
    <h2>Registration</h2>
    <form action="#">
      <div class="input-box">
        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
        <input type="text" required>
        <label>Username</label>
      </div>
      <div class="input-box">
        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
        <input type="email" required>
        <label>Email</label>
      </div>
      <div class="input-box">
        <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
        <input type="password" required>
        <label>Password</label>
      </div>
      <div class="remember-forgot">
        <label><input type="checkbox"> I agree to the terms & conditions</label>
      </div>
      <button type="submit" class="btn">Register</button>
      <div class="login-register">
        <p>Already have an account? <a href="#" class="login-link">Login</a></p>
      </div>
    </form>
  </div>
</div>

<!-- Contact Us Modal -->
<div id="contactModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Contact Us</h2>
    <form>
      <div class="input-box">
        <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
        <input type="text" required>
        <label>Name</label>
      </div>
      <div class="input-box">
        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
        <input type="email" required>
        <label>Email</label>
      </div>
      <div class="input-box">
        <span class="icon"><ion-icon name="chatbubble-outline"></ion-icon></span>
        <input type="text" required>
        <label>Message</label>
      </div>
      <button type="submit" class="btn">Send</button>
    </form>
  </div>
</div>

<!-- About Us Modal -->
<div id="aboutModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>About Us</h2>
    <p>Hello, we are a team!</p>
  </div>
</div>

<!-- Forgot Password Modal -->
<div id="forgotPasswordModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Forgot Password</h2>
    <form id="forgotPasswordForm">
      <div class="input-box">
        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
        <input type="email" id="forgotPasswordEmail" placeholder="Enter your email" required>
      </div>
      <button type="submit" class="btn">Submit</button>
    </form>
  </div>
</div>

<script src="../scripts/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>