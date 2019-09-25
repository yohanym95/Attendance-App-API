<?php 
     require_once ('../include/DBOperations.php');

     $response = array();

     if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_POST['stuPassword'])  && isset($_POST['stuEmail'])){

                $db = new DBOperations(); 
                $result = $db->updateStudentPassword($_POST['stuPassword'],
                                         $_POST['stuEmail']);
                                         
                 if($result == 1){
                  $response['error'] = false;
                  $response['message'] = "Password Updated successfully";
                 }else if($result == 2){
                  $response['error'] = true;
                  $response['message'] = "Student details are wrongs";
                 }else if($result == 0){
                    $response['error'] = true;
                    $response['message'] = "Some error occurred please try again ";
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