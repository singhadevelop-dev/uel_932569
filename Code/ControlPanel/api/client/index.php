<?php
include_once "../../../_cogs.php";
include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php";
include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/api/AbstractAPI.php";
libxml_use_internal_errors(true);
$abst = new AbstractAPI();
try {
    $method = $_SERVER['REQUEST_METHOD'];
    $action = $abst->GetParam("action");
    switch($method)
    {
        case "POST" :
            if($action == "UPDATE"){
                $ClientCode = GetCookieClientID();
                UpdateClient($ClientCode,$_POST);
                $abst->OK("Update success.",null);
            }else{
                $fullName = $abst->GetParam("name");
                $email = $abst->GetParam("email");
                $phone = $abst->GetParam("phone");
                $pass = $abst->GetParam("pass");
                $result = RegisterClient($fullName,$email,$phone,$pass);
                $abst->OK("Register $phone success.",$result);
            }
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function RegisterClient($fullName,$email,$phone,$pass)
{
    if(strlen($pass) < 6)
    {
        throw new Exception("Password is less than 6 degit");
    }

    if(!empty($email)){
        $selectSub = SelectRowsArray(" select Email FROM client WHERE  Email='$email' ");
        if(count($selectSub) > 0)
        {
            throw new Exception("Email : $email is already register to list web");
        }
    }
    $selectSub = SelectRowsArray(" select Email FROM client WHERE  Phone='$phone' ");
    if(count($selectSub) > 0)
    {
        throw new Exception("Phone : $phone is already register to list web");
    }

    $ClientCode = GenerateNextID("client","ClientCode",10,"C");
    $password = GeneratePassword($pass);
    $sql = "insert into client (ClientCode, Name, UserName, Password, Email,Phone, Image
    , CreatedOn, CreatedBy, UpdatedOn, UpdatedBy, Active, Register
    ,delivery_name,delivery_phone,delivery_province,delivery_district,delivery_postalnumber,delivery_other)
     VALUES ('$ClientCode','$fullName','$phone','$password','$email','$phone',''
     ,NOW(),'',NOW(),'',1,0,'$fullName','$phone','','','','') ";
     ExecuteSQL($sql);
}

function UpdateClient($ClientCode,$data){

    $email = $data["delivery_email"];
    if(!empty($email)){
        $selectSub = SelectRowsArray(" select Email FROM client WHERE  Email='$email' and ClientCode <> '$ClientCode' ");
        if(count($selectSub) > 0)
        {
            throw new Exception("Email : $email is already register to list web");
        }
    }

    $phone = $data["delivery_phone"];
    if(empty($phone)){
        throw new Exception("Phone : $phone not be null");
    }
    $selectSub = SelectRowsArray(" select Email FROM client WHERE  Phone='$phone' and ClientCode <> '$ClientCode' ");
    if(count($selectSub) > 0)
    {
        throw new Exception("Phone : $phone is already register to list web");
    }

    $sql = "update client set
     Name='".$data["delivery_name"]."'
    ,Phone='$phone'
    ,Email='$email'

    ,delivery_name='".$data["delivery_name"]."'
    ,delivery_phone='$phone'
    ,delivery_other='".$data["delivery_other"]."'
    ,delivery_district='".$data["delivery_district"]."'
    ,delivery_prefecture='".$data["delivery_prefecture"]."'
    ,delivery_province='".$data["delivery_province"]."'
    ,delivery_postalnumber='".$data["delivery_postalnumber"]."'

    ,opt_delivery_district='".$data["delivery_district"]."'
    ,opt_delivery_prefecture='".$data["delivery_prefecture"]."'
    ,opt_delivery_province='".$data["opt_delivery_province"]."'
    ,opt_delivery_postalnumber='".$data["delivery_postalnumber"]."'

    ,UpdatedOn=now()
    ,UpdatedBy='$ClientCode'
    where ClientCode='$ClientCode' ";
    ExecuteSQL($sql);
}


?>