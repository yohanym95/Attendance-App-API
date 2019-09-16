<?php 
     require_once ('../include/DBOperations.php');

     $response = array();

     if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_POST['courseNo']) && isset($_POST['courseName']) && isset($_POST['courseDep'])){

                $db = new DBOperations(); 

                $result = $db->createCourse($_POST['courseNo'],
                                         $_POST['courseName'],
                                         $_POST['courseDep']);

                if($result == 1){
                  $response['error'] = false;
                  $response['message'] = "Course added successfully";
                 }else if($result == 2){
                  $response['error'] = true;
                  $response['message'] = "Some error occurred please try again";
                }else if($result == 0){
                  $response['error'] = true;
                  $response['message'] = "It seems you are already add this course, Please try again!";

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