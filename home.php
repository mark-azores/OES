<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'Home';
include('header.php');

include('sidebar.php');

$sy = fetch_row($connect, "SELECT * FROM $SY_TABLE WHERE status = 'Active' ");
if ($sy)
{
    $school_year = '<div class="h1 text-bold text-success">Shool Year '.$sy["school_year"].'</div>';
    $sem = fetch_row($connect, "SELECT * FROM $SEM_TABLE WHERE status = 'Active' ");
    $sem = $sem["semester"];
}
else
{
    $school_year = '<div class="h1 text-bold text-danger">No School Yet.</div>';
    $sem = '';
}

?>

<div class="content-wrapper">
    
    <div class="content-header">
        <div class="container-fluid">
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <?php echo $school_year; ?>
                </div>
                <div class="col-12 text-center">
                    <div class="h3 text-bold"><?php echo $sem; ?></div>
                </div>
                <div class="col-12 mt-5">
                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-6 d-flex justify-content-center">
                            <div class="small-box col-12 col-md-8 elevation-2 border border-success text-success" style="border-radius: 20px;">
                                <div class="icon text-success">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                                <div class="inner ml-0 ml-sm-2">
                                    <p>Pending Enrollees</p>
                                    <h3><?php echo get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE status IN ('Scheduled','Pending') AND school_year = '".$sy["school_year"]."' "); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-6 d-flex justify-content-center">
                            <div class="small-box col-12 col-md-8 elevation-2 border border-success text-success" style="border-radius: 20px;">
                                <div class="icon text-success">
                                    <i class="fa fa-user-check"></i>
                                </div>
                                <div class="inner ml-0 ml-sm-2">
                                    <p>Enrolled Students</p>
                                    <h3><?php echo get_total_count($connect, "SELECT * FROM $ADMISSION_TABLE WHERE status = 'Enrolled' AND school_year = '".$sy["school_year"]."' "); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-6 d-flex justify-content-center">
                            <div class="small-box col-12 col-md-8 elevation-2 border border-success text-success" style="border-radius: 20px;">
                                <div class="icon text-success">
                                    <i class="fa fa-th"></i>
                                </div>
                                <div class="inner ml-0 ml-sm-2">
                                    <p>Strand</p>
                                    <h3><?php echo get_total_count($connect, "SELECT * FROM $STRANDS_TABLE "); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-6 d-flex justify-content-center">
                            <div class="small-box col-12 col-md-8 elevation-2 border border-success text-success" style="border-radius: 20px;">
                                <div class="icon text-success">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <div class="inner ml-0 ml-sm-2">
                                    <p>Section</p>
                                    <h3><?php echo get_total_count($connect, "SELECT * FROM $JHSECTION_TABLE ") +  get_total_count($connect, "SELECT * FROM $SHSECTION_TABLE "); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-6 d-flex justify-content-center">
                            <div class="small-box col-12 col-md-8 elevation-2 border border-success text-success" style="border-radius: 20px;">
                                <div class="icon text-success">
                                    <i class="fa fa-user-tag"></i>
                                </div>
                                <div class="inner ml-0 ml-sm-2">
                                    <p>Instructors</p>
                                    <h3><?php echo get_total_count($connect, "SELECT * FROM $INSTRUCTOR_TABLE "); ?></h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($_SESSION["user_type"] == 'Superadmin') {?>
                        <div class="col-lg-4 col-md-4 col-6 d-flex justify-content-center">
                            <div class="small-box col-12 col-md-8 elevation-2 border border-success text-success" style="border-radius: 20px;">
                                <div class="icon text-success">
                                    <i class="fa fa-user-cog"></i>
                                </div>
                                <div class="inner ml-0 ml-sm-2">
                                    <p>Staff Account</p>
                                    <h3><?php echo get_total_count($connect, "SELECT * FROM $USER_TABLE WHERE user_type != 'Superadmin' "); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card card-success elevation-2" style="border-radius: 20px;">
                                <div class="card-header" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                    <h3 class="card-title">Junior High Enrolled Students</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card card-success elevation-2" style="border-radius: 20px;">
                                <div class="card-header" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                    <h3 class="card-title">Junior High Incoming Students</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="donutChart1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card card-success elevation-2" style="border-radius: 20px;">
                                <div class="card-header" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                    <h3 class="card-title">Senior High Enrolled Students</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="donutChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card card-success elevation-2" style="border-radius: 20px;">
                                <div class="card-header" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                    <h3 class="card-title">Senior High Incoming Students</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="donutChart3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card card-success elevation-2" style="border-radius: 20px;">
                                <div class="card-header" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                                    <h3 class="card-title">Lake Shore Promotion Survey</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="donutChart4" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php

include('footer.php');

?>

<script>
    $(function () {
        
        var btn_action = 'load_pie';
        $.ajax({
            url:"action.php",
            method:"POST",
            data:{ btn_action:btn_action },
            dataType:"json",
            success:function(data)
            {
                //-------------
                //- DONUT CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
                var donutData        = {
                    labels: [
                        'Grade 7',
                        'Grade 8',
                        'Grade 9',
                        'Grade 10',
                    ],
                    datasets: [
                        {
                            // data: [700,500,400,600],
                            data: [data.e_seven, data.e_eight, data.e_nine, data.e_ten],
                            backgroundColor : ['#007bff', '#20c997', '#28a745', '#dc3545', '#ffc107'],
                        }
                    ]
                }
                var donutOptions     = {
                    maintainAspectRatio : false,
                    responsive : true,
                }
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                new Chart(donutChartCanvas, {
                    type: 'doughnut',
                    data: donutData,
                    options: donutOptions
                })
                
                var donutChartCanvas1 = $('#donutChart1').get(0).getContext('2d')
                var donutData1        = {
                    labels: [
                        'Grade 7',
                        'Grade 8',
                        'Grade 9',
                        'Grade 10',
                    ],
                    datasets: [
                        {
                            // data: [700,500,400,600,300],
                            data: [data.i_seven, data.i_eight, data.i_nine, data.i_ten],
                            // backgroundColor : ['#20c997', '#007bff', '#dc3545', '#ffc107'],
                            backgroundColor : ['#007bff', '#20c997', '#28a745', '#dc3545', '#ffc107'],
                        }
                    ]
                }
                new Chart(donutChartCanvas1, {
                    type: 'pie',
                    data: donutData1,
                    options: donutOptions
                }) 
                
                var donutChartCanvas2 = $('#donutChart2').get(0).getContext('2d')
                var donutData2        = {
                    // labels: [
                    //     'Pending',
                    //     'Accepted',
                    //     'Completed',
                    //     'Declined',
                    //     'Cancelled',
                    // ],
                    labels: data.s_enrolled,
                    datasets: [
                        {
                            // data: [700,500,400,600,300],
                            data: data.s_count,
                            backgroundColor : ['#ffc107', '#dc3545', '#28a745', '#20c997', '#007bff', '#6610f2', '#e83e8c', '#fd7e14', '#6c757d', '#6f42c1'],
                        }
                    ]
                }
                new Chart(donutChartCanvas2, {
                    type: 'doughnut',
                    data: donutData2,
                    options: donutOptions
                }) 
                
                var donutChartCanvas3 = $('#donutChart3').get(0).getContext('2d')
                var donutData3        = {
                    labels: data.si_enrolled,
                    datasets: [
                        {
                            // data: [700,500,400,600,300],
                            data: data.si_count,
                            backgroundColor : ['#ffc107', '#dc3545', '#28a745', '#20c997', '#007bff', '#6610f2', '#e83e8c', '#fd7e14', '#6c757d', '#6f42c1'],
                        }
                    ]
                }
                new Chart(donutChartCanvas3, {
                    type: 'pie',
                    data: donutData3,
                    options: donutOptions
                }) 

                var donutChartCanvas4 = $('#donutChart4').get(0).getContext('2d')
                var donutData4        = {
                    labels: [
                        'Poster',
                        'Advertisement',
                        'People',
                        'Others',
                    ],
                    datasets: [
                        {
                            // data: [700,500,400,600,300],
                            data: [data.ss_poster, data.ss_ads, data.ss_people, data.ss_others],
                            backgroundColor : ['#ffc107', '#dc3545', '#28a745', '#20c997', '#007bff', '#6610f2', '#e83e8c', '#fd7e14', '#6c757d', '#6f42c1'],
                        }
                    ]
                }
                new Chart(donutChartCanvas4, {
                    type: 'pie',
                    data: donutData4,
                    options: donutOptions
                })

            },error:function(e)
            {
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong.'
                });
            }
        });

    });
</script>

</body>
</html>