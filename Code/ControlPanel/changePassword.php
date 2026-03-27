<?php include  "header.php"; ?>
<?php 
if(isset($_POST["btnReset"])){
    if(!UserService::_CheckPassword(UserService::UserCode(),$_POST["old-pass"])){
        AlertError("Sorry","Old password invalid");
    }else{
        $password = GeneratePassword($_POST["verify-pass"]);
        ExecuteSQL("update user set Password = '$password' where UserCode = '".UserService::UserCode()."'");
        AlertSuccessRedirect("Your password was changed","Please sign in again.","logout.php");
    }
}
?>
<div class="mat-box">
    <div class="row">
        <div class="col-md-12">
            <p>
                <h4>
                    <i class="fa fa-lock"></i>&nbsp;
                เปลี่ยนรหัสผ่าน
                </h4>
            </p>
            <br />
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">รหัสผ่านเก่า:</label>
                    <div class="col-sm-6">
                        <label class="hide">Old password</label>
                        <input type="password" class="form-control require" autocomplete="off" id="old-pass" name="old-pass" placeholder="Enter old password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">รหัสผ่านใหม่:</label>
                    <div class="col-sm-6">
                        <label class="hide">New password</label>
                        <input type="password" class="form-control require password" autocomplete="off" id="new-pass" name="new-pass" placeholder="Enter new password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">ยืนยันรหัสผ่านใหม่:</label>
                    <div class="col-sm-6">
                        <label class="hide">Verify password</label>
                        <input type="password" class="form-control require verify-password" autocomplete="off" id="verify-pass" name="verify-pass" placeholder="Enter verify new password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-6">
                        <button type="submit" name="btnReset" onclick="return CustomerChangePassword(this);" id="btnReset" class="btn btn-primary">Submit</button>
                    </div>
                    <script>
                        function CustomerChangePassword(sender) {
                            return Validate(sender);
                        }
                    </script>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include  "footer.php"; ?>