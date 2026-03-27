<?php 
$_ALLOW_SESSION = true;
include_once "../_cogs.php";
include_once  $GLOBALS["DOCUMENT_ROOT"]."/ControlPanel/assets/b4w-framework/UtilService.php"; 
?>

<html lang="en">
<head>
    <title>Login - Website & Application Control Panel</title>
    <?php include  $GLOBALS["DOCUMENT_ROOT"]."/ControlPanel/assets/b4w-framework/IncludeLibrary.php"; ?>
</head>
<body>
    <?php 
    if(isset($_POST["btnLogin"]))
    {
        UserService::_UserLogin($_POST["inputUserName"],$_POST["inputPassword"]);
    }
    ?>
    <style>
        .form-signin {
            width: 100%;
            margin: 50px auto;
        }
        @media(min-width:768px) {
            .form-signin {
                width: 350px;
            }
        }
    </style>
    <div class="container">
        <form class="form-signin" method="post">
            <h5 class="text-danger"><?php echo SelectRow("select * from website")["WebName"]; ?></h5>
            <h2 class="text-warning" style="margin-top: 0; margin-bottom: 20px;">Control Panel</h2>
            <label for="inputUserName" class="sr-only">Username</label>
            <input type="text" id="inputUserName" name="inputUserName" class="form-control" placeholder="Username" required autofocus>
            <br />
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
            <br />
            <input type="submit" name="btnLogin" id="btnLogin" value="เข้าสู่ระบบ" class="btn btn-lg btn-success btn-block" />
        </form>
    </div>
    <!-- /container -->
</body>
</html>
