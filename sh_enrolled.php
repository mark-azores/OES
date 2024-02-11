<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'SH Enrolled Students';
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
                                    <select name="strands_id" id="strands_id" class="form-control"  >
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
                                        <th>ACTION</th>
                                        <th></th>
                                        <!-- <th>Grade Level</th>
                                        <th>Strand</th>
                                        <th>Section</th> -->
                                        <th>APPLICANT DETAILS</th>
                                        <th>GUARDIAN DETAILS</th>
                                        <!-- <th>Payment Details</th> -->
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
    <div class="modal-dialog">
        <form method="post" id="forms">
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
                                            style="cursor:pointer; width: 200px; height: 200px;"/>
                                    </label>
                                    <input type="file" accept=".png, .jpg, .jpeg" onchange="readURL(this);" name="files" id="files" />
                                </div>
                                <i>Click to upload recent school ID</i>
                            </div> 
                        </div>
                        <div class="form-group col-12 col-md-12 mb-0 pb-0 ">
                            <div class="form-group clearfix d-flex justify-content-around">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="r2" id="New" required>
                                    <label for="New">
                                        New Student
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="r2" id="Old" required>
                                    <label for="Old">
                                        Old Student
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="r2" id="Transferee" required>
                                    <label for="Transferee">
                                        Transferee Student
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="r2" id="Returnee" required>
                                    <label for="Returnee">
                                        Returnee Student
                                    </label>
                                </div>
                            </div>
                        </div>     
                        <div class="form-group col-6 col-md-4">
                            <select name="grade_level" id="grade_level" class="form-control" required>
                                <!-- <option value="">Grade Level</option> -->
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>    
                        <div class="form-group col-6 col-md-4">
                            <select name="strand_id" id="strand_id" class="form-control" required >
                                <!-- <option value="">Track</option> -->
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
                            <select name="section_id" id="section_id" class="form-control" required >
                                <!-- <option value="">Section</option> -->
                            </select>
                        </div>  
                        <div class="form-group col-12 col-md-6">
                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" required />
                        </div>  
                        <div class="form-group col-12 col-md-6">
                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" required />
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" />
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <input type="text" name="extension_name" id="extension_name" class="form-control" placeholder="Extension Name" />
                        </div>
                        <div class="form-group col-7 col-md-6">
                            <div class="input-group date" id="date_births" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_births" name="date_birth" id="date_birth" required placeholder="Date of Birth"/>
                                <div class="input-group-append" data-target="#date_births" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-5 col-md-6">
                            <select name="sex" id="sex" class="form-control" required>
                                <!-- <option value="">Sex</option> -->
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <input type="text"  name="nationality" id="nationality" class="form-control" placeholder="Nationality" required />
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <input type="text" name="last_attended" id="last_attended" class="form-control" placeholder="S.Y. Last Attended" required />
                        </div>
                        <div class="form-group col-12 col-md-8">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="number" min="1" name="contact" id="contact" class="form-control" maxlength = "11" 
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Contact" required />
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <textarea name="address" id="address" class="form-control" placeholder="Address" required ></textarea>
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <hr class="p-0 m-0">
                            <label class="mt-2 ml-2">Guardian Details</label>
                            <hr class="p-0 m-0">
                        </div>
                        <div class="form-group col-12 col-md-8">
                            <input type="text" name="g_fullname" id="g_fullname" class="form-control" placeholder="Fullname" required />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="number" min="1" name="g_contact" id="g_contact" class="form-control" maxlength = "11" 
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Contact" required />
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <input type="text" name="g_relationship" id="g_relationship" class="form-control" placeholder="Relationship" required />
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <input type="text" name="g_occupation" id="g_occupation" class="form-control" placeholder="Occupation" required />
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <textarea name="g_address" id="g_address" class="form-control" placeholder="Address" required ></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <input type="hidden" name="student_status" id="student_status" />
                    <input type="hidden" name="id" id="id"/>
                    <input type="hidden" name="btn_action" id="btn_action"/>
                    <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action" id="action" style="border-radius: 20px;" >
                        <i class="fa fa-plus text-white"></i> Add
                    </button>
                    <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="paymentModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form method="post" id="forms_payment">
            <div class="modal-content" style="border-radius: 20px;" >
                <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12 ">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>School Fees</th>
                                        <th>Modules & E-Books</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ue_date_paid" >Upon Enrollment</td>
                                        <td class="sf_ue_amount">0</td>
                                        <td class="me_ue_amount">0</td>
                                        <td>
                                            <select name="sf_ue_status" id="sf_ue_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="aug_date_paid" >AUGUST</td>
                                        <td class="sf_aug_amount">0</td>
                                        <td class="me_aug_amount">0</td>
                                        <td>
                                            <select name="sf_aug_status" id="sf_aug_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sep_date_paid" >SEPTEMBER</td>
                                        <td class="sf_sep_amount">0</td>
                                        <td class="me_sep_amount">0</td>
                                        <td>
                                            <select name="sf_sep_status" id="sf_sep_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="oct_date_paid" >OCTOBER</td>
                                        <td class="sf_oct_amount">0</td>
                                        <td class="me_oct_amount">0</td>
                                        <td>
                                            <select name="sf_oct_status" id="sf_oct_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="nov_date_paid" >NOVEMBER</td>
                                        <td class="sf_nov_amount">0</td>
                                        <td class="me_nov_amount">0</td>
                                        <td>
                                            <select name="sf_nov_status" id="sf_nov_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="dec_date_paid" >DECEMBER</td>
                                        <td class="sf_dec_amount">0</td>
                                        <td class="me_dec_amount">0</td>
                                        <td>
                                            <select name="sf_dec_status" id="sf_dec_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="jan_date_paid" >JANUARY</td>
                                        <td class="sf_jan_amount">0</td>
                                        <td class="me_jan_amount">0</td>
                                        <td>
                                            <select name="sf_jan_status" id="sf_jan_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="feb_date_paid" >FEBRUARY</td>
                                        <td class="sf_feb_amount">0</td>
                                        <td class="me_feb_amount">0</td>
                                        <td>
                                            <select name="sf_feb_status" id="sf_feb_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="mar_date_paid" >MARCH</td>
                                        <td class="sf_mar_amount">0</td>
                                        <td class="me_mar_amount">0</td>
                                        <td>
                                            <select name="sf_mar_status" id="sf_mar_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="apr_date_paid" >APRIL</td>
                                        <td class="sf_apr_amount">0</td>
                                        <td class="me_apr_amount">0</td>
                                        <td>
                                            <select name="sf_apr_status" id="sf_apr_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="may_date_paid" >MAY</td>
                                        <td class="sf_may_amount">0</td>
                                        <td class="me_may_amount">0</td>
                                        <td>
                                            <select name="sf_may_status" id="sf_may_status" class="form-control"  >
                                                <option value="Not Paid">Not Paid</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <th>TOTAL AMOUNT</th>
                                        <th class="total_amount">0</th>
                                    </tr>
                                    <tr>
                                        <th>TOTAL PAID</th>
                                        <th class="total_paid">0</th>
                                    </tr>
                                    <tr>
                                        <th>TOTAL BALANCE</th>
                                        <th class="total_balance">0</th>
                                    </tr>
                                </tfooter>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <input type="hidden" name="id" id="id_payment"/>
                    <input type="hidden" name="btn_action" id="btn_action_payment"/>
                    <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action" id="action_payment" style="border-radius: 20px;" ><i class="fa fa-save text-white"></i> Save</button>
                    <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" ><i class="fa fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-success elevation-2 pl-3 pr-3 " name="btn_complete" id="btn_complete" style="border-radius: 20px;" ><i class="fa fa-check text-white"></i> Complete</button>
                    <button type="button" class="btn btn-success elevation-2 pl-3 pr-3 hidden btn_undo" name="btn_undo" style="border-radius: 20px;" ><i class="fa fa-undo text-white"></i> Undo</button>
                </div>
            </div>
        </form>
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

