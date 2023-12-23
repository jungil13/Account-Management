<?php

    header("Access-Control-Allow-Origin: http://localhost:8080");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once(__DIR__ . '/Student.php');
    require_once(__DIR__ . '/Announcement.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $method = isset($_POST['method']) ? $_POST['method'] : '';
        // $method = "getAllStudents";
        if(function_exists($method)) {
            call_user_func($method);
        }
        else {
            exit();
        }
    }

    function signup(){

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $department = $_POST['department'];
        $password = $_POST['password'];
        $role = "Student";

        $studArr = array(
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "department" => $department,
            "password" => $password,
            "role" => $role
        );
        $student = new Student();
        $ret = $student->insert_student($studArr);
        echo json_encode($student->getStudentByEmailFromModel($studArr));
    }

    function signin() {
        // $email = 
        // $password = $_POST['password'];

        // $email = "young@chae.boang";
        // $password = "asdasd";

        $email = $_POST['email'];
        $password = $_POST['password'];

        $studArr = array(
            "email" => $email,
            "password" => $password,
        );
        $student = new Student();
        echo json_encode($student->signin_student($studArr));
    }

    function getAllStudents() {
        $student = new Student();
        echo json_encode($student->getAllStudentsFromModel());
        // echo "bruh";
        // print_r($student->getAllStudentsFromModel());
    }

    function updateUser() {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $department = $_POST['department'];
        $role = $_POST['role'];
        $password = $_POST['password'];

        $studArr = array(
            "id" => $id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "department" => $department,
            "role" => $role,
            "password" => $password
        );

        $student = new Student();
        $student->update_student($studArr);
        echo json_encode($student->getStudentFromModel($studArr));

    }

    function deleteUser() {
        $id = $_POST['id'];

        $studArr = array(
            "id" => $id
        );

        $student = new Student();
        $student->delete_student($studArr);
    }

    function storeAnnouncement() {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date = new DateTime('now');
        $formatted_date = date_format($date,"Y-m-d H-i-s");

        $announcementArr = array(
            "title" => $title,
            "description" => $description,
            "created_at" => $formatted_date,
        );
        $announcement = new Announcement();
        $ret = $announcement->store_announcement($announcementArr);
        echo json_encode($announcementArr);
    }

    function getAllAnnouncements() {
        $announcement = new Announcement();
        echo json_encode($announcement->getAllAnnouncementsFromModel());
        // echo "bruh";
        // print_r($student->getAllStudentsFromModel());
    }

    function updateAnnouncement() {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        $announcementArr = array(
            "id" => $id,
            "title" => $title,
            "description" => $description,
        );

        $announcement = new Announcement();
        $ret = $announcement->update_announcement($announcementArr);
        echo json_encode($announcement->getAllAnnouncementsFromModel());
    }

    function deleteAnnouncement() {
        $id = $_POST['id'];

        $announcementArr = array(
            "id" => $id
        );

        $announcement = new Announcement();
        $ret = $announcement->delete_announcement($announcementArr);
        echo json_encode($announcement->getAllAnnouncementsFromModel());

    }

    function get_student() {
        $id = "1";

        $studentArr = array(
            "id" => $id
        );

        $student = new Student();
        echo json_encode($student->getStudentFromModel($studentArr));
    }

    // get_student();