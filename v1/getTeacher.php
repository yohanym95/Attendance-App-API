<?php
require_once('../include/DBOperations.php');

$response = array();

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
       $db = new DBOperations();
       $teachers = $db->getTeacher();
       
       if(isset($teachers)){
        $response['error'] = false;
        $response['teachers'] = $teachers;
       }else{
        $response['error'] = true;
        $response['teachers'] = "No teacher's data";
       }

   }else{
    $response['error'] = false;
    $response['teachers'] = "invalid request";  
   }

   echo json_encode($response);
?>