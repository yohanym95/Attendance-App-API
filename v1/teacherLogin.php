<?php 

require_once ('../include/DBOperations.php');

$response = array();

  if($_SERVER['REQUEST_METHOD']=='POST'){
      if(isset($_POST['teacherEmail']) & isset($_POST['teacherPassword']) ){

        $db = new DBOperations();

        if($db->teacherLogin($_POST['teacherEmail'],$_POST['teacherPassword'])){
            $teacher = $db->getTeacherByUsername($_POST['teacherEmail']);
            $response['error'] = false;
            $response['teacherId'] = $teacher['teacherId'];
            $response['teacherEmail'] = $teacher['teacherEmail'];
            $response['teacherName'] = $teacher['teacherName'];
            $response['teacherCourse'] = $teacher['teacherCourse'];

            
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