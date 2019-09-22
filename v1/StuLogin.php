<?php 

require_once ('../include/DBOperations.php');

$response = array();

  if($_SERVER['REQUEST_METHOD']=='POST'){
      if(isset($_POST['stuEmail']) & isset($_POST['stuPassword']) ){

        $db = new DBOperations();

        if($db->stuLogin($_POST['stuEmail'],$_POST['stuPassword'])){
            $student = $db->getStudentByUsername($_POST['stuEmail']);
            $response['error'] = false;
            $response['id'] = $student['id'];
            $response['stuEmail'] = $student['stuEmail'];
            $response['stuName'] = $student['stuName'];
            $response['stuRegNo'] = $student['stuRegNo'];
            $response['stuCourse'] = $student['stuCourse'];

            
        }else{
            $response['error'] = true;
            $response['message'] = "Invalid Admin or Password, Please try again!";
        }
        
      }else{
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
      }
  }else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
  }  

  echo json_encode($response);

?>