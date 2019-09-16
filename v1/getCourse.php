<?php
require_once('../include/DBOperations.php');

$response = array();

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
       $db = new DBOperations();
       $courses = $db->getCourse();
       
       if(isset($courses)){
        $response['error'] = false;
        $response['courses'] = $courses;
       }else{
        $response['error'] = true;
        $response['courses'] = "No student data";
       }

   }else{
    $response['error'] = false;
    $response['courses'] = "invalid request";  
   }

   echo json_encode($response);
?>