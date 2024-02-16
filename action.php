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
                    $_SESSION['user_email']    = $result['user_email'];
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
                ('".trim($_POST["fullname"])."', '".trim($_POST["username"])."', '".$password."' , '', '".trim($_POST["username"])."', '', 'Staff', 'Active','".date("m-d-Y h:i A")."') ");
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
                        user_email = '".trim($_POST["username"])."',
                        user_name = '".trim($_POST["username"])."', 
                        password = '".$password."'
                    WHERE id = '".$_POST['id']."' ");
                }
                else
                {
                    $update = query($connect, "UPDATE $USER_TABLE SET 
                        fullname = '".trim($_POST["fullname"])."', 
                        user_email = '".trim($_POST["username"])."', 
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

            $update = query($connect, "UPDATE $SY_TABLE SET 
                status = 'Inactive' 
            WHERE status = 'Active' ");

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

	if($_POST['btn_action'] == 'admission_student' )
	{
        $sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
        if ($sy)
        {
            $school_year = $sy["school_year"];
            $sem = fetch_row($connect, "SELECT * FROM $SEM_TABLE WHERE status = 'Active' ");
            $semester = $sem["semester"];
            // if ($_FILES["file"]["size"] !== 0)
            // {
                if (trim($_POST["student_status"]) == 'New' || trim($_POST["student_status"]) == 'Transferee')
                {
                    // validate lrn, fullname, email
                    $count = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE lrn = '".trim($_POST["lrn"])."' AND status NOT IN ('Rejected','Archived')
                    AND school_year = '".$school_year."' AND lrn != ''");
                    if ($count > 0)
                    {
                        $output['status'] = false;
                        $output['message'] = 'LRN already exist.';
                    }
                    else
                    {
                        $count = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE last_name = '".trim($_POST["last_name"])."' AND 
                        first_name = '".trim($_POST["first_name"])."' AND middle_name = '".trim($_POST["middle_name"])."' 
                        AND extension_name = '".trim($_POST["extension_name"])."' AND status NOT IN ('Rejected','Archived')
                        AND school_year = '".$school_year."' ");
                        if ($count > 0)
                        {
                            $output['status'] = false;
                            $output['message'] = 'Fullname already exist.';
                        }
                        else
                        {
                            $count = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE email = '".trim($_POST["email"])."' 
                            AND status NOT IN ('Rejected','Archived') AND school_year = '".$school_year."' ");
                            if ($count > 0)
                            {
                                $output['status'] = false;
                                $output['message'] = 'Email already exist.';
                            }
                            else if ($_FILES["file"]["size"] !== 0)
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
            
                                    
                    
                                        $create = query($connect, "INSERT INTO $ADMISSION_TABLE (school_year, semester, admission_no, avatar, student_status, grade_level, strand_id, 
                                        lrn, last_name, first_name, middle_name, extension_name, 
                                        address, email, contact, date_birth, sex, nationality, last_attended, survey, g_fullname, g_contact, g_relationship, g_address,
                                        status, 
                                        -- payment_method, sf_plan, sf_amount, me_plan, me_amount, status, visitor_name, 
                                        -- report_card1, report_card2, report_card_date,
                                        -- form_1371, form_1372, form_137_date,
                                        -- psa, psa_date,
                                        -- good_moral, good_moral_date,
                                        -- certificate, certificate_date,
                                        date_created, time_created) VALUES 
                                        ('".$school_year."', '".$semester."', '".$admission_no."', '".$avatar."', '".trim($_POST["student_status"])."', '".trim($_POST["grade_level"])."', '".$strand_id."', 
                                        '".trim($_POST["lrn"])."', '".trim($_POST["last_name"])."', '".trim($_POST["first_name"])."', 
                                        '".trim($_POST["middle_name"])."', '".trim($_POST["extension_name"])."', 
                                        '".trim($_POST["address"])."', '".trim($_POST["email"])."', '".trim($_POST["contact"])."', '".trim($_POST["date_birth"])."', '".trim($_POST["sex"])."', 
                                        '".trim($_POST["nationality"])."', '".trim($_POST["last_attended"])."', '".trim($_POST["survey"])."', '".trim($_POST["g_fullname"])."', '".trim($_POST["g_contact"])."', '".trim($_POST["g_relationship"])."', 
                                        '".trim($_POST["g_address"])."', 'Pending',
                                        '".date("m-d-Y")."',
                                        '".date("h:i A")."') ");
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
                                            
                                            // $requirements = '';
                                            // if ($report_card1 != '')
                                            // {
                                            //     $requirements .= '- SF9 (Report Card)<br>';
                                            // }
                                            // if ($form_1371 != '')
                                            // {
                                            //     $requirements .= '- SF10 (Form 137)<br>';
                                            // }
                                            // if ($psa != '')
                                            // {
                                            //     $requirements .= '- PSA Birth Certificate<br>';
                                            // }
                                            // if ($good_moral != '')
                                            // {
                                            //     $requirements .= '- Good Moral Certificate<br>';
                                            // }
                                            // if ($certificate != '')
                                            // {
                                            //     $requirements .= '- Certificate of No Financial Obligation';
                                            // }
                    
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
                                            <b>Survey: </b> '.trim($_POST["survey"]).'
                                            <br>
                                            <b>Contact: </b> '.trim($_POST["contact"]).'
                                            <br>
                                            <b>Address: </b> '.trim($_POST["address"]).'

                                            <br><br>
                                            <b>Guardian Name: </b> '.trim($_POST["g_fullname"]).'
                                            <br>
                                            <b>Contact: </b> '.trim($_POST["g_contact"]).'
                                            <br>
                                            <b>Relationship: </b> '.trim($_POST["g_relationship"]).'
                                            <br>
                                            
                                            <br>
                                            <b>Address: </b> '.trim($_POST["g_address"]).'

                                            <br>

                                            <br><br>You can follow-up by using your admission no. : '.$admission_no.'
                                            <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                                            <br> <br><i>This is a system generated email. Do not reply.<i>');

                                            if ($mail) {
                                                $output['status'] = true;
                                                $output['message'] = 'Submitted successfully.';
                                                
                                                $sql = "SELECT user_email FROM $USER_TABLE";
                                                
                                                // Execute the query
                                                $stmt = $connect->query($sql);
                                                
                                                // Fetch all email addresses into an array
                                                $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                                
                                                // Loop through each email address and send the email
                                                foreach ($emails as $email) {
                                                    send_mail(trim($email),
                                                              'Enrollment Staff', 
                                                              'INCOMING ADMISSION', 
                                                              'Good day Enrollment Staff!<br><br>You have received an admission form from an enrollee, please check to process it.
                                                              <br>
                                                              <br>This is the preview of the enrollee\'s registration application, please check it for reference.
                                                
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
                                                              <b>Survey: </b> '.trim($_POST["survey"]).'
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
                                                              
                                                              <br>
                                                              <b>Address: </b> '.trim($_POST["g_address"]).'
                                                
                                                              <br>
                                                
                                                              <i>This is a system-generated email. Do not reply.<i>');
                                                }
                                            } else {
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
                            else
                            {
                                $output['status'] = true;
                                $output['message'] = 'Please upload a recent school ID.';

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

                                $strand_id = '';
                                $high_school = 'Junior';
                                if ($_POST["grade_level"] > 10)
                                {
                                    $strand_id = $_POST["strand_id"];
                                    $high_school = 'Senior';
                                }

                                $create = query($connect, "INSERT INTO $ADMISSION_TABLE (school_year, semester, admission_no, student_status, grade_level, strand_id, 
                                        lrn, last_name, first_name, middle_name, extension_name, 
                                        address, email, contact, date_birth, sex, nationality, last_attended, survey, g_fullname, g_contact, g_relationship, g_address,
                                        status, 
                                        -- payment_method, sf_plan, sf_amount, me_plan, me_amount, status, visitor_name, 
                                        -- report_card1, report_card2, report_card_date,
                                        -- form_1371, form_1372, form_137_date,
                                        -- psa, psa_date,
                                        -- good_moral, good_moral_date,
                                        -- certificate, certificate_date,
                                        date_created, time_created) VALUES 
                                        ('".$school_year."', '".$semester."', '".$admission_no."', '".trim($_POST["student_status"])."', '".trim($_POST["grade_level"])."', '".$strand_id."', 
                                        '".trim($_POST["lrn"])."', '".trim($_POST["last_name"])."', '".trim($_POST["first_name"])."', 
                                        '".trim($_POST["middle_name"])."', '".trim($_POST["extension_name"])."', 
                                        '".trim($_POST["address"])."', '".trim($_POST["email"])."', '".trim($_POST["contact"])."', '".trim($_POST["date_birth"])."', '".trim($_POST["sex"])."', 
                                        '".trim($_POST["nationality"])."', '".trim($_POST["last_attended"])."', '".trim($_POST["survey"])."', '".trim($_POST["g_fullname"])."', '".trim($_POST["g_contact"])."', '".trim($_POST["g_relationship"])."', 
                                        '".trim($_POST["g_address"])."', 'Pending',
                                        '".date("m-d-Y")."',
                                        '".date("h:i A")."') ");
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
                                            
                                            // $requirements = '';
                                            // if ($report_card1 != '')
                                            // {
                                            //     $requirements .= '- SF9 (Report Card)<br>';
                                            // }
                                            // if ($form_1371 != '')
                                            // {
                                            //     $requirements .= '- SF10 (Form 137)<br>';
                                            // }
                                            // if ($psa != '')
                                            // {
                                            //     $requirements .= '- PSA Birth Certificate<br>';
                                            // }
                                            // if ($good_moral != '')
                                            // {
                                            //     $requirements .= '- Good Moral Certificate<br>';
                                            // }
                                            // if ($certificate != '')
                                            // {
                                            //     $requirements .= '- Certificate of No Financial Obligation';
                                            // }
                    
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
                                            <b>Survey: </b> '.trim($_POST["survey"]).'
                                            <br>
                                            <b>Contact: </b> '.trim($_POST["contact"]).'
                                            <br>
                                            <b>Address: </b> '.trim($_POST["address"]).'

                                            <br><br>
                                            <b>Guardian Name: </b> '.trim($_POST["g_fullname"]).'
                                            <br>
                                            <b>Contact: </b> '.trim($_POST["g_contact"]).'
                                            <br>
                                            <b>Relationship: </b> '.trim($_POST["g_relationship"]).'
                                            <br>
                                            
                                            <br>
                                            <b>Address: </b> '.trim($_POST["g_address"]).'

                                            <br>

                                            <br><br>You can follow-up by using your admission no. : '.$admission_no.'
                                            <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                                            <br> <br><i>This is a system generated email. Do not reply.<i>');

                                            if ($mail) {
                                                $output['status'] = true;
                                                $output['message'] = 'Submitted successfully.';
                                                
                                                $sql = "SELECT user_email FROM $USER_TABLE";
                                                
                                                // Execute the query
                                                $stmt = $connect->query($sql);
                                                
                                                // Fetch all email addresses into an array
                                                $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                                
                                                // Loop through each email address and send the email
                                                foreach ($emails as $email) {
                                                    send_mail(trim($email),
                                                              'Enrollment Staff', 
                                                              'INCOMING ADMISSION', 
                                                              'Good day Enrollment Staff!<br><br>You have received an admission form from an enrollee, please check to process it.
                                                              <br>
                                                              <br>This is the preview of the enrollee\'s registration application, please check it for reference.
                                                
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
                                                              <b>Survey: </b> '.trim($_POST["survey"]).'
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
                                                              
                                                              <br>
                                                              <b>Address: </b> '.trim($_POST["g_address"]).'
                                                
                                                              <br>
                                                
                                                              <i>This is a system-generated email. Do not reply.<i>');
                                                }
                                            } else {
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
                    $student = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE lrn = '".trim($_POST["lrn"])."' AND status NOT IN ('Rejected','Archived')
                    ORDER BY id ASC LIMIT 1 ");
                    if ($student)
                    {
                        if ($student["school_year"] == $school_year)
                        {
                            $output['status'] = false;
                            $output['message'] = 'LRN already exist.';
                        } else if ($student ["lrn"] == ""){
                            $output['status'] = false;
                            $output['message'] = 'LRN is not Available.';
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
                                
                                

                                $upload = upload_image($_FILES["file"], $admission_no.'_avatar', 'assets/avatar/', $file_type, $type);
                                if ($upload["status"] == true)
                                {
                                //     $output['status'] = false;
                                //     $output['message'] = $upload["message"];
                                // }
                                // else
                                // {
                                    $avatar = $upload["message"];
                                    $strand_id = '';
                                    $high_school = 'Junior';
                                    if ($_POST["grade_level"] > 10)
                                    {
                                        $strand_id = $_POST["strand_id"];
                                        $high_school = 'Senior';
                                    }
        
                                    
                
                                    $create = query($connect, "INSERT INTO $ADMISSION_TABLE (school_year, semester, admission_no, avatar, student_status, grade_level, strand_id, 
                                    lrn, last_name, first_name, middle_name, extension_name, 
                                    address, email, contact, date_birth, sex, nationality, last_attended, g_fullname, g_contact, g_relationship, g_address, 
                                    status, 
                                    date_created, time_created) VALUES 
                                    ('".$school_year."', '".$semester."', '".$admission_no."', '".$avatar."', '".trim($_POST["student_status"])."', 
                                    '".trim($_POST["grade_level"])."', '".$strand_id."', 
                                    '".trim($_POST["lrn"])."', '".trim($student["last_name"])."', '".trim($student["first_name"])."', 
                                    '".trim($student["middle_name"])."', '".trim($student["extension_name"])."', 
                                    '".trim($student["address"])."', '".trim($_POST["email"])."', '".trim($student["contact"])."', '".trim($student["date_birth"])."', 
                                    '".trim($student["sex"])."', 
                                    '".trim($student["nationality"])."', '".trim($student["last_attended"])."', '".trim($student["g_fullname"])."', 
                                    '".trim($student["g_contact"])."', '".trim($student["g_relationship"])."', 
                                    '".trim($student["g_address"])."', 
                                    'Pending',
                                    '".date("m-d-Y")."', '".date("h:i A")."') ");
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

                                        <br>

                                        <br><br>You can follow-up by using your admission no. : '.$admission_no.'
                                        <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                                        <br> <br><i>This is a system generated email. Do not reply.<i>');
                                        if ($mail) // 
                                        {
                                            // $connect->commit();
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

            // }
            // else
            // {
            //     $output['status'] = false;
            //     $output['message'] = 'Please upload a recent school ID.';
            // }
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
                <br>Certificate of no financial obligation
                <br><br>You can use your admission no. : '.$student["admission_no"].'

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
                // $connect->beginTransaction();
                if ($student["grade_level"] > 10)
                {
                    $update = query($connect, "UPDATE $SHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$_POST['section_id']."' ");
                }
                else
                {
                    $update = query($connect, "UPDATE $JHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$_POST['section_id']."' ");
                }
                
                $admission = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE id = '".$_POST["id"]."' ");
                $update = query($connect, "UPDATE $ADMISSION_TABLE SET 
                    status = 'Enrolled', section_id = '".trim($_POST["section_id"])."', 
                    date_enrolled = '".date("m-d-Y h:i A")."'
                    WHERE id = '".$_POST['id']."' ");               
                
                    //send email add if cash is total amount then if installment tuition table with balance //'.number_format(trim($_POST["payment"]), 2, '.', ',').', 
                    $mail = send_mail(trim($student["email"]), 
                    trim($student['last_name']).", ".trim($student["first_name"])." ".trim($student["middle_name"])." ".trim($student["extension_name"]), 
                    'COMPLETED ADMISSION', 
                    'Dear Enrollee!<br><br>We are here to inform you that your section is <b>'.$section["section"].'</b>. 

                    <br><br>You can use your admission no. : '.$admission["admission_no"].'
                    <br><br>Thank You, <br>Welcome to Lake Shore Educational Institution, God Bless!
                    <br><br><i>This is a system generated email. Do not reply.<i>');
                    if ($mail)
                    {
                        // $connect->commit();
                        $output['status'] = true;
                        $output['message'] = 'Enrolled Successfully.';
                    }
                    else 
                    {
                        $connect->rollBack();
                        $output['status'] = false;
                        $output['message'] = 'Something went wrong.';
                    }
                // }
                // else 
                // {
                //     $connect->rollBack();
                //     $output['status'] = false;
                //     $output['message'] = 'Something went wrong.';
                // }
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
        $create = query($connect, "INSERT INTO $FEES_TABLE (high_school, fee_category, fee_name, fee_amount, fee_type, status, date_created, time_created) VALUES 
        ('".trim($_POST["high_school"])."', '".trim($_POST["fee_category"])."', '".trim($_POST["fee_name"])."', '".trim($_POST["fee_amount"])."', '".trim($_POST["fee_type"])."', 'Active','".date("m-d-Y")."', '".date("h:i A")."') ");
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
                    <th>Section</th>
                    <th>New</th>
                    <th>Old</th>
                    <th>Transferee</th>
                    <th>Returnee</th>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';

        if (!empty($_POST["grade_level"]))
        {
            if (intval($_POST["grade_level"]) > 10)
            {
                $rslt = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE grade_level = '".$_POST["grade_level"]."' AND strand_id = '".$_POST["strand_id"]."' #AND status = 'Enrolled' " ); // status IN ('Enrolled') 
            }
            else
            {
                $rslt = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE grade_level = '".$_POST["grade_level"]."' GROUP BY section_id #AND status IN ('Enrolled')  " ); // status IN ('Enrolled') 
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
        $output['lrn'] = $result["lrn"];
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
        // $output['g_occupation'] = $result["g_occupation"];
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
                    lrn = '".trim($_POST["lrn"])."',
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
                    lrn = '".trim($_POST["lrn"])."',
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
        $update = query($connect, "UPDATE $ADMISSION_TABLE SET status = 'Archived' WHERE id = '".$_POST['id']."' ");
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
                    <th>Admission</th>
                    <th>Applicant Details</th>
                    <th>Guardian Details</th>
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
        $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE status = 'Archived' AND school_year = '".$_POST['school_year']."' $query " ); // 
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
    
                $applicant = "<b>Name</b>: ".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name'];
    
                $guardian = "<b>Name</b>: ".$row['g_fullname'];

                // $payment = "<b>Payment</b>: " . $row['payment_method'];
            } else {
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
    
                $applicant = "<b>Name</b>: ".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name']
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
                
                ."<br><b>Address</b>: ".$row['g_address'];
    
                // REMOVE PAYMENT COLUMN IN ARCHIVED TAB
                // if ($row['payment_method'] == 'Installment')
                // {
                //     $payment = "<b>Payment</b>: ".$row['payment_method']
                //     ."<br><b>School Fees Plan</b>: ".$row['sf_plan']
                //     ."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
                //     ."<br><b>Modules & E-Book Plan</b>: ".$row['me_plan']
                //     ."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',');
                // }
                // else
                // {
                //     $payment = "<b>Payment</b>: ".$row['payment_method']
                //     ."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
                //     ."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',');
                // }
            }

            $table .= '
            <tr>
                <td>' . $admission . '</td>
                <td>' . $applicant . '</td>
                <td>' . $guardian . '</td>
                
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
        if (isset($_POST['title']))
        {
            $fetch = fetch_row($connect, "SELECT * FROM $ADMISSION_TABLE WHERE admission_no = '".$_POST["admission_no"]."' ");
            if (intval($fetch["grade_level"]) > 10)
            {
                query($connect, "UPDATE $SHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$fetch['section_id']."' ");
            }
            else
            {
                query($connect, "UPDATE $JHSECTION_TABLE SET no_students = no_students + 1 WHERE id = '".$fetch['section_id']."' ");
            }
            $update = query($connect, "UPDATE $ADMISSION_TABLE SET status = 'Enrolled' WHERE admission_no = '".$_POST['admission_no']."' ");
        }
        else
        {
            $update = query($connect, "UPDATE $ADMISSION_TABLE SET date_paid = NULL WHERE admission_no = '".$_POST['admission_no']."' ");
        }
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
            <tbody>';
        if (intval($_POST['grade_level']) > 10)
        {
            $fetch = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$_POST["id"]."' ");
            $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '".$_POST["grade_level"]."' AND strand_id = '".$fetch['strand_id']."'
            AND section_id = '".$_POST['id']."' " ); // 
        }
        else
        {
            $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND grade_level = '".$_POST["grade_level"]."' AND section_id = '".$_POST['id']."' " ); // 
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
            $section_table .= '
            <tr>
                <td class="text-center" colspan="3">No data found.</td>
            </tr>';
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
                    <th>Admission</th>
                    <th>Applicant Details</th>
                    <th>Guardian Details</th>
                   
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
            
            $admission = $image."<br><b>Grade Level</b>: ".$row['grade_level']
            ."<br><b>Section</b>: ".$section
            ."<br><b>LRN</b>: ".$row['lrn']
            ."<br><b>Status</b>: ".$row['student_status']
            ."<br><b>Date</b>: ".$row['date_created'];

            $applicant = "<b>Name</b>: ".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name']
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
            
            ."<br><b>Address</b>: ".$row['g_address'];


            $table .= '
            <tr>
                <td>' . $admission . '</td>
                <td>' . $applicant . '</td>
                <td>' . $guardian . '</td>
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

        $ss_poster = get_total_count($connect, "SELECT survey FROM $ADMISSION_TABLE WHERE survey = 'Poster' ");
        $ss_ads = get_total_count($connect, "SELECT survey FROM $ADMISSION_TABLE WHERE survey = 'Advertisement' ");
        $ss_people = get_total_count($connect, "SELECT survey FROM $ADMISSION_TABLE WHERE survey = 'Other People' ");
        $ss_others = get_total_count($connect, "SELECT survey FROM $ADMISSION_TABLE WHERE survey NOT IN ('Poster', 'Advertisement', 'Other People')");
        
        $output['ss_poster'] = $ss_poster;
        $output['ss_ads'] = $ss_ads;
        $output['ss_people'] = $ss_people;
        $output['ss_others'] = $ss_others;


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
        
        // $output['report_card1'] = !empty($fetch["report_card1"]) ? $fetch["report_card1"] : '';
        // $output['report_card_date'] = $fetch["report_card_date"];
        // $output['form_1371'] = !empty($fetch["form_1371"]) ? $fetch["form_1371"] : '';
        // $output['form_137_date'] = $fetch["form_137_date"];
        // $output['psa'] = !empty($fetch["psa"]) ? $fetch["psa"] : '';
        // $output['psa_date'] = $fetch["psa_date"];
        // $output['good_moral'] = !empty($fetch["good_moral"]) ? $fetch["good_moral"] : '';
        // $output['good_moral_date'] = $fetch["good_moral_date"];
        // $output['certificate'] = !empty($fetch["certificate"]) ? $fetch["certificate"] : '';
        // $output['certificate_date'] = $fetch["certificate_date"];
        // echo json_encode($output);

        $output = array();

// Check if the keys exist before accessing them
$output['report_card1'] = isset($fetch["report_card1"]) ? $fetch["report_card1"] : '';
$output['report_card_date'] = isset($fetch["report_card_date"]) ? $fetch["report_card_date"] : null;
$output['form_1371'] = isset($fetch["form_1371"]) ? $fetch["form_1371"] : '';
$output['form_137_date'] = isset($fetch["form_137_date"]) ? $fetch["form_137_date"] : null;
$output['psa'] = isset($fetch["psa"]) ? $fetch["psa"] : '';
$output['psa_date'] = isset($fetch["psa_date"]) ? $fetch["psa_date"] : null;
$output['good_moral'] = isset($fetch["good_moral"]) ? $fetch["good_moral"] : '';
$output['good_moral_date'] = isset($fetch["good_moral_date"]) ? $fetch["good_moral_date"] : null;
$output['certificate'] = isset($fetch["certificate"]) ? $fetch["certificate"] : '';
$output['certificate_date'] = isset($fetch["certificate_date"]) ? $fetch["certificate_date"] : null;

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

}

?>