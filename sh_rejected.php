<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'SH Rejected Applicants';
include('header.php');

include('sidebar.php');

?>

<div class="content-wrapper">
    
    <div class="content-header">
        <div class="container-fluid">
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success elevation-2" style="border-radius: 20px;">
                        <div class="card-header" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                            <div class="row">
                                <div class="col-12 col-md-2">
                                    <select name="grade_levels" id="grade_levels" class="form-control" >
                                        <option value="">Grade Level</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>   
                                <div class="col-12 col-md-2">
                                    <select name="strand_id" id="strand_id" class="form-control"  >
                                        <option value="">Track</option>
                                        <?php
                                            $output = '';
                                            $result = fetch_all($connect,"SELECT * FROM $STRANDS_TABLE WHERE status = 'Active' " );
                                            foreach($result as $row)
                                            {
                                                $output .= '<option value="'.$row["id"].'">'.$row["strand"].'</option>';
                                            }
                                            echo $output;
                                        ?>
                                    </select>
                                </div>   
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatables" class="table table-hover table-bordered ">
                                <thead>
                                    <tr>
                                        <th>ADMISSION</th>
                                        <th>APPLICANT DETAILS</th>
                                        <th>GUARDIAN DETAILS</th>
                                        <th>PAYMENT DETAILS</th>
                                        <th>DATE ADMISSION</th>
                                        <th>TIME ADMISSION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
    
        $(document).on('click', '.button_status', function(){
            var id = $(this).attr('id');
            var status = $(this).data('status');
            var btn_action = 'update_button';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{ btn_action:btn_action, id:id, status:status}, 
                dataType:"json",
                success:function(data)
                {
                    dataTable.ajax.reload();
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });

        $("#grade_levels").change(function(){
            dataTable.destroy();
            dataTable = $("#datatables").DataTable({
                // "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                // "processing":true,
                // "serverSide":true,
                "ordering": false,
                "order":[],
                "ajax":{
                    url:"fetch/sh_rejected.php?grade_level="+$("#grade_levels").val()+"&strand_id="+$("#strand_id").val(),
                    type:"POST"
                },
                "columnDefs":[
                    {
                    "targets":[0],
                    "orderable":false,
                    },
                ],
                "pageLength": 10, 
            });
        });

        $("#strand_id").change(function(){
            dataTable.destroy();
            dataTable = $("#datatables").DataTable({
                // "responsive": true, 
                "lengthChange": true, 
                "autoWidth": false,
                // "processing":true,
                // "serverSide":true,
                "ordering": false,
                "order":[],
                "ajax":{
                    url:"fetch/sh_rejected.php?grade_level="+$("#grade_levels").val()+"&strand_id="+$("#strand_id").val(),
                    type:"POST"
                },
                "columnDefs":[
                    {
                    "targets":[0],
                    "orderable":false,
                    },
                ],
                "pageLength": 10, 
            });
        });

        var dataTable = $("#datatables").DataTable({
            // "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            // "processing":true,
            // "serverSide":true,
            "ordering": false,
            "order":[],
            "ajax":{
                url:"fetch/sh_rejected.php?grade_level="+$("#grade_levels").val()+"&strand_id="+$("#strand_id").val(),
                type:"POST"
            },
            "columnDefs":[
                {
                "targets":[0],
                "orderable":false,
                },
            ],
            "pageLength": 10, 
        });

    });
</script>

</body>
</html>