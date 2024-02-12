<?php

//fetch_data.php

include('../config.php');

$query = '';

$output = array();

$query .= "SELECT * FROM $INSTRUCTOR_TABLE WHERE  ";

if(isset($_POST["search"]["value"]))
{
	$query .= '(fullname LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR gender LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR contact LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR status LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR date_created LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY id DESC ';
}

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$sub_array = array();
	
	if($row['status'] == 'Active')
	{
		$sub_array[] = ' &nbsp; 
		<a class="btn btn-success update elevation-2 pr-3 pl-3" href="#" name="update" id="'.$row["id"].'" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Edit">
			<i class="fa fa-edit"></i> Edit
		</a>';

		$sub_array[] = ' &nbsp; 
		<a class="btn btn-success status elevation-2 pr-3 pl-3" href="#" data-status="Inactive" name="status" id="'.$row["id"].'" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Active">
			<i class="fa fa-check-circle"></i> Active
		</a>';
	}
	else
	{
		$sub_array[] = '';

		$sub_array[] = ' &nbsp; 
		<a class="btn btn-danger status elevation-2 pr-3 pl-3" href="#" data-status="Active" name="status" id="'.$row["id"].'" style="border-radius: 20px;" data-toggle="tooltip" data-placement="top" title="Inactive">
			<i class="fa fa-times-circle"></i> Inactive
		</a>';
	}

	$section = '';
	if (!empty($row['grade_level']))
	{
		if (intval($row['grade_level']) > 10)
		{
			$strand = fetch_row($connect, "SELECT * FROM $STRANDS_TABLE WHERE id = '".$row["strand_id"]."' ");
			$sec = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$row["section_id"]."' ");
			$section = $row['grade_level'].' '.$strand['strand'].'-'.$sec['section'];
		}
		else
		{
			$sec = fetch_row($connect, "SELECT * FROM $JHSECTION_TABLE WHERE id = '".$row["section_id"]."' ");
			$section = $row['grade_level'].'-'.$sec['section'];
		}
	}
	$sub_array[] = $section;
	
	$sub_array[] = $row['fullname'];
	$sub_array[] = $row['gender'];
	$sub_array[] = $row['contact'];
	$sub_array[] = $row['date_created'];

	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_all_records($connect, $INSTRUCTOR_TABLE),
	"data"				=>	$data
);

function get_total_all_records($connect, $TABLE)
{
	$statement = $connect->prepare("SELECT * FROM $TABLE  ");
	$statement->execute();
	return $statement->rowCount();
}

echo json_encode($output);

?>