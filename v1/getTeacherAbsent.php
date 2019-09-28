<?php
require_once('../include/DBOperations.php');

$response = array();

   if($_SERVER['REQUEST_METHOD'] == 'POST'){

     if(isset($_POST['Date']) && isset($_POST['course']) ){

        $db = new DBOperations();
        $result = $db->getTeacherAbsent($_POST['Date'],$_POST['Course']);
        $response['attendance'] = array();

        while($row = mysqli_fetch_array($result)){
           $temp['teacherEmail'] = $row['teacherEmail'];
           $temp['teacherName'] = $row['teacherName'];

           array_push($response['attendance'],$temp);
        }
       
     }else{
        $response['error'] = true;
        $response['attendance'] = "Required fields are missing";

     }
       
   }else{
    $response['error'] = false;
    $response['attendance'] = "invalid request";  
   }

   echo json_encode($response);
?>