<?php
include_once "../../../_cogs.php";
include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php";
include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/api/AbstractAPI.php";
libxml_use_internal_errors(true);
$abst = new AbstractAPI();
try {
    $action = $_SERVER['REQUEST_METHOD'];
    switch($action)
    {
        case "POST" :
            $result = PaymentPOClient(UserService::UserCode(),$_POST);
            $abst->OK("Payment nofication success.",$result);
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function PaymentPOClient($clientCode,$data)
{
    
    $checkOutCode = strip_tags(trim($data["PaymentNumber"]));
    $paymentAmount = strip_tags(trim($data["PaymentAmount"]));
    $paymentDateTime = strip_tags(trim($_POST["PaymentDate"]));

    $datas = SelectRowsArray("select * from checkout where CheckOutCode='$checkOutCode' and ClientID='$clientCode' ");
    if(count($datas) <= 0)
    {
        throw new Exception("ไม่พบเลขที่ใบสั่งซื้อ ".$checkOutCode." ในระบบ! ");
    }
    if(!empty($datas[0]["StatusCode"]) && !($datas[0]["StatusCode"] == "WAITING" || $datas[0]["StatusCode"] == "CHECKPAID")){
        throw new Exception("ไม่สามรถแจ้งได้เนื่องจาก เอกสารอยู่ในสถานะ ".GetPOStatusDesc($datas[0]["StatusCode"])."! ");
    }
    
    $arrDate = explode(" ",$paymentDateTime);
    $txtDate = $arrDate[0];
    $txtTime = trim(str_replace($txtDate,"",$paymentDateTime));

    $txtFirstName = $datas[0]["Name"];
    $txtLastName = "";
    $Email = $datas[0]["Email"];
    $Phone = $datas[0]["Phone"];
    $Address = $datas[0]["Address"];
    $txtAmount = $paymentAmount;
    $txtProductName = "";
    $ddlBankCode = "";
    
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/".strtolower($checkOutCode)."/";
    $fileUploaded = $_FILES["fileUpload"];
    if(!empty($fileUploaded["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($_FILES["fileUpload"],$uploadFileTarget,$checkOutCode);
    }else{
        $fileUploadedPath = "";
    }


    $memberCode = GenerateNextID("member", "MemberCode", 10, "M");
    $sqlInsert = "insert into member (MemberCode,MemberType,MemberName,MemberName2,Email,Phone,LineID,Subject,Message,CreatedOn
        ,CheckOutCode,BankCode,PaymentDate,PaymentTime,PaymentAmount,Picture,Address)
        VALUES(
            '$memberCode',
            'PAYMENT',
            '$txtFirstName',
            '$txtLastName',
            '$Email','$Phone','',
            '',
            '$txtProductName',
            NOW(),
            '$checkOutCode',
            '$ddlBankCode',
            '$txtDate',
            '$txtTime',
            '$txtAmount',
            '$fileUploadedPath',
            '$Address'
        );";

    ExecuteSQL($sqlInsert);
    $_payment_date = ConvertDateTimeDisplayToDateTimeDB($paymentDateTime.":00");
    ExecuteSQL("update checkout set StatusCode='CHECKPAID' , PaymentDate='$_payment_date' where CheckOutCode='$checkOutCode' ");
    SendEmailContact($memberCode);
    return $memberCode;
}

?>