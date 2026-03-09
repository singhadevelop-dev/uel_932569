<?php 
include_once "../../../_cogs.php";
include_once  "../../assets/b4w-framework/UtilService.php";
include_once  "../AbstractAPI.php";
libxml_use_internal_errors(true);
$abst = new AbstractAPI();
try {
    if(!UserService::_IsAdmin()){
        new Exception("Not allowed function!");
    }
    $method = $_SERVER['REQUEST_METHOD'];
    $user_id = UserService::UserCode();
    switch($method)
    {
        case "POST" :
            if($_POST["action"] == "UPDATE_STATUS"){
                $checkOutCode = UpdateCheckoutStatus($_POST,$user_id);
                $abst->OK("อัพเดตสถานะสำเร็จแล้ว.",$checkOutCode);
            }
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function UpdateCheckoutStatus($data,$user_id)
{
    $ponumber = $data["ponumber"];
    $status = $data["status"];
    $sql = " update checkout set
        StatusCode = '$status', UpdatedOn=now(), UpdatedBy='$user_id'
        where CheckOutCode = '$ponumber' ";
    ExecuteSQL($sql);
    return $ponumber;

}

?>