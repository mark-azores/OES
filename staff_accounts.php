<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'Staff Accounts';
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
                                        <th>FULLNAME</th>
                                        <th>USERNAME</th>
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
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required />
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password"  />
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
        
        $('#add_button').click(function(){
            $('#forms')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus-circle'></i> Create");
            $('#action').html("<i class='fa fa-plus-circle '></i> Create");
            $('#action').val('user_add');
            $('#btn_action').val('user_add');
            $('#password').attr('required','required');
        });
    
        $(document).on('click', '.status', function(){
            var id = $(this).attr('id');
            var status = $(this).data("status");
            var btn_action = 'user_status';
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
            var btn_action = 'user_fetch';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{id:id, btn_action:btn_action},
                dataType:"json",
                success:function(data)
                {
                    $('#id').val(id);
                    $('#fullname').val(data.fullname);
                    $('#username').val(data.username);
                    $('#addModal').modal('show');
                    $('.modal-title').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').val('user_update');
                    $('#btn_action').val('user_update');
                    $('#password').removeAttr('required','required');
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
                url:"fetch/staff_accounts.php",
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