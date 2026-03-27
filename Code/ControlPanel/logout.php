<?php session_start(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
</head>
<body>
    <?php  
    include_once "../_cogs.php";
    session_destroy();   
    ?>
    <script>
        location.href = '<?php echo $GLOBALS["ROOT"] ?>/ControlPanel/login.php';
    </script>
</body>
</html>
