<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'JH Rejected Applicants';
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
                            <div class="col-12 col-md-2">
                                <select name="grade_level" id="grade_level" class="form-control" >
                                    <option value="">Grade Level</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>   
                        </div>
                        <div class="card-body">
                            <table id="datatables" class="table table-hover table-bordered ">
                                <thead>
                                    <tr>
                                        <th>Admission</th>
                                        <th>Applicant Details</th>
                                        <th>Guardian Details</th>
                                        <!-- <th>Payment Details</th> -->
                                        <th>Date Admission</th>
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

        $("#grade_level").change(function(){
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
                    url:"fetch/jh_rejected.php?&grade_level="+$("#grade_level").val(),
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
                url:"fetch/jh_rejected.php?&grade_level="+$("#grade_level").val(),
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