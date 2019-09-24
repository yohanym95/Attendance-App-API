<?php 
  
class DBOperations{
    private $con;
  
  function __construct(){
    require_once dirname(__FILE__).'/DBConnect.php';
    $db = new DBConnect();
    $this-> con = $db->connect();
  }

  //CRUD -> C -> create studenttable
  public function createStu($stuName,$stuEmail,$stuRegNo,$stuCourse,$stuPassword){
    if($this->isUserExist($stuName,$stuRegNo)){
      return 0;

    }else{
     $password1 = md5($stuPassword);
     $stmt = $this->con->prepare("INSERT INTO `students` (`id`, `stuName`, `stuEmail`, `stuRegNo`,`stuCourse`,`stuPassword`) VALUES (NULL, ?, ?, ?, ?, ?);");
     $stmt->bind_param("sssss",$stuName,$stuEmail,$stuRegNo,$stuCourse,$password1);
     if($stmt->execute()){
         return 1;
     }else{
         return 2;
     }

    }
     
  }
 
  private function isUserExist($stuName, $stuRegNo){
    $stmt = $this->con->prepare("SELECT id FROM students WHERE stuName = ? OR stuRegNo = ?");
    $stmt->bind_param("ss",$stuName,$stuRegNo );
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;

  }

  //get student list


  public function getStudent(){
    
    $stmt = $this->con->prepare("SELECT stuName,stuEmail,stuRegNo,stuCourse FROM students" );
   // $stmt ->bind_param("ssss",$stuName,$stuEmail,$stuRegNo,$stuCourse);
    $stmt ->execute();
    $stmt ->bind_result($stuName,$stuEmail,$stuRegNo,$stuCourse);
    $students = array();
    while($stmt -> fetch()){
      $student = array();
      $student['stuName']=$stuName;
      $student['stuEmail']=$stuEmail;
      $student['stuRegNo']=$stuRegNo;
      $student['stuCourse']=$stuCourse;
      array_push($students,$student);
    }

    return $students;

    }

    // Course
    private function isCourseExist($courseNo, $courseName){
      $stmt = $this->con->prepare("SELECT courseNo FROM course WHERE courseNo = ? OR courseName = ?");
      $stmt->bind_param("ss",$courseNo,$courseName );
      $stmt->execute();
      $stmt->store_result();
      return $stmt->num_rows > 0;
  
    }


    public function createCourse($courseNo,$courseName,$courseDep){
      if($this->isCourseExist($courseNo,$courseName)){
        return 0;
  
      }else{
       $stmt = $this->con->prepare("INSERT INTO `course` (`courseNo`, `courseName`,`courseDep`) VALUES ( ?, ?, ?);");
       $stmt->bind_param("sss",$courseNo,$courseName,$courseDep);
       if($stmt->execute()){
           return 1;
       }else{
           return 2;
       }
  
     }
       
    }

    //get course  list

    public function getCourse(){
    
      $stmt = $this->con->prepare("SELECT courseNo,courseName,courseDep FROM course" );
     // $stmt ->bind_param("ssss",$stuName,$stuEmail,$stuRegNo,$stuCourse);
      $stmt ->execute();
      $stmt ->bind_result($courseNo,$courseName,$courseDep);
      $courses = array();
      while($stmt -> fetch()){
        $course = array();
        $course['courseNo']=$courseNo;
        $course['courseName']=$courseName;
        $course['courseDep']=$courseDep;
        array_push($courses,$course); //The array_push() function inserts one or more elements to the end of an array.
      }
  
      return $courses;
  
      }


      //teacher
     private function isTeacherExist($teacherName, $teacherCourse){
      $stmt = $this->con->prepare("SELECT teacherId FROM teacher WHERE teacherName = ? AND teacherCourse = ?");
      $stmt->bind_param("ss",$teacherName,$teacherCourse );
      $stmt->execute();
      $stmt->store_result();
      return $stmt->num_rows > 0;
  
     }


      public function createTeacher($teacherName,$teacherEmail,$teacherCourse,$teacherPassword){
        if($this->isTeacherExist($teacherName,$teacherCourse)){
          return 0;  
        }else{
         $stmt = $this->con->prepare("INSERT INTO `teacher` ( `teacherId` ,`teacherName`, `teacherEmail`, `teacherCourse`, `teacherPassword`) VALUES ( null,?, ?, ?, ?);");
         $stmt->bind_param("ssss",$teacherName,$teacherEmail,$teacherCourse,$teacherPassword);
         if($stmt->execute()){
             return 1;
         }else{
             return 2;
         }
    
       }
         
      }

      //get teacher list

      public function getTeacher(){
    
        $stmt = $this->con->prepare("SELECT teacherName,teacherEmail,teacherCourse FROM teacher" );
       // $stmt ->bind_param("ssss",$stuName,$stuEmail,$stuRegNo,$stuCourse);
        $stmt ->execute();
        $stmt ->bind_result($teacherName,$teacherEmail,$teacherCourse);
        $teachers = array();
        while($stmt -> fetch()){
          $teacher = array();
          $teacher['teacherName']=$teacherName;
          $teacher['teacherEmail']=$teacherEmail;
          $teacher['teacherCourse']=$teacherCourse;
          array_push($teachers,$teacher); //The array_push() function inserts one or more elements to the end of an array.

        }
    
        return $teachers;
    
        }


