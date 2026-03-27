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
                $memberCode = BookingCreate($_POST);
                $abst->OK("Post success.",$memberCode);
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function BookingCreate($data)
{
    $name = $data["name"];
    $phone = $data["phone"];
    $email = $data["email"];
    $amount = $data["amount"];
    $adult = $data["adult"];
    $child = $data["child"];
    $message = $data["message"];
    $productCode = $data["product"];
    $productRefCode = $data["refcode"];
    
    $subject = "";
    $company = "";
    $memberCode = GenerateNextID("member","MemberCode",10,"M");
    $sql = "insert into member(MemberCode,MemberType,MemberName, Email,Phone,Subject,Company,Message
        ,ProductCode,ProductRefCode,Amount,Adult,Child,Picked,CreatedOn) 
    values ('$memberCode',
            'BOOKING',
            '$name',
            '$email',
            '$phone',
            '$subject',
            '$company',
            '$message',
            '$productCode',
            '$productRefCode',
             $amount,
             $adult,
             $child,
             0,
            Now())
    ";
    ExecuteSQL($sql);
    return $memberCode;

}

?>