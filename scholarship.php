<?php

include('config.php');

if(!isset($_SESSION["user_type"]))
{
    header("location:index.php");
}

$title = 'Scholarship';
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

    });
</script>

</body>
</html>