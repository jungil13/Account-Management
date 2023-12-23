-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 09:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `account_management_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_announcement` (IN `_id` INT)   BEGIN
  DELETE FROM announcements WHERE id = _id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_student` (IN `_id` INT)   BEGIN
  DELETE FROM users WHERE id = _id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getAllStudents` ()   BEGIN
  SELECT * FROM users;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_getStudentByEmail` (IN `_email` VARCHAR(250))   BEGIN
  SELECT * FROM student WHERE email = _email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_all_announcements` ()   BEGIN
  SELECT * FROM announcements;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_student` (IN `_id` INT)   BEGIN
  SELECT * FROM users WHERE id = _id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_student_by_email` (IN `_email` VARCHAR(255))   BEGIN
  SELECT * FROM users WHERE email = _email;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_student` (IN `_first_name` VARCHAR(255), IN `_last_name` VARCHAR(255), IN `_email` VARCHAR(255), IN `_department` VARCHAR(255), IN `_password` VARCHAR(255), IN `_role` VARCHAR(255))  SQL SECURITY INVOKER BEGIN

  Declare doesUserExists int;
    set doesUserExists = 0;

    SELECT count(*) into doesUserExists from users where email = _email;
  
   if doesUserExists = 0 then  
     INSERT INTO users(first_name, last_name, email, department, password, role)
      VALUES(_first_name, _last_name, _email, _department, _password, _role);
   end if;

   
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_signInStudent` (IN `_email` VARCHAR(255), IN `_password` VARCHAR(255))   BEGIN
  SELECT * FROM users WHERE email = _email && password = _password;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_store_announcement` (IN `_title` VARCHAR(255), IN `_description` VARCHAR(255), IN `_created_at` DATE)   BEGIN
  INSERT INTO announcements(title, description, created_at) VALUES (_title, _description, _created_at);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_announcement` (IN `_id` INT, IN `_title` VARCHAR(255), IN `_description` VARCHAR(255))   BEGIN
  UPDATE announcements SET
    title = _title,
    description = _description
    WHERE id = _id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_student` (IN `_id` INT, IN `_first_name` VARCHAR(255), IN `_last_name` VARCHAR(255), IN `_email` VARCHAR(255), IN `_department` VARCHAR(255), IN `_role` VARCHAR(255), IN `_password` VARCHAR(255))   BEGIN
  UPDATE users set 
    first_name = _first_name,
    last_name = _last_name, 
    email = _email,
    department = _department,
    password = _password,
    role = _role
    WHERE id = _id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `description`, `created_at`) VALUES
(5, 'Alas 9: 15 PM na', 'wa pa koy kaon ,mzxcn,m,m,mnxm,cn,mxnc,xmzncxz,mcnzx,mn', '2023-12-07'),
(6, 'BOANG NGA ANNOUNCEMENT', 'TINUWA NASAD AMONG SUDAN PISTE YAWA GAITAY BAHOG LOBOGT', '2023-12-07'),
(7, 'lorem ipsum or some shit', 'lorem ispum kokwd akwokd owaan,mdn awkoawkoa akwokaw ssadhsjhghsgs', '2023-12-07'),
(8, 'ANNOUNCEMENT: KATUGON NAKO', 'HAHAHAHAHAAHA', '2023-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `department`, `password`, `role`) VALUES
(1, 'Ryan', 'Gosling', 'literally me', 'BSIT', 'mefr', 'Admin'),
(2, 'Ice', 'Spice', 'ice@spice.e', 'BSIT', 'asdasd', 'Admin'),
(4, 'Hev', 'Abi', 'hev@abi.com', 'BSHM', 'Admin', 'Admin'),
(5, 'City', 'Girls', 'city@girls.com', 'BSHM', 'student', 'Student'),
(6, 'Skibidi', 'Gyatt', 'skibidi gyatt rizz', 'BEED', '123456', 'Admin'),
(7, 'Chae ', 'young', 'young@chae.boang', 'BSIT', 'asdasd', 'Student'),
(17, 'new', 'jeans', 'oma oma godd kasu kasu wa', 'BEED', 'gyatt', 'Admin'),
(19, '21', 'Savagee', '21@savage.com', 'BSED', 'bruh', 'Admin'),
(22, 'Ryan', 'Gosling', 'Ryan goslling unsint a message.', 'BSIT', 'asdasd', 'Admin'),
(23, 'Perrell', 'Brown', 'dreamy@is.perrell', 'BSHM', 'GYATTTT', 'student'),
(33, 'Joren', 'Sumagang', 'sumagangjoren@gmail.com', 'BSIT', 'asdasd', 'student'),
(35, 'Admin', 'Admin', 'admin@email.com', 'BSIT', 'asdasd', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
