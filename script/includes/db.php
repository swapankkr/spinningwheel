<?php 
function query($sql = ""){
    $conn = new mysqli('localhost', 'root', '', 'spinningwheel');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = $conn->query($sql);
    if(is_bool($result)){
        $insert_id = $conn->insert_id;
        mysqli_close($conn);
        return $insert_id;
    }else{
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[] = (object)$row;
        }
        mysqli_close($conn);
        return $data;
    }
}