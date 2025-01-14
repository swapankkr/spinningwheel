<?php 
require_once './includes/start.php';
require_once './includes/db.php';
function main(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = isset($_POST['email']) ? trim($_POST['email']) : "";
        $password = isset($_POST['password']) ? trim($_POST['password']) : "";
        $role = 'admin';

        $validation_errors = [];

        if(empty($email)){
            $validation_errors['email'] = 'Please enter email';
        }
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE){
            $validation_errors['email'] = 'Invalid email address';
        }

        if(empty($password)){
            $validation_errors['password'] = 'Please enter password';
        }

        if(!empty($validation_errors)){
            error($validation_errors);exit;
        }

        $users = query("SELECT * FROM users WHERE email = '$email' AND password = md5('$password') LIMIT 1");
        if(!empty($users)){
            $admin = $users[0];
            $_SESSION['loged_admin'] = $admin;
            response("Loged in successful");
        }else{
            error(['all' => 'Email or Passord is incorrct']);
        }
    }else{
        error("Method not allowed");
    }
}
main();
require_once './includes/end.php';