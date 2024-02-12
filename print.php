<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:login.php");
}

if ($_SESSION['title'] == 'STUDENT')
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
            </tr>
        </thead>
        <tbody>';
    if (intval($_SESSION['grade_level']) > 10)
    {
        $fetch = fetch_row($connect, "SELECT * FROM $SHSECTION_TABLE WHERE id = '".$_SESSION["section_id"]."' ");
        $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' 
        AND grade_level = '".$_SESSION["grade_level"]."' AND strand_id = '".$fetch['strand_id']."'
        AND section_id = '".$_SESSION['section_id']."' AND status IN ('Enrolled') " ); // 
    }
    else
    {
        $result = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE school_year = '".$school_year."' 
        AND grade_level = '".$_SESSION["grade_level"]."' AND section_id = '".$_SESSION['section_id']."' AND status IN ('Enrolled') " ); // 
    }
    if ($result)
    {
        foreach($result as $row)
        {
    
            $count += 1;
            $section_table .= '
            <tr>
                <td>'.$count.'</td>
                <td>'.$row['last_name'].", ".$row['first_name']." ".$row['middle_name']." ".$row['extension_name'].'</td>
            </tr>';
        }
    }
    else
    {
        $section_table .= '
        <tr>
            <td class="text-center" colspan="2">No data found.</td>
        </tr>';
    }
    $section_table .= '
        </tbody>
    </table>';
}
else
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

    if (!empty($_SESSION["grade_level"]))
    {
        $sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
        if (intval($_SESSION["grade_level"]) > 10)
        {
            $rslt = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE grade_level = '".$_SESSION["grade_level"]."' 
            AND strand_id = '".$_SESSION["strand_id"]."' AND school_year = '".$sy["school_year"]."' #AND status = 'Enrolled' " ); // status IN ('Enrolled') 
        }
        else
        {
            $rslt = fetch_all($connect,"SELECT * FROM $ADMISSION_TABLE WHERE grade_level = '".$_SESSION["grade_level"]."' AND school_year = '".$sy["school_year"]."' 
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

                $new = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE student_status = 'New' AND grade_level = '".$_SESSION["grade_level"]."' AND section_id = '".$row["section_id"]."' ");
                $new1 += $new;
                $old = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE student_status = 'Old' AND grade_level = '".$_SESSION["grade_level"]."' AND section_id = '".$row["section_id"]."' ");
                $old1 += $old;
                $returnee = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE student_status = 'Returnee' AND grade_level = '".$_SESSION["grade_level"]."' 
                AND section_id = '".$row["section_id"]."' ");
                $returnee1 += $returnee;
                $transferee = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE student_status = 'Transferee' AND grade_level = '".$_SESSION["grade_level"]."' 
                AND section_id = '".$row["section_id"]."' ");
                $transferee1 += $transferee;
                
                $male = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE sex = 'Male' AND grade_level = '".$_SESSION["grade_level"]."' AND section_id = '".$row["section_id"]."' ");
                $male1 += $male;
                $female = get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE sex = 'Female' AND grade_level = '".$_SESSION["grade_level"]."' AND section_id = '".$row["section_id"]."' ");
                $female1 += $female;
                
                $total += ($male + $female);
                $total1 += $total;
                if ($_SESSION["grade_level"] > 10)
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
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Enrollement System</title>
    <link rel="icon" href="assets/logo.jpg" type="image/ico">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <section class="p-3">
        <div class="col-12 text-center">
            <div class="h1">LakeShore Educational Institution</div>
        </div>
        <?php if ($_SESSION['title'] == 'STUDENT') { ?>
            <div class="col-12 col-md-12">
                <label>Grade : <?php echo $_SESSION["grade_level"]; ?></label>
            </div>
            <div class="col-12 col-md-12">
                <label>Section : <?php echo $_SESSION["section"]; ?></label>
            </div>
            <div class="col-12 col-md-12">
                <label>Adviser : <?php echo $_SESSION["adviser"]; ?></label>
            </div>
            <div class="col-12">
                <?php echo $section_table; ?>
            </div>
        <?php } else {?>
            <div class="col-12">
                <?php echo $datatables; ?>
            </div>
        <?php } ?>

    </section>
</div>
<script>
    window.addEventListener("load", window.print());
    onafterprint = function () 
    {
        window.history.back();
    }
</script>
</body>
</html>