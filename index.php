<?php

session_start();

$name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$active_form = $_SESSION['active_form'] ?? '';
$old = $_SESSION['old'] ?? []; //yung mga tinype ng user na ibabalik pag may error (walang password)

$reg_name    = ($old['form'] ?? '') === 'register' ? ($old['name'] ?? '') : '';
$reg_email   = ($old['form'] ?? '') === 'register' ? ($old['email'] ?? '') : '';
$login_email = ($old['form'] ?? '') === 'login' ? ($old['email'] ?? '') : '';

session_unset(); //this function use to delete all the registered session. It will be emptied but, the session still active

if ($name !== null) $_SESSION['name'] = $name; //the username will be remain even if you relaod the site.

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fullstack</title>
    <link rel="stylesheet" href="style.css"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
  <header>
    <a href="#" class="logo">Cyber</a>

    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Collection</a>
        <a href="#">Contact</a>
    </nav>

    <div class="user-auth">
         <?php if (!empty($name)): // if the user is logged in, then the content below (which is the html) will display ?>
         <div class="profile-box">
           <div class="avatar-circle"><?= htmlspecialchars(mb_strtoupper(mb_substr($name, 0, 1))) ?></div> <?php // the name of the user will capitalize and the icon will be the first letter of their name or Username. ?>
           <div class="dropdown">
                <a href="#">My Account</a>
                <a href="#">Logout</a>
           </div>
         </div>
         <?php else: // if the user is not logged in, the button will displayed. ?>
        <button type="button" class="login-btn-modal">Login</button>
        <?php endif; // for closure only. ?>
    </div>
  </header>

  <section class="torena">
    <h1>Hello <?= htmlspecialchars($name ?? 'Developer') ?></h1> <?php // if the user is not logged in, the display name will be Developer. ?>
  </section>

  <?php if (!empty($alerts)): ?>
  <div class="alert-box">
    <?php foreach($alerts as $alert):?>
     <div class="alert <?= $alert['type'] ?>">
         <i class='bx <?=  $alert['type'] === 'success' ? 'bxs-check-circle' : 'bxs-x-circle'?>'></i>
         <span><?= htmlspecialchars($alert['message']); ?></span>
     </div>
     <?php endforeach; ?>
  </div>
  <?php endif; // for closure only. ?>
  <!--For Login-->
  <div class="auth-modal <?=$active_form === 'register' ? 'show slide' : ($active_form === 'login' ? 'show' : '')   ?>">
    <button type="button" class="close-btn-modal">X</button>


     <div class="form-box login">
      <h2>Login</h2>
        <form action="auth_process.php" method="POST">
          <div class="input-box">
            <label>Email:</label>
             <input type="email" name="email" placeholder="Please put your email here" value="<?= htmlspecialchars($login_email) ?>" autocomplete="email" required />
          </div>

          <div class="input-box">
            <label>Password:</label>
             <input type="password" name="password" placeholder="Please put your password here" autocomplete="current-password" required />
          </div>

          <button type="submit" name="login_btn" class="btn">Login</button>
          <p>Don't have the account? <a href="#" class="register-link">Register</a></p>
        </form>
     </div>

     <!--Registration form-->
     <div class="form-box register">
      <h2>Register</h2>
        <form action="auth_process.php" method="POST">
          <div class="input-box">
            <label>Name:</label>
             <input type="text" name="name" placeholder="Please put your name here" value="<?= htmlspecialchars($reg_name) ?>" autocomplete="name" required />
          </div>

          <div class="input-box">
            <label>Email:</label>
             <input type="email" name="email" placeholder="Please put your email here" value="<?= htmlspecialchars($reg_email) ?>" autocomplete="email" required />
          </div>

          <div class="input-box">
            <label>Password:</label>
             <input type="password" name="password" placeholder="Please put your password here" autocomplete="new-password" required />
          </div>

          <div class="input-box">
            <label>Confirm Password:</label>
             <input type="password" name="confirm_password" placeholder="Please confirm your password here" autocomplete="new-password" required />
          </div>

          <button type="submit" name="register_btn" class="btn">Register</button>
          <p>Already have an account? <a href="#" class="login-link">Login</a></p>
        </form>
     </div>
  </div>


  <script src="index.js"></script>
</body>
</html>