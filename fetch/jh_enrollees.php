<?php

//fetch_data.php

include('../config.php');

$sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
$school_year = $sy["school_year"];

$query = " AND grade_level BETWEEN 7 AND 10 ";
if (!empty($_GET["grade_level"])) {
	$query = " AND grade_level = '" . $_GET["grade_level"] . "' ";
}
$result = fetch_all($connect, "SELECT * FROM $ADMISSION_TABLE WHERE school_year = '" . $school_year . "' AND status IN ('Scheduled','Pending') $query");
if ($result) {
	foreach ($result as $row) {
		$sub_array = array();

		$button = '';
		if ($row['status'] == 'Pending') {
			$button = ' &nbsp; 
			<a class="btn btn-success status elevation-2 mt-2 pr-3 pl-3" href="#" data-status="Schedule" name="status" id="' . $row["id"] . '" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Schedule">
				<i class="fa fa-calendar-day"></i> Schedule
			</a><br>
			<a class="btn btn-danger mt-2 status elevation-2 pr-3 pl-3" href="#" data-status="Reject" data-name="' . $row['last_name'] . ", " . $row['first_name'] . " " . $row['middle_name'] . " " . $row['extension_name'] . '" name="status" id="' . $row["id"] . '" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Reject">
				<i class="fa fa-times-circle"></i> Reject
			</a>';
		} else {

			//============= COMMENT OUT BEFORE ====== line 41 data-method="'.$row['payment_method'].'" data-sf="'.$row['sf_plan'].'"  data-me="'.$row['me_plan'].'"
			// line 42 data-tuition="'.($row['sf_amount'] + $row['me_amount']).'" 
			if (!empty($row["assessment_status"])) {
				$button = ' &nbsp; 
				<a class="btn btn-success status elevation-2 pr-3 pl-3" href="#" data-status="Payment"  data-grade_level="' . $row['grade_level'] . '" 
				
				data-admission_no="' . $row['admission_no'] . '" 
				name="status" id="' . $row["id"] . '" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Payment">
					<i class="fa fa-file-invoice-dollar"></i> Assign
				</a>
				<a class="btn btn-success archive elevation-2 pr-3 pl-3" href="#" name="archive" id="' . $row["id"] . '" 
					style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Archive">
					<i class="fa fa-archive"></i> Archive
				</a>
				<br><b>Date Scheduled</b>: ' . $row["date_scheduled"] . '
				<br><b class="text-success">Assessment</b>: ' . $row["assessment_status"];
			} else {
				//==========================================
				$button = ' &nbsp; 
				<a class="btn btn-primary assessment elevation-2 pr-3 pl-3" href="#" data-status="Assessment"  name="assessment"
				id="' . $row["id"] . '" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Assessment">
					<i class="fa fa-file"></i> Assessment
				</a>
				<a class="btn btn-success archive elevation-2 pr-3 pl-3" href="#" name="archive" id="' . $row["id"] . '" 
					style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Archive">
					<i class="fa fa-archive"></i> Archive
				</a>
				<br><b>Date Scheduled</b>: ' . $row["date_scheduled"];
			}
		}

		if (empty($row["button_status"])) {
			$sub_array[] = ' &nbsp; 
			<a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="Hide" name="button_status"
			id="' . $row["id"] . '" style="border-radius: 20px;" >
				<i class="fa fa-eye"></i> 
			</a> ' . $button;

			$image = '<a data-magnify="gallery" class="card-img-top " data-caption="' . $row["admission_no"] . '" data-group="" href="' . $row["avatar"] . '">
				<img class="img-fluid img-circle elevation-2" style="height: 50px; width: 50px; cursor: pointer;" id="user_img" src="' . $row["avatar"] . '" alt="' . $row["admission_no"] . '">
			</a>';

			$sub_array[] = $image . "<br><b>Admission No.</b>: " . $row['admission_no'];

			$sub_array[] = "" . $row['last_name'] . ", " . $row['first_name'] . " " . $row['middle_name'] . " " . $row['extension_name'];
			$sub_array[] = "<b>Name</b>: " . $row['g_fullname'];

			// $sub_array[] = "<b>Payment</b>: ".$row['payment_method'];
		} else {
			$sub_array[] = ' &nbsp; 
			<a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="" name="button_status"
			id="' . $row["id"] . '" style="border-radius: 20px;" >
				<i class="fa fa-eye-slash"></i> 
			</a>' . $button;

			$image = '<a data-magnify="gallery" class="card-img-top " data-caption="' . $row["admission_no"] . '" data-group="" href="' . $row["avatar"] . '">
				<img class="img-fluid img-circle elevation-2" style="height: 50px; width: 50px; cursor: pointer;" id="user_img" src="' . $row["avatar"] . '" alt="' . $row["admission_no"] . '">
			</a>';

			// $sub_array[] = $image . "<br><b>Admission No.</b>: " . $row['admission_no']
			// 	. "<br><b>Grade Level</b>: " . $row['grade_level']
			// 	. "<br><b>LRN</b>: " . $row['lrn']
			// 	. "<br><b>Status</b>: " . $row['student_status'] . ' <br>&nbsp; 
			// <a class="btn btn-success requirements elevation-2 pr-3 pl-3" href="#" name="requirements" id="' . $row["admission_no"] . '" 
			// 	style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Requirements">
			// 	<i class="fa fa-list"></i> Requirements
			// </a>';

			// MODIFIED OF THE ABOVE TO REMOVE REQ BUTTON
			$sub_array[] = $image . "<br><b>Admission No.</b>: " . $row['admission_no']
            . "<br><b>Grade Level</b>: " . $row['grade_level']
            . "<br><b>LRN</b>: " . $row['lrn']
            . "<br><b>Status</b>: " . $row['student_status'];
			//======================================

			$sub_array[] = "" . $row['last_name'] . ", " . $row['first_name'] . " " . $row['middle_name'] . " " . $row['extension_name']
				. "<br><b>Date of Birth</b>: " . $row['date_birth']
				. "<br><b>Sex</b>: " . $row['sex']
				. "<br><b>Email</b>: " . $row['email']
				. "<br><b>Contact</b>: " . $row['contact']
				. "<br><b>Address</b>: " . $row['address']
				. "<br><b>Nationality</b>: " . $row['nationality']
				. "<br><b>S.Y. Last Attended</b>: " . $row['last_attended']
				. "<br><b>Survey</b>: " . $row['survey'];
			$sub_array[] = "<b>Name</b>: " . $row['g_fullname']
				. "<br><b>Contact</b>: " . $row['g_contact']
				. "<br><b>Relationship</b>: " . $row['g_relationship']
				. "<br><b>Occupation</b>: " . $row['g_occupation']
				. "<br><b>Address</b>: " . $row['g_address'];

			// if ($row['payment_method'] == 'Installment')
			// {
			// 	$sub_array[] = "<b>Payment</b>: ".$row['payment_method']
			// 	."<br><b>School Fees Plan</b>: ".$row['sf_plan']
			// 	."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
			// 	."<br><b>Modules & E-Book Plan</b>: ".$row['me_plan']
			// 	."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',');
			// }
			// else
			// {
			// 	$sub_array[] = "<b>Payment</b>: ".$row['payment_method']
			// 	."<br><b>School Fees</b>: ".number_format($row['sf_amount'], 2, '.', ',')
			// 	."<br><b>Modules & E-Book</b>: ".number_format($row['me_amount'], 2, '.', ',');
			// }
		}

		$sub_array[] = $row['date_created'];
		$sub_array[] = $row['time_created'];
		$data[] = $sub_array;
	}
} else {
	$data = array();
}
$output = array("data" => $data);
echo json_encode($output);
return;

?>