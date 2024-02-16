<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'JH Enrollees Applicants';
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
                                        <th>ACTION</th>
                                        <th>ADMISSION</th>
                                        <!-- <th>Admission No.</th>
                                        <th>Grade Level</th> -->
                                        <th>APPLICANT DETAILS</th>
                                        <th>GUARDIAN DETAILS</th>
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

<div id="addModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog ">
        <form method="post" id="forms">
            <div class="modal-content" style="border-radius: 20px;" >
                <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-12 reason hidden">
                            <!-- <textarea name="reason" id="reason" class="form-control" placeholder="Reason" ></textarea> -->
                            <select name="reason" id="reason" class="form-control"  >
                                <option value="">-Select-</option>
                                <option value="Invalid Data Input">Invalid Data Input</option>
                                <option value="Invalid Requirements">Invalid Requirements</option>
                                <option value="Unpaid Balance">Unpaid Balance</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-12 reason hidden">
                            <textarea name="others" id="others" class="form-control" placeholder="Other Reason" disabled ></textarea>
                        </div>
                        <div class="form-group col-12 col-md-12 date_scheduled hidden">
                            <div class="input-group date" id="date_scheduleds" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_scheduleds" name="date_scheduled" id="date_scheduled" placeholder="Date Schedule"/>
                                <div class="input-group-append" data-target="#date_scheduleds" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-12 payment hidden">
                            <select name="section_id" id="section_id" class="form-control" >
                                <option value="">Section</option>
                            </select>
                        </div>
                       
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <input type="hidden" name="id" id="id"/>
                    <input type="hidden" name="status" id="status"/>
                    <input type="hidden" name="btn_action" id="btn_action"/>
                    <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action" id="action" style="border-radius: 20px;" ><i class="fa fa-plus text-white"></i> Add</button>
                    <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="assessModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog ">
        <form method="post" id="forms_assess">
            <div class="modal-content" style="border-radius: 20px;" >
                <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-12  ">
                            <select name="assessment_status" id="assessment_status" class="form-control" required >
                                <option value="">-Select-</option>
                                <option value="Passed Aptitude Test">Passed Aptitude Test</option>
                                <option value="Failed Aptitude Test">Failed Aptitude Test</option>
                                <option value="Passed Behavioral Test">Passed Behavioral Test</option>
                                <option value="Failed Behavioral Test">Failed Behavioral Test</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <input type="hidden" name="id" id="id_assess"/>
                    <input type="hidden" name="btn_action" id="btn_action_assess"/>
                    <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action" id="action_assess" style="border-radius: 20px;" ><i class="fa fa-plus text-white"></i> Add</button>
                    <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="viewModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content" style="border-radius: 20px;" >
            <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="list_file"></div>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div id="questionModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px;" >
            <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label class="questions">Are you sure you want to archive this?</label>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="btn_yes" id="btn_yes" style="border-radius: 20px;" ><i class="fa fa-plus text-white"></i> Add</button>
                <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        var id ;
        var question ;
        $(document).on('click', '.archive', function(){
            $('#questionModal').modal('show');
            $('#questionModal .modal-title').html("<i class='fa fa-archive'></i> Archive");
            $('#btn_yes').html("<i class='fa fa-check-circle '></i> Yes");
            id  = $(this).attr("id");
            $('#questionModal .questions').html("Are you sure you want to archive this?");
            question = 'Archive';
        });

        $("#btn_yes").click(function(e){
            if (question == 'Undo')
            {
                var btn_action = 'admission_undo';
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{ btn_action:btn_action, admission_no:admission_no},
                    dataType:"json",
                    success:function(data)
                    {
                        if (data.status)
                        {
                            dataTable.ajax.reload();
                            $('#questionModal').modal('hide');
                            $('#paymentModal').modal('hide');
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
            }
            else if (question == 'Complete')
            {
                var btn_action = 'admission_complete';
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{ btn_action:btn_action, admission_no:admission_no},
                    dataType:"json",
                    success:function(data)
                    {
                        if (data.status)
                        {
                            dataTable.ajax.reload();
                            $('#questionModal').modal('hide');
                            $('#paymentModal').modal('hide');
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
            }
            else
            {
                var btn_action = 'admission_archive';
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{ btn_action:btn_action, id:id},
                    dataType:"json",
                    success:function(data)
                    {
                        if (data.status)
                        {
                            dataTable.ajax.reload();
                            $('#questionModal').modal('hide');
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
            }
        });
    
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
    
        $(document).on('click', '.requirements', function(){
            var id = $(this).attr('id');
            var btn_action = 'load_requirements';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{ btn_action:btn_action, id:id}, 
                dataType:"json",
                success:function(data)
                {
                    $('.list_file').html(data.list);
                    $('#viewModal').modal('show');
                    $('#viewModal .modal-title').html("<i class='fa fa-list'></i> Requirements");
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });
    
        $(document).on('click', '.assessment', function(){
            var id = $(this).attr('id');
            $('#id_assess').val(id);
            $('#assessModal').modal('show');
            $('#assessModal .modal-title').html("<i class='fa fa-file'></i> Assessment");
            $('#action_assess').html("<i class='fa fa-save'></i> Save");
            $('#action_assess').val('admission_assess');
            $('#btn_action_assess').val('admission_assess');
            $('#forms_assess')[0].reset();
        });
    
        $(document).on('submit','#forms_assess', function(event){
            event.preventDefault();
            $('#action_assess').attr('disabled','disabled');
            var form_data = $(this).serialize();
            $.ajax({
                url:"action.php",
                method:"POST",
                data:form_data,
                dataType:"json",
                success:function(data)
                {
                    $('#action_assess').attr('disabled', false);
                    if (data.status == true)
                    {
                        $('#forms_assess')[0].reset();
                        $('#assessModal').modal('hide');
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
                    $('#action_assess').attr('disabled', false);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });

        $("#reason").change(function(){
            if ($('#reason').val() == 'Others')
            {
                $("#others").attr('disabled', false).attr('required', true).val('');
            }
            else
            {
                $("#others").attr('disabled', true).attr('required', false).val('');
            }
        });

        $('#date_scheduleds').datetimepicker({
            format: 'MM-DD-YYYY',
            minDate: moment()
        });

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            width: '12em'
        });

        // var tuition = 0;
        // $("#esc_payment").change(function(){
        //     var esc_payment = $('#esc_payment').val() !== '' ? $('#esc_payment').val() : 0;
        //     $('.total_fee').val( (parseFloat(tuition) - parseFloat(esc_payment)).toFixed(2) );
        //     if ($('#payment_method').val() == 'Installment')
        //     {
        //         loadTuition(admission_no,$('#school_fees').val(),$('#modules_ebook').val());
        //     }
        // });
        // $("#esc_payment").on('change keyup paste', function () {
        //     var esc_payment = $('#esc_payment').val() !== '' ? $('#esc_payment').val() : 0;
        //     $('.total_fee').val( (parseFloat(tuition) - parseFloat(esc_payment)).toFixed(2) );
        //     if ($('#payment_method').val() == 'Installment')
        //     {
        //         loadTuition(admission_no,$('#school_fees').val(),$('#modules_ebook').val());
        //     }
        // });
    
        $(document).on('click', '.status', function(){
            var id = $(this).attr('id');
            var status = $(this).data("status");
            var name = $(this).data("name");
            var method = $(this).data("method");
            $('#id').val(id);
            $('#addModal').modal('show');
            $('#addModal .modal-dialog').removeClass('modal-lg');
            if (status == 'Reject')
            {
                $('#reason').val('');
                $("#others").attr('disabled', true).attr('required', false).val('');
                $('#status').val('Rejected');
                $('.reason').removeClass('hidden');
                $('#reason').attr('required','required');
                $('.date_scheduled').addClass('hidden');
                $('#date_scheduled').removeAttr('required','required');
                $('.payment').addClass('hidden');
                $('#esc_payment').removeAttr('required','required');
                $('#section_id').removeAttr('required','required');
                $('.modal-title').html("<i class='fa fa-times-circle'></i> Reject");
                $('#action').html("<i class='fa fa-times-circle'></i> Reject");
                $('#action').val('admission_status');
                $('#btn_action').val('admission_status');
                
                $('#school_fees').removeAttr('required','required');
                $('#modules_ebook').removeAttr('required','required');
            }
            else if (status == 'Schedule')
            {
                $('#status').val('Scheduled');
                $('.reason').addClass('hidden');
                $('#reason').removeAttr('required','required');
                $('.date_scheduled').removeClass('hidden');
                $('#date_scheduled').attr('required','required');
                $('.payment').addClass('hidden');
                $('#esc_payment').removeAttr('required','required');
                $('#section_id').removeAttr('required','required');
                $('.modal-title').html("<i class='fa fa-calendar-day'></i> Schedule for Payment");
                $('#action').html("<i class='fa fa-calendar-day'></i> Schedule");
                $('#action').val('admission_status');
                $('#btn_action').val('admission_status');
                
                $('#school_fees').removeAttr('required','required');
                $('#modules_ebook').removeAttr('required','required');
            }
            else
            {
                $('#addModal .modal-dialog').addClass('modal-md');
                $('#status').val('Payment');
                $('.modal-title').html("<i class='fas fa-file-invoice'></i> Assign to Class Section");
                $('#action').html("<i class='fas fa-file-invoice'></i> Enroll");
                $('#action').val('admission_status');
                $('#btn_action').val('admission_status');
                $('.reason').addClass('hidden');
                $('#reason').removeAttr('required','required');
                $('.date_scheduled').addClass('hidden');
                $('#date_scheduled').removeAttr('required','required');
                $('.payment').removeClass('hidden');
                $('#esc_payment').attr('required','required');
                $('#section_id').attr('required','required');
                
                $('#school_fees').removeAttr('required','required');
                $('#modules_ebook').removeAttr('required','required');

                var sf = $(this).data("sf");
                var me = $(this).data("me");
                tuition = $(this).data("tuition");
                $('.tuition_fee').val( parseFloat(tuition).toFixed(2) );
                $('.total_fee').val( parseFloat(tuition).toFixed(2) );
                admission_no = $(this).data("admission_no");
                $('#payment_method').val(method);
                if (method == 'Installment')
                {
                    $('#school_fees').val(sf).removeAttr('disabled','disabled').attr('required','required');
                    $('#modules_ebook').val(me).removeAttr('disabled','disabled').attr('required','required');

                    $('.tuition').removeClass('hidden');
                    loadTuition(admission_no, sf, me);
                }
                else
                {
                    $('.tuition').addClass('hidden');
                    $('#school_fees').val('').attr('disabled','disabled');
                    $('#modules_ebook').val('').attr('disabled','disabled');
                }

                var grade_level = $(this).data("grade_level");
                var btn_action = 'admission_section';
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{grade_level:grade_level, btn_action:btn_action, title:'enrollees'},
                    dataType:"json",
                    success:function(data)
                    {
                        $('#section_id').html(data.section_id);
                        $('#esc_payment').html(data.esc_payment);
                    },error:function()
                    {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong.'
                        });
                    }
                })
            }
        });
        var admission_no = '';

        function loadTuition(admission_no, sf, me)
        {
            // var esc_payment = $('#esc_payment').val();// !== '' ? $('#esc_payment').val() : 0;
            var esc_payment = $('#esc_payment').val() !== '' ? $('#esc_payment').find(':selected').data('amount') : 0;
            var btn_action = 'fetch_admission_plan';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{ btn_action:btn_action, admission_no:admission_no, sf:sf, me:me, esc_payment:esc_payment}, 
                dataType:"json",
                success:function(data)
                {
                    $('.sf_ue_amount').html(data.sf_ue_amount);
                    $('.sf_aug_amount').html(data.sf_aug_amount);
                    $('.sf_sep_amount').html(data.sf_sep_amount);
                    $('.sf_oct_amount').html(data.sf_oct_amount);
                    $('.sf_nov_amount').html(data.sf_nov_amount);
                    $('.sf_dec_amount').html(data.sf_dec_amount);
                    $('.sf_jan_amount').html(data.sf_jan_amount);
                    $('.sf_feb_amount').html(data.sf_feb_amount);
                    $('.sf_mar_amount').html(data.sf_mar_amount);
                    $('.sf_apr_amount').html(data.sf_apr_amount);
                    $('.sf_may_amount').html(data.sf_may_amount);
                    
                    $('.me_ue_amount').html(data.me_ue_amount);
                    $('.me_aug_amount').html(data.me_aug_amount);
                    $('.me_sep_amount').html(data.me_sep_amount);
                    $('.me_oct_amount').html(data.me_oct_amount);
                    $('.me_nov_amount').html(data.me_nov_amount);
                    $('.me_dec_amount').html(data.me_dec_amount);
                    $('.me_jan_amount').html(data.me_jan_amount);
                    $('.me_feb_amount').html(data.me_feb_amount);
                    $('.me_mar_amount').html(data.me_mar_amount);
                    $('.me_apr_amount').html(data.me_apr_amount);
                    $('.me_may_amount').html(data.me_may_amount);
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        }

        $("#payment_method").change(function(){
            if (this.value == 'Installment')
            {
                loadTuition(admission_no,'','');
                $('.tuition').removeClass('hidden');
                $('#school_fees').removeAttr('disabled','disabled').attr('required','required');
                $('#modules_ebook').removeAttr('disabled','disabled').attr('required','required');
            }
            else
            {
                $('.tuition').addClass('hidden');
                $('#school_fees').val('').attr('disabled','disabled').removeAttr('required','required');
                $('#modules_ebook').val('').attr('disabled','disabled').removeAttr('required','required');
            }
        });

        $("#school_fees").change(function(){
            loadTuition(admission_no,$('#school_fees').val(),$('#modules_ebook').val());
        });

        $("#modules_ebook").change(function(){
            loadTuition(admission_no,$('#school_fees').val(),$('#modules_ebook').val());
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
                    url:"fetch/jh_enrollees.php?grade_level="+$("#grade_level").val(),
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
                url:"fetch/jh_enrollees.php?&grade_level="+$("#grade_level").val(),
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