        //mark course attendence // get student attendence list
        public function getStuAttendance($date,$course){
    
          $stmt = $this->con->prepare("SELECT stuRegNo,stuName FROM student_attendence WHERE Date = ? AND course = ?" );
         
          $stmt->bind_param("ss",$date,$course);
          $stmt ->execute();
          $result = $stmt->get_result();
        
      
          return $result;
      
        }

        //mark course attendence // get teacher attendence list
        public function getTeacherAttendance($date,$course){
    
          $stmt = $this->con->prepare("SELECT teacherName,teacherEmail FROM teacher_attendence WHERE Date = ? AND course = ?" );
         
          $stmt->bind_param("ss",$date,$course);
          $stmt ->execute();
          $result = $stmt->get_result();
      
          return $result;
      
        }

        //Admin login

        public function adminLogin($adminEmail,$adminPass){

         // $password = md5($adminPass);
          $stmt = $this->con->prepare("SELECT id FROM admindb WHERE adminEmail = ? AND adminPass = ?");
          $stmt ->bind_param("ss",$adminEmail,$adminPass);
          $stmt ->execute();
          $stmt ->store_result();
          return $stmt ->num_rows > 0;

        }

        public function getAdminByUsername($adminEmail){
          $stmt = $this->con->prepare("SELECT * FROM admindb WHERE adminEmail = ?");
          $stmt ->bind_param("s",$adminEmail);
          $stmt ->execute();
          return $stmt ->get_result()->fetch_assoc();
        }


        //Student login
        public function stuLogin($stuEmail,$stuPassword){

           $password = md5($stuPassword);
           $stmt = $this->con->prepare("SELECT id FROM students WHERE stuEmail = ? AND stuPassword = ?");
           $stmt ->bind_param("ss",$stuEmail,$password);
           $stmt ->execute();
           $stmt ->store_result();
           return $stmt ->num_rows > 0;
 
         }

         public function getStudentByUsername($stuEmail){
          $stmt = $this->con->prepare("SELECT * FROM students WHERE stuEmail = ?");
          $stmt ->bind_param("s",$stuEmail);
          $stmt ->execute();
          return $stmt ->get_result()->fetch_assoc();
        }

        //Teacher login
        public function teacherLogin($teacherEmail,$teacherPassword){

          $password = md5($teacherPassword);
          $stmt = $this->con->prepare("SELECT teacherId FROM teacher WHERE teacherEmail = ? AND teacherPassword = ?");
          $stmt ->bind_param("ss",$teacherEmail,$teacherPassword);
          $stmt ->execute();
          $stmt ->store_result();
          return $stmt ->num_rows > 0;

        }

        public function getTeacherByUsername($teacherEmail){
         $stmt = $this->con->prepare("SELECT * FROM teacher WHERE teacherEmail = ?");
         $stmt ->bind_param("s",$teacherEmail);
         $stmt ->execute();
         return $stmt ->get_result()->fetch_assoc();
       }

       //Student Attendance
  public function createStudentAttendance($Date,$stuName,$stuRegNo,$Attendance,$stuCourse){
  
    $stmt = $this->con->prepare("INSERT INTO `student_attendence` (`id`,`Date`, `stuName`, `stuRegNo`,`Attendance`,`course`) VALUES (NULL, ?, ?, ?, ?, ?);");
    $stmt->bind_param("sssss",$Date,$stuName,$stuRegNo,$Attendance,$stuCourse);
    if($stmt->execute()){
        return 1;
    }else{
        return 2;
    }
    
 }


 //Teacher Attendance //have to make 
 public function createTeacherAttendance($Date,$teacherName,$teacherEmail,$Attendance,$Course){
  
  $stmt = $this->con->prepare("INSERT INTO `student_attendence` (`id`,`Date`, `teacherName`, `teacherEmail`,`Attendance`,`Course`) VALUES (NULL, ?, ?, ?, ?, ?);");
  $stmt->bind_param("sssss",$Date,$teacherName,$teacherEmail,$Attendance,$Course);
  if($stmt->execute()){
      return 1;
  }else{
      return 2;
  }
  
 }


 //Update student password
 private function isStudentExist($stuEmail, $stuRegNo){
  $stmt = $this->con->prepare("SELECT id FROM students WHERE stuEmail = ? OR stuRegNo = ?");
  $stmt->bind_param("ss",$stuEmail,$stuRegNo );
  $stmt->execute();
  $stmt->store_result();
  return $stmt->num_rows > 0;

}

public function createStu($stuEmail,$stuRegNo,$stuPassword){
  if($this->isStudentExist($stuEmail,$stuRegNo)){

   $password1 = md5($stuPassword);
   $stmt = $this->con->prepare("UPDATE `students` SET stuPassword= ? WHERE stuEmail = ? AND stuRegNo = ?;");
   $stmt->bind_param("sss",$password1,$stuEmail,$stuRegNo);
   if($stmt->execute()){
       return 1;
   }else{
       return 2;
   }

  }else{
    return 0;
  }
   
}
    
    

  }


  
    
 

  








?>