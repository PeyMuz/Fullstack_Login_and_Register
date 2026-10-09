<?php

session_start();
session_unset(); // to delete all the variable stored in a session.
session_destroy(); //to destroy the users active session.
header('Location: index.php');
exit();

?>