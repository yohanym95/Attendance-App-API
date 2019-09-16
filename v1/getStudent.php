<?php 

require_once ('../include/DBOperations.php');

$response = array();
   
   if($_SERVER['REQUEST_METHOD']=='POST'){
       
    $db = new DBOperations();
    $students = $db->getStudent();

    if(isset($students)){
        $response['error'] = false;
        $response['students'] = $students;
    }else{
        $response['error'] = true;
        $response['students'] = "No student data";
    }
    
   }else{
    $response['error'] = false;
    $response['students'] = "invalid request"; 
   }

   echo json_encode($response);

?>