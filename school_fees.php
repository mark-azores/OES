<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'School Fees';
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
                                        <th>High School</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-12">
                    <div class="card card-success elevation-2" style="border-radius: 20px;">
                        <div class="card-header" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                            <div class="form-group col-12 col-md-2">
                                <select name="hs_category" id="hs_category" class="form-control" required>
                                    <option value="">High School</option>
                                    <option value="Junior">Junior</option>
                                    <option value="Senior">Senior</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-2">
                                    <table id="datatables_fees" class="table table-hover table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-md-4">
                                    <table id="datatables_fees_options" class="table table-hover table-bordered ">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>A</th>
                                                <th>B</th>
                                                <th>C</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Upon Enrollment</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>AUGUST</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>SEPTEMBER</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>OCTOBER</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>NOVEMBER</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>DECEMBER</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>JANUARY</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>FEBRUARY</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>MARCH</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>APRIL</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>MAY</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <th>Total</th>
                                                <th>0.00</th>
                                                <th>0.00</th>
                                                <th>0.00</th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                                <div class="col-12 col-md-2">
                                    <table id="datatables_modules" class="table table-hover table-bordered ">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-md-4">
                                    <table id="datatables_modules_options" class="table table-hover table-bordered ">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>A</th>
                                                <th>B</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Upon Enrollment</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>AUGUST</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>SEPTEMBER</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>OCTOBER</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>NOVEMBER</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>DECEMBER</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>JANUARY</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>FEBRUARY</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>MARCH</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>APRIL</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>MAY</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <th>Total</th>
                                                <th>0.00</th>
                                                <th>0.00</th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
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
                        <div class="form-group col-12 col-md-6">
                            <select name="high_school" id="high_school" class="form-control" required>
                                <option value="">High School</option>
                                <option value="Junior">Junior</option>
                                <option value="Senior">Senior</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <select name="fee_category" id="fee_category" class="form-control" required>
                                <option value="">Category</option>
                                <option value="School Fees">School Fees</option>
                                <option value="Modules & E-Books">Modules & E-Books</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="text" name="fee_name" id="fee_name" class="form-control" placeholder="Name" required />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="number" min="0" name="fee_amount" id="fee_amount" class="form-control" placeholder="Amount" required />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <select name="fee_type" id="fee_type" class="form-control" required>
                                <option value="">Type</option>
                                <option value="Add">Add</option>
                                <option value="Subtract">Subtract</option>
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
        
        // $('#hs_category').change(function(){
        //     var type = this.value;
        //     loadFees(type);
        // });

        // loadFees('');
        // function loadFees(type)
        // {
        //     var btn_action = 'hs_change';
        //     $.ajax({
        //         url:"action.php",
        //         method:"POST",
        //         data:{type:type, btn_action:btn_action},
        //         dataType:"json",
        //         success:function(data)
        //         {
        //             $('#datatables_fees').html(data.datatables_fees);  
        //             $('#datatables_modules').html(data.datatables_modules);  

        //             // $('#datatables_fees').DataTable().destroy();
        //             // $('#datatables_fees').html(data.datatables_fees);  
        //             // $("#datatables_fees").DataTable({ 
        //             //     // "scrollX": true, 
        //             //     "responsive": true, 
        //             //     "lengthChange": false, 
        //             //     "autoWidth": false,
        //             //     "ordering": false,
        //             //     "searching": false,
        //             //     "paging": false,
        //             //     "info": false,
        //             //     "pageLength": -1,
        //             // });
        //             // $('#datatables_fees').DataTable().draw();

        //             // $('#datatables_modules').DataTable().destroy();
        //             // $('#datatables_modules').html(data.datatables_modules);  
        //             // $("#datatables_modules").DataTable({ 
        //             //     // "scrollX": true, 
        //             //     "responsive": true, 
        //             //     "lengthChange": false, 
        //             //     "autoWidth": false,
        //             //     "ordering": false,
        //             //     "searching": false,
        //             //     "paging": false,
        //             //     "info": false,
        //             //     "pageLength": -1,
        //             // });
        //             // $('#datatables_modules').DataTable().draw();

        //         },error:function()
        //         {
        //             toastr.error('Please try again later.');
        //         }
        //     })
        // }
        
        $('#add_button').click(function(){
            $('#forms')[0].reset();
            $('.modal-title').html("<i class='fa fa-plus-circle'></i> Create");
            $('#action').html("<i class='fa fa-plus-circle '></i> Create");
            $('#action').val('fees_add');
            $('#btn_action').val('fees_add');
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
    
        $(document).on('click', '.status', function(){
            var id = $(this).attr('id');
            var status = $(this).data("status");
            var btn_action = 'fees_status';
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
    
        $(document).on('click', '.update', function(){
            var id = $(this).attr("id");
            var btn_action = 'fees_fetch';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{id:id, btn_action:btn_action},
                dataType:"json",
                success:function(data)
                {
                    $('#id').val(id);
                    $('#high_school').val(data.high_school);
                    $('#fee_category').val(data.fee_category);
                    $('#fee_type').val(data.fee_type);
                    $('#fee_name').val(data.fee_name);
                    $('#fee_amount').val(data.fee_amount);
                    $('#addModal').modal('show');
                    $('.modal-title').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').val('fees_update');
                    $('#btn_action').val('fees_update');
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
                url:"fetch/school_fees.php",
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