<?php
require_once("./dbconfig.php");

class Announcement {
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

    public function getAllAnnouncementsFromModel() {
        $sql = "CALL sp_get_all_announcements()";
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

    public function store_announcement($announcement) {
        $sql = "CALL sp_store_announcement(:title, :description, :created_at)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':title',$announcement['title']);
        $stmt->bindParam(':description',$announcement['description']);
        $stmt->bindParam(':created_at',$announcement['created_at']);

        try {
            $stmt->execute();
            if($stmt) {
                return $announcement;
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


    public function delete_announcement($announcement) {
        $sql = "CALL sp_delete_announcement(:id)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':id',$announcement['id']);
        try {
            $stmt->execute();
            if($stmt) {
                return $announcement;
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

    public function update_announcement($announcement) {
        $sql = "CALL sp_update_announcement(:id, :title, :description)";

        $stmt = $this->db_conn->prepare($sql);
        $stmt->bindParam(':id', $announcement['id']);
        $stmt->bindParam(':title', $announcement['title']);
        $stmt->bindParam(':description', $announcement['description']);
        try {
            $stmt->execute();
            if($stmt) {
                return $announcement;
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

    

    

    

}