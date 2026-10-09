<?php

session_start();
require_once 'config.php';

//If the register button is clicke, run this code.
if (isset($_POST['register_btn'])) {
   $name = trim($_POST['name'] ?? '');
   $email = trim($_POST['email'] ?? '');
   $raw_password = $_POST['password'] ?? '';
   $confirm_password = $_POST['confirm_password'] ?? '';

   //isasave muna yung name at email para hindi mawala pag may error (hindi isasama ang password)
   $_SESSION['old'] = ['form' => 'register', 'name' => $name, 'email' => $email];
   $_SESSION['active_form'] = 'register';

   //mga validation
   $error = null;
   if ($name === '' || $email === '' || $raw_password === '') {
      $error = 'Please fill in all fields!';
   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Please enter a valid email!';
   } elseif (strlen($raw_password) < 8) {
      $error = 'Password must be at least 8 characters!';
   } elseif ($raw_password !== $confirm_password) {
      $error = 'Passwords do not match!';
   }

   if ($error !== null) {
      $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => $error
      ];
      header('Location: index.php');
      exit();
   }

   $password = password_hash($raw_password, PASSWORD_DEFAULT);

   $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
   $check->bind_param("s", $email);
   $check->execute();
   $check->store_result();

   if($check->num_rows > 0){
      $_SESSION['alerts'][] = [
        'type' => 'error',
        'message' => 'Email is already registered!'
      ];
   } else{
     $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
     $insert->bind_param("sss", $name, $email, $password);

     try {
        $insert->execute();
        unset($_SESSION['old']); //success na, so di na kailangan ibalik yung laman ng form
        $_SESSION['alerts'][] = [
           'type' => 'success',
           'message' => 'Registration successful'
        ];
        $_SESSION['active_form'] = 'login';
     } catch (mysqli_sql_exception $e) {
        $_SESSION['alerts'][] = [
           'type' => 'error',
           'message' => 'Something went wrong. Please try again!'
        ];
     }
     $insert->close();
   }
   $check->close();
   header('Location: index.php');
   exit();
} 

//for login

if (isset($_POST['login_btn'])) {
      $email = trim($_POST['email'] ?? '');
      $password = $_POST['password'] ?? '';

      $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->num_rows > 0 ? $result->fetch_assoc() : null;
      $stmt->close();

      if ($user && password_verify($password, $user['password'])) {
          session_regenerate_id(true); //bagong session ID pag naka-login na, para safe
          $_SESSION['name'] = $user['name'];
          $_SESSION['alerts'][]= [
            'type' => 'success',
            'message' => 'Login successful!'
          ];
      } else {
         $_SESSION['alerts'][] = [
           'type' => 'error',
           'message' => 'Incorrect email or password!'
         ];
         $_SESSION['old'] = ['form' => 'login', 'email' => $email];
         $_SESSION['active_form'] = 'login';
      }

      header('Location: index.php');
      exit();
} 

//kung direktang binuksan itong file (hindi galing sa form), balik sa index
header('Location: index.php');
exit();

?>