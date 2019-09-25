<?php 
     require_once ('../include/DBOperations.php');

     $response = array();

     if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_POST['adminPass'])  && isset($_POST['adminEmail'])){

                $db = new DBOperations(); 
                $result = $db->updateAdminPassword($_POST['adminPass'],
                                         $_POST['adminEmail']);
                                         
                 if($result == 1){
                  $response['error'] = false;
                  $response['message'] = "Password Updated successfully";
                 }else if($result == 2){
                  $response['error'] = true;
                  $response['message'] = "Admin details are wrongs";
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