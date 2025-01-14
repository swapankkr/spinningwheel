<?php require_once './includes/start.php';
unset($_SESSION['loged_admin']);
session_destroy();
header('Location: ../login.php');
exit;