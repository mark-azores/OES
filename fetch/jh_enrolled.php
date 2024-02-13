<?php

//fetch_data.php

include('../config.php');

$sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
$school_year = $sy["school_year"];

$query = " AND grade_level BETWEEN 7 AND 10 ";
if (!empty($_GET["grade_level"])) {
    $query = " AND grade_level = '" . $_GET["grade_level"] . "' ";
}
$result = fetch_all($connect, "SELECT *, (SELECT section FROM $JHSECTION_TABLE WHERE id = $ADMISSION_TABLE.section_id ) AS section 
FROM $ADMISSION_TABLE WHERE school_year = '" . $school_year . "' AND status IN ('Enrolled') $query");
if ($result) {
    foreach ($result as $row) {
        $sub_array = array();

        $button = ' &nbsp; 
        <a class="btn btn-success update elevation-2 mt-2 pr-3 pl-3" href="#" name="update" id="'.$row["id"].'" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Edit">
            <i class="fa fa-edit"></i> Edit
        </a><br>
        <a class="btn btn-success archive elevation-2 mt-2 pr-3 pl-3" href="#" name="archive" id="'.$row["id"].'" 
            style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Archive">
            <i class="fa fa-archive"></i> Archive
        </a>';

        $image = '<a data-magnify="gallery" class="card-img-top " data-caption="'.$row["admission_no"].'" data-group="" href="'.$row["avatar"].'">
            <img class="img-fluid img-circle elevation-2" style="height: 50px; width: 50px; cursor: pointer;" id="user_img" src="'.$row["avatar"].'" alt="'.$row["admission_no"].'">
        </a>';

        if (empty($row["button_status"]))
        {
            $sub_array[] = ' &nbsp; 
            <a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="Hide" name="button_status"
            id="'.$row["id"].'" style="border-radius: 20px;" >
                <i class="fa fa-eye"></i> 
            </a> '.$button;
			
            $sub_array[] = $image;

            $sub_array[] = "".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name'];
            $sub_array[] = "<b>Name</b>: ".$row['g_fullname'];

            $sub_array[] = isset($row['payment_method']) ? "<b>Payment</b>: ".$row['payment_method'] : "<b>Payment</b>: Not Available";

        }
        else
        {
            $sub_array[] = ' &nbsp; 
            <a class="btn btn-primary button_status elevation-2 pr-3 pl-3" href="#" data-status="" name="button_status"
            id="'.$row["id"].'" style="border-radius: 20px;" >
                <i class="fa fa-eye-slash"></i> 
            </a>'.$button;

            $sub_array[] = $image."<br><b>Grade Level</b>: ".$row['grade_level']
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

            // $sub_array[] = isset($row['payment_method']) ? "<b>Payment</b>: ".$row['payment_method'] : "<b>Payment</b>: Not Available";
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
