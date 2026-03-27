<?php
include_once "../../../../_cogs.php";
include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php";
include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/api/AbstractAPI.php";
libxml_use_internal_errors(true);
$abst = new AbstractAPI();
$_CLIENTCODE_REF = UserService::UserCode();
try {
    if(!UserService::_IsCustomer()){
        throw new Exception("Not access,please signin system!");
    }
    $action = $_SERVER['REQUEST_METHOD'];
    switch($action)
    {
        case "POST" :
            DeliveryAddressClientUpdate($_CLIENTCODE_REF,$_POST);
            $abst->OK($result,"");
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function DeliveryAddressClientUpdate($userid,$data)
{
    $sql = "update client set 
     delivery_name='".$data["delivery_name"]."'
    ,delivery_phone='".$data["delivery_phone"]."'

    ,delivery_province='".$data["delivery_province"]."'
    ,delivery_prefecture='".$data["delivery_prefecture"]."'
    ,delivery_district='".$data["delivery_district"]."'
    ,delivery_postalnumber='".$data["delivery_postalnumber"]."'

    ,opt_delivery_province='".$data["opt_delivery_province"]."'
    ,opt_delivery_prefecture='".$data["opt_delivery_prefecture"]."'
    ,opt_delivery_district='".$data["opt_delivery_district"]."'
    ,opt_delivery_postalnumber='".$data["opt_delivery_postalnumber"]."'

    ,delivery_other='".$data["delivery_other"]."'
    where ClientCode='$userid' ";
    ExecuteSQL($sql);
}


?>