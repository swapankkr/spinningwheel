<?php session_start();
date_default_timezone_set('Asia/kolkata');
function response($data){
    header('Content-type: application/json');
    echo json_encode(['success' => 1, 'data' => $data]);
}
function error($error){
    header('Content-type: application/json');
    echo json_encode(['success' => 0, 'error' => $error]);
}
function check_loged_in(){
    if(empty($_SESSION['loged_admin'])){
        header('Location: login.php');
        exit;
    }
}
function admin(){
    return !empty($_SESSION['loged_admin']) ? $_SESSION['loged_admin'] : NULL;
}