<div id="viewModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog ">
        <form method="post" id="forms_requirements">
            <div class="modal-content" style="border-radius: 20px;" >
                <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="report_card1" name="report_card1" >
                                <label for="report_card1">SF9 (Report Card)</label>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <div class="input-group date" id="date_reports" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_reports" name="date_report" id="date_report"  placeholder=""/>
                                <div class="input-group-append" data-target="#date_reports" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="form_1371" name="form_1371" >
                                <label for="form_1371">SF10 (Form 137)</label>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 date_137 ">
                            <!-- <span>date_goodmoral <span class="text-danger">*</span></span> -->
                            <div class="input-group date" id="date_137s" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_137s" name="date_137" id="date_137"  placeholder=""/>
                                <div class="input-group-append" data-target="#date_137s" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="psa" name="psa" >
                                <label for="psa">PSA Birth Certificate</label>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <div class="input-group date" id="date_psas" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_psas" name="date_psa" id="date_psa"  placeholder=""/>
                                <div class="input-group-append" data-target="#date_psas" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="good_moral" name="good_moral" >
                                <label for="good_moral">Good Moral Certificate</label>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 date_goodmoral ">
                            <!-- <span>Date Submit <span class="text-danger">*</span></span> -->
                            <div class="input-group date" id="date_goodmorals" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_goodmorals" name="date_goodmoral" id="date_goodmoral"  placeholder=""/>
                                <div class="input-group-append" data-target="#date_goodmorals" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="certificate" name="certificate" >
                                <label for="certificate">Certificate of No Financial Obligation</label>
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 ">
                            <div class="input-group date" id="date_certificates" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_certificates" name="date_certificate" id="date_certificate"  placeholder=""/>
                                <div class="input-group-append" data-target="#date_certificates" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <input type="hidden" name="id" id="id_requirements"/>
                    <input type="hidden" name="btn_action" id="btn_action_requirements"/>
                    <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="action" id="action_requirements" style="border-radius: 20px;" >
                        <i class="fa fa-plus text-white"></i> Add
                    </button>
                    <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal" style="border-radius: 20px;" >
                        <i class="fa fa-times-circle"></i> Close
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('.files').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(function () {

        $('#date_reports').datetimepicker({
            format: 'MM-DD-YYYY'
        });
        $(document).on('click', '#report_card1', function(){
            if ($('#report_card1').is(':checked'))
            {
                $('#date_report').attr('required', true);
            }
            else
            {
                $('#date_report').attr('required', false);
            }
        });

        $('#date_psas').datetimepicker({
            format: 'MM-DD-YYYY'
        });
        $(document).on('click', '#psa', function(){
            if ($('#psa').is(':checked'))
            {
                $('#date_psa').attr('required', true);
            }
            else
            {
                $('#date_psa').attr('required', false);
            }
        });

        $('#date_certificates').datetimepicker({
            format: 'MM-DD-YYYY'
        });
        $(document).on('click', '#certificate', function(){
            if ($('#certificate').is(':checked'))
            {
                $('#date_certificate').attr('required', true);
            }
            else
            {
                $('#date_certificate').attr('required', false);
            }
        });

        $('#date_137s').datetimepicker({
            format: 'MM-DD-YYYY'
        });
        $(document).on('click', '#form_1371', function(){
            if ($('#form_1371').is(':checked'))
            {
                // $('.date_137').removeClass('hidden');
                $('#date_137').attr('required', true);
            }
            else
            {
                // $('.date_137').addClass('hidden');
                $('#date_137').attr('required', false);
            }
        });

        $('#date_goodmorals').datetimepicker({
            format: 'MM-DD-YYYY'
        });
        $(document).on('click', '#good_moral', function(){
            if ($('#good_moral').is(':checked'))
            {
                // $('.date_goodmoral').removeClass('hidden');
                $('#date_goodmoral').attr('required', true);
            }
            else
            {
                // $('.date_goodmoral').addClass('hidden');
                $('#date_goodmoral').attr('required', false);
            }
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
                    $('#forms_requirements')[0].reset();
                    // $('.date_goodmoral').addClass('hidden');
                    // $('.date_137').addClass('hidden');
                    // $('#date_137').attr('required', false);
                    // $('#date_goodmoral').attr('required', false);
                    $('#date_certificate').val(data.certificate_date);
                    $('#date_goodmoral').val(data.good_moral_date);
                    $('#date_psa').val(data.psa_date);
                    $('#date_137').val(data.form_137_date);
                    $('#date_report').val(data.report_card_date);
                    if (data.certificate != '')
                    {
                        $('#certificate').attr('checked', true);//.attr('disabled', true);
                        $('#date_certificate').attr('required', true);
                    }
                    else
                    {
                        $('#certificate').attr('checked', false);//.attr('disabled', false);
                        $('#date_certificate').attr('required', false);
                    }
                    if (data.good_moral != '')
                    {
                        $('#good_moral').attr('checked', true);//.attr('disabled', true);
                        $('#date_goodmoral').attr('required', true);
                    }
                    else
                    {
                        $('#good_moral').attr('checked', false);//.attr('disabled', false);
                        $('#date_goodmoral').attr('required', false);
                    }
                    if (data.psa != '')
                    {
                        $('#psa').attr('checked', true);//.attr('disabled', true);
                        $('#date_psa').attr('required', true);
                    }
                    else
                    {
                        $('#psa').attr('checked', false);//.attr('disabled', false);
                        $('#date_psa').attr('required', false);
                    }
                    if (data.form_1371 != '')
                    {
                        $('#form_1371').attr('checked', true);//.attr('disabled', true);
                        $('#date_137').attr('required', true);
                    }
                    else
                    {
                        $('#form_1371').attr('checked', false);//.attr('disabled', false);
                        $('#date_137').attr('required', false);
                    }
                    if (data.report_card1 != '')
                    {
                        $('#report_card1').attr('checked', true);//.attr('disabled', true);
                        $('#date_report').attr('required', true);
                    }
                    else
                    {
                        $('#report_card1').attr('checked', false);//.attr('disabled', false);
                        $('#date_report').attr('required', false);
                    }
                    $('#viewModal').modal('show');
                    $('#viewModal .modal-title').html("<i class='fa fa-list'></i> Requirements");
                    $('#action_requirements').html("<i class='fa fa-save '></i> Save");
                    $('#action_requirements').val('upload_requirements');
                    $('#id_requirements').val(id);
                    $('#btn_action_requirements').val('upload_requirements');
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });
    
        $(document).on('submit','#forms_requirements', function(event){
            event.preventDefault();
            $('#action_requirements').attr('disabled','disabled');
            $.ajax({
                url:"action.php",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                dataType:"json",
                success:function(data)
                {
                    $('#action_requirements').attr('disabled', false);
                    if (data.status == true)
                    {
                        $('#viewModal').modal('hide');
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
                    $('#action_requirements').attr('disabled', false);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
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
        
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            width: '12em'
        });
        
        $('#New').click(function(){
            $('#student_status').val('New');
        });
        
        $('#Transferee').click(function(){
            $('#student_status').val('Transferee');
        });
        
        $('#Old').click(function(){
            $('#student_status').val('Old');
        });
        
        $('#Returnee').click(function(){
            $('#student_status').val('Returnee');
        });
        
        $('#grade_level').change(function(){
            section();
        });
        
        $('#strand_id').change(function(){
            section();
        });

        function section()
        {
            var grade_level = $('#grade_level').val();
            var strand_id = $('#strand_id').val();
            var btn_action = 'senior_section';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{grade_level:grade_level, strand_id:strand_id, btn_action:btn_action},
                dataType:"json",
                success:function(data)
                {
                    $('#section_id').html(data.section_id);
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        }
    
        $(document).on('submit','#forms', function(event){
            event.preventDefault();
            $('#action').attr('disabled','disabled');
            $.ajax({
                url:"action.php",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
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
                    $('#student_status').val(data.student_status);
                    $('#grade_level').val(data.grade_level);

                    $('#strand_id').val(data.strand_id);
                    $('#section_id').html(data.section_id);

                    $('#last_name').val(data.last_name);
                    $('#first_name').val(data.first_name);
                    $('#middle_name').val(data.middle_name);
                    $('#extension_name').val(data.extension_name);

                    $('#address').val(data.address);
                    $('#email').val(data.email);
                    $('#contact').val(data.contact);
                    $('#date_birth').val(data.date_birth);
                    $('#sex').val(data.sex);
                    $('#nationality').val(data.nationality);
                    $('#last_attended').val(data.last_attended);
                    
                    $('#g_fullname').val(data.g_fullname);
                    $('#g_contact').val(data.g_contact);
                    $('#g_relationship').val(data.g_relationship);
                    $('#g_occupation').val(data.g_occupation);
                    $('#g_address').val(data.g_address);

                    $('#addModal').modal('show');
                    $('.modal-title').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').html("<i class='fa fa-edit'></i> Edit");
                    $('#action').val('student_update');
                    $('#btn_action').val('student_update');
                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });

        $(document).on('click', '.payment', function(){
            id = $(this).attr("id");
            var admission_no = $(this).attr("admission_no");
            var sf = $(this).attr("sf");
            var me = $(this).attr("me");
            var status = $(this).attr("status");
            $('#paymentModal').modal('show');
            $('.modal-title').html("<i class='fa fa-list'></i> Payment");
            $('#action_payment').html("<i class='fa fa-save'></i> Save");
            $('#btn_action_payment').val('admission_payment');
            $('#id_payment').val(admission_no);
            loadTuition(admission_no,sf, me)
            $('.btn_undo').addClass('hidden');
            if (status !== '')
            {
                $('.btn_undo').removeClass('hidden').attr('id', admission_no);
                $('#action_payment').attr('disabled','disabled');
                $('#btn_complete').attr('disabled','disabled');
                $('#btn_complete').attr('disabled','disabled');
                $('#sf_ue_status').attr('disabled','disabled');
                $('#sf_aug_status').attr('disabled','disabled');
                $('#sf_sep_status').attr('disabled','disabled');
                $('#sf_oct_status').attr('disabled','disabled');
                $('#sf_nov_status').attr('disabled','disabled');
                $('#sf_dec_status').attr('disabled','disabled');
                $('#sf_jan_status').attr('disabled','disabled');
                $('#sf_feb_status').attr('disabled','disabled');
                $('#sf_mar_status').attr('disabled','disabled');
                $('#sf_apr_status').attr('disabled','disabled');
                $('#sf_may_status').attr('disabled','disabled');
            }
            else
            {
                $('#action_payment').removeAttr('disabled','disabled');
                $('#btn_complete').removeAttr('disabled','disabled');
                $('#sf_ue_status').removeAttr('disabled','disabled');
                $('#sf_aug_status').removeAttr('disabled','disabled');
                $('#sf_sep_status').removeAttr('disabled','disabled');
                $('#sf_oct_status').removeAttr('disabled','disabled');
                $('#sf_nov_status').removeAttr('disabled','disabled');
                $('#sf_dec_status').removeAttr('disabled','disabled');
                $('#sf_jan_status').removeAttr('disabled','disabled');
                $('#sf_feb_status').removeAttr('disabled','disabled');
                $('#sf_mar_status').removeAttr('disabled','disabled');
                $('#sf_apr_status').removeAttr('disabled','disabled');
                $('#sf_may_status').removeAttr('disabled','disabled');
            }
        });

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
        
        var admission_no ;
        $('#btn_complete').click(function(){
            $('#questionModal').modal('show');
            $('#questionModal .modal-title').html("<i class='fa fa-check'></i> Complete");
            $('#btn_yes').html("<i class='fa fa-check-circle '></i> Yes");
            admission_no  =  $('#id_payment').val();
            $('#questionModal .questions').html("Are you sure you want to complete this?");
            question = 'Complete';
            $('#paymentModal').modal('hide');
        });
        
        $('.btn_undo').click(function(){
            $('#questionModal').modal('show');
            $('#questionModal .modal-title').html("<i class='fa fa-undo'></i> Undo");
            $('#btn_yes').html("<i class='fa fa-check-circle '></i> Yes");
            admission_no  = $(this).attr("id");
            $('#questionModal .questions').html("Are you sure you want to undo this?");
            question = 'Undo';
            $('#paymentModal').modal('hide');
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
    
        $(document).on('submit','#forms_payment', function(event){
            event.preventDefault();
            $('#action_payment').attr('disabled','disabled');
            $.ajax({
                url:"action.php",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                dataType:"json",
                success:function(data)
                {
                    $('#action_payment').attr('disabled', false);
                    if (data.status == true)
                    {
                        $('#forms_payment')[0].reset();
                        $('#paymentModal').modal('hide');
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
                    $('#action_payment').attr('disabled', false);
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });
        
        function loadTuition(admission_no, sf, me)
        {
            var btn_action = 'fetch_admission_tuition_plan';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{ btn_action:btn_action, admission_no:admission_no, sf:sf, me:me},
                dataType:"json",
                success:function(data)
                {
                    $('.total_amount').html(data.total_amount);
                    $('.total_paid').html(data.total_paid);
                    $('.total_balance').html(data.total_balance);

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

                    if (data.ue_date !== '')
                    {
                        $('.ue_date_paid').html('Upon Enrollment<br>'+data.ue_date);
                        // $('#sf_ue_status').attr('disabled','disabled').val('Paid');
                        $('#sf_ue_status').val('Paid');
                    }
                    else
                    {
                        $('.ue_date_paid').html('Upon Enrollment');
                        $('#sf_ue_status').val('Not Paid');
                    }
                    if (data.aug_date !== '')
                    {
                        $('.aug_date_paid').html('AUGUST (1Q)<br>'+data.aug_date);
                        $('#sf_aug_status').val('Paid');
                    }
                    else
                    {
                        $('.aug_date_paid').html('AUGUST (1Q)');
                        $('#sf_aug_status').val('Not Paid');
                    }
                    if (data.sep_date !== '')
                    {
                        $('.sep_date_paid').html('SEPTEMBER (1Q)<br>'+data.sep_date);
                        $('#sf_sep_status').val('Paid');
                    }
                    else
                    {
                        $('.sep_date_paid').html('SEPTEMBER (1Q)');
                        $('#sf_sep_status').val('Not Paid');
                    }
                    if (data.oct_date !== '')
                    {
                        $('.oct_date_paid').html('OCTOBER (1Q)<br>'+data.oct_date);
                        $('#sf_oct_status').val('Paid');
                    }
                    else
                    {
                        $('.oct_date_paid').html('OCTOBER (1Q)');
                        $('#sf_oct_status').val('Not Paid');
                    }
                    if (data.nov_date !== '')
                    {
                        $('.nov_date_paid').html('NOVEMBER (2Q)<br>'+data.nov_date);
                        $('#sf_nov_status').val('Paid');
                    }
                    else
                    {
                        $('.nov_date_paid').html('NOVEMBER (2Q)');
                        $('#sf_nov_status').val('Not Paid');
                    }
                    if (data.dec_date !== '')
                    {
                        $('.dec_date_paid').html('DECEMBER (2Q)<br>'+data.dec_date);
                        $('#sf_dec_status').val('Paid');
                    }
                    else
                    {
                        $('.dec_date_paid').html('DECEMBER (2Q)');
                        $('#sf_dec_status').val('Not Paid');
                    }
                    if (data.jan_date !== '')
                    {
                        $('.jan_date_paid').html('JANUARY (2Q)<br>'+data.jan_date);
                        $('#sf_jan_status').val('Paid');
                    }
                    else
                    {
                        $('.jan_date_paid').html('JANUARY (2Q)');
                        $('#sf_jan_status').val('Not Paid');
                    }
                    if (data.feb_date !== '')
                    {
                        $('.feb_date_paid').html('FEBRUARY (3Q)<br>'+data.feb_date);
                        $('#sf_feb_status').val('Paid');
                    }
                    else
                    {
                        $('.feb_date_paid').html('FEBRUARY (3Q)');
                        $('#sf_feb_status').val('Not Paid');
                    }
                    if (data.mar_date !== '')
                    {
                        $('.mar_date_paid').html('MARCH (3Q)<br>'+data.mar_date);
                        $('#sf_mar_status').val('Paid');
                    }
                    else
                    {
                        $('.mar_date_paid').html('MARCH (3Q)');
                        $('#sf_mar_status').val('Not Paid');
                    }
                    if (data.apr_date !== '')
                    {
                        $('.apr_date_paid').html('APRIL (4Q)<br>'+data.apr_date);
                        $('#sf_apr_status').val('Paid');
                    }
                    else
                    {
                        $('.apr_date_paid').html('APRIL (1Q)');
                        $('#sf_apr_status').val('Not Paid');
                    }
                    if (data.may_date !== '')
                    {
                        $('.may_date_paid').html('MAY (4Q)<br>'+data.may_date);
                        $('#sf_may_status').val('Paid');
                    }
                    else
                    {
                        $('.may_date_paid').html('MAY (4Q)');
                        $('#sf_may_status').val('Not Paid');
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
                    url:"fetch/sh_enrolled.php?grade_level="+$("#grade_levels").val()+"&strand_id="+$("#strands_id").val(),
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

        $("#strands_id").change(function(){
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
                    url:"fetch/sh_enrolled.php?grade_level="+$("#grade_levels").val()+"&strand_id="+$("#strands_id").val(),
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
                url:"fetch/sh_enrolled.php?grade_level="+$("#grade_levels").val()+"&strand_id="+$("#strands_id").val(),
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