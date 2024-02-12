<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'Instructors';
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
                            <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#addModal" class="btn btn-light pl-3 pr-3 elevation-2" 
                            style="border-radius: 20px;">
                                <i class="fa fa-plus-circle"></i> Create</button>
                        </div>
                        <div class="card-body">
                            <table id="datatables" class="table table-hover table-bordered ">
                                <thead>
                                    <tr>
                                        <th>EDIT</th>
                                        <th>STATUS</th>
                                        <th>ADVISORY</th>
                                        <th>FULLNAME</th>
                                        <th>GENDER</th>
                                        <th>CONTACT</th>
                                        <th>DATE CREATED</th>
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

<div id="addModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <form method="post" id="forms">
            <div class="modal-content" style="border-radius: 20px;" >
                <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-12">
                            <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Fullname" required />
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <input type="number" min="0" name="contact" id="contact" class="form-control" placeholder="Contact" required />
                        </div>
                        <div class="form-group col-12 col-md-6 ">
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
                        <div class="form-group col-12 col-md-6 ">
                            <select name="strand_id" id="strand_id" class="form-control" disabled>
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
                        <div class="form-group col-12 col-md-12 ">
                            <select name="section_id" id="section_id" class="form-control" disabled>
                                <option value="">Section</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <input type="hidden" name="id" id="id"/>
                    <input type="hidden" name="btn_action" id="btn_action"/>
                    <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action" id="action" style="border-radius: 20px;" ><i class="fa fa-plus text-white"></i> Add</button>
                    <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            width: '12em'
        });

        $("#grade_level").change(function(){
            if ($("#grade_level").val() > 10)
            {
                $("#strand_id").attr('disabled', false).val('').attr('required', true);
                $("#section_id").attr('disabled', false).attr('required', true);
                loadSection($("#grade_level").val(), '');
            }
            else
            {
                $("#strand_id").attr('disabled', true).attr('required', false);
                $("#section_id").attr('disabled', false).attr('required', true);
                if ($("#grade_level").val() == '')
                {
                    $("#section_id").attr('disabled', true).attr('required', false);
                }
                else
                {
                    loadSection($("#grade_level").val(), $("#strand_id").val())
                }
            }
        });

        function loadSection(grade_level, strand_id, section_id)
        {
            var btn_action = 'archived_section';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{ btn_action:btn_action, grade_level:grade_level, strand_id:strand_id , section_id:section_id },
                dataType:"json",
                success:function(data)
                {
                    $('#section_id').html(data.section_id);  
                },error:function(e)
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            });
        }

        $("#strand_id").change(function(){
            loadSection($("#grade_level").val(), $("#strand_id").val())
        });
        
        $('#add_button').click(function(){
            $('#forms')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus-circle'></i> Create");
            $('#action').html("<i class='fa fa-plus-circle '></i> Create");
            $('#action').val('instructors_add');
            $('#btn_action').val('instructors_add');
            
            $('#strand_id').attr('disabled', true).val('');
            $('#section_id').attr('disabled', true).val('');
        });
    
        $(document).on('click', '.status', function(){
            var id = $(this).attr('id');
            var status = $(this).data("status");
            var btn_action = 'instructors_status';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{id:id, status:status, btn_action:btn_action},
                dataType:"json",
                success:function(data)
                {
                    if (data.status == true)
                    {
                        dataTable.ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                    }
                    else 
                    {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });
    
        $(document).on('submit','#forms', function(event){
            event.preventDefault();
            $('#action').attr('disabled','disabled');
            var form_data = $(this).serialize();
            $.ajax({
                url:"action.php",
                method:"POST",
                data:form_data,
                dataType:"json",
                success:function(data)
                {
                    $('#action').attr('disabled', false);
                    if (data.status == true)
                    {
                        $('#forms')[0].reset();
                        $('#addModal').modal('hide');
                        dataTable.ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                    }
                    else 
                    {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                },error:function()
                {
                    $('#action').attr('disabled', false);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });
    
        $(document).on('click', '.update', function(){
            var id = $(this).attr("id");
            var btn_action = 'instructors_fetch';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{id:id, btn_action:btn_action},
                dataType:"json",
                success:function(data)
                {
                    $('#id').val(id);
                    $('#grade_level').val(data.grade_level);
                    if (data.grade_level > 10)
                    {
                        $('#strand_id').val(data.strand_id).attr('disabled', false);
                        loadSection(data.grade_level, data.strand_id, data.section_id);
                    }
                    else
                    {
                        $('#strand_id').val('').attr('disabled', true);
                        loadSection(data.grade_level, '', data.section_id);
                    }
                    if (data.section_id == '')
                    {
                        $('#section_id').attr('disabled', true);
                    }
                    else
                    {
                        $('#section_id').attr('disabled', false);
                    }
                    $('#fullname').val(data.fullname);
                    $('#gender').val(data.gender);
                    $('#contact').val(data.contact);
                    $('#addModal').modal('show');
                    $('.modal-title').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').val('instructors_update');
                    $('#btn_action').val('instructors_update');
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });

        var dataTable = $("#datatables").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "processing":true,
            "serverSide":true,
            "ordering": false,
            "order":[],
            "ajax":{
                url:"fetch/instructors.php",
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