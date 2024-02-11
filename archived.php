<?php

include('config.php');

if (!isset($_SESSION["user_type"])) {
    header("location:index.php");
}

$title = 'Archived';
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
                                    <select name="school_year" id="school_year" class="form-control">
                                        <option value="">School Year</option>
                                        <?php
                                        $output = '';
                                        $result = fetch_all($connect, "SELECT * FROM $SY_TABLE "); //WHERE status = 'Inactive' 
                                        foreach ($result as $row) {
                                            $output .= '<option value="' . $row["school_year"] . '">' . $row["school_year"] . '</option>';
                                        }
                                        echo $output;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2">
                                    <select name="grade_level" id="grade_level" class="form-control">
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
                                    <select name="strand_id" id="strand_id" class="form-control" disabled>
                                        <option value="">Track</option>
                                        <?php
                                        $output = '';
                                        $result = fetch_all($connect, "SELECT * FROM $STRANDS_TABLE WHERE status = 'Active' ");
                                        foreach ($result as $row) {
                                            $output .= '<option value="' . $row["id"] . '">' . $row["strand"] . '</option>';
                                        }
                                        echo $output;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2">
                                    <select name="section_id" id="section_id" class="form-control" disabled>
                                        <option value="">Section</option>
                                    </select>
                                </div>
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

<div id="questionModal" class="modal fade" data-backdrop="static" data-keyword="false" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header bg-success" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i></h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <label>Are you sure you want to retrieve this?</label>
            </div>
            <div class="modal-footer d-flex justify-content-start">
                <button type="submit" class="btn btn-success elevation-2 pl-3 pr-3 " name="btn_yes" id="btn_yes"
                    style="border-radius: 20px;"><i class="fa fa-plus text-white"></i> Add</button>
                <button type="button" class="btn btn-danger elevation-2 pl-3 pr-3 " data-dismiss="modal"
                    style="border-radius: 20px;"><i class="fa fa-times-circle"></i> Close</button>
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

        $(document).on('click', '.button_status', function () {
            var id = $(this).attr('id');
            var status = $(this).data('status');
            var btn_action = 'update_button';
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { btn_action: btn_action, id: id, status: status },
                dataType: "json",
                success: function (data) {
                    // dataTable.ajax.reload();
                    loadData($("#school_year").val(), $("#grade_level").val(), $("#strand_id").val(), $("#section_id").val());
                }, error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });

        $("#school_year").change(function () {
            loadData(this.value, $("#grade_level").val(), $("#strand_id").val(), $("#section_id").val());
        });

        $("#grade_level").change(function () {
            if ($("#grade_level").val() > 10) {
                $("#strand_id").attr('disabled', false).val('');
                $("#section_id").attr('disabled', false);
                loadSection($("#grade_level").val(), '')
            }
            else {
                $("#strand_id").attr('disabled', true);
                $("#section_id").attr('disabled', false);
                if ($("#grade_level").val() == '') {
                    $("#section_id").attr('disabled', true);
                }
                else {
                    loadSection($("#grade_level").val(), $("#strand_id").val())
                }
            }
            loadData($("#school_year").val(), this.value, $("#section_id").val());
        });

        function loadSection(grade_level, strand_id) {
            var btn_action = 'archived_section';
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { btn_action: btn_action, grade_level: grade_level, strand_id: strand_id },
                dataType: "json",
                success: function (data) {
                    $('#section_id').html(data.section_id);
                }, error: function (e) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            });
        }

        $("#strand_id").change(function () {
            loadSection($("#grade_level").val(), $("#strand_id").val())
            loadData($("#school_year").val(), $("#grade_level").val(), this.value, $("#section_id").val());
        });

        $("#section_id").change(function () {
            loadData($("#school_year").val(), $("#grade_level").val(), $("#strand_id").val(), this.value);
        });

        loadData('', '');
        function loadData(school_year, grade_level, strand_id, section_id) {
            var btn_action = 'load_archived';
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { btn_action: btn_action, school_year: school_year, grade_level: grade_level, strand_id: strand_id, section_id: section_id },
                dataType: "json",
                success: function (data) {
                    $('#datatables').DataTable().destroy();
                    $('#datatables').html(data.table);
                    $("#datatables").DataTable({
                        // "scrollX": true, 
                        "lengthChange": true,
                        "autoWidth": false,
                        "ordering": false,
                    });
                    $('#datatables').DataTable().draw();
                }, error: function (e) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            });
        }

        var admission_no;
        $(document).on('click', '.undo', function () {
            $('#questionModal').modal('show');
            $('.modal-title').html("<i class='fa fa-undo'></i> Retrieve");
            $('#btn_yes').html("<i class='fa fa-check-circle '></i> Yes");
            admission_no = $(this).attr("id");
        });

        $("#btn_yes").click(function (e) {
            var btn_action = 'admission_undo';
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { btn_action: btn_action, admission_no: admission_no, title: 'archived' },
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        $('#questionModal').modal('hide');
                        loadData($("#school_year").val(), $("#grade_level").val(), $("#strand_id").val(), $("#section_id").val());
                    }
                    else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                }, error: function () {
                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong.'
                    });
                }
            })
        });

    });
</script>

</body>

</html>