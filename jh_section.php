<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'JH Section';
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
                                        <th>Edit</th>
                                        <th>Status</th>
                                        <th>Grade Level</th>
                                        <th>Section</th>
                                        <th>Grade Req. Lowest</th>
                                        <th>Grade Req. Highest</th>
                                        <th>Slots</th>
                                        <th>Total Students</th>
                                        <th>Date Created</th>
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
                        <div class="form-group col-12 col-md-6 ">
                            <select name="grade_level" id="grade_level" class="form-control" required>
                                <option value="">Grade Level</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <input type="text" name="section" id="section" class="form-control" placeholder="Section" required />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="number" min="75" max="100" name="grade_lowest" id="grade_lowest" class="form-control" placeholder="Lowest Grade" required />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="number" min="75" max="100" name="grade_highest" id="grade_highest" class="form-control" placeholder="Highest Grade" required />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="number" name="no_limit" id="no_limit" class="form-control" placeholder="Slots" required />
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

<div id="sectionModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px;" >
            <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <label>Grade : <span class="grade_name"></span></label>
                    </div>
                    <div class="col-12 col-md-12">
                        <label>Section : <span class="section_name"></span></label>
                    </div>
                    <div class="col-12 col-md-12">
                        <label>Adviser : <span class="adviser_name"></span></label>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="section_table"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div id="studentModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 20px;" >
            <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12 ">
                        <label class="details"></label>
                        <div class="text-center">
                            <div class="image-upload " >
                                <label for="files">
                                    <img class="img-thumbnail files" src="assets/avatar/default.jpg" 
                                        style="width: 200px; height: 200px;"/>
                                </label>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group col-12 col-md-12 mb-0 pb-0 ">
                        <div class="form-group clearfix d-flex justify-content-around">
                            <div class="icheck-success d-inline">
                                <input type="radio" name="r2" id="New" disabled>
                                <label for="New">
                                    New Student
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" name="r2" id="Old" disabled>
                                <label for="Old">
                                    Old Student
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" name="r2" id="Transferee" disabled>
                                <label for="Transferee">
                                    Transferee Student
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" name="r2" id="Returnee" disabled>
                                <label for="Returnee">
                                    Returnee Student
                                </label>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <hr class="p-0 m-0">
                                    <label class="mt-2 ml-2">Personal Details</label>
                                    <hr class="p-0 m-0">
                                </div>
                                <div class="form-group col-6 col-md-4">
                                    <select class="form-control grade_level" disabled>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>    
                                <div class="form-group col-6 col-md-4">
                                    <select class="form-control strand_id" disabled >
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
                                <div class="form-group col-6 col-md-4">
                                    <select class="form-control section_id" disabled >
                                    </select>
                                </div>  
                                <div class="form-group col-12 col-md-6">
                                    <input type="text" class="form-control last_name" placeholder="Last Name" disabled />
                                </div>  
                                <div class="form-group col-12 col-md-6">
                                    <input type="text" class="form-control first_name" placeholder="First Name" disabled />
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <input type="text" class="form-control middle_name" placeholder="Middle Name" disabled />
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <input type="text" class="form-control extension_name" placeholder="Extension Name" disabled />
                                </div>
                                <div class="form-group col-7 col-md-6">
                                    <div class="input-group date" id="date_births" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input date_birth" data-target="#date_births" disabled placeholder="Date of Birth"/>
                                        <div class="input-group-append" data-target="#date_births" >
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-5 col-md-6">
                                    <select class="form-control sex" disabled>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <input type="text" class="form-control nationality" placeholder="Nationality" disabled />
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <input type="text" class="form-control last_attended" placeholder="S.Y. Last Attended" disabled />
                                </div>
                                <div class="form-group col-12 col-md-8">
                                    <input type="email" class="form-control email" placeholder="Email" disabled />
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <input type="number" min="1" class="form-control contact" maxlength = "11" 
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Contact" disabled />
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <textarea class="form-control address" placeholder="Complete Address" disabled ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <hr class="p-0 m-0">
                                    <label class="mt-2 ml-2">Guardian Details</label>
                                    <hr class="p-0 m-0">
                                </div>
                                <div class="form-group col-12 col-md-8">
                                    <input type="text" class="form-control g_fullname" placeholder="Fullname" disabled />
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <input type="number" min="1" class="form-control g_contact" maxlength = "11" 
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Contact" disabled />
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <input type="text" class="form-control g_relationship" placeholder="Relationship" disabled />
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <input type="text" class="form-control g_occupation" placeholder="Occupation" disabled />
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <textarea class="form-control g_address" placeholder="Complete Address" disabled ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
            </div>
        </div>
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
        
        $('#add_button').click(function(){
            $('#forms')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus-circle'></i> Create");
            $('#action').html("<i class='fa fa-plus-circle '></i> Create");
            $('#action').val('jhsection_add');
            $('#btn_action').val('jhsection_add');
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
            var btn_action = 'jhsection_fetch';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{id:id, btn_action:btn_action},
                dataType:"json",
                success:function(data)
                {
                    $('#id').val(id);
                    $('#grade_level').val(data.grade_level);
                    $('#section').val(data.section);
                    $('#grade_lowest').val(data.grade_lowest);
                    $('#grade_highest').val(data.grade_highest);
                    $('#no_limit').val(data.no_limit);
                    $('#addModal').modal('show');
                    $('.modal-title').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').val('jhsection_update');
                    $('#btn_action').val('jhsection_update');
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });
    
        $(document).on('click', '.status', function(){
            var id = $(this).attr('id');
            var status = $(this).data("status");
            var btn_action = 'jhsection_status';
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
    
        $(document).on('click', '.view', function(){
            var id = $(this).attr("id");
            var grade_level = $(this).data("grade_level");
                    $('.grade_name').html(grade_level);
            var section = $(this).data("section");
                    $('.section_name').html(section);
            var adviser = $(this).data("adviser");
                    $('.adviser_name').html(adviser);
            var btn_action = 'load_sections';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{id:id, btn_action:btn_action, grade_level:grade_level},
                dataType:"json",
                success:function(data)
                {
                    $('.section_table').html(data.section_table);
                    $('#sectionModal').modal('show');
                    $('#sectionModal .modal-title').html("<i class='fa fa-list'></i> Student List");
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });
    
        $(document).on('click', '.view_info', function(){
            var id = $(this).attr("id");
            var btn_action = 'student_fetch';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{id:id, btn_action:btn_action},
                dataType:"json",
                success:function(data)
                {
                    $('#forms')[0].reset();
                    $('#id').val(id);
                    $('.files').attr('src', data.avatar);
                    if (data.student_status == 'New')
                    {
                        $('#New').attr('checked','checked');
                        $('#Old').removeAttr('checked','checked');
                        $('#Transferee').removeAttr('checked','checked');
                        $('#Returnee').removeAttr('checked','checked');
                    }
                    else if (data.student_status == 'Old')
                    {
                        $('#Old').attr('checked','checked');
                        $('#New').removeAttr('checked','checked');
                        $('#Transferee').removeAttr('checked','checked');
                        $('#Returnee').removeAttr('checked','checked');
                    }
                    else if (data.student_status == 'Transferee')
                    {
                        $('#Transferee').attr('checked','checked');
                        $('#New').removeAttr('checked','checked');
                        $('#Old').removeAttr('checked','checked');
                        $('#Returnee').removeAttr('checked','checked');
                    }
                    else
                    {
                        $('#Returnee').attr('checked','checked');
                        $('#New').removeAttr('checked','checked');
                        $('#Old').removeAttr('checked','checked');
                        $('#Transferee').removeAttr('checked','checked');
                    }
                    $('.grade_level').val(data.grade_level);

                    $('.strand_id').val(data.strand_id);
                    $('.section_id').html(data.section_id);

                    $('.last_name').val(data.last_name);
                    $('.first_name').val(data.first_name);
                    $('.middle_name').val(data.middle_name);
                    $('.extension_name').val(data.extension_name);

                    $('.address').val(data.address);
                    $('.email').val(data.email);
                    $('.contact').val(data.contact);
                    $('.date_birth').val(data.date_birth);
                    $('.sex').val(data.sex);
                    $('.nationality').val(data.nationality);
                    $('.last_attended').val(data.last_attended);
                    
                    $('.g_fullname').val(data.g_fullname);
                    $('.g_contact').val(data.g_contact);
                    $('.g_relationship').val(data.g_relationship);
                    $('.g_occupation').val(data.g_occupation);
                    $('.g_address').val(data.g_address);

                    $('#studentModal').modal('show');
                    $('#studentModal .modal-title').html("<i class='fa fa-list'></i> Student Info");
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
                url:"fetch/jh_section.php",
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