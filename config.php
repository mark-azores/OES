<?php
    
    try{

        define('DB_HOST','localhost');
        define('DB_USER','root');
        define('DB_PASS','');
        define('DB_NAME','oes');
        date_default_timezone_set('Asia/Manila');
        
        $conn_pdo = new PDO("mysql:host=".DB_HOST, DB_USER, DB_PASS);
        // set the PDO error mode to exception
        $conn_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_pdo->query("CREATE DATABASE IF NOT EXISTS ".DB_NAME);

        $connect = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS); 
        $USER_TABLE = 'user_account';
        $USER_COLUMN = 'fullname, user_name, password, contact, address, user_type, status, date_created';
        session_start();
        
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        include('function.php');

        $query = "SHOW TABLES LIKE '$USER_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $USER_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `fullname` VARCHAR(255) DEFAULT NULL,
                `user_name` VARCHAR(255) DEFAULT NULL,
                `password` VARCHAR(255) DEFAULT NULL,
                `contact` VARCHAR(255) DEFAULT NULL,
                `address` VARCHAR(255) DEFAULT NULL,
                `user_type` VARCHAR(255) DEFAULT NULL,
                `status` VARCHAR(255) DEFAULT NULL,
                `date_created` VARCHAR(255) DEFAULT NULL,
                INDEX (`id`)
            );";
            $connect->exec($create);
            $password = password_hash('admin', PASSWORD_DEFAULT);
            query($connect, "INSERT INTO $USER_TABLE ($USER_COLUMN) VALUES ('Administrator', 'adminadmin', '".$password."' , '', '', 'Superadmin', 'Active','".date("m-d-Y h:i A")."') ");
        }

        $INSTRUCTOR_TABLE = 'instructors';
        $query = "SHOW TABLES LIKE '$INSTRUCTOR_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $INSTRUCTOR_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `grade_level` VARCHAR(255) DEFAULT NULL,
                `strand_id` VARCHAR(255) DEFAULT NULL,
                `section_id` VARCHAR(255) DEFAULT NULL,
                `fullname` VARCHAR(255) DEFAULT NULL,
                `gender` VARCHAR(255) DEFAULT NULL,
                `contact` VARCHAR(255) DEFAULT NULL,
                `status` VARCHAR(255) DEFAULT NULL,
                `date_created` VARCHAR(255) DEFAULT NULL,
                INDEX (`id`)
            );";
            $connect->exec($create);
        }

        $SY_TABLE = 'school_year';
        $query = "SHOW TABLES LIKE '$SY_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $SY_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `school_year` VARCHAR(255) DEFAULT NULL,
                `status` VARCHAR(255) DEFAULT NULL,
                `date_created` VARCHAR(255) DEFAULT NULL,
                INDEX (`id`)
            );";
            $connect->exec($create);
        }

        $SEM_TABLE = 'semester';
        $query = "SHOW TABLES LIKE '$SEM_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $SEM_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `semester` VARCHAR(255) DEFAULT NULL,
                `status` VARCHAR(255) DEFAULT NULL,
                `date_created` VARCHAR(255) DEFAULT NULL,
                INDEX (`id`)
            );";
            $connect->exec($create);
            // query($connect, "INSERT INTO $SEM_TABLE (semester, status, date_created) VALUES ('First Semester', 'Active','".date("m-d-Y h:i A")."') ");
            // query($connect, "INSERT INTO $SEM_TABLE (semester, status, date_created) VALUES ('Second Semester', 'Inactive','".date("m-d-Y h:i A")."') ");
            
            query($connect, "INSERT INTO $SEM_TABLE (semester, status, date_created) VALUES ('First Quarter', 'Active','".date("m-d-Y h:i A")."') ");
            query($connect, "INSERT INTO $SEM_TABLE (semester, status, date_created) VALUES ('Second Quarter', 'Inactive','".date("m-d-Y h:i A")."') ");
            query($connect, "INSERT INTO $SEM_TABLE (semester, status, date_created) VALUES ('Third Quarter', 'Inactive','".date("m-d-Y h:i A")."') ");
            query($connect, "INSERT INTO $SEM_TABLE (semester, status, date_created) VALUES ('Fourth Quarter', 'Inactive','".date("m-d-Y h:i A")."') ");
        }

        $JHSECTION_TABLE = 'jh_sections';
        $query = "SHOW TABLES LIKE '$JHSECTION_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $JHSECTION_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `adviser_id` VARCHAR(255) DEFAULT NULL,
                `grade_level` VARCHAR(255) DEFAULT NULL,
                `section` VARCHAR(255) DEFAULT NULL,
                `grade_lowest` VARCHAR(255) DEFAULT NULL,
                `grade_highest` VARCHAR(255) DEFAULT NULL,
                `no_limit` VARCHAR(255) DEFAULT NULL,
                `no_students` VARCHAR(255) DEFAULT NULL,
                `status` VARCHAR(255) DEFAULT NULL,
                `date_created` VARCHAR(255) DEFAULT NULL,
                INDEX (`id`)
            );";
            $connect->exec($create);
        }

        $STRANDS_TABLE = 'strands';
        $query = "SHOW TABLES LIKE '$STRANDS_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $STRANDS_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `strand` VARCHAR(255) DEFAULT NULL,
                `status` VARCHAR(255) DEFAULT NULL,
                `date_created` VARCHAR(255) DEFAULT NULL,
                INDEX (`id`)
            );";
            $connect->exec($create);
        }

        $SHSECTION_TABLE = 'sh_sections';
        $query = "SHOW TABLES LIKE '$SHSECTION_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $SHSECTION_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `adviser_id` VARCHAR(255) DEFAULT NULL,
                `strand_id` VARCHAR(255) DEFAULT NULL,
                `grade_level` VARCHAR(255) DEFAULT NULL,
                `section` VARCHAR(255) DEFAULT NULL,
                `grade_lowest` VARCHAR(255) DEFAULT NULL,
                `grade_highest` VARCHAR(255) DEFAULT NULL,
                `no_limit` VARCHAR(255) DEFAULT NULL,
                `no_students` VARCHAR(255) DEFAULT NULL,
                `status` VARCHAR(255) DEFAULT NULL,
                `date_created` VARCHAR(255) DEFAULT NULL,
                INDEX (`id`)
            );";
            $connect->exec($create);
        }

        $ADMISSION_TABLE = 'admission';
        $query = "SHOW TABLES LIKE '$ADMISSION_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $ADMISSION_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `school_year` VARCHAR(255) DEFAULT NULL,
                `semester` VARCHAR(255) DEFAULT NULL,
                `admission_no` VARCHAR(255) DEFAULT NULL,
                `avatar` VARCHAR(255) DEFAULT NULL,
                `student_status` VARCHAR(255) DEFAULT NULL,
                `grade_level` VARCHAR(255) DEFAULT NULL,
                `strand_id` VARCHAR(255) DEFAULT NULL,
                `section_id` VARCHAR(255) DEFAULT NULL,
                `lrn` VARCHAR(255) DEFAULT NULL,
                `last_name` VARCHAR(255) DEFAULT NULL,
                `first_name` VARCHAR(255) DEFAULT NULL,
                `middle_name` VARCHAR(255) DEFAULT NULL,
                `extension_name` VARCHAR(255) DEFAULT NULL,
                `address` VARCHAR(255) DEFAULT NULL,
                `email` VARCHAR(255) DEFAULT NULL,
                `contact` VARCHAR(255) DEFAULT NULL,
                `date_birth` VARCHAR(255) DEFAULT NULL,
                `sex` VARCHAR(255) DEFAULT NULL,
                `nationality` VARCHAR(255) DEFAULT NULL,
                `last_attended` VARCHAR(255) DEFAULT NULL,
                `g_fullname` VARCHAR(255) DEFAULT NULL,
                `g_contact` VARCHAR(255) DEFAULT NULL,
                `g_relationship` VARCHAR(255) DEFAULT NULL,
                `g_occupation` VARCHAR(255) DEFAULT NULL,
                `g_address` VARCHAR(255) DEFAULT NULL,
                `status` VARCHAR(255) DEFAULT NULL,
                `archived` VARCHAR(255) DEFAULT NULL,
                `date_scheduled` VARCHAR(255) DEFAULT NULL,
                `reason` VARCHAR(255) DEFAULT NULL,
                `payment_method` VARCHAR(255) DEFAULT NULL,
                `sf_plan` VARCHAR(255) DEFAULT NULL,
                `sf_amount` VARCHAR(255) DEFAULT 0,
                `me_plan` VARCHAR(255) DEFAULT NULL,
                `me_amount` VARCHAR(255) DEFAULT 0,
                `esc_payment` VARCHAR(255) DEFAULT 0,
                `date_paid` VARCHAR(255) DEFAULT NULL,
                `visitor_name` VARCHAR(255) DEFAULT NULL,
                `assessment_status` VARCHAR(255) DEFAULT NULL,
                `report_card1` VARCHAR(255) DEFAULT NULL,
                `report_card2` VARCHAR(255) DEFAULT NULL,
                `report_card_date` VARCHAR(255) DEFAULT NULL,
                `form_1371` VARCHAR(255) DEFAULT NULL,
                `form_1372` VARCHAR(255) DEFAULT NULL,
                `form_137_date` VARCHAR(255) DEFAULT NULL,
                `psa` VARCHAR(255) DEFAULT NULL,
                `psa_date` VARCHAR(255) DEFAULT NULL,
                `good_moral` VARCHAR(255) DEFAULT NULL,
                `good_moral_date` VARCHAR(255) DEFAULT NULL,
                `certificate` VARCHAR(255) DEFAULT NULL,
                `certificate_date` VARCHAR(255) DEFAULT NULL,
                `button_status` VARCHAR(255) DEFAULT NULL,
                `date_enrolled` VARCHAR(255) DEFAULT NULL,
                `date_created` VARCHAR(255) DEFAULT NULL,
                INDEX (`id`)
            );";
            $connect->exec($create);
        }

        $AD_TABLE = 'admission_tuition';
        $query = "SHOW TABLES LIKE '$AD_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $AD_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `admission_no` VARCHAR(255) DEFAULT NULL,
                `sf_plan` VARCHAR(255) DEFAULT NULL,
                `sf_amount` VARCHAR(255) DEFAULT 0,
                `me_plan` VARCHAR(255) DEFAULT NULL,
                `me_amount` VARCHAR(255) DEFAULT 0,

                `sf_ue_amount` VARCHAR(255) DEFAULT 0,
                `sf_ue_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_aug_amount` VARCHAR(255) DEFAULT 0,
                `sf_aug_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_sep_amount` VARCHAR(255) DEFAULT 0,
                `sf_sep_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_oct_amount` VARCHAR(255) DEFAULT 0,
                `sf_oct_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_nov_amount` VARCHAR(255) DEFAULT 0,
                `sf_nov_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_dec_amount` VARCHAR(255) DEFAULT 0,
                `sf_dec_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_jan_amount` VARCHAR(255) DEFAULT 0,
                `sf_jan_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_feb_amount` VARCHAR(255) DEFAULT 0,
                `sf_feb_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_mar_amount` VARCHAR(255) DEFAULT 0,
                `sf_mar_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_apr_amount` VARCHAR(255) DEFAULT 0,
                `sf_apr_date_paid` VARCHAR(255) DEFAULT NULL,
                `sf_may_amount` VARCHAR(255) DEFAULT 0,
                `sf_may_date_paid` VARCHAR(255) DEFAULT NULL,

                `me_ue_amount` VARCHAR(255) DEFAULT 0,
                `me_ue_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_aug_amount` VARCHAR(255) DEFAULT 0,
                `me_aug_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_sep_amount` VARCHAR(255) DEFAULT 0,
                `me_sep_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_oct_amount` VARCHAR(255) DEFAULT 0,
                `me_oct_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_nov_amount` VARCHAR(255) DEFAULT 0,
                `me_nov_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_dec_amount` VARCHAR(255) DEFAULT 0,
                `me_dec_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_jan_amount` VARCHAR(255) DEFAULT 0,
                `me_jan_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_feb_amount` VARCHAR(255) DEFAULT 0,
                `me_feb_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_mar_amount` VARCHAR(255) DEFAULT 0,
                `me_mar_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_apr_amount` VARCHAR(255) DEFAULT 0,
                `me_apr_date_paid` VARCHAR(255) DEFAULT NULL,
                `me_may_amount` VARCHAR(255) DEFAULT 0,
                `me_may_date_paid` VARCHAR(255) DEFAULT NULL,

                INDEX (`id`)
            );";
            $connect->exec($create);
        }

        // `net_total` VARCHAR(255) DEFAULT NULL,
        // `total_sf_a` VARCHAR(255) DEFAULT NULL,
        // `total_sf_b` VARCHAR(255) DEFAULT NULL,
        // `total_sf_c` VARCHAR(255) DEFAULT NULL,
        // `total_me_a` VARCHAR(255) DEFAULT NULL,
        // `total_me_b` VARCHAR(255) DEFAULT NULL,

        $TP_TABLE = 'tuition_plan';
        $query = "SHOW TABLES LIKE '$TP_TABLE'";
        $statement = $connect->prepare($query);
        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $create = "CREATE TABLE $TP_TABLE(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `high_school` VARCHAR(255) DEFAULT NULL,
                `sf_one_year` VARCHAR(255) DEFAULT 0,
                `sf_esc` VARCHAR(255) DEFAULT 0,

                `me_one_year` VARCHAR(255) DEFAULT 0,

                `sf_ue_a` VARCHAR(255) DEFAULT 0,
                `sf_aug_a` VARCHAR(255) DEFAULT 0,
                `sf_sep_a` VARCHAR(255) DEFAULT 0,
                `sf_oct_a` VARCHAR(255) DEFAULT 0,
                `sf_nov_a` VARCHAR(255) DEFAULT 0,
                `sf_dec_a` VARCHAR(255) DEFAULT 0,
                `sf_jan_a` VARCHAR(255) DEFAULT 0,
                `sf_feb_a` VARCHAR(255) DEFAULT 0,
                `sf_mar_a` VARCHAR(255) DEFAULT 0,
                `sf_apr_a` VARCHAR(255) DEFAULT 0,
                `sf_may_a` VARCHAR(255) DEFAULT 0,

                `sf_ue_b` VARCHAR(255) DEFAULT 0,
                `sf_aug_b` VARCHAR(255) DEFAULT 0,
                `sf_sep_b` VARCHAR(255) DEFAULT 0,
                `sf_oct_b` VARCHAR(255) DEFAULT 0,
                `sf_nov_b` VARCHAR(255) DEFAULT 0,
                `sf_dec_b` VARCHAR(255) DEFAULT 0,
                `sf_jan_b` VARCHAR(255) DEFAULT 0,
                `sf_feb_b` VARCHAR(255) DEFAULT 0,
                `sf_mar_b` VARCHAR(255) DEFAULT 0,
                `sf_apr_b` VARCHAR(255) DEFAULT 0,
                `sf_may_b` VARCHAR(255) DEFAULT 0,

                `sf_ue_c` VARCHAR(255) DEFAULT 0,
                `sf_aug_c` VARCHAR(255) DEFAULT 0,
                `sf_sep_c` VARCHAR(255) DEFAULT 0,
                `sf_oct_c` VARCHAR(255) DEFAULT 0,
                `sf_nov_c` VARCHAR(255) DEFAULT 0,
                `sf_dec_c` VARCHAR(255) DEFAULT 0,
                `sf_jan_c` VARCHAR(255) DEFAULT 0,
                `sf_feb_c` VARCHAR(255) DEFAULT 0,
                `sf_mar_c` VARCHAR(255) DEFAULT 0,
                `sf_apr_c` VARCHAR(255) DEFAULT 0,
                `sf_may_c` VARCHAR(255) DEFAULT 0,

                `me_ue_a` VARCHAR(255) DEFAULT 0,
                `me_aug_a` VARCHAR(255) DEFAULT 0,
                `me_sep_a` VARCHAR(255) DEFAULT 0,
                `me_oct_a` VARCHAR(255) DEFAULT 0,
                `me_nov_a` VARCHAR(255) DEFAULT 0,
                `me_dec_a` VARCHAR(255) DEFAULT 0,
                `me_jan_a` VARCHAR(255) DEFAULT 0,
                `me_feb_a` VARCHAR(255) DEFAULT 0,
                `me_mar_a` VARCHAR(255) DEFAULT 0,
                `me_apr_a` VARCHAR(255) DEFAULT 0,
                `me_may_a` VARCHAR(255) DEFAULT 0,

                `me_ue_b` VARCHAR(255) DEFAULT 0,
                `me_aug_b` VARCHAR(255) DEFAULT 0,
                `me_sep_b` VARCHAR(255) DEFAULT 0,
                `me_oct_b` VARCHAR(255) DEFAULT 0,
                `me_nov_b` VARCHAR(255) DEFAULT 0,
                `me_dec_b` VARCHAR(255) DEFAULT 0,
                `me_jan_b` VARCHAR(255) DEFAULT 0,
                `me_feb_b` VARCHAR(255) DEFAULT 0,
                `me_mar_b` VARCHAR(255) DEFAULT 0,
                `me_apr_b` VARCHAR(255) DEFAULT 0,
                `me_may_b` VARCHAR(255) DEFAULT 0,

                INDEX (`id`)
            );";
            $connect->exec($create);
            query($connect, "INSERT INTO $TP_TABLE (high_school) VALUES ('Junior') ");
            query($connect, "INSERT INTO $TP_TABLE (high_school) VALUES ('Junior ESC') ");
            query($connect, "INSERT INTO $TP_TABLE (high_school) VALUES ('Senior') ");
            query($connect, "INSERT INTO $TP_TABLE (high_school) VALUES ('Senior ESC') ");
        }

    } catch(PDOException $err){   
        $connect = null;
        return;
    }

?>