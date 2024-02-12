<?php

include('config.php');

if(isset($_POST['btn_action']))
{

	if($_POST['btn_action'] == 'login' )
	{
        $result = fetch_row($connect, "SELECT * FROM $USER_TABLE WHERE user_name = '".trim($_POST["username"])."' ");
        if($result)
        {
            if($result['status'] == 'Active')
            {
                if(password_verify(trim($_POST["password"]), $result["password"]))
                {
                    $_SESSION['user_name']  = $result['user_name'];
                    $_SESSION['user_type']  = $result['user_type'];
                    $_SESSION['user_id']    = $result['id'];
                    $output['status'] = true;
                }
                else
                {
                    $output['status'] = false;
                    $output['message'] = 'Wrong password!';
                }
            }
            else
            {
                $output['status'] = false;
                $output['message'] = 'Invalid Account!';
            }
        }
        else
        {
            $output['status'] = false;
            $output['message'] = 'Account does not exist';
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'user_add' )
	{
        $count = get_total_count($connect, "SELECT * FROM $USER_TABLE WHERE fullname = '".trim($_POST["fullname"])."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Fullname already exist.';
        }
        else 
        {
            $count = get_total_count($connect, "SELECT * FROM $USER_TABLE WHERE user_name = '".trim($_POST["username"])."' ");
            if ($count > 0)
            {
                $output['status'] = false;
                $output['message'] = 'Username already exist.';
            }
            else 
            {
                $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
                $connect->beginTransaction();
                $create = query($connect, "INSERT INTO $USER_TABLE ($USER_COLUMN) VALUES 
                ('".trim($_POST["fullname"])."', '".trim($_POST["username"])."', '".$password."' , '', '', 'Staff', 'Active','".date("m-d-Y h:i A")."') ");
                if ($create == true)
                {
                    $connect->commit();
                    $output['status'] = true;
                    $output['message'] = 'Created successfully.';
                }
                else 
                {
                    $connect->rollBack();
                    $output['status'] = false;
                    $output['message'] = 'Something went wrong.';
                }
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'user_status' )
	{
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
        else
        {
			$status = 'Active';	
        }
        $connect->beginTransaction();
        $update = query($connect, "UPDATE $USER_TABLE SET status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}
	
	if($_POST['btn_action'] == 'user_fetch' )
	{
        $result = fetch_row($connect, "SELECT * FROM $USER_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['username'] = $result['user_name'];
        $output['fullname'] = $result['fullname'];
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'user_update' )
	{
        $count = get_total_count($connect, "SELECT * FROM $USER_TABLE WHERE fullname = '".trim($_POST["fullname"])."' AND id != '".$_POST['id']."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Fullname already exist.';
        }
        else 
        {
            $count = get_total_count($connect, "SELECT * FROM $USER_TABLE WHERE user_name = '".trim($_POST["username"])."' AND id != '".$_POST['id']."' ");
            if ($count > 0)
            {
                $output['status'] = false;
                $output['message'] = 'Username already exist.';
            }
            else 
            {
                $connect->beginTransaction();
                if (!empty(trim($_POST["password"])))
                {
                    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
                    $update = query($connect, "UPDATE $USER_TABLE SET 
                        fullname = '".trim($_POST["fullname"])."', 
                        user_name = '".trim($_POST["username"])."', 
                        password = '".$password."'
                    WHERE id = '".$_POST['id']."' ");
                }
                else
                {
                    $update = query($connect, "UPDATE $USER_TABLE SET 
                        fullname = '".trim($_POST["fullname"])."', 
                        user_name = '".trim($_POST["username"])."'
                    WHERE id = '".$_POST['id']."' ");
                }
                if ($update == true)
                {
                    $connect->commit();
                    $output['status'] = true;
                    $output['message'] = 'Edited successfully.';
                }
                else 
                {
                    $connect->rollBack();
                    $output['status'] = false;
                    $output['message'] = 'Something went wrong.';
                }
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'instructors_add' )
	{
        $count = get_total_count($connect, "SELECT * FROM $INSTRUCTOR_TABLE WHERE fullname = '".trim($_POST["fullname"])."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Fullname already exist.';
        }
        else 
        {
            $strand = isset($_POST["strand_id"]) ? $_POST["strand_id"] : '';
            $section = isset($_POST["section_id"]) ? $_POST["section_id"] : '';
            $connect->beginTransaction();
            $create = query($connect, "INSERT INTO $INSTRUCTOR_TABLE (grade_level, strand_id, section_id, fullname, gender, contact, status, date_created) VALUES 
            ('".trim($_POST["grade_level"])."', '".$strand."', '".$section."', 
            '".trim($_POST["fullname"])."', '".trim($_POST["gender"])."', '".trim($_POST["contact"])."', 
            'Active','".date("m-d-Y h:i A")."') ");
            if ($create == true)
            {
                if (!empty(trim($_POST["grade_level"])))
                {
                    $last_id = $connect->lastInsertId();
                    if (intval(trim($_POST["grade_level"])) > 10)
                    {
                        query($connect, "UPDATE $SHSECTION_TABLE SET adviser_id = '".$last_id."' WHERE id = '".$_POST['section_id']."' ");
                    }
                    else
                    {
                        query($connect, "UPDATE $JHSECTION_TABLE SET adviser_id = '".$last_id."' WHERE id = '".$_POST['section_id']."' ");
                    }
                }
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Created successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'instructors_status' )
	{
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
        else
        {
			$status = 'Active';	
        }
        $connect->beginTransaction();
        $update = query($connect, "UPDATE $INSTRUCTOR_TABLE SET status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}
	
	if($_POST['btn_action'] == 'instructors_fetch' )
	{
        $result = fetch_row($connect, "SELECT * FROM $INSTRUCTOR_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['gender'] = $result['gender'];
        $output['fullname'] = $result['fullname'];
        $output['contact'] = $result['contact'];
        $output['grade_level'] = $result['grade_level'];
        $output['strand_id'] = $result['strand_id'];
        $output['section_id'] = $result['section_id'];
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'instructors_update' )
	{
        $count = get_total_count($connect, "SELECT * FROM $INSTRUCTOR_TABLE WHERE fullname = '".trim($_POST["fullname"])."' AND id != '".$_POST['id']."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Fullname already exist.';
        }
        else 
        {
            $strand = isset($_POST["strand_id"]) ? $_POST["strand_id"] : '';
            $section = isset($_POST["section_id"]) ? $_POST["section_id"] : '';
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $INSTRUCTOR_TABLE SET 
                grade_level = '".trim($_POST["grade_level"])."', 
                strand_id = '".$strand."', 
                section_id = '".$section."', 
                fullname = '".trim($_POST["fullname"])."', 
                gender = '".trim($_POST["gender"])."', 
                contact = '".trim($_POST["contact"])."'
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                if (!empty(trim($_POST["grade_level"])))
                {
                    $last_id = $_POST['id'];
                    if (intval(trim($_POST["grade_level"])) > 10)
                    {
                        query($connect, "UPDATE $SHSECTION_TABLE SET adviser_id = '".$last_id."' WHERE id = '".$_POST['section_id']."' ");
                    }
                    else
                    {
                        query($connect, "UPDATE $JHSECTION_TABLE SET adviser_id = '".$last_id."' WHERE id = '".$_POST['section_id']."' ");
                    }
                }
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Edited successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'sy_add' )
	{
        $count = get_total_count($connect, "SELECT * FROM $SY_TABLE WHERE school_year = '".trim($_POST["school_year"])."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'School year already exist.';
        }
        else 
        {
            $connect->beginTransaction();

            $update = query($connect, "UPDATE $JHSECTION_TABLE SET no_students = '0' "); // WHERE status = 'Active'
            $update = query($connect, "UPDATE $SHSECTION_TABLE SET no_students = '0' ");

            $update = query($connect, "UPDATE $SY_TABLE SET status = 'Inactive' WHERE status = 'Active' ");

            $create = query($connect, "INSERT INTO $SY_TABLE (school_year, status, date_created) VALUES 
            ('".trim($_POST["school_year"])."', 'Active','".date("m-d-Y h:i A")."') ");
            if ($create == true)
            {

                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Created successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'sy_status' )
	{
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
        else
        {
			$status = 'Active';	
        }
        $connect->beginTransaction();
            
        $update = query($connect, "UPDATE $SY_TABLE SET 
            status = 'Inactive' 
        WHERE status = 'Active' ");

        $update = query($connect, "UPDATE $SY_TABLE SET status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}
	
	if($_POST['btn_action'] == 'sy_fetch' )
	{
        $result = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['school_year'] = $result['school_year'];
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'sy_update' )
	{
        $count = get_total_count($connect, "SELECT * FROM $SY_TABLE WHERE school_year = '".trim($_POST["school_year"])."' AND id != '".$_POST['id']."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'School year already exist.';
        }
        else 
        {
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $SY_TABLE SET 
                school_year = '".trim($_POST["school_year"])."' 
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Edited successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'sem_status' )
	{
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
        else
        {
			$status = 'Active';	
        }
        $connect->beginTransaction();
            
        $update = query($connect, "UPDATE $SEM_TABLE SET 
            status = 'Inactive' 
        WHERE status = 'Active' ");

        $update = query($connect, "UPDATE $SEM_TABLE SET status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'strand_add' )
	{
        $count = get_total_count($connect, "SELECT * FROM $STRANDS_TABLE WHERE strand = '".trim($_POST["strand"])."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Strand already exist.';
        }
        else 
        {
            $connect->beginTransaction();

            $create = query($connect, "INSERT INTO $STRANDS_TABLE (strand, status, date_created) VALUES 
            ('".trim($_POST["strand"])."', 'Active','".date("m-d-Y h:i A")."') ");
            if ($create == true)
            {

                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Created successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'strand_status' )
	{
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
        else
        {
			$status = 'Active';	
        }
        $connect->beginTransaction();

        $update = query($connect, "UPDATE $STRANDS_TABLE SET status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}
	
	if($_POST['btn_action'] == 'strand_fetch' )
	{
        $result = fetch_row($connect, "SELECT * FROM $STRANDS_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['strand'] = $result['strand'];
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'strand_update' )
	{
        $count = get_total_count($connect, "SELECT * FROM $STRANDS_TABLE WHERE strand = '".trim($_POST["strand"])."' AND id != '".$_POST['id']."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Strand already exist.';
        }
        else 
        {
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $STRANDS_TABLE SET 
                strand = '".trim($_POST["strand"])."' 
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Edited successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'jhsection_add' )
	{
        $count = get_total_count($connect, "SELECT * FROM $JHSECTION_TABLE WHERE grade_level = '".trim($_POST["grade_level"])."' AND section = '".trim($_POST["section"])."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Section already exist.';
        }
        else 
        {
            $connect->beginTransaction();

            $create = query($connect, "INSERT INTO $JHSECTION_TABLE (grade_level, section, grade_lowest, grade_highest, no_limit, no_students, status, date_created) VALUES 
            ('".trim($_POST["grade_level"])."', '".trim($_POST["section"])."', '".trim($_POST["grade_lowest"])."', '".trim($_POST["grade_highest"])."', 
            '".trim($_POST["no_limit"])."', '0', 'Active', '".date("m-d-Y h:i A")."') ");
            if ($create == true)
            {

                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Created successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'jhsection_status' )
	{
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
        else
        {
			$status = 'Active';	
        }
        $connect->beginTransaction();

        $update = query($connect, "UPDATE $JHSECTION_TABLE SET status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}
	
	if($_POST['btn_action'] == 'jhsection_fetch' )
	{
        $result = fetch_row($connect, "SELECT * FROM $JHSECTION_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['grade_level'] = $result['grade_level'];
        $output['section'] = $result['section'];
        $output['grade_lowest'] = $result['grade_lowest'];
        $output['grade_highest'] = $result['grade_highest'];
        $output['no_limit'] = $result['no_limit'];
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'jhsection_update' )
	{
        $count = get_total_count($connect, "SELECT * FROM $JHSECTION_TABLE WHERE 
        grade_level = '".trim($_POST["grade_level"])."' AND section = '".trim($_POST["section"])."' AND id != '".$_POST['id']."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Section already exist.';
        }
        else 
        {
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $JHSECTION_TABLE SET 
                grade_level = '".trim($_POST["grade_level"])."', 
                section = '".trim($_POST["section"])."', 
                grade_lowest = '".trim($_POST["grade_lowest"])."', 
                grade_highest = '".trim($_POST["grade_highest"])."', 
                no_limit = '".trim($_POST["no_limit"])."'
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Edited successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'shsection_add' )
	{
        $count = get_total_count($connect, "SELECT * FROM $SHSECTION_TABLE WHERE strand_id = '".trim($_POST["strand_id"])."' AND 
        grade_level = '".trim($_POST["grade_level"])."' AND section = '".trim($_POST["section"])."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Section already exist.';
        }
        else 
        {
            $connect->beginTransaction();

            $create = query($connect, "INSERT INTO $SHSECTION_TABLE (strand_id, grade_level, section, grade_lowest, grade_highest, no_limit, no_students, status, date_created) VALUES 
            ('".trim($_POST["strand_id"])."', '".trim($_POST["grade_level"])."', '".trim($_POST["section"])."', '".trim($_POST["grade_lowest"])."', 
            '".trim($_POST["grade_highest"])."', '".trim($_POST["no_limit"])."', '0', 'Active', '".date("m-d-Y h:i A")."') ");
            if ($create == true)
            {

                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Created successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'shsection_status' )
	{
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
        else
        {
			$status = 'Active';	
        }
        $connect->beginTransaction();

        $update = query($connect, "UPDATE $SHSECTION_TABLE SET status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}
	
	if($_POST['btn_action'] == 'shsection_fetch' )
	{
        $result = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['strand_id'] = $result['strand_id'];
        $output['grade_level'] = $result['grade_level'];
        $output['section'] = $result['section'];
        $output['grade_lowest'] = $result['grade_lowest'];
        $output['grade_highest'] = $result['grade_highest'];
        $output['no_limit'] = $result['no_limit'];
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'shsection_update' )
	{
        $count = get_total_count($connect, "SELECT * FROM $SHSECTION_TABLE WHERE strand_id = '".trim($_POST["strand_id"])."' AND 
        grade_level = '".trim($_POST["grade_level"])."' AND section = '".trim($_POST["section"])."' AND id != '".$_POST['id']."' ");
        if ($count > 0)
        {
            $output['status'] = false;
            $output['message'] = 'Section already exist.';
        }
        else 
        {
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $SHSECTION_TABLE SET 
                strand_id = '".trim($_POST["strand_id"])."', 
                grade_level = '".trim($_POST["grade_level"])."', 
                section = '".trim($_POST["section"])."', 
                grade_lowest = '".trim($_POST["grade_lowest"])."', 
                grade_highest = '".trim($_POST["grade_highest"])."', 
                no_limit = '".trim($_POST["no_limit"])."'
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Edited successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'lrn_validation' )
    {
        $sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
        if (trim($_POST["lrn"]) == 'Old' || trim($_POST["lrn"]) == 'Returnee')
        {
            $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE lrn = '".trim($_POST["lrn"])."' AND status NOT IN ('Rejected') 
            AND school_year = '".$sy["school_year"]."'
            ORDER BY id ASC LIMIT 1 "); // AND archived IS NULL
            if (!$student)
            {
                $output['status'] = true;
                $output['message'] = 'LRN does not exist.';
            }
            else
            {
                $output['status'] = false;
                $output['message'] = 'LRN does exist.';
                // $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE email = '".trim($_POST["email"])."' AND status NOT IN ('Rejected') 
                // ORDER BY id ASC LIMIT 1 ");
                // if ($student)
                // {
                //     $output['status'] = true;
                //     $output['message'] = 'Email does exist.';
                // }
                // else
                // {
                //     $output['status'] = false;
                //     $output['message'] = 'Email does not exist.';
                // }
            }
        }
        else
        {
            $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE lrn = '".trim($_POST["lrn"])."' AND status NOT IN ('Rejected') 
            AND school_year = '".$sy["school_year"]."'
            ORDER BY id ASC LIMIT 1 ");
            if ($student)
            {
                $output['status'] = true;
                $output['message'] = 'LRN does exist.';
            }
            else
            {
                $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE email = '".trim($_POST["email"])."' AND status NOT IN ('Rejected') 
                AND school_year = '".$sy["school_year"]."'
                ORDER BY id ASC LIMIT 1 ");
                if ($student)
                {
                    $output['status'] = true;
                    $output['message'] = 'Email does exist.';
                }
                else
                {
                    // $output['status'] = false;
                    // $output['message'] = 'Email does not exist.';
                    $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE last_name = '".trim($_POST["last_name"])."' 
                    AND first_name = '".trim($_POST["first_name"])."' AND middle_name = '".trim($_POST["middle_name"])."' AND extension_name = '".trim($_POST["extension_name"])."' 
                    AND status NOT IN ('Rejected') 
                    AND school_year = '".$sy["school_year"]."'
                    ORDER BY id ASC LIMIT 1 ");
                    if ($student)
                    {
                        $output['status'] = true;
                        $output['message'] = 'Fullname does exist.';
                    }
                    else
                    {
                        $output['status'] = false;
                        $output['message'] = 'Fullname does not exist.';
                    }
                }
            }
        }
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'admission_student' )
	{
        $sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
        if ($sy)
        {
            $school_year = $sy["school_year"];
            $sem = fetch_row($connect, "SELECT * FROM $SEM_TABLE WHERE status = 'Active' ");
            $semester = $sem["semester"];
            if ($_FILES["file"]["size"] !== 0)
            {
                if (trim($_POST["student_status"]) == 'New' || trim($_POST["student_status"]) == 'Transferee')
                {
                    // validate lrn, fullname, email
                    $count = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE lrn = '".trim($_POST["lrn"])."' AND status NOT IN ('Rejected') AND archived IS NULL
                    AND school_year = '".$school_year."' ");
                    if ($count > 0)
                    {
                        $output['status'] = false;
                        $output['message'] = 'LRN already exist.';
                    }
                    else
                    {
                        $count = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE last_name = '".trim($_POST["last_name"])."' AND 
                        first_name = '".trim($_POST["first_name"])."' AND middle_name = '".trim($_POST["middle_name"])."' 
                        AND extension_name = '".trim($_POST["extension_name"])."' AND status NOT IN ('Rejected') AND archived IS NULL
                        AND school_year = '".$school_year."' ");
                        if ($count > 0)
                        {
                            $output['status'] = false;
                            $output['message'] = 'Fullname already exist.';
                        }
                        else
                        {
                            $count = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE email = '".trim($_POST["email"])."' 
                            AND status NOT IN ('Rejected') AND archived IS NULL AND school_year = '".$school_year."' ");
                            if ($count > 0)
                            {
                                $output['status'] = false;
                                $output['message'] = 'Email already exist.';
                            }
                            else
                            {
                                $avatar = $_FILES["file"]["name"];
                                $png = strpos($avatar, 'png');
                                $jpg = strpos($avatar, 'jpg');
                                $jpeg = strpos($avatar, 'jpeg');
                                $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                if ($type == 'false')
                                {
                                    $output['status'] = false;
                                    $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                }
                                else
                                {
                                    $file_type = array("jpg", "png", "jpeg");

                                    $admission_no = '';
                                    $result = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE ORDER BY id DESC LIMIT 1");
                                    if ($result)
                                    {
                                        if ( date('Y') == substr($result['admission_no'], 4, 4) )
                                        {
                                            $add = intval(substr($result['admission_no'], 8)) + 1;
                                            if (strlen($add) == 1) { $add = "00000".$add; }
                                            if (strlen($add) == 2) { $add = "0000".$add; }
                                            if (strlen($add) == 3) { $add = "000".$add; }
                                            if (strlen($add) == 4) { $add = "00".$add; }
                                            if (strlen($add) == 5) { $add = "0".$add; }
                                            $admission_no = "ANS-".date('Y').$add;
                                        } 
                                        else { $admission_no = "ANS-".date('Y').'000001'; }
                                    }
                                    else { $admission_no = "ANS-".date('Y').'000001';  }
                                
                                    $report_card1 = '';
                                    $report_card_date = '';
                                    $image = $_FILES["report_card1"]["name"];
                                    $png = strpos($image, 'png');
                                    $jpg = strpos($image, 'jpg');
                                    $jpeg = strpos($image, 'jpeg');
                                    $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                    if ($type == 'false')
                                    {
                                        $output['status'] = false;
                                        $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                        echo json_encode($output);
                                        return;
                                    }
                                    $upload = upload_image($_FILES["report_card1"], $admission_no.'_report_card1', 'assets/files/', $file_type, $type);
                                    if ($upload["status"] == false)
                                    {
                                        $output['status'] = false;
                                        $output['message'] = $upload["message"];
                                        echo json_encode($output);
                                        return;
                                    }
                                    else
                                    {
                                        $report_card1 = $upload["message"];
                                        $report_card_date = date("m-d-Y");
                                    }
                                    
                                    $report_card2 = '';
                                    $image = $_FILES["report_card2"]["name"];
                                    $png = strpos($image, 'png');
                                    $jpg = strpos($image, 'jpg');
                                    $jpeg = strpos($image, 'jpeg');
                                    $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                    if ($type == 'false')
                                    {
                                        $output['status'] = false;
                                        $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                        echo json_encode($output);
                                        return;
                                    }
                                    $upload = upload_image($_FILES["report_card2"], $admission_no.'_report_card2', 'assets/files/', $file_type, $type);
                                    if ($upload["status"] == false)
                                    {
                                        $output['status'] = false;
                                        $output['message'] = $upload["message"];
                                        echo json_encode($output);
                                        return;
                                    }
                                    else
                                    {
                                        $report_card2 = $upload["message"];
                                    }
                                    
                                    $form_1371 = '';
                                    $form_137_date = '';
                                    if ($_FILES["form_1371"]["size"] !== 0)
                                    {
                                        $image = $_FILES["form_1371"]["name"];
                                        $png = strpos($image, 'png');
                                        $jpg = strpos($image, 'jpg');
                                        $jpeg = strpos($image, 'jpeg');
                                        $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                        if ($type == 'false')
                                        {
                                            $output['status'] = false;
                                            $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                            echo json_encode($output);
                                            return;
                                        }
                                        $upload = upload_image($_FILES["form_1371"], $admission_no.'_form_1371', 'assets/files/', $file_type, $type);
                                        if ($upload["status"] == false)
                                        {
                                            $output['status'] = false;
                                            $output['message'] = $upload["message"];
                                            echo json_encode($output);
                                            return;
                                        }
                                        else
                                        {
                                            $form_1371 = $upload["message"];
                                            $form_137_date = date("m-d-Y");
                                        }
                                    }
                                    
                                    $form_1372 = '';
                                    if ($_FILES["form_1372"]["size"] !== 0)
                                    {
                                        $image = $_FILES["form_1372"]["name"];
                                        $png = strpos($image, 'png');
                                        $jpg = strpos($image, 'jpg');
                                        $jpeg = strpos($image, 'jpeg');
                                        $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                        if ($type == 'false')
                                        {
                                            $output['status'] = false;
                                            $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                            echo json_encode($output);
                                            return;
                                        }
                                        $upload = upload_image($_FILES["form_1372"], $admission_no.'_form_1372', 'assets/files/', $file_type, $type);
                                        if ($upload["status"] == false)
                                        {
                                            $output['status'] = false;
                                            $output['message'] = $upload["message"];
                                            echo json_encode($output);
                                            return;
                                        }
                                        else
                                        {
                                            $form_1372 = $upload["message"];
                                        }
                                    }
                                    
                                    $psa = '';
                                    $psa_date = '';
                                    $image = $_FILES["psa"]["name"];
                                    $png = strpos($image, 'png');
                                    $jpg = strpos($image, 'jpg');
                                    $jpeg = strpos($image, 'jpeg');
                                    $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                    if ($type == 'false')
                                    {
                                        $output['status'] = false;
                                        $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                        echo json_encode($output);
                                        return;
                                    }
                                    $upload = upload_image($_FILES["psa"], $admission_no.'_psa', 'assets/files/', $file_type, $type);
                                    if ($upload["status"] == false)
                                    {
                                        $output['status'] = false;
                                        $output['message'] = $upload["message"];
                                        echo json_encode($output);
                                        return;
                                    }
                                    else
                                    {
                                        $psa = $upload["message"];
                                        $psa_date = date("m-d-Y");
                                    }
                                    
                                    $good_moral = '';
                                    $good_moral_date = '';
                                    if ($_FILES["good_moral"]["size"] !== 0)
                                    {
                                        $image = $_FILES["good_moral"]["name"];
                                        $png = strpos($image, 'png');
                                        $jpg = strpos($image, 'jpg');
                                        $jpeg = strpos($image, 'jpeg');
                                        $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                        if ($type == 'false')
                                        {
                                            $output['status'] = false;
                                            $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                            echo json_encode($output);
                                            return;
                                        }
                                        $upload = upload_image($_FILES["good_moral"], $admission_no.'_good_moral', 'assets/files/', $file_type, $type);
                                        if ($upload["status"] == false)
                                        {
                                            $output['status'] = false;
                                            $output['message'] = $upload["message"];
                                            echo json_encode($output);
                                            return;
                                        }
                                        else
                                        {
                                            $good_moral = $upload["message"];
                                            $good_moral_date = date("m-d-Y");
                                        }
                                    }
                                    
                                    $certificate = '';
                                    $certificate_date = '';
                                    $image = $_FILES["certificate"]["name"];
                                    $png = strpos($image, 'png');
                                    $jpg = strpos($image, 'jpg');
                                    $jpeg = strpos($image, 'jpeg');
                                    $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                    if ($type == 'false')
                                    {
                                        $output['status'] = false;
                                        $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                        echo json_encode($output);
                                        return;
                                    }
                                    $upload = upload_image($_FILES["certificate"], $admission_no.'_certificate', 'assets/files/', $file_type, $type);
                                    if ($upload["status"] == false)
                                    {
                                        $output['status'] = false;
                                        $output['message'] = $upload["message"];
                                        echo json_encode($output);
                                        return;
                                    }
                                    else
                                    {
                                        $certificate = $upload["message"];
                                        $certificate_date = date("m-d-Y");
                                    }
                    
                                    $upload = upload_image($_FILES["file"], $admission_no.'_avatar', 'assets/avatar/', $file_type, $type);
                                    if ($upload["status"] == false)
                                    {
                                        $output['status'] = false;
                                        $output['message'] = $upload["message"];
                                    }
                                    else
                                    {
                                        $avatar = $upload["message"];
                                        $strand_id = '';
                                        $high_school = 'Junior';
                                        if ($_POST["grade_level"] > 10)
                                        {
                                            $strand_id = $_POST["strand_id"];
                                            $high_school = 'Senior';
                                        }
            
                                        $sf_amount = '0';
                                        $me_amount = '0';
                                        $tp_result = fetch_row($connect,"SELECT * FROM $TP_TABLE WHERE high_school = '".$high_school."' " );
                                        $sf_amount = $tp_result["sf_one_year"];
                                        $me_amount = $tp_result["me_one_year"];
            
                                        $school_fees = '';
                                        $modules_ebook = '';
                                        $connect->beginTransaction();
                                        if (trim($_POST["payment_method"]) == 'Installment')
                                        {
                                            $school_fees = trim($_POST["school_fees"]);
                                            $modules_ebook = trim($_POST["modules_ebook"]);
                                            if (trim($_POST["school_fees"]) == 'A')
                                            {
                                                $sf_ue_amount = $tp_result["sf_ue_a"];
                                                $sf_aug_amount = $tp_result["sf_aug_a"];
                                                $sf_sep_amount = $tp_result["sf_sep_a"];
                                                $sf_oct_amount = $tp_result["sf_oct_a"];
                                                $sf_nov_amount = $tp_result["sf_nov_a"];
                                                $sf_dec_amount = $tp_result["sf_dec_a"];
                                                $sf_jan_amount = $tp_result["sf_jan_a"];
                                                $sf_feb_amount = $tp_result["sf_feb_a"];
                                                $sf_mar_amount = $tp_result["sf_mar_a"];
                                                $sf_apr_amount = $tp_result["sf_apr_a"];
                                                $sf_may_amount = $tp_result["sf_may_a"];
                                            }
                                            else if (trim($_POST["school_fees"]) == 'B')
                                            {
                                                $sf_ue_amount = $tp_result["sf_ue_b"];
                                                $sf_aug_amount = $tp_result["sf_aug_b"];
                                                $sf_sep_amount = $tp_result["sf_sep_b"];
                                                $sf_oct_amount = $tp_result["sf_oct_b"];
                                                $sf_nov_amount = $tp_result["sf_nov_b"];
                                                $sf_dec_amount = $tp_result["sf_dec_b"];
                                                $sf_jan_amount = $tp_result["sf_jan_b"];
                                                $sf_feb_amount = $tp_result["sf_feb_b"];
                                                $sf_mar_amount = $tp_result["sf_mar_b"];
                                                $sf_apr_amount = $tp_result["sf_apr_b"];
                                                $sf_may_amount = $tp_result["sf_may_b"];
                                            }
                                            else
                                            {
                                                $sf_ue_amount = $tp_result["sf_ue_c"];
                                                $sf_aug_amount = $tp_result["sf_aug_c"];
                                                $sf_sep_amount = $tp_result["sf_sep_c"];
                                                $sf_oct_amount = $tp_result["sf_oct_c"];
                                                $sf_nov_amount = $tp_result["sf_nov_c"];
                                                $sf_dec_amount = $tp_result["sf_dec_c"];
                                                $sf_jan_amount = $tp_result["sf_jan_c"];
                                                $sf_feb_amount = $tp_result["sf_feb_c"];
                                                $sf_mar_amount = $tp_result["sf_mar_c"];
                                                $sf_apr_amount = $tp_result["sf_apr_c"];
                                                $sf_may_amount = $tp_result["sf_may_c"];
                                            }
                                            if (trim($_POST["modules_ebook"]) == 'A')
                                            {
                                                $me_ue_amount = $tp_result["me_ue_a"];
                                                $me_aug_amount = $tp_result["me_aug_a"];
                                                $me_sep_amount = $tp_result["me_sep_a"];
                                                $me_oct_amount = $tp_result["me_oct_a"];
                                                $me_nov_amount = $tp_result["me_nov_a"];
                                                $me_dec_amount = $tp_result["me_dec_a"];
                                                $me_jan_amount = $tp_result["me_jan_a"];
                                                $me_feb_amount = $tp_result["me_feb_a"];
                                                $me_mar_amount = $tp_result["me_mar_a"];
                                                $me_apr_amount = $tp_result["me_apr_a"];
                                                $me_may_amount = $tp_result["me_may_a"];
                                            }
                                            else
                                            {
                                                $me_ue_amount = $tp_result["me_ue_b"];
                                                $me_aug_amount = $tp_result["me_aug_b"];
                                                $me_sep_amount = $tp_result["me_sep_b"];
                                                $me_oct_amount = $tp_result["me_oct_b"];
                                                $me_nov_amount = $tp_result["me_nov_b"];
                                                $me_dec_amount = $tp_result["me_dec_b"];
                                                $me_jan_amount = $tp_result["me_jan_b"];
                                                $me_feb_amount = $tp_result["me_feb_b"];
                                                $me_mar_amount = $tp_result["me_mar_b"];
                                                $me_apr_amount = $tp_result["me_apr_b"];
                                                $me_may_amount = $tp_result["me_may_b"];
                                            }
                                            query($connect, "INSERT INTO $AD_TABLE (admission_no, sf_plan, sf_amount, me_plan, me_amount, sf_ue_amount, sf_aug_amount, sf_sep_amount,
                                            sf_oct_amount, sf_nov_amount, sf_dec_amount, sf_jan_amount, sf_feb_amount, sf_mar_amount, sf_apr_amount, sf_may_amount,
                                            me_ue_amount, me_aug_amount, me_sep_amount, me_oct_amount, me_nov_amount, me_dec_amount, me_jan_amount, me_feb_amount,
                                            me_mar_amount, me_apr_amount, me_may_amount) VALUES 
                                            ('".$admission_no."', '".$school_fees."', '".$sf_amount."', '".$modules_ebook."', '".$me_amount."',
                                            '".$sf_ue_amount."', '".$sf_aug_amount."', '".$sf_sep_amount."', '".$sf_oct_amount."', '".$sf_nov_amount."', '".$sf_dec_amount."',
                                            '".$sf_jan_amount."', '".$sf_feb_amount."', '".$sf_mar_amount."', '".$sf_apr_amount."', '".$sf_may_amount."',
                                            '".$me_ue_amount."', '".$me_aug_amount."', '".$me_sep_amount."', '".$me_oct_amount."', '".$me_nov_amount."', '".$me_dec_amount."',
                                            '".$me_jan_amount."', '".$me_feb_amount."', '".$me_mar_amount."', '".$me_apr_amount."', '".$me_may_amount."' ) ");
                                        }
                    
                                        $create = query($connect, "INSERT INTO $ADMISSION_TABLE (school_year, semester, admission_no, avatar, student_status, grade_level, strand_id, 
                                        lrn, last_name, first_name, middle_name, extension_name, 
                                        address, email, contact, date_birth, sex, nationality, last_attended, g_fullname, g_contact, g_relationship, g_occupation, g_address, 
                                        payment_method, sf_plan, sf_amount, me_plan, me_amount, status, visitor_name, 
                                        report_card1, report_card2, report_card_date,
                                        form_1371, form_1372, form_137_date,
                                        psa, psa_date,
                                        good_moral, good_moral_date,
                                        certificate, certificate_date,
                                        date_created) VALUES 
                                        ('".$school_year."', '".$semester."', '".$admission_no."', '".$avatar."', '".trim($_POST["student_status"])."', '".trim($_POST["grade_level"])."', '".$strand_id."', 
                                        '".trim($_POST["lrn"])."', '".trim($_POST["last_name"])."', '".trim($_POST["first_name"])."', 
                                        '".trim($_POST["middle_name"])."', '".trim($_POST["extension_name"])."', 
                                        '".trim($_POST["address"])."', '".trim($_POST["email"])."', '".trim($_POST["contact"])."', '".trim($_POST["date_birth"])."', '".trim($_POST["sex"])."', 
                                        '".trim($_POST["nationality"])."', '".trim($_POST["last_attended"])."', '".trim($_POST["g_fullname"])."', '".trim($_POST["g_contact"])."', '".trim($_POST["g_relationship"])."', 
                                        '".trim($_POST["g_occupation"])."', '".trim($_POST["g_address"])."', 
                                        '".trim($_POST["payment_method"])."', '".$school_fees."', '".$sf_amount."', '".$modules_ebook."', '".$me_amount."', 
                                        'Pending', '".trim($_POST["visitor_name"])."', 
                                        '".$report_card1."', '".$report_card2."', '".$report_card_date."', 
                                        '".$form_1371."', '".$form_1372."', '".$form_137_date."', 
                                        '".$psa."', '".$psa_date."', 
                                        '".$good_moral."', '".$good_moral_date."', 
                                        '".$certificate."', '".$certificate_date."', 
                                        '".date("m-d-Y h:i A")."') ");
                                        if ($create == true)
                                        {
                                            // $connect->commit();
                                            // $output['status'] = true;
                                            // $output['message'] = 'Submitted successfully.';

                                            $track = '';
                                            if ($strand_id != '')
                                            {
                                                $strand = fetch_row($connect,"SELECT * FROM $STRANDS_TABLE WHERE id = '".$strand_id."' " );
                                                $track = '
                                                <b>Track: </b> '.trim($strand["strand"]).'
                                                <br>';
                                            }
                                            
                                            $requirements = '';
                                            if ($report_card1 != '')
                                            {
                                                $requirements .= '- SF9 (Report Card)<br>';
                                            }
                                            if ($form_1371 != '')
                                            {
                                                $requirements .= '- SF10 (Form 137)<br>';
                                            }
                                            if ($psa != '')
                                            {
                                                $requirements .= '- PSA Birth Certificate<br>';
                                            }
                                            if ($good_moral != '')
                                            {
                                                $requirements .= '- Good Moral Certificate<br>';
                                            }
                                            if ($certificate != '')
                                            {
                                                $requirements .= '- Certificate of No Financial Obligation';
                                            }
                    
                                            // send email 
                                            $mail = send_mail(trim($_POST["email"]), 
                                            trim($_POST['last_name']).", ".trim($_POST["first_name"])." ".trim($_POST["middle_name"])." ".trim($_POST["extension_name"]), 
                                            'ADMISSION', 
                                            'Good day Enrollee!<br><br>We received your admission form and we will check and process it.
                                            <br>We will email you again about the status of your application.
                                            <br>This is thye preview of your registration application, please check it for reference.

                                            <br><br>
                                            <b>'.trim($_POST["student_status"]).' Student</b> 
                                            <br>
                                            <b>LRN: </b> '.trim($_POST["lrn"]).'
                                            <br>
                                            <b>Grade Level: </b> '.trim($_POST["grade_level"]).
                                            $track.'
                                            <br>
                                            <b>Email: </b> '.trim($_POST["email"]).'
                                            <br>
                                            <b>Fullname: </b> '.trim($_POST['last_name']).", ".trim($_POST["first_name"])." ".trim($_POST["middle_name"])." ".trim($_POST["extension_name"]).'
                                            <br>
                                            <b>Date of Birth: </b> '.trim($_POST["date_birth"]).'
                                            <br>
                                            <b>Sex: </b> '.trim($_POST["sex"]).'
                                            <br>
                                            <b>Nationality: </b> '.trim($_POST["nationality"]).'
                                            <br>
                                            <b>S.Y. Last Attended: </b> '.trim($_POST["last_attended"]).'
                                            <br>
                                            <b>Contact: </b> '.trim($_POST["contact"]).'
                                            <br>
                                            <b>Address: </b> '.trim($_POST["address"]).'

                                            <br><br>
                                            <b>Guardian Name: </b> '.trim($_POST["g_fullname"]).'
                                            <br>
                                            <b>Contact: </b> '.trim($_POST["g_contact"]).'
                                            <br>
                                            <b>Relationsip: </b> '.trim($_POST["g_relationship"]).'
                                            <br>
                                            <b>Occupation: </b> '.trim($_POST["g_occupation"]).'
                                            <br>
                                            <b>Address: </b> '.trim($_POST["g_address"]).'

                                            <br><br>
                                            <b>Payment Method: </b> '.trim($_POST["payment_method"]).'

                                            <br><br>
                                            <b>School Requirements: </b> <br>'.$requirements.'

                                            <br><br>
                                            <b>Visitor: </b> '.trim($_POST["visitor_name"]).'

                                            <br><br>You can follow-up by using your admission no. : '.$admission_no.'
                                            <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                                            <br> <br><i>This is a system generated email. Do not reply.<i>');
                                            if ($mail) // 
                                            {
                                                $connect->commit();
                                                $output['status'] = true;
                                                $output['message'] = 'Submitted successfully.';
                                            }
                                            else 
                                            {
                                                $connect->rollBack();
                                                $output['status'] = false;
                                                $output['message'] = 'Something went wrong.';
                                            }
                                        }
                                        else 
                                        {
                                            $connect->rollBack();
                                            $output['status'] = false;
                                            $output['message'] = 'Something went wrong.';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE lrn = '".trim($_POST["lrn"])."' AND status NOT IN ('Rejected') AND archived IS NULL
                    ORDER BY id ASC LIMIT 1 ");
                    if ($student)
                    {
                        if ($student["school_year"] == $school_year)
                        {
                            $output['status'] = false;
                            $output['message'] = 'LRN already exist.';
                        }
                        else // fetch previous data lrn, grade level, track email, payment requirements
                        {
                            $avatar = $_FILES["file"]["name"];
                            $png = strpos($avatar, 'png');
                            $jpg = strpos($avatar, 'jpg');
                            $jpeg = strpos($avatar, 'jpeg');
                            $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                            if ($type == 'false')
                            {
                                $output['status'] = false;
                                $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                            }
                            else
                            {
                                $file_type = array("jpg", "png", "jpeg");

                                $admission_no = '';
                                $result = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE ORDER BY id DESC LIMIT 1");
                                if ($result)
                                {
                                    if ( date('Y') == substr($result['admission_no'], 4, 4) )
                                    {
                                        $add = intval(substr($result['admission_no'], 8)) + 1;
                                        if (strlen($add) == 1) { $add = "00000".$add; }
                                        if (strlen($add) == 2) { $add = "0000".$add; }
                                        if (strlen($add) == 3) { $add = "000".$add; }
                                        if (strlen($add) == 4) { $add = "00".$add; }
                                        if (strlen($add) == 5) { $add = "0".$add; }
                                        $admission_no = "ANS-".date('Y').$add;
                                    } 
                                    else { $admission_no = "ANS-".date('Y').'000001'; }
                                }
                                else { $admission_no = "ANS-".date('Y').'000001';  }
                                
                                $report_card1 = '';
                                $report_card_date = '';
                                $image = $_FILES["report_card1"]["name"];
                                $png = strpos($image, 'png');
                                $jpg = strpos($image, 'jpg');
                                $jpeg = strpos($image, 'jpeg');
                                $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                if ($type == 'false')
                                {
                                    $output['status'] = false;
                                    $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                    echo json_encode($output);
                                    return;
                                }
                                $upload = upload_image($_FILES["report_card1"], $admission_no.'_report_card1', 'assets/files/', $file_type, $type);
                                if ($upload["status"] == false)
                                {
                                    $output['status'] = false;
                                    $output['message'] = $upload["message"];
                                    echo json_encode($output);
                                    return;
                                }
                                else
                                {
                                    $report_card1 = $upload["message"];
                                    $report_card_date = date("m-d-Y");
                                }
                                
                                $report_card2 = '';
                                $image = $_FILES["report_card2"]["name"];
                                $png = strpos($image, 'png');
                                $jpg = strpos($image, 'jpg');
                                $jpeg = strpos($image, 'jpeg');
                                $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                if ($type == 'false')
                                {
                                    $output['status'] = false;
                                    $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                    echo json_encode($output);
                                    return;
                                }
                                $upload = upload_image($_FILES["report_card2"], $admission_no.'_report_card2', 'assets/files/', $file_type, $type);
                                if ($upload["status"] == false)
                                {
                                    $output['status'] = false;
                                    $output['message'] = $upload["message"];
                                    echo json_encode($output);
                                    return;
                                }
                                else
                                {
                                    $report_card2 = $upload["message"];
                                }
                                
                                $form_1371 = '';
                                $form_137_date = '';
                                if ($_FILES["form_1371"]["size"] !== 0)
                                {
                                    $image = $_FILES["form_1371"]["name"];
                                    $png = strpos($image, 'png');
                                    $jpg = strpos($image, 'jpg');
                                    $jpeg = strpos($image, 'jpeg');
                                    $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                    if ($type == 'false')
                                    {
                                        $output['status'] = false;
                                        $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                        echo json_encode($output);
                                        return;
                                    }
                                    $upload = upload_image($_FILES["form_1371"], $admission_no.'_form_1371', 'assets/files/', $file_type, $type);
                                    if ($upload["status"] == false)
                                    {
                                        $output['status'] = false;
                                        $output['message'] = $upload["message"];
                                        echo json_encode($output);
                                        return;
                                    }
                                    else
                                    {
                                        $form_1371 = $upload["message"];
                                        $form_137_date = date("m-d-Y");
                                    }
                                }
                                
                                $form_1372 = '';
                                if ($_FILES["form_1372"]["size"] !== 0)
                                {
                                    $image = $_FILES["form_1372"]["name"];
                                    $png = strpos($image, 'png');
                                    $jpg = strpos($image, 'jpg');
                                    $jpeg = strpos($image, 'jpeg');
                                    $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                    if ($type == 'false')
                                    {
                                        $output['status'] = false;
                                        $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                        echo json_encode($output);
                                        return;
                                    }
                                    $upload = upload_image($_FILES["form_1372"], $admission_no.'_form_1372', 'assets/files/', $file_type, $type);
                                    if ($upload["status"] == false)
                                    {
                                        $output['status'] = false;
                                        $output['message'] = $upload["message"];
                                        echo json_encode($output);
                                        return;
                                    }
                                    else
                                    {
                                        $form_1372 = $upload["message"];
                                    }
                                }
                                
                                $psa = '';
                                $psa_date = '';
                                $image = $_FILES["psa"]["name"];
                                $png = strpos($image, 'png');
                                $jpg = strpos($image, 'jpg');
                                $jpeg = strpos($image, 'jpeg');
                                $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                if ($type == 'false')
                                {
                                    $output['status'] = false;
                                    $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                    echo json_encode($output);
                                    return;
                                }
                                $upload = upload_image($_FILES["psa"], $admission_no.'_psa', 'assets/files/', $file_type, $type);
                                if ($upload["status"] == false)
                                {
                                    $output['status'] = false;
                                    $output['message'] = $upload["message"];
                                    echo json_encode($output);
                                    return;
                                }
                                else
                                {
                                    $psa = $upload["message"];
                                    $psa_date = date("m-d-Y");
                                }
                                
                                $good_moral = '';
                                $good_moral_date = '';
                                if ($_FILES["good_moral"]["size"] !== 0)
                                {
                                    $image = $_FILES["good_moral"]["name"];
                                    $png = strpos($image, 'png');
                                    $jpg = strpos($image, 'jpg');
                                    $jpeg = strpos($image, 'jpeg');
                                    $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                    if ($type == 'false')
                                    {
                                        $output['status'] = false;
                                        $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                        echo json_encode($output);
                                        return;
                                    }
                                    $upload = upload_image($_FILES["good_moral"], $admission_no.'_good_moral', 'assets/files/', $file_type, $type);
                                    if ($upload["status"] == false)
                                    {
                                        $output['status'] = false;
                                        $output['message'] = $upload["message"];
                                        echo json_encode($output);
                                        return;
                                    }
                                    else
                                    {
                                        $good_moral = $upload["message"];
                                        $good_moral_date = date("m-d-Y");
                                    }
                                }
                                
                                $certificate = '';
                                $certificate_date = '';
                                $image = $_FILES["certificate"]["name"];
                                $png = strpos($image, 'png');
                                $jpg = strpos($image, 'jpg');
                                $jpeg = strpos($image, 'jpeg');
                                $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
                                if ($type == 'false')
                                {
                                    $output['status'] = false;
                                    $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
                                    echo json_encode($output);
                                    return;
                                }
                                $upload = upload_image($_FILES["certificate"], $admission_no.'_certificate', 'assets/files/', $file_type, $type);
                                if ($upload["status"] == false)
                                {
                                    $output['status'] = false;
                                    $output['message'] = $upload["message"];
                                    echo json_encode($output);
                                    return;
                                }
                                else
                                {
                                    $certificate = $upload["message"];
                                    $certificate_date = date("m-d-Y");
                                }

                                $upload = upload_image($_FILES["file"], $admission_no.'_avatar', 'assets/avatar/', $file_type, $type);
                                if ($upload["status"] == false)
                                {
                                    $output['status'] = false;
                                    $output['message'] = $upload["message"];
                                }
                                else
                                {
                                    $avatar = $upload["message"];
                                    $strand_id = '';
                                    $high_school = 'Junior';
                                    if ($_POST["grade_level"] > 10)
                                    {
                                        $strand_id = $_POST["strand_id"];
                                        $high_school = 'Senior';
                                    }
        
                                    $sf_amount = '0';
                                    $me_amount = '0';
                                    $tp_result = fetch_row($connect,"SELECT * FROM $TP_TABLE WHERE high_school = '".$high_school."' " );
                                    $sf_amount = $tp_result["sf_one_year"];
                                    $me_amount = $tp_result["me_one_year"];
        
                                    $school_fees = '';
                                    $modules_ebook = '';
                                    $connect->beginTransaction();
                                    if (trim($_POST["payment_method"]) == 'Installment')
                                    {
                                        $school_fees = trim($_POST["school_fees"]);
                                        $modules_ebook = trim($_POST["modules_ebook"]);
                                        if (trim($_POST["school_fees"]) == 'A')
                                        {
                                            $sf_ue_amount = $tp_result["sf_ue_a"];
                                            $sf_aug_amount = $tp_result["sf_aug_a"];
                                            $sf_sep_amount = $tp_result["sf_sep_a"];
                                            $sf_oct_amount = $tp_result["sf_oct_a"];
                                            $sf_nov_amount = $tp_result["sf_nov_a"];
                                            $sf_dec_amount = $tp_result["sf_dec_a"];
                                            $sf_jan_amount = $tp_result["sf_jan_a"];
                                            $sf_feb_amount = $tp_result["sf_feb_a"];
                                            $sf_mar_amount = $tp_result["sf_mar_a"];
                                            $sf_apr_amount = $tp_result["sf_apr_a"];
                                            $sf_may_amount = $tp_result["sf_may_a"];
                                        }
                                        else if (trim($_POST["school_fees"]) == 'B')
                                        {
                                            $sf_ue_amount = $tp_result["sf_ue_b"];
                                            $sf_aug_amount = $tp_result["sf_aug_b"];
                                            $sf_sep_amount = $tp_result["sf_sep_b"];
                                            $sf_oct_amount = $tp_result["sf_oct_b"];
                                            $sf_nov_amount = $tp_result["sf_nov_b"];
                                            $sf_dec_amount = $tp_result["sf_dec_b"];
                                            $sf_jan_amount = $tp_result["sf_jan_b"];
                                            $sf_feb_amount = $tp_result["sf_feb_b"];
                                            $sf_mar_amount = $tp_result["sf_mar_b"];
                                            $sf_apr_amount = $tp_result["sf_apr_b"];
                                            $sf_may_amount = $tp_result["sf_may_b"];
                                        }
                                        else
                                        {
                                            $sf_ue_amount = $tp_result["sf_ue_c"];
                                            $sf_aug_amount = $tp_result["sf_aug_c"];
                                            $sf_sep_amount = $tp_result["sf_sep_c"];
                                            $sf_oct_amount = $tp_result["sf_oct_c"];
                                            $sf_nov_amount = $tp_result["sf_nov_c"];
                                            $sf_dec_amount = $tp_result["sf_dec_c"];
                                            $sf_jan_amount = $tp_result["sf_jan_c"];
                                            $sf_feb_amount = $tp_result["sf_feb_c"];
                                            $sf_mar_amount = $tp_result["sf_mar_c"];
                                            $sf_apr_amount = $tp_result["sf_apr_c"];
                                            $sf_may_amount = $tp_result["sf_may_c"];
                                        }
                                        if (trim($_POST["modules_ebook"]) == 'A')
                                        {
                                            $me_ue_amount = $tp_result["me_ue_a"];
                                            $me_aug_amount = $tp_result["me_aug_a"];
                                            $me_sep_amount = $tp_result["me_sep_a"];
                                            $me_oct_amount = $tp_result["me_oct_a"];
                                            $me_nov_amount = $tp_result["me_nov_a"];
                                            $me_dec_amount = $tp_result["me_dec_a"];
                                            $me_jan_amount = $tp_result["me_jan_a"];
                                            $me_feb_amount = $tp_result["me_feb_a"];
                                            $me_mar_amount = $tp_result["me_mar_a"];
                                            $me_apr_amount = $tp_result["me_apr_a"];
                                            $me_may_amount = $tp_result["me_may_a"];
                                        }
                                        else
                                        {
                                            $me_ue_amount = $tp_result["me_ue_b"];
                                            $me_aug_amount = $tp_result["me_aug_b"];
                                            $me_sep_amount = $tp_result["me_sep_b"];
                                            $me_oct_amount = $tp_result["me_oct_b"];
                                            $me_nov_amount = $tp_result["me_nov_b"];
                                            $me_dec_amount = $tp_result["me_dec_b"];
                                            $me_jan_amount = $tp_result["me_jan_b"];
                                            $me_feb_amount = $tp_result["me_feb_b"];
                                            $me_mar_amount = $tp_result["me_mar_b"];
                                            $me_apr_amount = $tp_result["me_apr_b"];
                                            $me_may_amount = $tp_result["me_may_b"];
                                        }
                                        query($connect, "INSERT INTO $AD_TABLE (admission_no, sf_plan, sf_amount, me_plan, me_amount, sf_ue_amount, sf_aug_amount, sf_sep_amount,
                                        sf_oct_amount, sf_nov_amount, sf_dec_amount, sf_jan_amount, sf_feb_amount, sf_mar_amount, sf_apr_amount, sf_may_amount,
                                        me_ue_amount, me_aug_amount, me_sep_amount, me_oct_amount, me_nov_amount, me_dec_amount, me_jan_amount, me_feb_amount,
                                        me_mar_amount, me_apr_amount, me_may_amount) VALUES 
                                        ('".$admission_no."', '".$school_fees."', '".$sf_amount."', '".$modules_ebook."', '".$me_amount."',
                                        '".$sf_ue_amount."', '".$sf_aug_amount."', '".$sf_sep_amount."', '".$sf_oct_amount."', '".$sf_nov_amount."', '".$sf_dec_amount."',
                                        '".$sf_jan_amount."', '".$sf_feb_amount."', '".$sf_mar_amount."', '".$sf_apr_amount."', '".$sf_may_amount."',
                                        '".$me_ue_amount."', '".$me_aug_amount."', '".$me_sep_amount."', '".$me_oct_amount."', '".$me_nov_amount."', '".$me_dec_amount."',
                                        '".$me_jan_amount."', '".$me_feb_amount."', '".$me_mar_amount."', '".$me_apr_amount."', '".$me_may_amount."' ) ");
                                    }
                
                                    $create = query($connect, "INSERT INTO $ADMISSION_TABLE (school_year, semester, admission_no, avatar, student_status, grade_level, strand_id, 
                                    lrn, last_name, first_name, middle_name, extension_name, 
                                    address, email, contact, date_birth, sex, nationality, last_attended, g_fullname, g_contact, g_relationship, g_occupation, g_address, 
                                    payment_method, sf_plan, sf_amount, me_plan, me_amount, status, visitor_name, 
                                    report_card1, report_card2, report_card_date,
                                    form_1371, form_1372, form_137_date,
                                    psa, psa_date,
                                    good_moral, good_moral_date,
                                    certificate, certificate_date,
                                    date_created) VALUES 
                                    ('".$school_year."', '".$semester."', '".$admission_no."', '".$avatar."', '".trim($_POST["student_status"])."', 
                                    '".trim($_POST["grade_level"])."', '".$strand_id."', 
                                    '".trim($_POST["lrn"])."', '".trim($student["last_name"])."', '".trim($student["first_name"])."', 
                                    '".trim($student["middle_name"])."', '".trim($student["extension_name"])."', 
                                    '".trim($student["address"])."', '".trim($_POST["email"])."', '".trim($student["contact"])."', '".trim($student["date_birth"])."', 
                                    '".trim($student["sex"])."', 
                                    '".trim($student["nationality"])."', '".trim($student["last_attended"])."', '".trim($student["g_fullname"])."', 
                                    '".trim($student["g_contact"])."', '".trim($student["g_relationship"])."', 
                                    '".trim($student["g_occupation"])."', '".trim($student["g_address"])."', 
                                    '".trim($_POST["payment_method"])."', '".$school_fees."', '".$sf_amount."', '".$modules_ebook."', '".$me_amount."', 
                                    'Pending', '".trim($_POST["visitor_name"])."', 
                                    '".$report_card1."', '".$report_card2."', '".$report_card_date."', 
                                    '".$form_1371."', '".$form_1372."', '".$form_137_date."', 
                                    '".$psa."', '".$psa_date."', 
                                    '".$good_moral."', '".$good_moral_date."', 
                                    '".$certificate."', '".$certificate_date."', 
                                    '".date("m-d-Y h:i A")."') ");
                                    if ($create == true)
                                    {
                                        // $connect->commit();
                                        // $output['status'] = true;
                                        // $output['message'] = 'Submitted successfully.';

                                        $track = '';
                                        if ($strand_id != '')
                                        {
                                            $strand = fetch_row($connect,"SELECT * FROM $STRANDS_TABLE WHERE id = '".$strand_id."' " );
                                            $track = '
                                            <b>Track: </b> '.trim($strand["strand"]).'
                                            <br>';
                                        }
                                        
                                        $requirements = '';
                                        if ($report_card1 != '')
                                        {
                                            $requirements .= '- SF9 (Report Card)<br>';
                                        }
                                        if ($form_1371 != '')
                                        {
                                            $requirements .= '- SF10 (Form 137)<br>';
                                        }
                                        if ($psa != '')
                                        {
                                            $requirements .= '- PSA Birth Certificate<br>';
                                        }
                                        if ($good_moral != '')
                                        {
                                            $requirements .= '- Good Moral Certificate<br>';
                                        }
                                        if ($certificate != '')
                                        {
                                            $requirements .= '- Certificate of No Financial Obligation';
                                        }
                
                                        // send email 
                                        $mail = send_mail(trim($_POST["email"]), 
                                        trim($student['last_name']).", ".trim($student["first_name"])." ".trim($student["middle_name"])." ".trim($student["extension_name"]), 
                                        'ADMISSION', 
                                        'Good day Enrollee!<br><br>We received your admission form and we will check and process it.
                                        <br>We will email you again about the status of your application.
                                        <br>This is thye preview of your registration application, please check it for reference.

                                        <br><br>
                                        <b>'.trim($_POST["student_status"]).' Student</b> 
                                        <br>
                                        <b>LRN: </b> '.trim($_POST["lrn"]).'
                                        <br>
                                        <b>Grade Level: </b> '.trim($_POST["grade_level"]).
                                        $track.'
                                        <br>
                                        <b>Email: </b> '.trim($_POST["email"]).'

                                        <br><br>
                                        <b>Payment Method: </b> '.trim($_POST["payment_method"]).'

                                        <br><br>
                                        <b>School Requirements: </b> <br>'.$requirements.'

                                        <br><br>
                                        <b>Visitor: </b> '.trim($_POST["visitor_name"]).'

                                        <br><br>You can follow-up by using your admission no. : '.$admission_no.'
                                        <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                                        <br> <br><i>This is a system generated email. Do not reply.<i>');
                                        if ($mail) // 
                                        {
                                            $connect->commit();
                                            $output['status'] = true;
                                            $output['message'] = 'Submitted successfully.';
                                        }
                                        else 
                                        {
                                            $connect->rollBack();
                                            $output['status'] = false;
                                            $output['message'] = 'Something went wrong.';
                                        }
                                    }
                                    else 
                                    {
                                        $connect->rollBack();
                                        $output['status'] = false;
                                        $output['message'] = 'Something went wrong.';
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $output['status'] = false;
                        $output['message'] = 'LRN does not exist.';
                    }
                }
            }
            else
            {
                $output['status'] = false;
                $output['message'] = 'Please upload a recent school ID.';
            }
        }
        else
        {
            $output['status'] = false;
            $output['message'] = 'Admission is not ready yet.';
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'admission_assess' )
	{
        if ($_POST["assessment_status"] == 'Failed Aptitude Test' || $_POST["assessment_status"] == 'Failed Behavioral Test') //send email
        {
            $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE id = '".$_POST["id"]."' ");
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $ADMISSION_TABLE SET 
                status = 'Rejected', reason = '".trim($_POST["assessment_status"])."'
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                // $connect->commit();
                // $output['status'] = true;
                // $output['message'] = 'Rejected successfully.';

                // send email
                $mail = send_mail(trim($student["email"]), 
                trim($student['last_name']).", ".trim($student["first_name"])." ".trim($student["middle_name"])." ".trim($student["extension_name"]), 
                'REJECTED ADMISSION', 
                'Dear Enrollee!<br><br>We\'re sorry to inform you that we rejected your admission for some reason : '.trim($_POST["assessment_status"]).'
                <br>Once you receive this email, please fill it out again and follow accordingly. 
                <br><br>Fill out the following:
                <br>Guardian Details,
                <br>Guardian Relationship
                <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                <br><br><i>This is a system generated email. Do not reply.<i>');
                if ($mail)
                {
                    $connect->commit();
                    $output['status'] = true;
                    $output['message'] = 'Rejected successfully.';
                }
                else 
                {
                    $connect->rollBack();
                    $output['status'] = false;
                    $output['message'] = 'Something went wrong.';
                }
    
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
        else
        {
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $ADMISSION_TABLE SET assessment_status = '".trim($_POST["assessment_status"])."'
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Assess successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'admission_status' )
	{
        $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE id = '".$_POST["id"]."' ");
        $user = fetch_row($connect, "SELECT * FROM $USER_TABLE WHERE id = '".$_SESSION["user_id"]."' ");
        if ($_POST["status"] == 'Rejected')
        {
            $reason = trim($_POST["reason"]);
            if (trim($_POST["reason"]) == 'Others')
            {
                $reason = trim($_POST["others"]);
            }
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $ADMISSION_TABLE SET 
                status = 'Rejected', reason = '".$reason."'
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                // $connect->commit();
                // $output['status'] = true;
                // $output['message'] = 'Rejected successfully.';

                //send email
                $mail = send_mail(trim($student["email"]), 
                trim($student['last_name']).", ".trim($student["first_name"])." ".trim($student["middle_name"])." ".trim($student["extension_name"]), 
                'REJECTED ADMISSION', 
                'Dear Enrollee!<br><br>We\'re sorry to inform you that we rejected your admission for some reason : '.$reason.'
                <br>Once you receive this email, please fill it out again and follow accordingly. 
                <br><br>Fill out the following:
                <br>Guardian Details,
                <br>Guardian Relationship
                <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                <br><br><i>This is a system generated email. Do not reply.<i>');
                if ($mail)
                {
                    $connect->commit();
                    $output['status'] = true;
                    $output['message'] = 'Rejected successfully.';
                }
                else 
                {
                    $connect->rollBack();
                    $output['status'] = false;
                    $output['message'] = 'Something went wrong.';
                }
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
        else if ($_POST["status"] == 'Scheduled')
        {
            $connect->beginTransaction();
            $update = query($connect, "UPDATE $ADMISSION_TABLE SET 
                status = 'Scheduled', date_scheduled = '".trim($_POST["date_scheduled"])."'
            WHERE id = '".$_POST['id']."' ");
            if ($update == true)
            {
                // $connect->commit();
                // $output['status'] = true;
                // $output['message'] = 'Scheduled successfully.';

                $total_amount = number_format(floatval($student["sf_amount"]) + floatval($student["me_amount"]), 2, ".", ",");
                if ($student["payment_method"] == 'Installment')
                {
                    $tuition = fetch_row($connect, "SELECT * FROM $AD_TABLE WHERE admission_no = '".$student["admission_no"]."' ");

                    $table = '<br><table style="border: 1px solid black; width: 40%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid black;"></th>
                                <th style="border: 1px solid black; text-align: right;">School Fees (₱)</th>
                                <th style="border: 1px solid black; text-align: right;">Modules & E-Books (₱)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid black;">Upon Enrollment</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_ue_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_ue_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">AUGUST</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_aug_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_aug_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">SEPTEMBER</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_sep_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_sep_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">OCTOBER</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_oct_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_oct_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">NOVEMBER</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_nov_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_nov_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">DECEMBER</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_dec_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_dec_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">JANUARY</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_jan_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_jan_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">FEBRUARY</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_feb_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_feb_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">MARCH</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_mar_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_mar_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">APRIL</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_apr_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_apr_amount"], 2, ".", ",").'</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black;">MAY</td>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["sf_may_amount"], 2, ".", ",").'</th>
                                <th style="border: 1px solid black; text-align: right;">'.number_format($tuition["me_may_amount"], 2, ".", ",").'</th>
                            </tr>
                        </tbody>
                    </table>';
                    $message = '<br><br>Payment Method: <b>INSTALLMENT</b><br>Tuition Fee Amount: <b>₱ '.$total_amount.'</b><br>'.$table;
                }
                else
                {
                    $message = '<br><br>Payment Method: <b>CASH</b><br>Tuition Fee Amount: <b>₱ '.$total_amount.'</b><br><br>';
                }

                //send email add if cash -> tuition fee then if installment, tuition table
                $mail = send_mail(trim($student["email"]), 
                trim($student['last_name']).", ".trim($student["first_name"])." ".trim($student["middle_name"])." ".trim($student["extension_name"]), 
                'SCHEDULED FOR ADMISSION', 
                'Dear Enrollee!<br><br>We are here to inform you that we have received your registration form. For further procedures, 
                please report to the following schedule and building/room #: <b>'.trim($_POST["date_scheduled"]).'</b>, Bldg. 1 Maliksi Building, Room 101.  
                <br><br>Please follow the indicated schedule for aptitude testing, settling down payment for tuition fees, and other enrollment matters, 
                such as applying for a scholarship (ESC). 
                <br><br>Bring the requirements indicated when you fill out the registration form, and for ESC, please read the instruction beside the registration form. 
                <br><br><b>Requirements for Application</b>
                <br>School Requirements (from School Last Attended) 
                <br>SF 9 (Report Card) 
                <br>Good Moral Certificate 
                <br>SF 10 (Form 137) 
                <br>PSA Birth Certificate (original and one photocopy) 
                <br>Certificate of no financial obligation'
                .$message.'
                <br><br>You can use your admission no. : '.$student["admission_no"].'
                <br><br><b style="color: red">*This email serve as your visitor form upon entering the institution.</b>
                <br><b>Visitor Name: '.$student["visitor_name"].'</b>
                <br><b>Processed by: '.$user["fullname"].'</b>
                <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                <br><br><i>This is a system generated email. Do not reply.<i>');
                if ($mail)
                {
                    $connect->commit();
                    $output['status'] = true;
                    $output['message'] = 'Scheduled successfully.';
                }
                else 
                {
                    $connect->rollBack();
                    $output['status'] = false;
                    $output['message'] = 'Something went wrong.';
                }
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
        else
        {
            if ($student["grade_level"] > 10)
            {
                $section = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$_POST["section_id"]."' ");
            }
            else
            {
                $section = fetch_row($connect, "SELECT * FROM $JHSECTION_TABLE WHERE id = '".$_POST["section_id"]."' ");
            }
            if (intval($section ["no_limit"]) > intval($section ["no_students"]) )
            {
                $connect->beginTransaction();
                if ($student["grade_level"] > 10)
                {
                    $update = query($connect, "UPDATE $SHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$_POST['section_id']."' ");
                }
                else
                {
                    $update = query($connect, "UPDATE $JHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$_POST['section_id']."' ");
                }
                
                $admission = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE id = '".$_POST["id"]."' ");
                if (trim($_POST["payment_method"]) == 'Cash')
                {
                    $esc_payment = empty(trim($_POST["esc_payment"])) ? 0 : trim($_POST["esc_payment"]);
                    $total_amount = (floatval($admission["sf_amount"]) + floatval($admission["me_amount"])) - floatval($esc_payment);
                    // $check_ad = fetch_row($connect, "SELECT * FROM $AD_TABLE WHERE admission_no = '".$admission_no["admission_no"]."' ");
                    // if ($check_ad) // delete data
                    // {

                    // }
                    $update = query($connect, "UPDATE $ADMISSION_TABLE SET 
                        status = 'Enrolled', section_id = '".trim($_POST["section_id"])."', 
                        payment_method = '".trim($_POST["payment_method"])."', esc_payment = '".$esc_payment ."',
                        date_paid = '".date("m-d-Y h:i A")."'
                        WHERE id = '".$_POST['id']."' ");
                }
                else
                {
                    if ($admission["grade_level"] > 10)
                    {
                        if (intval(trim($_POST["esc_payment"])) == 0)
                        {
                            $high_school = 'Senior';
                        }
                        else
                        {
                            $high_school = 'Senior ESC';
                        }
                    }
                    else
                    {
                        if (intval(trim($_POST["esc_payment"])) == 0)
                        {
                            $high_school = 'Junior';
                        }
                        else
                        {
                            $high_school = 'Junior ESC';
                        }
                    }
                    $tuition = fetch_row($connect, "SELECT * FROM $TP_TABLE WHERE high_school = '".$high_school."' ");
                    if ($_POST["school_fees"] == 'A')
                    {
                        $sf_ue_amount =  $tuition["sf_ue_a"];
                        $sf_aug_amount =  $tuition["sf_aug_a"];
                        $sf_sep_amount =  $tuition["sf_sep_a"];
                        $sf_oct_amount =  $tuition["sf_oct_a"];
                        $sf_nov_amount =  $tuition["sf_nov_a"];
                        $sf_dec_amount =  $tuition["sf_dec_a"];
                        $sf_jan_amount =  $tuition["sf_jan_a"];
                        $sf_feb_amount =  $tuition["sf_feb_a"];
                        $sf_mar_amount =  $tuition["sf_mar_a"];
                        $sf_apr_amount =  $tuition["sf_apr_a"];
                        $sf_may_amount =  $tuition["sf_may_a"];
                    }
                    else if ($_POST["school_fees"] == 'B')
                    {
                        $sf_ue_amount =  $tuition["sf_ue_b"];
                        $sf_aug_amount =  $tuition["sf_aug_b"];
                        $sf_sep_amount =  $tuition["sf_sep_b"];
                        $sf_oct_amount =  $tuition["sf_oct_b"];
                        $sf_nov_amount =  $tuition["sf_nov_b"];
                        $sf_dec_amount =  $tuition["sf_dec_b"];
                        $sf_jan_amount =  $tuition["sf_jan_b"];
                        $sf_feb_amount =  $tuition["sf_feb_b"];
                        $sf_mar_amount =  $tuition["sf_mar_b"];
                        $sf_apr_amount =  $tuition["sf_apr_b"];
                        $sf_may_amount =  $tuition["sf_may_b"];
                    }
                    else  if ($_POST["school_fees"] == 'C')
                    {
                        $sf_ue_amount =  $tuition["sf_ue_c"];
                        $sf_aug_amount =  $tuition["sf_aug_c"];
                        $sf_sep_amount =  $tuition["sf_sep_c"];
                        $sf_oct_amount =  $tuition["sf_oct_c"];
                        $sf_nov_amount =  $tuition["sf_nov_c"];
                        $sf_dec_amount =  $tuition["sf_dec_c"];
                        $sf_jan_amount =  $tuition["sf_jan_c"];
                        $sf_feb_amount =  $tuition["sf_feb_c"];
                        $sf_mar_amount =  $tuition["sf_mar_c"];
                        $sf_apr_amount =  $tuition["sf_apr_c"];
                        $sf_may_amount =  $tuition["sf_may_c"];
                    }

                    if (!empty(trim($_POST["esc_payment"])))
                    {
                        $count = 0;
                        if (intval($sf_aug_amount) != 0) { $count += 1; }
                        if (intval($sf_sep_amount) != 0) { $count += 1; }
                        if (intval($sf_oct_amount) != 0) { $count += 1; }
                        if (intval($sf_nov_amount) != 0) { $count += 1; }
                        if (intval($sf_dec_amount) != 0) { $count += 1; }
                        if (intval($sf_jan_amount) != 0) { $count += 1; }
                        if (intval($sf_feb_amount) != 0) { $count += 1; }
                        if (intval($sf_mar_amount) != 0) { $count += 1; }
                        if (intval($sf_apr_amount) != 0) { $count += 1; }
                        if (intval($sf_may_amount) != 0) { $count += 1; }
                        $sf_total = ((floatval($tuition['sf_one_year']) - floatval(trim($_POST['esc_payment']))) - floatval($sf_ue_amount)) / $count;
                        $sf_aug_amount = intval($sf_aug_amount) == 0 ? 0 : $sf_total;
                        $sf_sep_amount = intval($sf_sep_amount) == 0 ? 0 : $sf_total;
                        $sf_oct_amount = intval($sf_oct_amount) == 0 ? 0 : $sf_total;
                        $sf_nov_amount = intval($sf_nov_amount) == 0 ? 0 : $sf_total;
                        $sf_dec_amount = intval($sf_dec_amount) == 0 ? 0 : $sf_total;
                        $sf_jan_amount = intval($sf_jan_amount) == 0 ? 0 : $sf_total;
                        $sf_feb_amount = intval($sf_feb_amount) == 0 ? 0 : $sf_total;
                        $sf_mar_amount = intval($sf_mar_amount) == 0 ? 0 : $sf_total;
                        $sf_apr_amount = intval($sf_apr_amount) == 0 ? 0 : $sf_total;
                        $sf_may_amount = intval($sf_may_amount) == 0 ? 0 : $sf_total;
                    }
        
                    if ($_POST["modules_ebook"] == 'A')
                    {
                        $me_ue_amount =  $tuition["me_ue_a"];
                        $me_aug_amount =  $tuition["me_aug_a"];
                        $me_sep_amount =  $tuition["me_sep_a"];
                        $me_oct_amount =  $tuition["me_oct_a"];
                        $me_nov_amount =  $tuition["me_nov_a"];
                        $me_dec_amount =  $tuition["me_dec_a"];
                        $me_jan_amount =  $tuition["me_jan_a"];
                        $me_feb_amount =  $tuition["me_feb_a"];
                        $me_mar_amount =  $tuition["me_mar_a"];
                        $me_apr_amount =  $tuition["me_apr_a"];
                        $me_may_amount =  $tuition["me_may_a"];
                    }
                    else if ($_POST["modules_ebook"] == 'B')
                    {
                        $me_ue_amount =  $tuition["me_ue_b"];
                        $me_aug_amount =  $tuition["me_aug_b"];
                        $me_sep_amount =  $tuition["me_sep_b"];
                        $me_oct_amount =  $tuition["me_oct_b"];
                        $me_nov_amount =  $tuition["me_nov_b"];
                        $me_dec_amount =  $tuition["me_dec_b"];
                        $me_jan_amount =  $tuition["me_jan_b"];
                        $me_feb_amount =  $tuition["me_feb_b"];
                        $me_mar_amount =  $tuition["me_mar_b"];
                        $me_apr_amount =  $tuition["me_apr_b"];
                        $me_may_amount =  $tuition["me_may_b"];
                    }
                    
                    $sf_amount = $tuition["sf_one_year"];
                    $me_amount = $tuition["me_one_year"];

                    $check_ad = fetch_row($connect, "SELECT * FROM $AD_TABLE WHERE admission_no = '".$admission["admission_no"]."' ");
                    if ($check_ad)
                    {
                        query($connect, "UPDATE $AD_TABLE SET 
                                sf_plan = '".trim($_POST["school_fees"])."', sf_amount = '".$sf_amount."', 
                                me_plan = '".trim($_POST["modules_ebook"])."', me_amount = '".$me_amount."',
                                sf_ue_amount = '".$sf_ue_amount."',
                                sf_ue_date_paid = '".(trim($_POST["sf_ue_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_aug_amount = '".$sf_aug_amount."',
                                sf_aug_date_paid = '".(trim($_POST["sf_aug_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_sep_amount = '".$sf_sep_amount."',
                                sf_sep_date_paid = '".(trim($_POST["sf_sep_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_oct_amount = '".$sf_oct_amount."',
                                sf_oct_date_paid = '".(trim($_POST["sf_oct_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_nov_amount = '".$sf_nov_amount."',
                                sf_nov_date_paid = '".(trim($_POST["sf_nov_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_dec_amount = '".$sf_dec_amount."',
                                sf_dec_date_paid = '".(trim($_POST["sf_dec_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_jan_amount = '".$sf_jan_amount."',
                                sf_jan_date_paid = '".(trim($_POST["sf_jan_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_feb_amount = '".$sf_feb_amount."',
                                sf_feb_date_paid = '".(trim($_POST["sf_feb_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_mar_amount = '".$sf_mar_amount."',
                                sf_mar_date_paid = '".(trim($_POST["sf_mar_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_apr_amount = '".$sf_apr_amount."',
                                sf_apr_date_paid = '".(trim($_POST["sf_apr_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                sf_may_amount = '".$sf_may_amount."',
                                sf_may_date_paid = '".(trim($_POST["sf_may_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_ue_amount = '".$me_ue_amount."',
                                me_ue_date_paid = '".(trim($_POST["sf_ue_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_aug_amount = '".$me_aug_amount."',
                                me_aug_date_paid = '".(trim($_POST["sf_aug_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_sep_amount = '".$me_sep_amount."',
                                me_sep_date_paid = '".(trim($_POST["sf_sep_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_oct_amount = '".$me_oct_amount."',
                                me_oct_date_paid = '".(trim($_POST["sf_oct_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_nov_amount = '".$me_nov_amount."',
                                me_nov_date_paid = '".(trim($_POST["sf_nov_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_dec_amount = '".$me_dec_amount."',
                                me_dec_date_paid = '".(trim($_POST["sf_dec_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_jan_amount = '".$me_jan_amount."',
                                me_jan_date_paid = '".(trim($_POST["sf_jan_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_feb_amount = '".$me_feb_amount."',
                                me_feb_date_paid = '".(trim($_POST["sf_feb_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_mar_amount = '".$me_mar_amount."',
                                me_mar_date_paid = '".(trim($_POST["sf_mar_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_apr_amount = '".$me_apr_amount."',
                                me_apr_date_paid = '".(trim($_POST["sf_apr_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                                me_may_amount = '".$me_may_amount."',
                                me_may_date_paid = '".(trim($_POST["sf_may_status"]) == 'Paid' ? date("m-d-Y") : '')."'
                            WHERE admission_no = '".$admission['admission_no']."'; ");
                    }
                    else
                    {
                        query($connect, "INSERT INTO $AD_TABLE (admission_no, sf_plan, sf_amount, me_plan, me_amount,
                        sf_ue_amount, sf_ue_date_paid, sf_aug_amount, sf_aug_date_paid, sf_sep_amount, sf_sep_date_paid, sf_oct_amount, sf_oct_date_paid,
                        sf_nov_amount, sf_nov_date_paid, sf_dec_amount, sf_dec_date_paid, sf_jan_amount, sf_jan_date_paid, sf_feb_amount, sf_feb_date_paid,
                        sf_mar_amount, sf_mar_date_paid, sf_apr_amount, sf_apr_date_paid, sf_may_amount, sf_may_date_paid, 
                        me_ue_amount, me_ue_date_paid, me_aug_amount, me_aug_date_paid, me_sep_amount, me_sep_date_paid, me_oct_amount, me_oct_date_paid,
                        me_nov_amount, me_nov_date_paid, me_dec_amount, me_dec_date_paid, me_jan_amount, me_jan_date_paid, me_feb_amount, me_feb_date_paid,
                        me_mar_amount, me_mar_date_paid, me_apr_amount, me_apr_date_paid, me_may_amount, me_may_date_paid) VALUES 
                            ('".$admission["admission_no"]."', '".trim($_POST["school_fees"])."', '".$sf_amount."', '".trim($_POST["modules_ebook"])."', '".$me_amount."', 
                            '".$sf_ue_amount."', '".(trim($_POST["sf_ue_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_aug_amount."', '".(trim($_POST["sf_aug_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_sep_amount."', '".(trim($_POST["sf_sep_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_oct_amount."', '".(trim($_POST["sf_oct_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_nov_amount."', '".(trim($_POST["sf_nov_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_dec_amount."', '".(trim($_POST["sf_dec_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_jan_amount."', '".(trim($_POST["sf_jan_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_feb_amount."', '".(trim($_POST["sf_feb_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_mar_amount."', '".(trim($_POST["sf_mar_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_apr_amount."', '".(trim($_POST["sf_apr_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$sf_may_amount."', '".(trim($_POST["sf_may_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_ue_amount."', '".(trim($_POST["sf_ue_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_aug_amount."', '".(trim($_POST["sf_aug_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_sep_amount."', '".(trim($_POST["sf_sep_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_oct_amount."', '".(trim($_POST["sf_oct_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_nov_amount."', '".(trim($_POST["sf_nov_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_dec_amount."', '".(trim($_POST["sf_dec_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_jan_amount."', '".(trim($_POST["sf_jan_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_feb_amount."', '".(trim($_POST["sf_feb_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_mar_amount."', '".(trim($_POST["sf_mar_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_apr_amount."', '".(trim($_POST["sf_apr_status"]) == 'Paid' ? date("m-d-Y") : '')."',
                            '".$me_may_amount."', '".(trim($_POST["sf_may_status"]) == 'Paid' ? date("m-d-Y") : '')."'
                        ) ");
                    }

                    // $esc_payment = empty(trim($_POST["esc_payment"])) ? 0 : trim($_POST["esc_payment"]);
                    $esc_payment = trim($_POST["esc_payment"]);
                    $total_amount = (floatval($sf_amount) + floatval($me_amount)) - floatval($esc_payment);

                    $update = query($connect, "UPDATE $ADMISSION_TABLE SET 
                        status = 'Enrolled', section_id = '".trim($_POST["section_id"])."', payment_method = '".trim($_POST["payment_method"])."',
                        sf_plan = '".trim($_POST["school_fees"])."', sf_amount = '".$sf_amount."', 
                        me_plan = '".trim($_POST["modules_ebook"])."', me_amount = '".$me_amount."',
                        esc_payment = '".$esc_payment."'
                        WHERE id = '".$_POST['id']."' ");
                }
                if ($update == true)
                {
                    // $connect->commit();
                    // $output['status'] = true;
                    // $output['message'] = 'Paid successfully.';
                    // $output['total_amount'] = $total_amount;

                    if (trim($_POST["payment_method"]) == 'Cash')
                    {
                        $esc = empty(trim($_POST["esc_payment"])) ? '<br><br>' : '<br><br>ESC Amount: <b>₱ '.number_format($esc_payment, 2, '.', ',').'</b><br>';
                        $message = $esc.'Payment Method: <b>CASH</b><br>Amount Paid: <b>₱ '.number_format($total_amount, 2, '.', ',').'</b><br><br>';
                    }
                    else
                    {
                        $table = '<br><table style="border: 1px solid black; width: 40%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid black;"></th>
                                    <th style="border: 1px solid black; text-align: right;">School Fees (₱)</th>
                                    <th style="border: 1px solid black; text-align: right;">Modules & E-Books (₱)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid black;">Upon Enrollment</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_ue_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_ue_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">AUGUST</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_aug_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_aug_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">SEPTEMBER</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_sep_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_sep_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">OCTOBER</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_oct_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_oct_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">NOVEMBER</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_nov_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_nov_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">DECEMBER</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_dec_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_dec_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">JANUARY</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_jan_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_jan_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">FEBRUARY</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_feb_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_feb_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">MARCH</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_mar_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_mar_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">APRIL</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_apr_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_apr_amount, 2, ".", ",").'</th>
                                </tr>
                                <tr>
                                    <td style="border: 1px solid black;">MAY</td>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($sf_may_amount, 2, ".", ",").'</th>
                                    <th style="border: 1px solid black; text-align: right;">'.number_format($me_may_amount, 2, ".", ",").'</th>
                                </tr>
                            </tbody>
                        </table>';
                        $paid = 0;
                        if (trim($_POST["sf_ue_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_ue_amount) + floatval($me_ue_amount));
                        }
                        if (trim($_POST["sf_aug_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_aug_amount) + floatval($me_aug_amount));
                        }
                        if (trim($_POST["sf_sep_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_sep_amount) + floatval($me_sep_amount));
                        }
                        if (trim($_POST["sf_oct_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_oct_amount) + floatval($me_oct_amount));
                        }
                        if (trim($_POST["sf_nov_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_nov_amount) + floatval($me_nov_amount));
                        }
                        if (trim($_POST["sf_dec_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_dec_amount) + floatval($me_dec_amount));
                        }
                        if (trim($_POST["sf_jan_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_jan_amount) + floatval($me_jan_amount));
                        }
                        if (trim($_POST["sf_feb_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_feb_amount) + floatval($me_feb_amount));
                        }
                        if (trim($_POST["sf_mar_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_mar_amount) + floatval($me_mar_amount));
                        }
                        if (trim($_POST["sf_apr_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_apr_amount) + floatval($me_apr_amount));
                        }
                        if (trim($_POST["sf_may_status"]) == 'Paid')
                        {
                            $paid += (floatval($sf_may_amount) + floatval($me_may_amount));
                        }
                        $total_balance = number_format( floatval($total_amount) - floatval($paid), 2, '.', ',');
                        $esc = empty(trim($_POST["esc_payment"])) ? '<br><br>' : '<br><br>ESC Amount: <b>₱ '.number_format($esc_payment, 2, '.', ',').'</b><br>';
                        $message = $esc.'Payment Method: <b>INSTALLMENT</b><br>Tuition Fee Amount: <b>₱ '.number_format($total_amount, 2, '.', ',').'</b><br>
                        Total Paid: <b>₱ '.number_format($paid, 2, ".", ",").'</b><br>Total Balance: <b>₱ '.$total_balance.'</b><br>'.$table;
                    }
                    //send email add if cash is total amount then if installment tuition table with balance //₱'.number_format(trim($_POST["payment"]), 2, '.', ',').', 
                    $mail = send_mail(trim($student["email"]), 
                    trim($student['last_name']).", ".trim($student["first_name"])." ".trim($student["middle_name"])." ".trim($student["extension_name"]), 
                    'COMPLETED ADMISSION', 
                    'Dear Enrollee!<br><br>We are here to inform you that your section is <b>'.$section["section"].'</b>. 
                    '.$message.'
                    <br><br>You can use your admission no. : '.$admission["admission_no"].'
                    <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                    <br><br><i>This is a system generated email. Do not reply.<i>');
                    if ($mail)
                    {
                        $connect->commit();
                        $output['status'] = true;
                        $output['message'] = 'Paid successfully.';
                    }
                    else 
                    {
                        $connect->rollBack();
                        $output['status'] = false;
                        $output['message'] = 'Something went wrong.';
                    }
                }
                else 
                {
                    $connect->rollBack();
                    $output['status'] = false;
                    $output['message'] = 'Something went wrong.';
                }
            }
            else
            {
                $output['status'] = false;
                $output['message'] = 'This section has already in limit.';
            }

        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'fees_add' )
	{
        $connect->beginTransaction();
        $create = query($connect, "INSERT INTO $FEES_TABLE (high_school, fee_category, fee_name, fee_amount, fee_type, status, date_created) VALUES 
        ('".trim($_POST["high_school"])."', '".trim($_POST["fee_category"])."', '".trim($_POST["fee_name"])."', '".trim($_POST["fee_amount"])."', '".trim($_POST["fee_type"])."', 'Active','".date("m-d-Y h:i A")."') ");
        if ($create == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Created successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'fees_status' )
	{
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';	
		}
        else
        {
			$status = 'Active';	
        }
        $connect->beginTransaction();

        $update = query($connect, "UPDATE $FEES_TABLE SET status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}
	
	if($_POST['btn_action'] == 'fees_fetch' )
	{
        $result = fetch_row($connect, "SELECT * FROM $FEES_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['high_school'] = $result['high_school'];
        $output['fee_category'] = $result['fee_category'];
        $output['fee_name'] = $result['fee_name'];
        $output['fee_amount'] = $result['fee_amount'];
        $output['fee_type'] = $result['fee_type'];
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'fees_update' )
	{
        $connect->beginTransaction();
        $update = query($connect, "UPDATE $FEES_TABLE SET 
            high_school = '".trim($_POST["high_school"])."', 
            fee_category = '".trim($_POST["fee_category"])."', 
            fee_name = '".trim($_POST["fee_name"])."', 
            fee_amount = '".trim($_POST["fee_amount"])."', 
            fee_type = '".trim($_POST["fee_type"])."'
        WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Edited successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'hs_change' )
    {
        $datatables_fees = '
        <table id="datatables_fees" class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">School Fees</th>
                </tr>
            </thead>
            <tbody>';
        $rslt = fetch_all($connect,"SELECT * FROM $FEES_TABLE WHERE high_school = '".$_POST["type"]."' AND fee_category = 'School Fees' " );
        if ($rslt)
        {
            foreach($rslt as $row)
            {
                $datatables_fees .= '
                    <tr>
                        <td>'.$row["fee_name"].'</td>
                        <td>'.$row["fee_amount"].'</td>
                    </tr>';
            }
        }
        else
        {
            $datatables_fees .= '
                <tr>
                    <td colspan="2" class="text-center">No data available in table</td>
                </tr>';
        }
        $datatables_fees .= '
            </tbody>
        </table>';
        $output['datatables_fees'] = $datatables_fees;

        $datatables_modules = '
        <table id="datatables_modules" class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">Modules & E-Books</th>
                </tr>
            </thead>
            <tbody>';
        $rslt = fetch_all($connect,"SELECT * FROM $FEES_TABLE WHERE high_school = '".$_POST["type"]."' AND fee_category = 'Modules & E-Books' " );
        if ($rslt)
        {
            foreach($rslt as $row)
            {
                $datatables_modules .= '
                    <tr>
                        <td>'.$row["fee_name"].'</td>
                        <td>'.$row["fee_amount"].'</td>
                    </tr>';
            }
        }
        else
        {
            $datatables_modules .= '
                <tr>
                    <td colspan="2" class="text-center">No data available in table</td>
                </tr>';
        }
        $datatables_modules .= '
            </tbody>
        </table>';
        $output['datatables_modules'] = $datatables_modules;

		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'admission_section' )
    {
        $section_id = '
        <select name="section_id" id="section_id" class="form-control" >
            <option value="">Section</option>';
        if (intval($_POST["grade_level"]) > 10)
        {
            $rslt = fetch_all($connect,"SELECT * FROM $SHSECTION_TABLE 
            WHERE strand_id = '".$_POST["strand"]."' AND grade_level = '".$_POST["grade_level"]."' AND status = 'Active'  " ); //AND no_limit > no_students
            foreach($rslt as $row)
            {
                if (intval($row["no_limit"]) > intval($row["no_students"]))
                {
                    $section_id .= '<option value="'.$row["id"].'">'.$row["section"].'</option>';
                }
            }
        }
        else
        {
            $rslt = fetch_all($connect,"SELECT * FROM $JHSECTION_TABLE 
            WHERE grade_level = '".$_POST["grade_level"]."' AND status = 'Active'  " ); //AND no_limit > no_students
            foreach($rslt as $row)
            {
                if (intval($row["no_limit"]) > intval($row["no_students"]))
                {
                    $section_id .= '<option value="'.$row["id"].'">'.$row["section"].'</option>';
                }
            }
        }
        $section_id .= '
        </select>';
        $output['section_id'] = $section_id;

        if (isset($_POST['title']))
        {
            $esc_payment = '
            <select name="esc_payment" id="esc_payment" class="form-control" >
                <option value="">Select ESC</option>';
            if (intval($_POST["grade_level"]) > 10)
            {
                $rslt = fetch_all($connect,"SELECT * FROM $TP_TABLE WHERE high_school IN ('Senior','Senior ESC') " ); 
            }
            else
            {
                $rslt = fetch_all($connect,"SELECT * FROM $TP_TABLE WHERE high_school IN ('Junior','Junior ESC') " ); 
            }
            foreach($rslt as $row)
            {
                $esc_payment .= '<option value="'.$row["sf_esc"].'" data-amount="'.$row["high_school"].'" >'.$row["high_school"].' - '.$row["sf_esc"].'</option>';
            }
            $esc_payment .= '
            </select>';
            $output['esc_payment'] = $esc_payment;
        }
		echo json_encode($output);
    }
    
	if($_POST['btn_action'] == 'change_password' )
    {
        $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
        $connect->beginTransaction();
        $update = query($connect, "UPDATE $USER_TABLE SET password = '".$password."' WHERE id = '".$_SESSION['user_id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
    }
    
	if($_POST['btn_action'] == 'reports' )
    {
        $new1 = 0;
        $old1 = 0;
        $transferee1 = 0;
        $returnee1 = 0;
        $male1 = 0;
        $female1 = 0;
        $total1 = 0;
        $datatables = '
        <table id="datatables" class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <th>SECTION</th>
                    <th>NEW</th>
                    <th>OLD</th>
                    <th>TRANSFEREE</th>
                    <th>RETURNEE</th>
                    <th>MALE</th>
                    <th>FEMALE</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>';

        if (!empty($_POST["grade_level"]))
        {
            $sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
            if (intval($_POST["grade_level"]) > 10)
            {
                $rslt = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE grade_level = '".$_POST["grade_level"]."' 
                AND strand_id = '".$_POST["strand_id"]."' AND school_year = '".$sy["school_year"]."' #AND status = 'Enrolled' " ); // status IN ('Enrolled') 
            }
            else
            {
                $rslt = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE grade_level = '".$_POST["grade_level"]."' AND school_year = '".$sy["school_year"]."' 
                GROUP BY section_id #AND status IN ('Enrolled')  " ); // status IN ('Enrolled') 
            }
            if ($rslt)
            {
                foreach($rslt as $row)
                {
                    $total = 0;
                    $new = 0;
                    $old = 0;
                    $transferee = 0;
                    $returnee = 0;
                    $male = 0;
                    $female = 0;

                    $new = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE student_status = 'New' AND grade_level = '".$_POST["grade_level"]."' AND section_id = '".$row["section_id"]."' ");
                    $new1 += $new;
                    $old = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE student_status = 'Old' AND grade_level = '".$_POST["grade_level"]."' AND section_id = '".$row["section_id"]."' ");
                    $old1 += $old;
                    $returnee = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE student_status = 'Returnee' AND grade_level = '".$_POST["grade_level"]."' 
                    AND section_id = '".$row["section_id"]."' ");
                    $returnee1 += $returnee;
                    $transferee = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE student_status = 'Transferee' AND grade_level = '".$_POST["grade_level"]."' 
                    AND section_id = '".$row["section_id"]."' ");
                    $transferee1 += $transferee;
                    
                    $male = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE sex = 'Male' AND grade_level = '".$_POST["grade_level"]."' AND section_id = '".$row["section_id"]."' ");
                    $male1 += $male;
                    $female = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE sex = 'Female' AND grade_level = '".$_POST["grade_level"]."' AND section_id = '".$row["section_id"]."' ");
                    $female1 += $female;
                    
                    $total += ($male + $female);
                    $total1 += $total;
                    if ($_POST["grade_level"] > 10)
                    {
                        $section = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$row["section_id"]."' ");
                    }
                    else
                    {
                        $section = fetch_row($connect, "SELECT * FROM $JHSECTION_TABLE WHERE id = '".$row["section_id"]."' ");
                    }
                    $datatables .= '
                    <tr>
                        <td>'.($section ? $section["section"] : '').'</td>
                        <td>'.$new.'</td>
                        <td>'.$old.'</td>
                        <td>'.$transferee.'</td>
                        <td>'.$returnee.'</td>
                        <td>'.$male.'</td>
                        <td>'.$female.'</td>
                        <td>'.$total.'</td>
                    </tr>';
                }
            }
        }

        $datatables .= '
                <tr>
                    <th>Total</th>
                    <th>'.$new1.'</th>
                    <th>'.$old1.'</th>
                    <th>'.$transferee1.'</th>
                    <th>'.$returnee1.'</th>
                    <th>'.$male1.'</th>
                    <th>'.$female1.'</th>
                    <th>'.$total1.'</th>
                </tr>
            </tbody>
        </table>';
        
        $output['datatables'] = $datatables;
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'student_fetch' )
	{
        $result = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['avatar'] = $result["avatar"];
        $output['student_status'] = $result["student_status"];
        $output['grade_level'] = $result["grade_level"];
        $output['strand_id'] = $result["strand_id"];

        // $output['section_id'] = $result["section_id"];
        
        $section_id = '
        <select name="section_id" id="section_id" class="form-control" >
            <option value="">Section</option>';
        if (intval($result["grade_level"]) > 10)
        {
            $rslt = fetch_all($connect,"SELECT * FROM $SHSECTION_TABLE 
            WHERE strand_id = '".$result["strand_id"]."' AND grade_level = '".$result["grade_level"]."' AND status = 'Active' AND no_limit > no_students " );
            foreach($rslt as $row)
            {
                if ($row["id"] == $result["section_id"])
                {
                    $section_id .= '<option selected value="'.$row["id"].'">'.$row["section"].'</option>';
                }
                else
                {
                    $section_id .= '<option value="'.$row["id"].'">'.$row["section"].'</option>';
                }
            }
        }
        else
        {
            $rslt = fetch_all($connect,"SELECT * FROM $JHSECTION_TABLE 
            WHERE grade_level = '".$result["grade_level"]."' AND status = 'Active' AND no_limit > no_students " );
            foreach($rslt as $row)
            {
                if ($row["id"] == $result["section_id"])
                {
                    $section_id .= '<option selected value="'.$row["id"].'">'.$row["section"].'</option>';
                }
                else
                {
                    $section_id .= '<option value="'.$row["id"].'">'.$row["section"].'</option>';
                }
            }
        }
        $section_id .= '
        </select>';
        $output['section_id'] = $section_id;

        $output['last_name'] = $result["last_name"];
        $output['first_name'] = $result["first_name"];
        $output['middle_name'] = $result["middle_name"];
        $output['extension_name'] = $result["extension_name"];
        $output['address'] = $result["address"];
        $output['email'] = $result["email"];
        $output['contact'] = $result["contact"];
        $output['date_birth'] = $result["date_birth"];
        $output['sex'] = $result["sex"];
        $output['nationality'] = $result["nationality"];
        $output['last_attended'] = $result["last_attended"];
        $output['g_fullname'] = $result["g_fullname"];
        $output['g_contact'] = $result["g_contact"];
        $output['g_relationship'] = $result["g_relationship"];
        $output['g_occupation'] = $result["g_occupation"];
        $output['g_address'] = $result["g_address"];
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'student_update' )
	{
        $result = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE id = '".$_POST["id"]."' ");
        $output['status'] = true;
        $avatar = $result["avatar"];
        $admission_no = $result["admission_no"];
        if ($_FILES["files"]["size"] !== 0)
        {
            $avatar = $_FILES["files"]["name"];
            $png = strpos($avatar, 'png');
            $jpg = strpos($avatar, 'jpg');
            $jpeg = strpos($avatar, 'jpeg');
            $type = $png !== false ? 'png' : ($jpg !== false ? 'jpg' : ($jpeg !== false ? 'jpeg' : 'false'));
            if ($type == 'false')
            {
                $output['status'] = false;
                $output['message'] = "Invalid image type, please upload a png, jpg, jpeg.";
            }
            else
            {
                $file_type = array("jpg", "png", "jpeg");
                $upload = upload_image($_FILES["files"], $admission_no.'_avatar', 'assets/avatar/', $file_type, $type);
                if ($upload["status"] == false)
                {
                    $output['status'] = false;
                    $output['message'] = $upload["message"];
                }
                else
                {
                    $output['status'] = true;
                    $avatar = $upload["message"];
                }
            }
        }

        if ($output['status'] == true)
        {
            $connect->beginTransaction();
            if ($_POST["grade_level"] > 10)
            {
                $update = query($connect, "UPDATE $ADMISSION_TABLE SET 
                    avatar = '".$avatar."',
                    student_status = '".trim($_POST["student_status"])."',
                    grade_level = '".trim($_POST["grade_level"])."',
                    strand_id = '".trim($_POST["strand_id"])."',
                    section_id = '".trim($_POST["section_id"])."',
                    last_name = '".trim($_POST["last_name"])."',
                    first_name = '".trim($_POST["first_name"])."',
                    middle_name = '".trim($_POST["middle_name"])."',
                    extension_name = '".trim($_POST["extension_name"])."',
                    address = '".trim($_POST["address"])."',
                    email = '".trim($_POST["email"])."',
                    contact = '".trim($_POST["contact"])."',
                    date_birth = '".trim($_POST["date_birth"])."',
                    sex = '".trim($_POST["sex"])."',
                    nationality = '".trim($_POST["nationality"])."',
                    last_attended = '".trim($_POST["last_attended"])."',
                    g_fullname = '".trim($_POST["g_fullname"])."',
                    g_contact = '".trim($_POST["g_contact"])."',
                    g_relationship = '".trim($_POST["g_relationship"])."',
                    g_occupation = '".trim($_POST["g_occupation"])."',
                    g_address = '".trim($_POST["g_address"])."'
                WHERE id = '".$_POST['id']."' ");
            }
            else
            {
                $update = query($connect, "UPDATE $ADMISSION_TABLE SET 
                    avatar = '".$avatar."',
                    student_status = '".trim($_POST["student_status"])."',
                    grade_level = '".trim($_POST["grade_level"])."',
                    section_id = '".trim($_POST["section_id"])."',
                    last_name = '".trim($_POST["last_name"])."',
                    first_name = '".trim($_POST["first_name"])."',
                    middle_name = '".trim($_POST["middle_name"])."',
                    extension_name = '".trim($_POST["extension_name"])."',
                    address = '".trim($_POST["address"])."',
                    email = '".trim($_POST["email"])."',
                    contact = '".trim($_POST["contact"])."',
                    date_birth = '".trim($_POST["date_birth"])."',
                    sex = '".trim($_POST["sex"])."',
                    nationality = '".trim($_POST["nationality"])."',
                    last_attended = '".trim($_POST["last_attended"])."',
                    g_fullname = '".trim($_POST["g_fullname"])."',
                    g_contact = '".trim($_POST["g_contact"])."',
                    g_relationship = '".trim($_POST["g_relationship"])."',
                    g_occupation = '".trim($_POST["g_occupation"])."',
                    g_address = '".trim($_POST["g_address"])."'
                WHERE id = '".$_POST['id']."' ");
            }
            if ($update == true)
            {
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Edited successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'senior_section' )
	{
        $section_id = '
        <select name="section_id" id="section_id" class="form-control" >
            <option value="">Section</option>';
        $rslt = fetch_all($connect,"SELECT * FROM $SHSECTION_TABLE 
        WHERE strand_id = '".$_POST["strand_id"]."' AND grade_level = '".$_POST["grade_level"]."' AND status = 'Active' AND no_limit > no_students " );
        foreach($rslt as $row)
        {
            $section_id .= '<option value="'.$row["id"].'">'.$row["section"].'</option>';
        }
        $section_id .= '
        </select>';
        $output['section_id'] = $section_id;
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'fetch_tuition_plan' )
	{
        $result = fetch_row($connect,"SELECT * FROM $TP_TABLE WHERE high_school = '".$_POST["high_school"]."' " );
        $output['sf_one_year'] = !$result ? "" : $result["sf_one_year"];
        $output['sf_esc'] = !$result ? "" : $result["sf_esc"];

        $output['me_one_year'] =  !$result ? "" : $result["me_one_year"];
        
        $output['sf_ue_a'] =  !$result ? "" : $result["sf_ue_a"];
        $output['sf_aug_a'] =  !$result ? "" : $result["sf_aug_a"];
        $output['sf_sep_a'] =  !$result ? "" : $result["sf_sep_a"];
        $output['sf_oct_a'] =  !$result ? "" : $result["sf_oct_a"];
        $output['sf_nov_a'] =  !$result ? "" : $result["sf_nov_a"];
        $output['sf_dec_a'] =  !$result ? "" : $result["sf_dec_a"];
        $output['sf_jan_a'] =  !$result ? "" : $result["sf_jan_a"];
        $output['sf_feb_a'] =  !$result ? "" : $result["sf_feb_a"];
        $output['sf_mar_a'] =  !$result ? "" : $result["sf_mar_a"];
        $output['sf_apr_a'] =  !$result ? "" : $result["sf_apr_a"];
        $output['sf_may_a'] =  !$result ? "" : $result["sf_may_a"];
        
        $output['sf_ue_b'] =  !$result ? "" : $result["sf_ue_b"];
        $output['sf_aug_b'] =  !$result ? "" : $result["sf_aug_b"];
        $output['sf_sep_b'] =  !$result ? "" : $result["sf_sep_b"];
        $output['sf_oct_b'] =  !$result ? "" : $result["sf_oct_b"];
        $output['sf_nov_b'] =  !$result ? "" : $result["sf_nov_b"];
        $output['sf_dec_b'] =  !$result ? "" : $result["sf_dec_b"];
        $output['sf_jan_b'] =  !$result ? "" : $result["sf_jan_b"];
        $output['sf_feb_b'] =  !$result ? "" : $result["sf_feb_b"];
        $output['sf_mar_b'] =  !$result ? "" : $result["sf_mar_b"];
        $output['sf_apr_b'] =  !$result ? "" : $result["sf_apr_b"];
        $output['sf_may_b'] =  !$result ? "" : $result["sf_may_b"];
        
        $output['sf_ue_c'] =  !$result ? "" : $result["sf_ue_c"];
        $output['sf_aug_c'] =  !$result ? "" : $result["sf_aug_c"];
        $output['sf_sep_c'] =  !$result ? "" : $result["sf_sep_c"];
        $output['sf_oct_c'] =  !$result ? "" : $result["sf_oct_c"];
        $output['sf_nov_c'] =  !$result ? "" : $result["sf_nov_c"];
        $output['sf_dec_c'] =  !$result ? "" : $result["sf_dec_c"];
        $output['sf_jan_c'] =  !$result ? "" : $result["sf_jan_c"];
        $output['sf_feb_c'] =  !$result ? "" : $result["sf_feb_c"];
        $output['sf_mar_c'] =  !$result ? "" : $result["sf_mar_c"];
        $output['sf_apr_c'] =  !$result ? "" : $result["sf_apr_c"];
        $output['sf_may_c'] =  !$result ? "" : $result["sf_may_c"];
        
        $output['me_ue_a'] =  !$result ? "" : $result["me_ue_a"];
        $output['me_aug_a'] =  !$result ? "" : $result["me_aug_a"];
        $output['me_sep_a'] =  !$result ? "" : $result["me_sep_a"];
        $output['me_oct_a'] =  !$result ? "" : $result["me_oct_a"];
        $output['me_nov_a'] =  !$result ? "" : $result["me_nov_a"];
        $output['me_dec_a'] =  !$result ? "" : $result["me_dec_a"];
        $output['me_jan_a'] =  !$result ? "" : $result["me_jan_a"];
        $output['me_feb_a'] =  !$result ? "" : $result["me_feb_a"];
        $output['me_mar_a'] =  !$result ? "" : $result["me_mar_a"];
        $output['me_apr_a'] =  !$result ? "" : $result["me_apr_a"];
        $output['me_may_a'] =  !$result ? "" : $result["me_may_a"];
        
        $output['me_ue_b'] =  !$result ? "" : $result["me_ue_b"];
        $output['me_aug_b'] =  !$result ? "" : $result["me_aug_b"];
        $output['me_sep_b'] =  !$result ? "" : $result["me_sep_b"];
        $output['me_oct_b'] =  !$result ? "" : $result["me_oct_b"];
        $output['me_nov_b'] =  !$result ? "" : $result["me_nov_b"];
        $output['me_dec_b'] =  !$result ? "" : $result["me_dec_b"];
        $output['me_jan_b'] =  !$result ? "" : $result["me_jan_b"];
        $output['me_feb_b'] =  !$result ? "" : $result["me_feb_b"];
        $output['me_mar_b'] =  !$result ? "" : $result["me_mar_b"];
        $output['me_apr_b'] =  !$result ? "" : $result["me_apr_b"];
        $output['me_may_b'] =  !$result ? "" : $result["me_may_b"];

		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'update_tuition_plan' )
    {
        $connect->beginTransaction();
        $update = query($connect, "UPDATE $TP_TABLE SET 
            sf_one_year = '".trim($_POST["sf_one_year"])."',
            sf_esc = '".trim($_POST["sf_esc"])."',

            me_one_year = '".trim($_POST["me_one_year"])."',

            sf_ue_a = '".(!empty(trim($_POST["sf_ue_a"])) ? trim($_POST["sf_ue_a"]) : 0)."',
            sf_aug_a = '".(!empty(trim($_POST["sf_aug_a"])) ? trim($_POST["sf_aug_a"]) : 0)."',
            sf_sep_a = '".(!empty(trim($_POST["sf_sep_a"])) ? trim($_POST["sf_sep_a"]) : 0)."',
            sf_oct_a = '".(!empty(trim($_POST["sf_oct_a"])) ? trim($_POST["sf_oct_a"]) : 0)."',
            sf_nov_a = '".(!empty(trim($_POST["sf_nov_a"])) ? trim($_POST["sf_nov_a"]) : 0)."',
            sf_dec_a = '".(!empty(trim($_POST["sf_dec_a"])) ? trim($_POST["sf_dec_a"]) : 0)."',
            sf_jan_a = '".(!empty(trim($_POST["sf_jan_a"])) ? trim($_POST["sf_jan_a"]) : 0)."',
            sf_feb_a = '".(!empty(trim($_POST["sf_feb_a"])) ? trim($_POST["sf_feb_a"]) : 0)."',
            sf_mar_a = '".(!empty(trim($_POST["sf_mar_a"])) ? trim($_POST["sf_mar_a"]) : 0)."',
            sf_apr_a = '".(!empty(trim($_POST["sf_apr_a"])) ? trim($_POST["sf_apr_a"]) : 0)."',
            sf_may_a = '".(!empty(trim($_POST["sf_may_a"])) ? trim($_POST["sf_may_a"]) : 0)."',

            sf_ue_b = '".(!empty(trim($_POST["sf_ue_b"])) ? trim($_POST["sf_ue_b"]) : 0)."',
            sf_aug_b = '".(!empty(trim($_POST["sf_aug_b"])) ? trim($_POST["sf_aug_b"]) : 0)."',
            sf_sep_b = '".(!empty(trim($_POST["sf_sep_b"])) ? trim($_POST["sf_sep_b"]) : 0)."',
            sf_oct_b = '".(!empty(trim($_POST["sf_oct_b"])) ? trim($_POST["sf_oct_b"]) : 0)."',
            sf_nov_b = '".(!empty(trim($_POST["sf_nov_b"])) ? trim($_POST["sf_nov_b"]) : 0)."',
            sf_dec_b = '".(!empty(trim($_POST["sf_dec_b"])) ? trim($_POST["sf_dec_b"]) : 0)."',
            sf_jan_b = '".(!empty(trim($_POST["sf_jan_b"])) ? trim($_POST["sf_jan_b"]) : 0)."',
            sf_feb_b = '".(!empty(trim($_POST["sf_feb_b"])) ? trim($_POST["sf_feb_b"]) : 0)."',
            sf_mar_b = '".(!empty(trim($_POST["sf_mar_b"])) ? trim($_POST["sf_mar_b"]) : 0)."',
            sf_apr_b = '".(!empty(trim($_POST["sf_apr_b"])) ? trim($_POST["sf_apr_b"]) : 0)."',
            sf_may_b = '".(!empty(trim($_POST["sf_may_b"])) ? trim($_POST["sf_may_b"]) : 0)."',

            sf_ue_c = '".(!empty(trim($_POST["sf_ue_c"])) ? trim($_POST["sf_ue_c"]) : 0)."',
            sf_aug_c = '".(!empty(trim($_POST["sf_aug_c"])) ? trim($_POST["sf_aug_c"]) : 0)."',
            sf_sep_c = '".(!empty(trim($_POST["sf_sep_c"])) ? trim($_POST["sf_sep_c"]) : 0)."',
            sf_oct_c = '".(!empty(trim($_POST["sf_oct_c"])) ? trim($_POST["sf_oct_c"]) : 0)."',
            sf_nov_c = '".(!empty(trim($_POST["sf_nov_c"])) ? trim($_POST["sf_nov_c"]) : 0)."',
            sf_dec_c = '".(!empty(trim($_POST["sf_dec_c"])) ? trim($_POST["sf_dec_c"]) : 0)."',
            sf_jan_c = '".(!empty(trim($_POST["sf_jan_c"])) ? trim($_POST["sf_jan_c"]) : 0)."',
            sf_feb_c = '".(!empty(trim($_POST["sf_feb_c"])) ? trim($_POST["sf_feb_c"]) : 0)."',
            sf_mar_c = '".(!empty(trim($_POST["sf_mar_c"])) ? trim($_POST["sf_mar_c"]) : 0)."',
            sf_apr_c = '".(!empty(trim($_POST["sf_apr_c"])) ? trim($_POST["sf_apr_c"]) : 0)."',
            sf_may_c = '".(!empty(trim($_POST["sf_may_c"])) ? trim($_POST["sf_may_c"]) : 0)."',

            me_ue_a = '".(!empty(trim($_POST["me_ue_a"])) ? trim($_POST["me_ue_a"]) : 0)."',
            me_aug_a = '".(!empty(trim($_POST["me_aug_a"])) ? trim($_POST["me_aug_a"]) : 0)."',
            me_sep_a = '".(!empty(trim($_POST["me_sep_a"])) ? trim($_POST["me_sep_a"]) : 0)."',
            me_oct_a = '".(!empty(trim($_POST["me_oct_a"])) ? trim($_POST["me_oct_a"]) : 0)."',
            me_nov_a = '".(!empty(trim($_POST["me_nov_a"])) ? trim($_POST["me_nov_a"]) : 0)."',
            me_dec_a = '".(!empty(trim($_POST["me_dec_a"])) ? trim($_POST["me_dec_a"]) : 0)."',
            me_jan_a = '".(!empty(trim($_POST["me_jan_a"])) ? trim($_POST["me_jan_a"]) : 0)."',
            me_feb_a = '".(!empty(trim($_POST["me_feb_a"])) ? trim($_POST["me_feb_a"]) : 0)."',
            me_mar_a = '".(!empty(trim($_POST["me_mar_a"])) ? trim($_POST["me_mar_a"]) : 0)."',
            me_apr_a = '".(!empty(trim($_POST["me_apr_a"])) ? trim($_POST["me_apr_a"]) : 0)."',
            me_may_a = '".(!empty(trim($_POST["me_may_a"])) ? trim($_POST["me_may_a"]) : 0)."',

            me_ue_b = '".(!empty(trim($_POST["me_ue_b"])) ? trim($_POST["me_ue_b"]) : 0)."',
            me_aug_b = '".(!empty(trim($_POST["me_aug_b"])) ? trim($_POST["me_aug_b"]) : 0)."',
            me_sep_b = '".(!empty(trim($_POST["me_sep_b"])) ? trim($_POST["me_sep_b"]) : 0)."',
            me_oct_b = '".(!empty(trim($_POST["me_oct_b"])) ? trim($_POST["me_oct_b"]) : 0)."',
            me_nov_b = '".(!empty(trim($_POST["me_nov_b"])) ? trim($_POST["me_nov_b"]) : 0)."',
            me_dec_b = '".(!empty(trim($_POST["me_dec_b"])) ? trim($_POST["me_dec_b"]) : 0)."',
            me_jan_b = '".(!empty(trim($_POST["me_jan_b"])) ? trim($_POST["me_jan_b"]) : 0)."',
            me_feb_b = '".(!empty(trim($_POST["me_feb_b"])) ? trim($_POST["me_feb_b"]) : 0)."',
            me_mar_b = '".(!empty(trim($_POST["me_mar_b"])) ? trim($_POST["me_mar_b"]) : 0)."',
            me_apr_b = '".(!empty(trim($_POST["me_apr_b"])) ? trim($_POST["me_apr_b"]) : 0)."',
            me_may_b = '".(!empty(trim($_POST["me_may_b"])) ? trim($_POST["me_may_b"]) : 0)."' 
            WHERE high_school = '".$_POST['high_school']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Saved successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'admission_payment' )
    {
        $connect->beginTransaction();
        $update = query($connect, "UPDATE $AD_TABLE SET 
            sf_ue_date_paid = '".(trim($_POST["sf_ue_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_aug_date_paid = '".(trim($_POST["sf_aug_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_sep_date_paid = '".(trim($_POST["sf_sep_status"]) == 'Paid' ? date("m-d-Y") : '')."',   
            sf_oct_date_paid = '".(trim($_POST["sf_oct_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_nov_date_paid = '".(trim($_POST["sf_nov_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_dec_date_paid = '".(trim($_POST["sf_dec_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_jan_date_paid = '".(trim($_POST["sf_jan_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_feb_date_paid = '".(trim($_POST["sf_feb_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_mar_date_paid = '".(trim($_POST["sf_mar_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_apr_date_paid = '".(trim($_POST["sf_apr_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            sf_may_date_paid = '".(trim($_POST["sf_may_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_ue_date_paid = '".(trim($_POST["sf_ue_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_aug_date_paid = '".(trim($_POST["sf_aug_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_sep_date_paid = '".(trim($_POST["sf_sep_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_oct_date_paid = '".(trim($_POST["sf_oct_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_nov_date_paid = '".(trim($_POST["sf_nov_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_dec_date_paid = '".(trim($_POST["sf_dec_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_jan_date_paid = '".(trim($_POST["sf_jan_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_feb_date_paid = '".(trim($_POST["sf_feb_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_mar_date_paid = '".(trim($_POST["sf_mar_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_apr_date_paid = '".(trim($_POST["sf_apr_status"]) == 'Paid' ? date("m-d-Y") : '')."',
            me_may_date_paid = '".(trim($_POST["sf_may_status"]) == 'Paid' ? date("m-d-Y") : '')."'
        WHERE admission_no = '".$_POST['id']."' ");
        if ($update == true)
        {
            // $connect->commit();
            // $output['status'] = true;
            // $output['message'] = 'Edited successfully.';

            $admission = fetch_row($connect, "SELECT * FROM $AD_TABLE WHERE admission_no = '".$_POST["id"]."' ");
            
            $sf_ue_amount =  $admission["sf_ue_amount"];
            $sf_aug_amount =  $admission["sf_aug_amount"];
            $sf_sep_amount =  $admission["sf_sep_amount"];
            $sf_oct_amount =  $admission["sf_oct_amount"];
            $sf_nov_amount =  $admission["sf_nov_amount"];
            $sf_dec_amount =  $admission["sf_dec_amount"];
            $sf_jan_amount =  $admission["sf_jan_amount"];
            $sf_feb_amount =  $admission["sf_feb_amount"];
            $sf_mar_amount =  $admission["sf_mar_amount"];
            $sf_apr_amount =  $admission["sf_apr_amount"];
            $sf_may_amount =  $admission["sf_may_amount"];
            
            $me_ue_amount =  $admission["me_ue_amount"];
            $me_aug_amount =  $admission["me_aug_amount"];
            $me_sep_amount =  $admission["me_sep_amount"];
            $me_oct_amount =  $admission["me_oct_amount"];
            $me_nov_amount =  $admission["me_nov_amount"];
            $me_dec_amount =  $admission["me_dec_amount"];
            $me_jan_amount =  $admission["me_jan_amount"];
            $me_feb_amount =  $admission["me_feb_amount"];
            $me_mar_amount =  $admission["me_mar_amount"];
            $me_apr_amount =  $admission["me_apr_amount"];
            $me_may_amount =  $admission["me_may_amount"];

            $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE admission_no = '".$_POST["id"]."' ");
            $table = '<br><table style="border: 1px solid black; width: 40%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black;"></th>
                        <th style="border: 1px solid black; text-align: right;">School Fees (₱)</th>
                        <th style="border: 1px solid black; text-align: right;">Modules & E-Books (₱)</th>
                        <th style="border: 1px solid black; text-align: right;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid black;">Upon Enrollment</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_ue_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_ue_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_ue_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">AUGUST (1Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_aug_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_aug_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_aug_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">SEPTEMBER (1Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_sep_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_sep_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_sep_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">OCTOBER (1Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_oct_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_oct_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_oct_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">NOVEMBER (2Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_nov_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_nov_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_nov_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">DECEMBER (2Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_dec_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_dec_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_dec_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">JANUARY (2Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_jan_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_jan_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_jan_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">FEBRUARY (3Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_feb_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_feb_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_feb_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">MARCH (3Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_mar_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_mar_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_mar_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">APRIL (4Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_apr_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_apr_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_apr_status"]).'</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black;">MAY (4Q)</td>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($sf_may_amount, 2, ".", ",").'</th>
                        <th style="border: 1px solid black; text-align: right;">'.number_format($me_may_amount, 2, ".", ",").'</th>
                        <td style="border: 1px solid black; text-align: right;">'.trim($_POST["sf_may_status"]).'</td>
                    </tr>
                </tbody>
            </table>';
            $paid = 0;
            if (trim($_POST["sf_ue_status"]) == 'Paid')
            {
                $paid += (floatval($sf_ue_amount) + floatval($me_ue_amount));
            }
            if (trim($_POST["sf_aug_status"]) == 'Paid')
            {
                $paid += (floatval($sf_aug_amount) + floatval($me_aug_amount));
            }
            if (trim($_POST["sf_sep_status"]) == 'Paid')
            {
                $paid += (floatval($sf_sep_amount) + floatval($me_sep_amount));
            }
            if (trim($_POST["sf_oct_status"]) == 'Paid')
            {
                $paid += (floatval($sf_oct_amount) + floatval($me_oct_amount));
            }
            if (trim($_POST["sf_nov_status"]) == 'Paid')
            {
                $paid += (floatval($sf_nov_amount) + floatval($me_nov_amount));
            }
            if (trim($_POST["sf_dec_status"]) == 'Paid')
            {
                $paid += (floatval($sf_dec_amount) + floatval($me_dec_amount));
            }
            if (trim($_POST["sf_jan_status"]) == 'Paid')
            {
                $paid += (floatval($sf_jan_amount) + floatval($me_jan_amount));
            }
            if (trim($_POST["sf_feb_status"]) == 'Paid')
            {
                $paid += (floatval($sf_feb_amount) + floatval($me_feb_amount));
            }
            if (trim($_POST["sf_mar_status"]) == 'Paid')
            {
                $paid += (floatval($sf_mar_amount) + floatval($me_mar_amount));
            }
            if (trim($_POST["sf_apr_status"]) == 'Paid')
            {
                $paid += (floatval($sf_apr_amount) + floatval($me_apr_amount));
            }
            if (trim($_POST["sf_may_status"]) == 'Paid')
            {
                $paid += (floatval($sf_may_amount) + floatval($me_may_amount));
            }

            $esc_payment = intval($student["esc_payment"]) == 0 ? 0 : $student["esc_payment"];
            $total_amount = (floatval($student["sf_amount"]) + floatval($student["me_amount"])) - floatval($esc_payment);

            $total_balance = number_format( floatval($total_amount) - floatval($paid), 2, '.', ',');
            $esc = intval($student["esc_payment"]) == 0 ? '<br><br>' : '<br><br>ESC Amount: <b>₱ '.number_format($student["esc_payment"], 2, '.', ',').'</b><br>';
            $message = $esc.'Payment Method: <b>INSTALLMENT</b><br>Tuition Fee Amount: <b>₱ '.number_format($total_amount, 2, '.', ',').'</b><br>
            Total Paid: <b>₱ '.number_format($paid, 2, ".", ",").'</b><br>Total Balance: <b>₱ '.$total_balance.'</b><br>'.$table;

            $mail = send_mail($student["email"], 
            $student['last_name'].", ".$student["first_name"]." ".$student["middle_name"]." ".$student["extension_name"], 
            'PAYMENT STATUS', 
            'Dear Enrollee!<br><br>This is the update of your tuition fee installment.</b>. 
            '.$message.'
            <br><br>You can use your admission no. : '.$_POST["id"].'
            <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
            <br><br><i>This is a system generated email. Do not reply.<i>');
            if ($mail)
            {
                $connect->commit();
                $output['status'] = true;
                $output['message'] = 'Saved successfully.';
            }
            else 
            {
                $connect->rollBack();
                $output['status'] = false;
                $output['message'] = 'Something went wrong.';
            }
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'admission_complete' )
    {
        $connect->beginTransaction();
        $update = query($connect, "UPDATE $ADMISSION_TABLE SET date_paid = '".date("m-d-Y")."' WHERE admission_no = '".$_POST['admission_no']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Completed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'admission_archive' )
    {
        $fetch = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE id = '".$_POST["id"]."' ");
        $connect->beginTransaction();
        if (intval($fetch["grade_level"]) > 10)
        {
            query($connect, "UPDATE $SHSECTION_TABLE SET no_students = no_students - 1 WHERE id = '".$fetch['section_id']."' ");
        }
        else
        {
            query($connect, "UPDATE $JHSECTION_TABLE SET no_students = no_students - 1 WHERE id = '".$fetch['section_id']."' ");
        }
        $update = query($connect, "UPDATE $ADMISSION_TABLE SET archived = 'Archived' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Archived successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'load_archived' )
    {
        $table = '
        <table id="datatables" class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <th>ADMISSION</th>
                    <th>APPLICANT DETAILS</th>
                    <th>GUARDIAN DETAILS</th>
                    <th>PAYMENT DETAILS</th>
                </tr>
            </thead>
            <tbody>';

        $query = '';
        if (!empty($_POST['grade_level']))
        {
            $query .= " AND grade_level = '".$_POST['grade_level']."' ";
        }
        if (!empty($_POST['strand_id']))
        {
            $query .= " AND strand_id = '".$_POST['strand_id']."' ";
        }
        if (!empty($_POST['section_id']))
        {
            $query .= " AND section_id = '".$_POST['section_id']."' ";
        }
        $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE archived IS NOT NULL AND school_year = '".$_POST['school_year']."' $query " ); // 
        foreach($result as $row)
        {
            $section = '';
            if (!empty($row["section_id"]))
            {
                if (intval($row['grade_level']) > 10)
                {
                    $fetch = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$row["section_id"]."' ");
                    $section = $fetch["section"];
                }
                else
                {
                    $fetch = fetch_row($connect, "SELECT * FROM $JHSECTION_TABLE WHERE id = '".$row["section_id"]."' ");
                    $section = $fetch["section"];
                }
            }
            $image = '<a data-magnify="gallery" class="card-img-top " data-caption="'.$row["admission_no"].'" data-group="" href="'.$row["avatar"].'">
                <img class="img-fluid img-circle elevation-2" style="height: 50px; width: 50px; cursor: pointer;" id="user_img" src="'.$row["avatar"].'" alt="'.$row["admission_no"].'">
            </a>';
            
            if (empty($row["button_status"]))
            {
                $button = ' 
                <a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="Hide" name="button_status"
                id="'.$row["id"].'" style="border-radius: 20px;" >
                    <i class="fa fa-eye"></i> 
                </a> ';
                $button .= ' &nbsp; 
                <a class="btn btn-success undo elevation-2 pr-3 pl-3" href="#" name="undo" id="'.$row["admission_no"].'" 
                    style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Retrieve">
                    <i class="fa fa-undo"></i> Retrieve
                </a>';

                $admission = $image.' &nbsp; '.$button;
    
                $applicant = "".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name'];
    
                $guardian = "<b>Name</b>: ".$row['g_fullname'];

                $payment = "<b>Payment</b>: ".$row['payment_method'];
            }
            else
            {
                $button = ' <br>
                <a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="" name="button_status"
                id="'.$row["id"].'" style="border-radius: 20px;" >
                    <i class="fa fa-eye-slash"></i> 
                </a>  &nbsp; 
                <a class="btn btn-success undo elevation-2 pr-3 pl-3" href="#" name="undo" id="'.$row["admission_no"].'" 
                    style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Retrieve">
                    <i class="fa fa-undo"></i> Retrieve
                </a>';
                $admission = $image."<br><b>Grade Level</b>: ".$row['grade_level']
                ."<br><b>Section</b>: ".$section
                ."<br><b>LRN</b>: ".$row['lrn']
                ."<br><b>Status</b>: ".$row['student_status']
                ."<br><b>Date</b>: ".$row['date_created'].$button;
    
                $applicant = "".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name']
                ."<br><b>Date of Birth</b>: ".$row['date_birth']
                ."<br><b>Sex</b>: ".$row['sex']
                ."<br><b>Email</b>: ".$row['email']
                ."<br><b>Contact</b>: ".$row['contact']
                ."<br><b>Address</b>: ".$row['address']
                ."<br><b>Nationality</b>: ".$row['nationality']
                ."<br><b>S.Y. Last Attended</b>: ".$row['last_attended'];
    
                $guardian = "<b>Name</b>: ".$row['g_fullname']
                ."<br><b>Contact</b>: ".$row['g_contact']
                ."<br><b>Relationship</b>: ".$row['g_relationship']
                ."<br><b>Occupation</b>: ".$row['g_occupation']
                ."<br><b>Address</b>: ".$row['g_address'];
    
                if ($row['payment_method'] == 'Installment')
                {
                    $payment = "<b>Payment</b>: ".$row['payment_method']
                    ."<br><b>School Fees Plan</b>: ".$row['sf_plan']
                    ."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
                    ."<br><b>Modules & E-Book Plan</b>: ".$row['me_plan']
                    ."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',');
                }
                else
                {
                    $payment = "<b>Payment</b>: ".$row['payment_method']
                    ."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
                    ."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',');
                }
            }

            $table .= '
            <tr>
                <td>'.$admission.'</td>
                <td>'.$applicant.'</td>
                <td>'.$guardian.'</td>
                <td>'.$payment.'</td>
            </tr>';
        }
        $table .= '
            </tbody>
        </table>';
        $output['table'] = $table;
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'admission_undo' )
    {
        $connect->beginTransaction();
        // if (isset($_POST['title']))
        // {
        //     $fetch = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE admission_no = '".$_POST["admission_no"]."' ");
        //     if (intval($fetch["grade_level"]) > 10)
        //     {
        //         query($connect, "UPDATE $SHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$fetch['section_id']."' ");
        //     }
        //     else
        //     {
        //         query($connect, "UPDATE $JHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$fetch['section_id']."' ");
        //     }
        //     $update = query($connect, "UPDATE $ADMISSION_TABLE SET status = 'Enrolled' WHERE admission_no = '".$_POST['admission_no']."' ");
        // }
        // else
        // {
        //     $update = query($connect, "UPDATE $ADMISSION_TABLE SET date_paid = NULL WHERE admission_no = '".$_POST['admission_no']."' ");
        // }
        $fetch = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE admission_no = '".$_POST["admission_no"]."' ");
        if (intval($fetch["grade_level"]) > 10)
        {
            query($connect, "UPDATE $SHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$fetch['section_id']."' ");
        }
        else
        {
            query($connect, "UPDATE $JHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$fetch['section_id']."' ");
        }
        $update = query($connect, "UPDATE $ADMISSION_TABLE SET archived = NULL WHERE admission_no = '".$_POST['admission_no']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Retrieved successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'fetch_admission_plan' )
    {
        if (empty($_POST['esc_payment']))
        {
            $admission = fetch_row($connect,"SELECT * FROM $ADMISSION_TABLE WHERE admission_no = '".$_POST["admission_no"]."' " );
            $high_school = $admission["grade_level"] > 10 ? 'Senior' : 'Junior';
            $result = fetch_row($connect,"SELECT * FROM $TP_TABLE WHERE high_school = '".$high_school."' " );
        }
        else
        {
            $result = fetch_row($connect,"SELECT * FROM $TP_TABLE WHERE high_school = '".$_POST['esc_payment']."' " );
        }

        if ($_POST["sf"] == 'A')
        {
            $output['sf_ue_amount'] =  $result["sf_ue_a"];
            $output['sf_aug_amount'] =  $result["sf_aug_a"];
            $output['sf_sep_amount'] =  $result["sf_sep_a"];
            $output['sf_oct_amount'] =  $result["sf_oct_a"];
            $output['sf_nov_amount'] =  $result["sf_nov_a"];
            $output['sf_dec_amount'] =  $result["sf_dec_a"];
            $output['sf_jan_amount'] =  $result["sf_jan_a"];
            $output['sf_feb_amount'] =  $result["sf_feb_a"];
            $output['sf_mar_amount'] =  $result["sf_mar_a"];
            $output['sf_apr_amount'] =  $result["sf_apr_a"];
            $output['sf_may_amount'] =  $result["sf_may_a"];
        }
        else if ($_POST["sf"] == 'B')
        {
            $output['sf_ue_amount'] =  $result["sf_ue_b"];
            $output['sf_aug_amount'] =  $result["sf_aug_b"];
            $output['sf_sep_amount'] =  $result["sf_sep_b"];
            $output['sf_oct_amount'] =  $result["sf_oct_b"];
            $output['sf_nov_amount'] =  $result["sf_nov_b"];
            $output['sf_dec_amount'] =  $result["sf_dec_b"];
            $output['sf_jan_amount'] =  $result["sf_jan_b"];
            $output['sf_feb_amount'] =  $result["sf_feb_b"];
            $output['sf_mar_amount'] =  $result["sf_mar_b"];
            $output['sf_apr_amount'] =  $result["sf_apr_b"];
            $output['sf_may_amount'] =  $result["sf_may_b"];
        }
        else  if ($_POST["sf"] == 'C')
        {
            $output['sf_ue_amount'] =  $result["sf_ue_c"];
            $output['sf_aug_amount'] =  $result["sf_aug_c"];
            $output['sf_sep_amount'] =  $result["sf_sep_c"];
            $output['sf_oct_amount'] =  $result["sf_oct_c"];
            $output['sf_nov_amount'] =  $result["sf_nov_c"];
            $output['sf_dec_amount'] =  $result["sf_dec_c"];
            $output['sf_jan_amount'] =  $result["sf_jan_c"];
            $output['sf_feb_amount'] =  $result["sf_feb_c"];
            $output['sf_mar_amount'] =  $result["sf_mar_c"];
            $output['sf_apr_amount'] =  $result["sf_apr_c"];
            $output['sf_may_amount'] =  $result["sf_may_c"];
        }
        else  
        {
            $output['sf_ue_amount'] =  0;
            $output['sf_aug_amount'] =  0;
            $output['sf_sep_amount'] =  0;
            $output['sf_oct_amount'] =  0;
            $output['sf_nov_amount'] =  0;
            $output['sf_dec_amount'] =  0;
            $output['sf_jan_amount'] =  0;
            $output['sf_feb_amount'] =  0;
            $output['sf_mar_amount'] =  0;
            $output['sf_apr_amount'] =  0;
            $output['sf_may_amount'] =  0;
        }

        if ($_POST["me"] == 'A')
        {
            $output['me_ue_amount'] =  $result["me_ue_a"];
            $output['me_aug_amount'] =  $result["me_aug_a"];
            $output['me_sep_amount'] =  $result["me_sep_a"];
            $output['me_oct_amount'] =  $result["me_oct_a"];
            $output['me_nov_amount'] =  $result["me_nov_a"];
            $output['me_dec_amount'] =  $result["me_dec_a"];
            $output['me_jan_amount'] =  $result["me_jan_a"];
            $output['me_feb_amount'] =  $result["me_feb_a"];
            $output['me_mar_amount'] =  $result["me_mar_a"];
            $output['me_apr_amount'] =  $result["me_apr_a"];
            $output['me_may_amount'] =  $result["me_may_a"];
        }
        else if ($_POST["me"] == 'B')
        {
            $output['me_ue_amount'] =  $result["me_ue_b"];
            $output['me_aug_amount'] =  $result["me_aug_b"];
            $output['me_sep_amount'] =  $result["me_sep_b"];
            $output['me_oct_amount'] =  $result["me_oct_b"];
            $output['me_nov_amount'] =  $result["me_nov_b"];
            $output['me_dec_amount'] =  $result["me_dec_b"];
            $output['me_jan_amount'] =  $result["me_jan_b"];
            $output['me_feb_amount'] =  $result["me_feb_b"];
            $output['me_mar_amount'] =  $result["me_mar_b"];
            $output['me_apr_amount'] =  $result["me_apr_b"];
            $output['me_may_amount'] =  $result["me_may_b"];
        }
        else
        {
            $output['me_ue_amount'] =  0;
            $output['me_aug_amount'] =  0;
            $output['me_sep_amount'] =  0;
            $output['me_oct_amount'] =  0;
            $output['me_nov_amount'] =  0;
            $output['me_dec_amount'] =  0;
            $output['me_jan_amount'] =  0;
            $output['me_feb_amount'] =  0;
            $output['me_mar_amount'] =  0;
            $output['me_apr_amount'] =  0;
            $output['me_may_amount'] =  0;
        }
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'fetch_admission_tuition_plan' )
    {
        $result = fetch_row($connect,"SELECT * FROM $AD_TABLE WHERE admission_no = '".$_POST["admission_no"]."' " );
        if ($result)
        {
            $output['sf_ue_amount'] = $result["sf_ue_amount"];
            $output['sf_aug_amount'] = $result["sf_aug_amount"];
            $output['sf_sep_amount'] = $result["sf_sep_amount"];
            $output['sf_oct_amount'] = $result["sf_oct_amount"];
            $output['sf_nov_amount'] = $result["sf_nov_amount"];
            $output['sf_dec_amount'] = $result["sf_dec_amount"];
            $output['sf_jan_amount'] = $result["sf_jan_amount"];
            $output['sf_feb_amount'] = $result["sf_feb_amount"];
            $output['sf_mar_amount'] = $result["sf_mar_amount"];
            $output['sf_apr_amount'] = $result["sf_apr_amount"];
            $output['sf_may_amount'] = $result["sf_may_amount"];

            $output['me_ue_amount'] = $result["me_ue_amount"];
            $output['me_aug_amount'] = $result["me_aug_amount"];
            $output['me_sep_amount'] = $result["me_sep_amount"];
            $output['me_oct_amount'] = $result["me_oct_amount"];
            $output['me_nov_amount'] = $result["me_nov_amount"];
            $output['me_dec_amount'] = $result["me_dec_amount"];
            $output['me_jan_amount'] = $result["me_jan_amount"];
            $output['me_feb_amount'] = $result["me_feb_amount"];
            $output['me_mar_amount'] = $result["me_mar_amount"];
            $output['me_apr_amount'] = $result["me_apr_amount"];
            $output['me_may_amount'] = $result["me_may_amount"];
        }
        $output['ue_date'] =  !$result ? '' : $result["sf_ue_date_paid"];
        $output['aug_date'] =  !$result ? '' : $result["sf_aug_date_paid"];
        $output['sep_date'] =  !$result ? '' : $result["sf_sep_date_paid"];
        $output['oct_date'] =  !$result ? '' : $result["sf_oct_date_paid"];
        $output['nov_date'] =  !$result ? '' : $result["sf_nov_date_paid"];
        $output['dec_date'] =  !$result ? '' : $result["sf_dec_date_paid"];
        $output['jan_date'] =  !$result ? '' : $result["sf_jan_date_paid"];
        $output['feb_date'] =  !$result ? '' : $result["sf_feb_date_paid"];
        $output['mar_date'] =  !$result ? '' : $result["sf_mar_date_paid"];
        $output['apr_date'] =  !$result ? '' : $result["sf_apr_date_paid"];
        $output['may_date'] =  !$result ? '' : $result["sf_may_date_paid"];
            
        $output['sf_amount'] = !$result ? 0 : $result["sf_amount"];
        $output['me_amount'] = !$result ? 0 : $result["me_amount"];
        
        $ad = fetch_row($connect,"SELECT * FROM $ADMISSION_TABLE WHERE admission_no = '".$_POST["admission_no"]."' " );
        $output['esc_payment'] = !$ad ? 0 : $ad["esc_payment"];
        $total_amount = (floatval($output['sf_amount']) + floatval($output['me_amount'])) - floatval($output['esc_payment']);
        $output['total_amount'] = number_format($total_amount, 2, '.', ',');

        $paid = 0;
        if (!empty($output['ue_date']))
        {
            $paid += (floatval($output['sf_ue_amount']) + floatval($output['me_ue_amount']));
        }
        if (!empty($output['aug_date']))
        {
            $paid += (floatval($output['sf_aug_amount']) + floatval($output['me_aug_amount']));
        }
        if (!empty($output['sep_date']))
        {
            $paid += (floatval($output['sf_sep_amount']) + floatval($output['me_sep_amount']));
        }
        if (!empty($output['oct_date']))
        {
            $paid += (floatval($output['sf_oct_amount']) + floatval($output['me_oct_amount']));
        }
        if (!empty($output['nov_date']))
        {
            $paid += (floatval($output['sf_nov_amount']) + floatval($output['me_nov_amount']));
        }
        if (!empty($output['dec_date']))
        {
            $paid += (floatval($output['sf_dec_amount']) + floatval($output['me_dec_amount']));
        }
        if (!empty($output['jan_date']))
        {
            $paid += (floatval($output['sf_jan_amount']) + floatval($output['me_jan_amount']));
        }
        if (!empty($output['feb_date']))
        {
            $paid += (floatval($output['sf_feb_amount']) + floatval($output['me_feb_amount']));
        }
        if (!empty($output['mar_date']))
        {
            $paid += (floatval($output['sf_mar_amount']) + floatval($output['me_mar_amount']));
        }
        if (!empty($output['apr_date']))
        {
            $paid += (floatval($output['sf_apr_amount']) + floatval($output['me_apr_amount']));
        }
        if (!empty($output['may_date']))
        {
            $paid += (floatval($output['sf_may_amount']) + floatval($output['me_may_amount']));
        }
        $output['total_paid'] = number_format($paid, 2, '.',',');

        $output['total_balance'] = number_format( floatval($total_amount) - floatval($paid), 2, '.', ',');
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'archived_section' )
    {
        $section_id = '<select name="section_id" id="section_id" class="form-control" disabled >
        <option value="">Section</option>';

        if (intval($_POST["grade_level"]) > 10)
        {
            if (!empty($_POST['strand_id']))
            {
                $result = fetch_all($connect,"SELECT * FROM $SHSECTION_TABLE WHERE grade_level = '".$_POST['grade_level']."' AND strand_id = '".$_POST['strand_id']."' " ); 
            }
            else
            {
                $result = fetch_all($connect,"SELECT * FROM $SHSECTION_TABLE WHERE grade_level = '".$_POST['grade_level']."' " ); 
            }
        }
        else
        {
            $result = fetch_all($connect,"SELECT * FROM $JHSECTION_TABLE WHERE grade_level = '".$_POST['grade_level']."' " ); 
        }
        foreach($result as $row)
        {
            if (isset($_POST['section_id']))
            {
                if ($row["id"] == $_POST["section_id"])
                {
                    $section_id .= '<option selected value="'.$row["id"].'">'.$row["section"].'</option>';
                }
            }
            else
            {
                $section_id .= '<option value="'.$row["id"].'">'.$row["section"].'</option>';
            }
        }
        $section_id .= '</select>';
        $output['section_id'] = $section_id;
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'load_sections' )
    {
        $sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
        $school_year = $sy["school_year"];
        $count = 0;
        $section_table = '
        <table id="datatables_section" class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NAME</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
        if (intval($_POST['grade_level']) > 10)
        {
            $fetch = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$_POST["id"]."' ");
            $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' 
            AND grade_level = '".$_POST["grade_level"]."' AND strand_id = '".$fetch['strand_id']."'
            AND section_id = '".$_POST['id']."' AND status IN ('Enrolled') " ); // 
        }
        else
        {
            $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' 
            AND grade_level = '".$_POST["grade_level"]."' AND section_id = '".$_POST['id']."' AND status IN ('Enrolled') " ); // 
        }
        if ($result)
        {
            foreach($result as $row)
            {
                $button = '<a class="btn btn-success view_info elevation-2 pr-3 pl-3" href="#" name="view_info" id="'.$row["id"].'" 
                    style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="View Student Info">
                    <i class="fa fa-eye"></i> View
                </a>';
    
                $count += 1;
                $section_table .= '
                <tr>
                    <td>'.$count.'</td>
                    <td>'.$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name'].'</td>
                    <td>'.$button.'</td>
                </tr>';
            }
        }
        else
        {
            // $section_table .= '
            // <tr>
            //     <td class="text-center" colspan="3">No data found.</td>
            // </tr>';
        }
        $section_table .= '
            </tbody>
        </table>';
        $output['section_table'] = $section_table;
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'load_history' )
    {
        $table = '
        <table id="datatables" class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <th>ADMISSION</th>
                    <th>APPLICANT DETAILS</th>
                    <th>GUARDIAN DETAILS</th>
                    <th>PAYMENT DETAILS</th>
                </tr>
            </thead>
            <tbody>';

        $query = '';
        if (!empty($_POST['grade_level']))
        {
            $query .= " AND grade_level = '".$_POST['grade_level']."' ";
        }
        if (!empty($_POST['strand_id']))
        {
            $query .= " AND strand_id = '".$_POST['strand_id']."' ";
        }
        if (!empty($_POST['section_id']))
        {
            $query .= " AND section_id = '".$_POST['section_id']."' ";
        }
        $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE status = 'Enrolled' AND school_year = '".$_POST['school_year']."' $query " ); // 
        foreach($result as $row)
        {
            $section = '';
            if (intval($row['grade_level']) > 10)
            {
                $fetch = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$row["section_id"]."' ");
                $section = $fetch["section"];
            }
            else
            {
                $fetch = fetch_row($connect, "SELECT * FROM $JHSECTION_TABLE WHERE id = '".$row["section_id"]."' ");
                $section = $fetch["section"];
            }
            $image = '<a data-magnify="gallery" class="card-img-top " data-caption="'.$row["admission_no"].'" data-group="" href="'.$row["avatar"].'">
                <img class="img-fluid img-circle elevation-2" style="height: 50px; width: 50px; cursor: pointer;" id="user_img" src="'.$row["avatar"].'" alt="'.$row["admission_no"].'">
            </a>';
            
		
            if (empty($row["button_status"]))
            {
                $button = ' &nbsp; 
                <a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="Hide" name="button_status"
                id="'.$row["id"].'" style="border-radius: 20px;" >
                    <i class="fa fa-eye"></i> 
                </a> ';

                $admission = $image."<br><b>Grade Level</b>: ".$row['grade_level'].'<br>'.$button;
                $applicant = "".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name'];
                $guardian = "<b>Name</b>: ".$row['g_fullname'];
                $payment = "<b>Payment</b>: ".$row['payment_method'];
            }
            else
            {
                $button = ' &nbsp; 
                <a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="" name="button_status"
                id="'.$row["id"].'" style="border-radius: 20px;" >
                    <i class="fa fa-eye-slash"></i> 
                </a>';

                $admission = $image."<br><b>Grade Level</b>: ".$row['grade_level']
                ."<br><b>Section</b>: ".$section
                ."<br><b>LRN</b>: ".$row['lrn']
                ."<br><b>Status</b>: ".$row['student_status']
                ."<br><b>Date</b>: ".$row['date_created'].'<br>'.$button;

                $applicant = "".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name']
                ."<br><b>Date of Birth</b>: ".$row['date_birth']
                ."<br><b>Sex</b>: ".$row['sex']
                ."<br><b>Email</b>: ".$row['email']
                ."<br><b>Contact</b>: ".$row['contact']
                ."<br><b>Address</b>: ".$row['address']
                ."<br><b>Nationality</b>: ".$row['nationality']
                ."<br><b>S.Y. Last Attended</b>: ".$row['last_attended'];

                $guardian = "<b>Name</b>: ".$row['g_fullname']
                ."<br><b>Contact</b>: ".$row['g_contact']
                ."<br><b>Relationship</b>: ".$row['g_relationship']
                ."<br><b>Occupation</b>: ".$row['g_occupation']
                ."<br><b>Address</b>: ".$row['g_address'];

                if ($row['payment_method'] == 'Installment')
                {
                    $payment = "<b>Payment</b>: ".$row['payment_method']
                    ."<br><b>School Fees Plan</b>: ".$row['sf_plan']
                    ."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
                    ."<br><b>Modules & E-Book Plan</b>: ".$row['me_plan']
                    ."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',');
                }
                else
                {
                    $payment = "<b>Payment</b>: ".$row['payment_method']
                    ."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
                    ."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',');
                }
            }

            $table .= '
            <tr>
                <td>'.$admission.'</td>
                <td>'.$applicant.'</td>
                <td>'.$guardian.'</td>
                <td>'.$payment.'</td>
            </tr>';
        }
        $table .= '
            </tbody>
        </table>';
        $output['table'] = $table;
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'load_pie' )
    {
        $sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
        $school_year = $sy["school_year"];

        $e_seven = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '7' AND status = 'Enrolled' ");
        $e_eight = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '8' AND status = 'Enrolled' ");
        $e_nine = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '9' AND status = 'Enrolled' ");
        $e_ten = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '10' AND status = 'Enrolled' ");

        $i_seven = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '7' AND status IN ('Pending','Scheduled') ");
        $i_eight = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '8' AND status IN ('Pending','Scheduled') ");
        $i_nine = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '9' AND status IN ('Pending','Scheduled') ");
        $i_ten = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '10' AND status IN ('Pending','Scheduled') ");
        
        $output['e_seven'] = $e_seven;
        $output['e_eight'] = $e_eight;
        $output['e_nine'] = $e_nine;
        $output['e_ten'] = $e_ten;
        
        $output['i_seven'] = $i_seven;
        $output['i_eight'] = $i_eight;
        $output['i_nine'] = $i_nine;
        $output['i_ten'] = $i_ten;

        $arr = [];
        $number = [];
        $result = fetch_all($connect,"SELECT * FROM $STRANDS_TABLE WHERE status = 'Active' " ); 
        foreach($result as $row)
        {
            array_push($arr, $row["strand"]);
            $count = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' 
            AND strand_id = '".$row["id"]."' AND status = 'Enrolled' AND grade_level BETWEEN 11 AND 12 ");
            
            array_push($number, $count);
        }
        $output['s_enrolled'] = $arr;
        $output['s_count'] = $number;

        $arr = [];
        $number = [];
        $result = fetch_all($connect,"SELECT * FROM $STRANDS_TABLE WHERE status = 'Active' " ); 
        foreach($result as $row)
        {
            array_push($arr, $row["strand"]);
            $count = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' 
            AND strand_id = '".$row["id"]."' AND status IN ('Pending','Scheduled') AND grade_level BETWEEN 11 AND 12 ");
            
            array_push($number, $count);
        }
        $output['si_enrolled'] = $arr;
        $output['si_count'] = $number;

        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'load_requirements' )
    {
        $fetch = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE admission_no = '".$_POST["id"]."' ");
        $list = '<div class="row">';
        if (!empty($fetch["report_card1"]))
        {
            $list .= '<div class="form-group col-6">
                    <label>SF9 (Report Card) Page 1</label>
                    <a data-magnify="gallery" class="card-img-top " data-caption="SF9 (Report Card) Page 1" data-group="" href="'.$fetch["report_card1"].'">
                        <img class="img-fluid elevation-2 " style="height: 300px; width: 300px; cursor: pointer;" src="'.$fetch["report_card1"].'" 
                        alt="SF9 (Report Card) Page 1">
                    </a>
                </div>';
        }
        if (!empty($fetch["report_card2"]))
        {
            $list .= '<div class="form-group col-6">
                    <label>SF9 (Report Card) Page 2</label>
                    <a data-magnify="gallery" class="card-img-top " data-caption="SF9 (Report Card) Page 2" data-group="" href="'.$fetch["report_card2"].'">
                        <img class="img-fluid elevation-2 " style="height: 300px; width: 300px; cursor: pointer;" src="'.$fetch["report_card2"].'" 
                        alt="SF9 (Report Card) Page 2">
                    </a>
                </div>';
        }
        if (!empty($fetch["form_1371"]))
        {
            $list .= '<div class="form-group col-6">
                    <label>SF10 (Form 137) Page 1</label>
                    <a data-magnify="gallery" class="card-img-top " data-caption="SF10 (Form 137) Page 1" data-group="" href="'.$fetch["form_1371"].'">
                        <img class="img-fluid elevation-2 " style="height: 300px; width: 300px; cursor: pointer;" src="'.$fetch["form_1371"].'" 
                        alt="SF10 (Form 137) Page 2">
                    </a>
                </div>';
        }
        if (!empty($fetch["form_1372"]))
        {
            $list .= '<div class="form-group col-6">
                    <label>SF10 (Form 137) Page 2</label>
                    <a data-magnify="gallery" class="card-img-top " data-caption="SF10 (Form 137) Page 2" data-group="" href="'.$fetch["form_1372"].'">
                        <img class="img-fluid elevation-2 " style="height: 300px; width: 300px; cursor: pointer;" src="'.$fetch["form_1372"].'" 
                        alt="SF10 (Form 137) Page 2">
                    </a>
                </div>';
        }
        if (!empty($fetch["psa"]))
        {
            $list .= '<div class="form-group col-6">
                    <label>PSA Birth Certificate</label>
                    <a data-magnify="gallery" class="card-img-top " data-caption="PSA Birth Certificate" data-group="" href="'.$fetch["psa"].'">
                        <img class="img-fluid elevation-2 " style="height: 300px; width: 300px; cursor: pointer;" src="'.$fetch["psa"].'" 
                        alt="PSA Birth Certificate">
                    </a>
                </div>';
        }
        if (!empty($fetch["good_moral"]))
        {
            $list .= '<div class="form-group col-6">
                    <label>Good Moral Certificate</label>
                    <a data-magnify="gallery" class="card-img-top " data-caption="Good Moral Certificate" data-group="" href="'.$fetch["good_moral"].'">
                        <img class="img-fluid elevation-2 " style="height: 300px; width: 300px; cursor: pointer;" src="'.$fetch["good_moral"].'" 
                        alt="Good Moral Certificate">
                    </a>
                </div>';
        }
        if (!empty($fetch["certificate"]))
        {
            $list .= '<div class="form-group col-12">
                    <label>Certificate of No Financial Obligation</label>
                    <a data-magnify="gallery" class="card-img-top " data-caption="Certificate of No Financial Obligation" data-group="" href="'.$fetch["certificate"].'">
                        <img class="img-fluid elevation-2 " style="height: 300px; width: 300px; cursor: pointer;" src="'.$fetch["certificate"].'" 
                        alt="Certificate of No Financial Obligation">
                    </a>
                </div>';
        }
        $list .= '</div>';
        $output['list'] = $list;
        
        $output['report_card1'] = !empty($fetch["report_card1"]) ? $fetch["report_card1"] : '';
        $output['report_card_date'] = $fetch["report_card_date"];
        $output['form_1371'] = !empty($fetch["form_1371"]) ? $fetch["form_1371"] : '';
        $output['form_137_date'] = $fetch["form_137_date"];
        $output['psa'] = !empty($fetch["psa"]) ? $fetch["psa"] : '';
        $output['psa_date'] = $fetch["psa_date"];
        $output['good_moral'] = !empty($fetch["good_moral"]) ? $fetch["good_moral"] : '';
        $output['good_moral_date'] = $fetch["good_moral_date"];
        $output['certificate'] = !empty($fetch["certificate"]) ? $fetch["certificate"] : '';
        $output['certificate_date'] = $fetch["certificate_date"];
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'update_button' )
    {
        $connect->beginTransaction();
        $update = query($connect, "UPDATE $ADMISSION_TABLE SET button_status = '".$_POST['status']."' WHERE id = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Changed successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'upload_requirements' )
    {
        $admission = fetch_row($connect,"SELECT * FROM $ADMISSION_TABLE WHERE admission_no = '".$_POST["id"]."' " );

        $query = '';
        if (isset($_POST["report_card1"]))
        {
            $query .= " report_card1 = '".trim($_POST["date_report"])."', report_card_date = '".trim($_POST["date_report"])."' ";
        }
        else
        {
            $query .= " report_card1 = '', report_card_date = '' ";
        }
        if (isset($_POST["psa"]))
        {
            $query .= ", psa = '".trim($_POST["date_psa"])."', psa_date = '".trim($_POST["date_psa"])."' ";
        }
        else
        {
            $query .= ", psa = '', psa_date = '' ";
        }
        if (isset($_POST["form_1371"]))
        {
            $query .= ", form_1371 = '".trim($_POST["date_137"])."', form_137_date = '".trim($_POST["date_137"])."' ";
        }
        else
        {
            $query .= ", form_1371 = '', form_137_date = '' ";
        }
        if (isset($_POST["good_moral"]))
        {
            $query .= ", good_moral = '".trim($_POST["date_goodmoral"])."', good_moral_date = '".trim($_POST["date_goodmoral"])."' ";
        }
        else
        {
            $query .= ", good_moral = '', good_moral_date = '' ";
        }
        if (isset($_POST["certificate"]))
        {
            $query .= ", certificate = '".trim($_POST["date_certificate"])."', certificate_date = '".trim($_POST["date_certificate"])."' ";
        }
        else
        {
            $query .= ", certificate = '', certificate_date = '' ";
        }

        $connect->beginTransaction();
        $update = query($connect, "UPDATE $ADMISSION_TABLE SET $query
        WHERE admission_no = '".$_POST['id']."' ");
        if ($update == true)
        {
            $connect->commit();
            $output['status'] = true;
            $output['message'] = 'Saved successfully.';
        }
        else 
        {
            $connect->rollBack();
            $output['status'] = false;
            $output['message'] = 'Something went wrong.';
        }
        echo json_encode($output);
    }

	if($_POST['btn_action'] == 'print_student_list' )
    {
        $_SESSION['section_id'] = $_POST['id'];
        $_SESSION['grade_level'] = $_POST['grade_level'];
        $_SESSION['section'] = $_POST['section'];
        $_SESSION['adviser'] = $_POST['adviser'];
        $_SESSION['title'] = 'STUDENT';
        $output['status'] = false;
		echo json_encode($output);
    }

	if($_POST['btn_action'] == 'print_reports' )
    {
        $_SESSION['strand_id'] = $_POST['strand_id'];
        $_SESSION['grade_level'] = $_POST['grade_level'];
        $_SESSION['title'] = 'REPORTS';
        $output['status'] = false;
		echo json_encode($output);
    }

}

?>