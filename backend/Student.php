<?php
require_once("./dbconfig.php");

class Student {
    private $db_conn;
    private $state;
    private $error_message;

    public function __construct() {
        try{
            $db = new Database();
            if($db->getState()){
                $this->db_conn = $db->getDb();
                $this->state = true;
                $this->error_message = "Connected";
            }else{
                $this->state = false;
                $this->error_message = $db->getErrMsg();
            }
        }
        catch(Exception $e){
            $this->state = false;
            $this->error_message = $e->getMessage();
        }
    }

    public function insert_student($student) {
        $sql = "CALL sp_insert_student(:first_name, :last_name, :email, :department, :password, :role)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':first_name',$student['first_name']);
        $stmt->bindParam(':last_name',$student['last_name']);
        $stmt->bindParam(':email',$student['email']);
        $stmt->bindParam(':department',$student['department']);
        $stmt->bindParam(':password',$student['password']);
        $stmt->bindParam(':role',$student['role']);
        try {
            $stmt->execute();
            if($stmt) {
                return $student;
            } 
            else {
                return 0;
            }
        }
        catch(Exception $ex) {
            $this->error_message = $ex->getMessage();
            echo $ex->getMessage();
            return -1;
        }
    }

    public function update_student($student) {
        $sql = "CALL sp_update_student(:id, :first_name, :last_name, :email, :department, :role, :password)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':id',$student['id']);
        $stmt->bindParam(':first_name',$student['first_name']);
        $stmt->bindParam(':last_name',$student['last_name']);
        $stmt->bindParam(':email',$student['email']);
        $stmt->bindParam(':department',$student['department']);
        $stmt->bindParam(':role',$student['role']);
        $stmt->bindParam(':password',$student['password']);
        try {
            $stmt->execute();
            if($stmt) {
                return $student;
            } 
            else {
                return 0;
            }
        }
        catch(Exception $ex) {
            $this->error_message = $ex->getMessage();
            echo $ex->getMessage();
            return -1;
        }
    }

    public function delete_student($student) {
        $sql = "CALL sp_delete_student(:id)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':id',$student['id']);
        try {
            $stmt->execute();
            if($stmt) {
                return $student;
            } 
            else {
                return 0;
            }
        }
        catch(Exception $ex) {
            $this->error_message = $ex->getMessage();
            echo $ex->getMessage();
            return -1;
        }
    }

    public function signin_student($student) {
        $sql = "CALL sp_signInStudent(:email, :password)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':email',$student['email']);
        $stmt->bindParam(':password',$student['password']);
        try {
            $stmt->execute();
            if($stmt) {
                $rows = array();
                while($rw = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $rows[] = $rw;
                }
            return $rows;
            }
            else {  
                return array();
            }
        }
        catch(Exception $ex) {
            $this->error_message = $ex->getMessage();
            echo $ex->getMessage();
            return -1;
        }
    }

    public function getAllStudentsFromModel(){
        $sql = "call sp_getAllStudents()";

        $stmt = $this->db_conn->prepare($sql);
        try {
            $stmt->execute();
            if($stmt) {
                $rows = array();
                while($rw = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $rows[] = $rw;
                }
            return $rows;
            }
            else {  
                return array();
            }
        }
        catch(PDOException $ex) {
            $this->state = false;
            return $ex->getMessage();
        }
    }

    public function getStudentFromModel($student){
        $sql = "call sp_get_student(:id)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':id',$student['id']);
        try {
            $stmt->execute();
            if($stmt) {
                $rows = array();
                while($rw = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $rows[] = $rw;
                }
                return $rows;
            }
            else {  
                return array();
            }
        }
        catch(PDOException $ex) {
            $this->state = false;
            return $ex->getMessage();
        }
    }

    public function getStudentByEmailFromModel($student){
        $sql = "call sp_get_student_by_email(:email)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':email',$student['email']);
        try {
            $stmt->execute();
            if($stmt) {
                $rows = array();
                while($rw = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $rows[] = $rw;
                }
                return $rows;
            }
            else {  
                return array();
            }
        }
        catch(PDOException $ex) {
            $this->state = false;
            return $ex->getMessage();
        }
    }

}