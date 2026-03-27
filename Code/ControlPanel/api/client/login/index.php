<?php
include_once "../../../../_cogs.php";
include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php";
include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/api/AbstractAPI.php";
libxml_use_internal_errors(true);
$abst = new AbstractAPI();
try {
    $action = $_SERVER['REQUEST_METHOD'];
    switch($action)
    {
        case "POST" :
            $loginType = $abst->GetParam("login_type");
            if($loginType == "facebook")
            {
                $name = $abst->GetParam("name");
                $userid = $abst->GetParam("userid");
                $image = $abst->GetParam("image");
                $accessToken = $abst->GetParam("accessToken");
                if(empty($userid) || empty($name) || empty($accessToken))
                {
                    throw new Exception("เกิดข้อผิดพลาด, กรุณาตรวจสอบชื่อผู้ใช้หรือรหัสผ่าน!");
                }
                if(empty(UserService::UserCode())){
                    $_TEMP_COOKIE_CLIENT = GetCookieClientID();
                }
                RegisterClientLoginFacebook($userid,$accessToken,$name,$image);
                $result = "Logged into your webpage and Facebook.";
                $sqlUpdate = "update cart set ClientID='".UserService::UserCode()."'  where Active = 1 and ClientID = '$_TEMP_COOKIE_CLIENT'";
			    ExecuteSQL($sqlUpdate);
            }
            else
            {
                $email = $abst->GetParam("user");
                $pass = $abst->GetParam("pass");
                $stutus = UserService::_CustomerLogin($email,$pass,true);
                if(!$stutus)
                {
                    throw new Exception("เกิดข้อผิดพลาด, กรุณาตรวจสอบชื่อผู้ใช้หรือรหัสผ่าน!");
                }
                $result = "เข้าสู่ระบบสำเร็จ.";
            }
            $abst->OK($result,"");
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function RegisterClientLoginFacebook($userid,$accessToken,$name,$image)
{
    $selectSub = SelectRowsArray(" select ClientCode,ClientFacebookID FROM client WHERE  ClientFacebookID='$userid' limit 1 ");
    if(count($selectSub) <= 0)
    {
        $ClientCode = GenerateNextID("client","ClientCode",10,"C");
        //$password = GeneratePassword($pass = "");
        $sql = "insert into client (ClientCode,ClientFacebookID,AccessTokenFacebook, Name, UserName, Password, Email,Phone, Image
        , CreatedOn, CreatedBy, UpdatedOn, UpdatedBy, Active, Register)
         VALUES ('$ClientCode','$userid','$accessToken','$name','','','','','$image'
         ,NOW(),'',NOW(),'',1,0) ";
         ExecuteSQL($sql);
    }
    else if($userid === $selectSub[0]["ClientFacebookID"])
    {
        $ClientCode = $selectSub[0]["ClientCode"];
    }
    else
    {
        throw new Exception("sign in failed, Please check verify your facebook!");
    }
    UserService::_ReCustomerLogin($ClientCode);
}


?>