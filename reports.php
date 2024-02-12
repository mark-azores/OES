<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'Reports';
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
                                    <select name="grade_level" id="grade_level" class="form-control" >
                                        <option value="">Grade Level</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>   
                                <div class="col-12 col-md-2">
                                    <select name="strand_id" id="strand_id" class="form-control" disabled >
                                        <option value="">Track</option>
                                        <?php
                                            $output = '';
                                            $rslt = fetch_all($connect,"SELECT * FROM $STRANDS_TABLE WHERE status = 'Active' " );
                                            foreach($rslt as $row)
                                            {
                                                $output .= '<option value="'.$row["id"].'">'.$row["strand"].'</option>';
                                            }
                                            echo $output;
                                        ?>
                                    </select>
                                </div>  
                                <div class="col-12 col-md-2">
                                    <button type="button" name="btn_search" id="btn_search" class="btn btn-light pl-3 pr-3 elevation-2" style="border-radius: 20px;">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div> 
                            </div>
                        </div>
                        <div class="card-body">
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
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            width: '12em'
        });
        
        $('#btn_search').click(function(){
            // console.log( $('#grade_level').val(), $('#strand_id').val() );

            loadSections($('#grade_level').val(), $('#strand_id').val());
        });

        loadSections('', '');
        function loadSections(grade_level, strand_id)
        {
            var btn_action = 'reports';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{grade_level:grade_level, strand_id:strand_id, btn_action:btn_action},
                dataType:"json",
                success:function(data)
                {
                    $('#datatables').DataTable().destroy();
                    $('#datatables').html(data.datatables);  
                    $("#datatables").DataTable({ 
                        "initComplete": function () { 
                            $("#datatables").DataTable().buttons().container().appendTo( $('.col-sm-12:eq(0)', $("#datatables").DataTable().table().container() ) );   
                        },
                        "buttons": [ 
                            {
                                extend: 'print',
                                action: function ( e, dt, node, config ) {
                                    var btn_action = 'print_reports';
                                    $.ajax({
                                        url:"action.php",
                                        method:"POST",
                                        data:{ btn_action:btn_action, grade_level:grade_level, strand_id:strand_id },
                                        dataType:"json",
                                        success:function(data)
                                        {
                                            window.location.href = "print.php";
                                            $('#grade_level').val('');
                                            $('#strand_id').val('');
                                        },error:function()
                                        {
                                            Swal.fire({
                                                icon: 'error',
                                                // title: 'Error',
                                                text: 'Something went wrong.',
                                            })
                                        }
                                    })
                                }
                            },
                        ],
                        // "scrollX": true, 
                        // "responsive": true, 
                        "lengthChange": false, 
                        "autoWidth": false,
                        "ordering": false,
                        "searching": false,
                        "paging": false,
                        "pageLength": -1,
                    });
                    $('#datatables').DataTable().draw();
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        }

        $("#grade_level").change(function(){
            if (this.value > 10)
            {
                $('#strand_id').removeAttr('disabled','disabled').attr('required','required');
            }
            else
            {
                $('#strand_id').attr('disabled','disabled').removeAttr('required','required').val('');
            }
        });

    });
</script>

</body>
</html>