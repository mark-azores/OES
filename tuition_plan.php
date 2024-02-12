<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'Tuition Plan';
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
                                    <select name="high_school" id="high_school" class="form-control" >
                                        <option value="">High School</option>
                                        <option value="Junior">Junior</option>
                                        <option value="Junior ESC">Junior ESC</option>
                                        <option value="Senior">Senior</option>
                                        <option value="Senior ESC">Senior ESC</option>
                                    </select>
                                </div>   
                                <div class="col-12 col-md-2">
                                    <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#addModal" class="btn btn-light pl-3 pr-3 elevation-2" 
                                    style="border-radius: 20px;">
                                        <i class="fa fa-save"></i> Save</button>
                                </div> 
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <table class="table table-hover table-bordered ">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">SCHOOL FEES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>One Year</td>
                                                <th><input type="number" class="form-control" name="sf_one_year" id="sf_one_year" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>ESC Subsidy</td>
                                                <th><input type="number" class="form-control" name="sf_esc" id="sf_esc" min="0" placeholder="0" disabled /></th>
                                            </tr>
                                            <tr>
                                                <td>Net</td>
                                                <th class="net_total">0</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-hover table-bordered ">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">MODULES & E-BOOKS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>One Year</td>
                                                <th><input type="number" class="form-control " name="me_one_year" id="me_one_year" min="0" placeholder="0" /></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-md-9">
                                    <table class="table table-hover table-bordered table-responsive ">
                                        <thead>
                                            <tr>
                                                <th colspan="6" class="text-center">PAYMENT OPTIONS</th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-center">School Fees</th>
                                                <th colspan="2" class="text-center">Modules and E-Books</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th>A</th>
                                                <th>B</th>
                                                <th>C</th>
                                                <th>A</th>
                                                <th>B</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Upon Enrollment</td>
                                                <th><input type="number" class="form-control" name="sf_ue_a" id="sf_ue_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_ue_b" id="sf_ue_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_ue_c" id="sf_ue_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_ue_a" id="me_ue_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_ue_b" id="me_ue_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>AUGUST</td>
                                                <th><input type="number" class="form-control" name="sf_aug_a" id="sf_aug_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_aug_b" id="sf_aug_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_aug_c" id="sf_aug_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_aug_a" id="me_aug_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_aug_b" id="me_aug_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>SEPTEMBER</td>
                                                <th><input type="number" class="form-control" name="sf_sep_a" id="sf_sep_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_sep_b" id="sf_sep_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_sep_c" id="sf_sep_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_sep_a" id="me_sep_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_sep_b" id="me_sep_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>OCTOBER</td>
                                                <th><input type="number" class="form-control" name="sf_oct_a" id="sf_oct_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_oct_b" id="sf_oct_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_oct_c" id="sf_oct_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_oct_a" id="me_oct_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_oct_b" id="me_oct_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>NOVEMBER</td>
                                                <th><input type="number" class="form-control" name="sf_nov_a" id="sf_nov_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_nov_b" id="sf_nov_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_nov_c" id="sf_nov_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_nov_a" id="me_nov_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_nov_b" id="me_nov_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>DECEMBER</td>
                                                <th><input type="number" class="form-control" name="sf_dec_a" id="sf_dec_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_dec_b" id="sf_dec_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_dec_c" id="sf_dec_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_dec_a" id="me_dec_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_dec_b" id="me_dec_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>JANUARY</td>
                                                <th><input type="number" class="form-control" name="sf_jan_a" id="sf_jan_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_jan_b" id="sf_jan_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_jan_c" id="sf_jan_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_jan_a" id="me_jan_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_jan_b" id="me_jan_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>FEBRUARY</td>
                                                <th><input type="number" class="form-control" name="sf_feb_a" id="sf_feb_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_feb_b" id="sf_feb_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_feb_c" id="sf_feb_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_feb_a" id="me_feb_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_feb_b" id="me_feb_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>MARCH</td>
                                                <th><input type="number" class="form-control" name="sf_mar_a" id="sf_mar_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_mar_b" id="sf_mar_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_mar_c" id="sf_mar_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_mar_a" id="me_mar_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_mar_b" id="me_mar_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>APRIL</td>
                                                <th><input type="number" class="form-control" name="sf_apr_a" id="sf_apr_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_apr_b" id="sf_apr_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_apr_c" id="sf_apr_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_apr_a" id="me_apr_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_apr_b" id="me_apr_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <td>MAY</td>
                                                <th><input type="number" class="form-control" name="sf_may_a" id="sf_may_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_may_b" id="sf_may_b" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="sf_may_c" id="sf_may_c" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_may_a" id="me_may_a" min="0" placeholder="0" /></th>
                                                <th><input type="number" class="form-control" name="me_may_b" id="me_may_b" min="0" placeholder="0" /></th>
                                            </tr>
                                            <tr>
                                                <th>TOTAL</th>
                                                <th class="total_sf_a">0</th>
                                                <th class="total_sf_b">0</th>
                                                <th class="total_sf_c">0</th>
                                                <th class="total_me_a">0</th>
                                                <th class="total_me_b">0</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

        $("#high_school").change(function(){
            $('#sf_esc').attr('disabled', true);
            if (this.value == 'Junior ESC' || this.value == 'Senior ESC')
            {
                $('#sf_esc').attr('disabled', false);
            }
            loadData(this.value)
        });
        
        $('#add_button').click(function(){
            if ($("#high_school").val() == '')
            {
                Toast.fire({
                    icon: 'error',
                    title: 'Please select high school.'
                });
            }
            else
            {
                var btn_action = 'update_tuition_plan';
                var high_school = $("#high_school").val();
                
                var sf_one_year = $("#sf_one_year").val();
                var sf_esc = $("#sf_esc").val();
                
                var me_one_year = $("#me_one_year").val();
                
                var sf_ue_a = $("#sf_ue_a").val();
                var sf_aug_a = $("#sf_aug_a").val();
                var sf_sep_a = $("#sf_sep_a").val();
                var sf_oct_a = $("#sf_oct_a").val();
                var sf_nov_a = $("#sf_nov_a").val();
                var sf_dec_a = $("#sf_dec_a").val();
                var sf_jan_a = $("#sf_jan_a").val();
                var sf_feb_a = $("#sf_feb_a").val();
                var sf_mar_a = $("#sf_mar_a").val();
                var sf_apr_a = $("#sf_apr_a").val();
                var sf_may_a = $("#sf_may_a").val();
                
                var sf_ue_b = $("#sf_ue_b").val();
                var sf_aug_b = $("#sf_aug_b").val();
                var sf_sep_b = $("#sf_sep_b").val();
                var sf_oct_b = $("#sf_oct_b").val();
                var sf_nov_b = $("#sf_nov_b").val();
                var sf_dec_b = $("#sf_dec_b").val();
                var sf_jan_b = $("#sf_jan_b").val();
                var sf_feb_b = $("#sf_feb_b").val();
                var sf_mar_b = $("#sf_mar_b").val();
                var sf_apr_b = $("#sf_apr_b").val();
                var sf_may_b = $("#sf_may_b").val();
                
                var sf_ue_c = $("#sf_ue_c").val();
                var sf_aug_c = $("#sf_aug_c").val();
                var sf_sep_c = $("#sf_sep_c").val();
                var sf_oct_c = $("#sf_oct_c").val();
                var sf_nov_c = $("#sf_nov_c").val();
                var sf_dec_c = $("#sf_dec_c").val();
                var sf_jan_c = $("#sf_jan_c").val();
                var sf_feb_c = $("#sf_feb_c").val();
                var sf_mar_c = $("#sf_mar_c").val();
                var sf_apr_c = $("#sf_apr_c").val();
                var sf_may_c = $("#sf_may_c").val();
                
                var me_ue_a = $("#me_ue_a").val();
                var me_aug_a = $("#me_aug_a").val();
                var me_sep_a = $("#me_sep_a").val();
                var me_oct_a = $("#me_oct_a").val();
                var me_nov_a = $("#me_nov_a").val();
                var me_dec_a = $("#me_dec_a").val();
                var me_jan_a = $("#me_jan_a").val();
                var me_feb_a = $("#me_feb_a").val();
                var me_mar_a = $("#me_mar_a").val();
                var me_apr_a = $("#me_apr_a").val();
                var me_may_a = $("#me_may_a").val();
                
                var me_ue_b = $("#me_ue_b").val();
                var me_aug_b = $("#me_aug_b").val();
                var me_sep_b = $("#me_sep_b").val();
                var me_oct_b = $("#me_oct_b").val();
                var me_nov_b = $("#me_nov_b").val();
                var me_dec_b = $("#me_dec_b").val();
                var me_jan_b = $("#me_jan_b").val();
                var me_feb_b = $("#me_feb_b").val();
                var me_mar_b = $("#me_mar_b").val();
                var me_apr_b = $("#me_apr_b").val();
                var me_may_b = $("#me_may_b").val();

                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{btn_action:btn_action, high_school:high_school, sf_one_year:sf_one_year, sf_esc:sf_esc, me_one_year:me_one_year,
                        sf_ue_a:sf_ue_a, 
                        sf_aug_a:sf_aug_a, 
                        sf_sep_a:sf_sep_a, 
                        sf_oct_a:sf_oct_a, 
                        sf_nov_a:sf_nov_a, 
                        sf_dec_a:sf_dec_a,
                        sf_jan_a:sf_jan_a, 
                        sf_feb_a:sf_feb_a, 
                        sf_mar_a:sf_mar_a, 
                        sf_apr_a:sf_apr_a, 
                        sf_may_a:sf_may_a, 
                        
                        sf_ue_b:sf_ue_b, 
                        sf_aug_b:sf_aug_b, 
                        sf_sep_b:sf_sep_b, 
                        sf_oct_b:sf_oct_b, 
                        sf_nov_b:sf_nov_b, 
                        sf_dec_b:sf_dec_b,
                        sf_jan_b:sf_jan_b, 
                        sf_feb_b:sf_feb_b, 
                        sf_mar_b:sf_mar_b, 
                        sf_apr_b:sf_apr_b, 
                        sf_may_b:sf_may_b, 
                        
                        sf_ue_c:sf_ue_c, 
                        sf_aug_c:sf_aug_c, 
                        sf_sep_c:sf_sep_c, 
                        sf_oct_c:sf_oct_c, 
                        sf_nov_c:sf_nov_c, 
                        sf_dec_c:sf_dec_c,
                        sf_jan_c:sf_jan_c, 
                        sf_feb_c:sf_feb_c, 
                        sf_mar_c:sf_mar_c, 
                        sf_apr_c:sf_apr_c, 
                        sf_may_c:sf_may_c, 
                        
                        me_ue_a:me_ue_a, 
                        me_aug_a:me_aug_a, 
                        me_sep_a:me_sep_a, 
                        me_oct_a:me_oct_a, 
                        me_nov_a:me_nov_a, 
                        me_dec_a:me_dec_a,
                        me_jan_a:me_jan_a, 
                        me_feb_a:me_feb_a, 
                        me_mar_a:me_mar_a, 
                        me_apr_a:me_apr_a, 
                        me_may_a:me_may_a, 
                        
                        me_ue_b:me_ue_b, 
                        me_aug_b:me_aug_b, 
                        me_sep_b:me_sep_b, 
                        me_oct_b:me_oct_b, 
                        me_nov_b:me_nov_b, 
                        me_dec_b:me_dec_b,
                        me_jan_b:me_jan_b, 
                        me_feb_b:me_feb_b, 
                        me_mar_b:me_mar_b, 
                        me_apr_b:me_apr_b, 
                        me_may_b:me_may_b
                    },
                    dataType:"json",
                    success:function(data)
                    {
                        if (data.status )
                        {
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
                        // else
                        // {
                        //     loadData($("#high_school").val())
                        // }
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

        loadData('');
        function loadData(high_school)
        {
            var btn_action = 'fetch_tuition_plan';
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{btn_action:btn_action, high_school:high_school},
                dataType:"json",
                success:function(data)
                {
                    $('#sf_one_year').val(data.sf_one_year);
                    $('#sf_esc').val(data.sf_esc);
                    
                    $('#me_one_year').val(data.me_one_year);
                    
                    $('#sf_ue_a').val(data.sf_ue_a);
                    $('#sf_aug_a').val(data.sf_aug_a);
                    $('#sf_sep_a').val(data.sf_sep_a);
                    $('#sf_oct_a').val(data.sf_oct_a);
                    $('#sf_nov_a').val(data.sf_nov_a);
                    $('#sf_dec_a').val(data.sf_dec_a);
                    $('#sf_jan_a').val(data.sf_jan_a);
                    $('#sf_feb_a').val(data.sf_feb_a);
                    $('#sf_mar_a').val(data.sf_mar_a);
                    $('#sf_apr_a').val(data.sf_apr_a);
                    $('#sf_may_a').val(data.sf_may_a);
                    
                    $('#sf_ue_b').val(data.sf_ue_b);
                    $('#sf_aug_b').val(data.sf_aug_b);
                    $('#sf_sep_b').val(data.sf_sep_b);
                    $('#sf_oct_b').val(data.sf_oct_b);
                    $('#sf_nov_b').val(data.sf_nov_b);
                    $('#sf_dec_b').val(data.sf_dec_b);
                    $('#sf_jan_b').val(data.sf_jan_b);
                    $('#sf_feb_b').val(data.sf_feb_b);
                    $('#sf_mar_b').val(data.sf_mar_b);
                    $('#sf_apr_b').val(data.sf_apr_b);
                    $('#sf_may_b').val(data.sf_may_b);
                    
                    $('#sf_ue_c').val(data.sf_ue_c);
                    $('#sf_aug_c').val(data.sf_aug_c);
                    $('#sf_sep_c').val(data.sf_sep_c);
                    $('#sf_oct_c').val(data.sf_oct_c);
                    $('#sf_nov_c').val(data.sf_nov_c);
                    $('#sf_dec_c').val(data.sf_dec_c);
                    $('#sf_jan_c').val(data.sf_jan_c);
                    $('#sf_feb_c').val(data.sf_feb_c);
                    $('#sf_mar_c').val(data.sf_mar_c);
                    $('#sf_apr_c').val(data.sf_apr_c);
                    $('#sf_may_c').val(data.sf_may_c);
                    
                    $('#me_ue_a').val(data.me_ue_a);
                    $('#me_aug_a').val(data.me_aug_a);
                    $('#me_sep_a').val(data.me_sep_a);
                    $('#me_oct_a').val(data.me_oct_a);
                    $('#me_nov_a').val(data.me_nov_a);
                    $('#me_dec_a').val(data.me_dec_a);
                    $('#me_jan_a').val(data.me_jan_a);
                    $('#me_feb_a').val(data.me_feb_a);
                    $('#me_mar_a').val(data.me_mar_a);
                    $('#me_apr_a').val(data.me_apr_a);
                    $('#me_may_a').val(data.me_may_a);
                    
                    $('#me_ue_b').val(data.me_ue_b);
                    $('#me_aug_b').val(data.me_aug_b);
                    $('#me_sep_b').val(data.me_sep_b);
                    $('#me_oct_b').val(data.me_oct_b);
                    $('#me_nov_b').val(data.me_nov_b);
                    $('#me_dec_b').val(data.me_dec_b);
                    $('#me_jan_b').val(data.me_jan_b);
                    $('#me_feb_b').val(data.me_feb_b);
                    $('#me_mar_b').val(data.me_mar_b);
                    $('#me_apr_b').val(data.me_apr_b);
                    $('#me_may_b').val(data.me_may_b);

                    computeSFNet();
                    computeSFA();
                    computeSFB();
                    computeSFC();
                    computeMEA();
                    computeMEB();

                },error:function()
                {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        }

        $("#sf_one_year").on('change keyup paste', function () {
            computeSFNet();
        });

        $("#sf_esc").on('change keyup paste', function () {
            computeSFNet();
        });

        function computeSFNet()
        {
            var sf_esc = $('#sf_esc').val() !== '' ? $('#sf_esc').val() : 0;
            var sf_one_year = $('#sf_one_year').val() !== '' ? $('#sf_one_year').val() : 0;
            $('.net_total').html( (parseFloat(sf_one_year) - parseFloat(sf_esc)).toFixed(2) );
        }

        $("#sf_ue_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_aug_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_sep_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_oct_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_nov_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_dec_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_jan_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_feb_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_mar_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_apr_a").on('change keyup paste', function () { computeSFA(); });
        $("#sf_may_a").on('change keyup paste', function () { computeSFA(); });

        function computeSFA()
        {
            var sf_ue = $('#sf_ue_a').val() !== '' ? $('#sf_ue_a').val() : 0;
            var sf_aug = $('#sf_aug_a').val() !== '' ? $('#sf_aug_a').val() : 0;
            var sf_sep = $('#sf_sep_a').val() !== '' ? $('#sf_sep_a').val() : 0;
            var sf_oct = $('#sf_oct_a').val() !== '' ? $('#sf_oct_a').val() : 0;
            var sf_nov = $('#sf_nov_a').val() !== '' ? $('#sf_nov_a').val() : 0;
            var sf_dec = $('#sf_dec_a').val() !== '' ? $('#sf_dec_a').val() : 0;
            var sf_jan = $('#sf_jan_a').val() !== '' ? $('#sf_jan_a').val() : 0;
            var sf_feb = $('#sf_feb_a').val() !== '' ? $('#sf_feb_a').val() : 0;
            var sf_mar = $('#sf_mar_a').val() !== '' ? $('#sf_mar_a').val() : 0;
            var sf_apr = $('#sf_apr_a').val() !== '' ? $('#sf_apr_a').val() : 0;
            var sf_may = $('#sf_may_a').val() !== '' ? $('#sf_may_a').val() : 0;
            var total = parseFloat(sf_ue) + parseFloat(sf_aug) + parseFloat(sf_sep) + parseFloat(sf_oct) + parseFloat(sf_nov) + parseFloat(sf_dec)
            + parseFloat(sf_jan) + parseFloat(sf_feb) + parseFloat(sf_mar) + parseFloat(sf_apr) + parseFloat(sf_may);
            $('.total_sf_a').html( total.toFixed(2) );
        }

        $("#sf_ue_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_aug_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_sep_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_oct_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_nov_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_dec_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_jan_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_feb_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_mar_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_apr_b").on('change keyup paste', function () { computeSFB(); });
        $("#sf_may_b").on('change keyup paste', function () { computeSFB(); });

        function computeSFB()
        {
            var sf_ue = $('#sf_ue_b').val() !== '' ? $('#sf_ue_b').val() : 0;
            var sf_aug = $('#sf_aug_b').val() !== '' ? $('#sf_aug_b').val() : 0;
            var sf_sep = $('#sf_sep_b').val() !== '' ? $('#sf_sep_b').val() : 0;
            var sf_oct = $('#sf_oct_b').val() !== '' ? $('#sf_oct_b').val() : 0;
            var sf_nov = $('#sf_nov_b').val() !== '' ? $('#sf_nov_b').val() : 0;
            var sf_dec = $('#sf_dec_b').val() !== '' ? $('#sf_dec_b').val() : 0;
            var sf_jan = $('#sf_jan_b').val() !== '' ? $('#sf_jan_b').val() : 0;
            var sf_feb = $('#sf_feb_b').val() !== '' ? $('#sf_feb_b').val() : 0;
            var sf_mar = $('#sf_mar_b').val() !== '' ? $('#sf_mar_b').val() : 0;
            var sf_apr = $('#sf_apr_b').val() !== '' ? $('#sf_apr_b').val() : 0;
            var sf_may = $('#sf_may_b').val() !== '' ? $('#sf_may_b').val() : 0;
            var total = parseFloat(sf_ue) + parseFloat(sf_aug) + parseFloat(sf_sep) + parseFloat(sf_oct) + parseFloat(sf_nov) + parseFloat(sf_dec)
            + parseFloat(sf_jan) + parseFloat(sf_feb) + parseFloat(sf_mar) + parseFloat(sf_apr) + parseFloat(sf_may);
            $('.total_sf_b').html( total.toFixed(2) );
        }

        $("#sf_ue_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_aug_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_sep_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_oct_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_nov_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_dec_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_jan_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_feb_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_mar_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_apr_c").on('change keyup paste', function () { computeSFC(); });
        $("#sf_may_c").on('change keyup paste', function () { computeSFC(); });

        function computeSFC()
        {
            var sf_ue = $('#sf_ue_c').val() !== '' ? $('#sf_ue_c').val() : 0;
            var sf_aug = $('#sf_aug_c').val() !== '' ? $('#sf_aug_c').val() : 0;
            var sf_sep = $('#sf_sep_c').val() !== '' ? $('#sf_sep_c').val() : 0;
            var sf_oct = $('#sf_oct_c').val() !== '' ? $('#sf_oct_c').val() : 0;
            var sf_nov = $('#sf_nov_c').val() !== '' ? $('#sf_nov_c').val() : 0;
            var sf_dec = $('#sf_dec_c').val() !== '' ? $('#sf_dec_c').val() : 0;
            var sf_jan = $('#sf_jan_c').val() !== '' ? $('#sf_jan_c').val() : 0;
            var sf_feb = $('#sf_feb_c').val() !== '' ? $('#sf_feb_c').val() : 0;
            var sf_mar = $('#sf_mar_c').val() !== '' ? $('#sf_mar_c').val() : 0;
            var sf_apr = $('#sf_apr_c').val() !== '' ? $('#sf_apr_c').val() : 0;
            var sf_may = $('#sf_may_c').val() !== '' ? $('#sf_may_c').val() : 0;
            var total = parseFloat(sf_ue) + parseFloat(sf_aug) + parseFloat(sf_sep) + parseFloat(sf_oct) + parseFloat(sf_nov) + parseFloat(sf_dec)
            + parseFloat(sf_jan) + parseFloat(sf_feb) + parseFloat(sf_mar) + parseFloat(sf_apr) + parseFloat(sf_may);
            $('.total_sf_c').html( total.toFixed(2) );
        }

        $("#me_ue_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_aug_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_sep_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_oct_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_nov_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_dec_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_jan_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_feb_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_mar_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_apr_a").on('change keyup paste', function () { computeMEA(); });
        $("#me_may_a").on('change keyup paste', function () { computeMEA(); });

        function computeMEA()
        {
            var me_ue = $('#me_ue_a').val() !== '' ? $('#me_ue_a').val() : 0;
            var me_aug = $('#me_aug_a').val() !== '' ? $('#me_aug_a').val() : 0;
            var me_sep = $('#me_sep_a').val() !== '' ? $('#me_sep_a').val() : 0;
            var me_oct = $('#me_oct_a').val() !== '' ? $('#me_oct_a').val() : 0;
            var me_nov = $('#me_nov_a').val() !== '' ? $('#me_nov_a').val() : 0;
            var me_dec = $('#me_dec_a').val() !== '' ? $('#me_dec_a').val() : 0;
            var me_jan = $('#me_jan_a').val() !== '' ? $('#me_jan_a').val() : 0;
            var me_feb = $('#me_feb_a').val() !== '' ? $('#me_feb_a').val() : 0;
            var me_mar = $('#me_mar_a').val() !== '' ? $('#me_mar_a').val() : 0;
            var me_apr = $('#me_apr_a').val() !== '' ? $('#me_apr_a').val() : 0;
            var me_may = $('#me_may_a').val() !== '' ? $('#me_may_a').val() : 0;
            var total = parseFloat(me_ue) + parseFloat(me_aug) + parseFloat(me_sep) + parseFloat(me_oct) + parseFloat(me_nov) + parseFloat(me_dec)
            + parseFloat(me_jan) + parseFloat(me_feb) + parseFloat(me_mar) + parseFloat(me_apr) + parseFloat(me_may);
            $('.total_me_a').html( total.toFixed(2) );
        }

        $("#me_ue_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_aug_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_sep_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_oct_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_nov_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_dec_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_jan_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_feb_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_mar_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_apr_b").on('change keyup paste', function () { computeMEB(); });
        $("#me_may_b").on('change keyup paste', function () { computeMEB(); });

        function computeMEB()
        {
            var sf_ue = $('#me_ue_b').val() !== '' ? $('#me_ue_b').val() : 0;
            var sf_aug = $('#me_aug_b').val() !== '' ? $('#me_aug_b').val() : 0;
            var sf_sep = $('#me_sep_b').val() !== '' ? $('#me_sep_b').val() : 0;
            var sf_oct = $('#me_oct_b').val() !== '' ? $('#me_oct_b').val() : 0;
            var sf_nov = $('#me_nov_b').val() !== '' ? $('#me_nov_b').val() : 0;
            var sf_dec = $('#me_dec_b').val() !== '' ? $('#me_dec_b').val() : 0;
            var sf_jan = $('#me_jan_b').val() !== '' ? $('#me_jan_b').val() : 0;
            var sf_feb = $('#me_feb_b').val() !== '' ? $('#me_feb_b').val() : 0;
            var sf_mar = $('#me_mar_b').val() !== '' ? $('#me_mar_b').val() : 0;
            var sf_apr = $('#me_apr_b').val() !== '' ? $('#me_apr_b').val() : 0;
            var sf_may = $('#me_may_b').val() !== '' ? $('#me_may_b').val() : 0;
            var total = parseFloat(sf_ue) + parseFloat(sf_aug) + parseFloat(sf_sep) + parseFloat(sf_oct) + parseFloat(sf_nov) + parseFloat(sf_dec)
            + parseFloat(sf_jan) + parseFloat(sf_feb) + parseFloat(sf_mar) + parseFloat(sf_apr) + parseFloat(sf_may);
            $('.total_me_b').html( total.toFixed(2) );
        }

    });
</script>

</body>
</html>