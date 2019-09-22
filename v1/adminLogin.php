<?php 

require_once ('../include/DBOperations.php');

$response = array();

  if($_SERVER['REQUEST_METHOD']=='POST'){
      if(isset($_POST['adminEmail']) & isset($_POST['adminPass']) ){

        $db = new DBOperations();

        if($db->adminLogin($_POST['adminEmail'],$_POST['adminPass'])){
            $admin = $db->getAdminByUsername($_POST['adminEmail']);
            $response['error'] = false;
            $response['id'] = $admin['id'];
            $response['adminEmail'] = $admin['adminEmail'];
            
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