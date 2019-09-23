<?php
require_once('../include/DBOperations.php');

$response = array();

   if($_SERVER['REQUEST_METHOD'] == 'POST'){

     if(isset($_POST['date']) && isset($_POST['course']) ){

        $db = new DBOperations();
        $result = $db->getTeacherAttendance($_POST['date'],$_POST['course']);
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