<?php 
include_once "../../../_cogs.php";
include_once  "../../assets/b4w-framework/UtilService.php";
include_once  "../AbstractAPI.php";
libxml_use_internal_errors(true);
$abst = new AbstractAPI();
try {
    
    $action = $_SERVER['REQUEST_METHOD'];
    switch($action)
    {
        case "POST" :
            if($_POST["action"] == "REGISTER"){
                $memberCode = RegisterMemberContact($_POST);
                $abst->OK("Register success.",$memberCode);
            }else if($_POST["action"] == "SUBSCRIBE"){
                $memberCode = ContactServiceCreate($_POST);
                $abst->OK("Contact Service success.",$memberCode);
            }else if($_POST["action"] == "SAMPLE"){
                $memberCode = SampleMemberContact($_POST);
                $abst->OK("Save success.",$memberCode);
            }
            else
            {
                $memberCode = ContactMemberCreate($_POST);
                $abst->OK("Post success.",$memberCode);
            }
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function ContactMemberCreate($data)
{
    $subject = $data["subject"];
    $name = $data["first_name"];
    $name2 = $data["last_name"];
    $email = $data["email"];
    $phone = $data["phone"];
    $company = $data["company"];
    $message = $data["message"];
    $address = $data["address"];
    $gender = $data["gender"];
    $memberCode = GenerateNextID("member","MemberCode",10,"M");
    $sql = "insert into member(MemberCode,MemberType,MemberName,MemberName2, Email,Phone,Subject,Company,Address,Message,Gender,Picked,CreatedOn) 
    values ('$memberCode',
            'CONTACT',
            '$name',
            '$name2',
            '$email',
            '$phone',
            '$subject',
            '$company',
            '$address',
            '$message',
            '$gender',
            0,
            Now())
    ";
    ExecuteSQL($sql);
    SendEmailContact($memberCode);
    return $memberCode;

}

function RegisterMemberContact($data)
{
    $subject = $data["subject"];
    $name = $data["first_name"];
    $name2 = $data["last_name"];
    $email = $data["email"];
    $phone = $data["phone"];
    $company = $data["company"];
    $department = $data["department"];
    $productrefcode = $data["productrefcode"];
    $message = $data["message"];
    $product = $data["productcode"];
    $paymentamount = $data["paymentamount"];
    $memberCode = GenerateNextID("member","MemberCode",10,"R");
    $sql = "insert into member(MemberCode,MemberType,MemberName,MemberName2, Email,Phone,Subject,Message,Company,Department,Picked,CreatedOn
    ,ProductCode ,ProductRefCode ,PaymentAmount) 
    values ('$memberCode',
            'REGISTER',
            '$name',
            '$name2',
            '$email',
            '$phone',
            '$subject',
            '$message',
            '$company',
            '$department',
            0,
            Now()
            ,'$product'
            ,'$productrefcode'
            ,'$paymentamount'
            )
    ";
    ExecuteSQL($sql);
    SendEmailRegister($memberCode);
    //SendEmailContactRefProduct($memberCode,$productrefcode,true);
    return $memberCode;
}

function SampleMemberContact($data)
{
    $subject = $data["subject"];
    $name = $data["first_name"];
    $name2 = $data["last_name"];
    $email = $data["email"];
    $phone = $data["phone"];
    $message = $data["message"];
    $product = $data["productcode"];
    $company = $data["company"];
    $department = $data["department"];
    $productrefcode = $data["productrefcode"];
    $paymentamount = $data["paymentamount"];
    $checkout = $data["checkout"];
    $paymenttime = $data["paymenttime"];

    $memberCode = GenerateNextID("member","MemberCode",10,"E");
    $sql = "insert into member(MemberCode,MemberType,MemberName,MemberName2, Email,Phone,Subject,Message,Company,Department,Picked,CreatedOn
    ,ProductCode ,ProductRefCode ,PaymentAmount,CheckOutCode,PaymentTime ) 
    values ('$memberCode',
            'SAMPLE',
            '$name',
            '$name2',
            '$email',
            '$phone',
            '$subject',
            '$message',
            '$company',
            '$department',
            0,
            Now()
            ,'$product'
            ,'$productrefcode'
            ,'$paymentamount'
            ,'$checkout'
            ,'$paymenttime'
            )
    ";
    ExecuteSQL($sql);
    SendEmailContactRefProduct($memberCode,$productrefcode,false);
    return $memberCode;
}

function ContactServiceCreate($data)
{
    $subject = $data["subject"];
    $name = "";
    $email = $data["email"];
    $phone = $data["phone"];
    $memberCode = GenerateNextID("member","MemberCode",10,"S");
    $sql = "insert into member(MemberCode,MemberType,MemberName, Email,Phone,Subject,Picked,CreatedOn) 
    values ('$memberCode',
            'SUBSCRIBE',
            '$name',
            '$email',
            '$phone',
            '$subject',
            0,
            Now())
    ";
    ExecuteSQL($sql);
    SendEmailContact($memberCode);
    return $memberCode;
}


?>