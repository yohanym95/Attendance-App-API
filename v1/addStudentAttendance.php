<?php 
     require_once ('../include/DBOperations.php');

     $response = array();

     if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_POST['Date']) && isset($_POST['stuName']) && isset($_POST['stuRegNo']) && isset($_POST['Attendance']) && isset($_POST['course'])){

                $db = new DBOperations(); 
                $result = $db->createStudentAttendance($_POST['Date'],
                                         $_POST['stuName'],
                                         $_POST['stuRegNo'],
                                         $_POST['Attendance'],
                                         $_POST['course']);
                                         
                if($result == 1){
                  $response['error'] = false;
                  $response['message'] = "Student added successfully";
                 }else if($result == 2){
                  $response['error'] = true;
                  $response['message'] = "Some error occurred please try again";
                }                     
        }else{
            $response['error'] = true;
            $response['message'] = "Required fields are missing";
        }

     }else{
        $response['error'] = true;
        $response['message'] = "Invalid Request"; 
     }

     header('Content-Type: application/json');
     echo json_encode($response);

?>