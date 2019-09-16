<?php 
     require_once ('../include/DBOperations.php');

     $response = array();

     if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_POST['teacherName']) && isset($_POST['teacherEmail']) && isset($_POST['teacherCourse'])  && isset($_POST['teacherPassword'])){

                $db = new DBOperations(); 
                $result = $db->createTeacher($_POST['teacherName'],
                                         $_POST['teacherEmail'],
                                         $_POST['teacherCourse'],
                                         $_POST['teacherPassword']);
                                         
                if($result == 1){
                  $response['error'] = false;
                  $response['message'] = "Teacher added successfully";
                 }else if($result == 2){
                  $response['error'] = true;
                  $response['message'] = "Some error occurred please try again";
                }else if($result == 0){
                  $response['error'] = true;
                  $response['message'] = "It seems you are already add this Teacher and course , Please try again!";

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