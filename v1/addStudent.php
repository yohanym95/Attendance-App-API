<?php 
     require_once ('../include/DBOperations.php');

     $response = array();

     if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_POST['stuName']) && isset($_POST['stuEmail']) && isset($_POST['stuRegNo']) && isset($_POST['stuCourse']) && isset($_POST['stuPassword'])){

                $db = new DBOperations(); 
                $result = $db->createStu($_POST['stuName'],
                                         $_POST['stuEmail'],
                                         $_POST['stuRegNo'],
                                         $_POST['stuCourse'],
                                         $_POST['stuPassword']);
                                         
                if($result == 1){
                  $response['error'] = false;
                  $response['message'] = "Student added successfully";
                 }else if($result == 2){
                  $response['error'] = true;
                  $response['message'] = "Some error occurred please try again";
                }else if($result == 0){
                  $response['error'] = true;
                  $response['message'] = "It seems you are already add this student, Please try again!";

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