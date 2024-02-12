<?php

//fetch_data.php

include('../config.php');

$sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
$school_year = $sy["school_year"];

$query = " AND grade_level BETWEEN 11 AND 12 ";
if (!empty($_GET["grade_level"]))
{
	$query = " AND grade_level = '".$_GET["grade_level"]."' ";
}
if (!empty($_GET["strand_id"]))
{
	$query .= " AND strand_id = '".$_GET["strand_id"]."' ";
}
$result = fetch_all($connect,"SELECT *, (SELECT strand FROM $STRANDS_TABLE WHERE id = $ADMISSION_TABLE.strand_id ) AS strand,
(SELECT section FROM $SHSECTION_TABLE WHERE id = $ADMISSION_TABLE.section_id ) AS section 
FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' AND status IN ('Enrolled') AND archived IS NULL $query" ); 
if ($result)
{
	foreach($result as $row)
	{
		$sub_array = array();
	
		// $sub_array[] = $row['student_status'];
		// $sub_array[] = $row['grade_level'];
		// $sub_array[] = $row['strand'];
		// $sub_array[] = $row['section'];
		
		$button = '';
		if ($row['payment_method'] == 'Installment')
		{
			$button = ' &nbsp; 
			<a class="btn btn-success update elevation-2 pr-3 pl-3" href="#" name="update" id="'.$row["id"].'" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Edit">
				<i class="fa fa-edit"></i> Edit
			</a>
			<a class="btn btn-success payment elevation-2 pr-3 pl-3" href="#" name="payment" id="'.$row["id"].'" 
				admission_no="'.$row["admission_no"].'" status="'.$row["date_paid"].'" status="'.$row["date_paid"].'" sf="'.$row["sf_plan"].'" me="'.$row["me_plan"].'"
				style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="View Payment">
				<i class="fa fa-file-invoice-dollar"></i> Payment
			</a>
			<a class="btn btn-success archive elevation-2 pr-3 pl-3" href="#" name="archive" id="'.$row["id"].'" 
				style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Archive">
				<i class="fa fa-archive"></i> Archive
			</a>';
		}
		else
		{
			$button = ' &nbsp; 
			<a class="btn btn-success update elevation-2 pr-3 pl-3" href="#" name="update" id="'.$row["id"].'" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Edit">
				<i class="fa fa-edit"></i> Edit
			</a>
			<a class="btn btn-success archive elevation-2 pr-3 pl-3" href="#" name="archive" id="'.$row["id"].'" 
				style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Archive">
				<i class="fa fa-archive"></i> Archive
			</a>';
		}
	
		$image = '<a data-magnify="gallery" class="card-img-top " data-caption="'.$row["admission_no"].'" data-group="" href="'.$row["avatar"].'">
			<img class="img-fluid img-circle elevation-2" style="height: 50px; width: 50px; cursor: pointer;" id="user_img" src="'.$row["avatar"].'" alt="'.$row["admission_no"].'">
		</a>';

		if (empty($row["button_status"]))
		{
			$sub_array[] = ' &nbsp; 
			<a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="Hide" name="button_status"
			id="'.$row["id"].'" style="border-radius: 20px;" >
				<i class="fa fa-eye"></i> 
			</a>'.$button;

			$sub_array[] = $image;
		
			$sub_array[] = "".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name'];
			$sub_array[] = "<b>Name</b>: ".$row['g_fullname'];
			
			$sub_array[] = "<b>Payment</b>: ".$row['payment_method'];

		}
		else
		{
			$sub_array[] = ' &nbsp; 
			<a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="" name="button_status"
			id="'.$row["id"].'" style="border-radius: 20px;" >
				<i class="fa fa-eye-slash"></i> 
			</a>'.$button;
			
			$sub_array[] = $image."<br><b>Grade Level</b>: ".$row['grade_level']
			."<br><b>Strand</b>: ".$row['strand']
			."<br><b>Section</b>: ".$row['section']
            ."<br><b>LRN</b>: ".$row['lrn']
			."<br><b>Status</b>: ".$row['student_status'].' <br>&nbsp; 
			<a class="btn btn-success requirements elevation-2 pr-3 pl-3" href="#" name="requirements" id="'.$row["admission_no"].'" 
				style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Requirements">
				<i class="fa fa-list"></i> Requirements
			</a>';
		
			$sub_array[] = "".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name']
			."<br><b>Date of Birth</b>: ".$row['date_birth']
			."<br><b>Sex</b>: ".$row['sex']
			."<br><b>Email</b>: ".$row['email']
			."<br><b>Contact</b>: ".$row['contact']
			."<br><b>Address</b>: ".$row['address']
			."<br><b>Nationality</b>: ".$row['nationality']
			."<br><b>S.Y. Last Attended</b>: ".$row['last_attended'];
		
			$sub_array[] = "<b>Name</b>: ".$row['g_fullname']
			."<br><b>Contact</b>: ".$row['g_contact']
			."<br><b>Relationship</b>: ".$row['g_relationship']
			."<br><b>Occupation</b>: ".$row['g_occupation']
			."<br><b>Address</b>: ".$row['g_address'];
		
			if ($row['payment_method'] == 'Installment')
			{
				$esc = '';
				if (intval($row['esc_payment']) != 0)
				{
					$esc .= "<br><b>ESC Amount</b>: ".number_format($row['esc_payment'], 2, '.', ',');
				}
				$sub_array[] = "<b>Payment</b>: ".$row['payment_method']
				."<br><b>School Fees Plan</b>: ".$row['sf_plan']
				."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
				."<br><b>Modules & E-Book Plan</b>: ".$row['me_plan']
				."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',').$esc;
			}
			else
			{
				$esc = '';
				if (intval($row['esc_payment']) != 0)
				{
					$esc .= "<br><b>ESC Amount</b>: ".number_format($row['esc_payment'], 2, '.', ',');
				}
				$sub_array[] = "<b>Payment</b>: ".$row['payment_method']
				."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
				."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',').$esc;
			}
		}
		
		$sub_array[] = substr($row['date_created'], 0, 10);
		$sub_array[] = substr($row['date_created'], 11);
	
		$data[] = $sub_array;
	}
}
else
{
	$data = array();
}
$output = array("data" => $data);
echo json_encode($output);
return;

?>