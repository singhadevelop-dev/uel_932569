<?php 
include_once "../../_cogs.php";
include "../assets/b4w-framework/UtilService.php";
libxml_use_internal_errors(true);

try {
    $action = $_SERVER['REQUEST_METHOD'];
    switch($action)
    {
        case "POST" :
            if($_POST["action"] == "NEW"){
                $result = updateNew($_POST);
            }else  if($_POST["action"] == "ACTIVE"){
                $result = updateActive($_POST);
            }else  if($_POST["action"] == "UPLOAD"){
                $result = uploadProduct($_POST);
            }else{
                throw new Exception("Not allowed function!");
            }
            OK("Post success.",$result);
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    BadRequest($e->getMessage(),null);
}

function updateNew($data)
{
    $sql = "update product set New=".$data["new"]." where ProductCode='". $data["product"] ."' ";
    ExecuteSQL($sql);
    return $data;
}

function updateActive($data)
{
    $sql = "update product set Active=".$data["active"]." where ProductCode='". $data["product"] ."' ";
    ExecuteSQL($sql);
    return $data;
}

function uploadProduct($data){

    $productRefCode = trim($data["code"]);
    $productname = $data["name"];
    $category = $data["cat"];
    $oldPrice = !empty($data["old"]) ? doubleval($data["old"]) : 0;
    $price = !empty($data["price"]) ? doubleval($data["price"]) : 0;
    $new = $data["new"] == 1 ? 1 : 0;
    $rank = !empty($data["rank"]) ? intval($data["rank"]) : 0;
    // $detail1 = GeneratePageFile($data["detail1"]);
    // $detail2 = GeneratePageFile($data["detail2"]);

    $d = SelectRow("select ProductCode from product where ProductRefCode='$productRefCode'");
    $productCode = $d["ProductCode"];
    if(!empty($productCode)){
        
        $detail1 = GeneratePageFile('<p>'.$data["detail1"].'</p>',$productCode."-HTMLDETAIL-1");
        $detail2 = GeneratePageFile('<p>'.$data["detail2"].'</p>',$productCode."-HTMLDETAIL-2");
        $sql = "update product set 
            ProductRefCode='".REP_SG($productRefCode)."',
            ProductName='".REP_SG($productname)."',
            CategoryCode='".REP_SG($category)."',
            OldPrice='$oldPrice',
            Price='$price',
            New='$new',
            Rank='$rank',
            ProductDetail='$detail1',
            ProductDetail2='$detail2',
            Active=1,
            UpdatedOn=now()
            where ProductCode='$productCode'
        ";
    }else{
        $productCode = GenerateNextID("product","ProductCode",5,"P");
        $detail1 = GeneratePageFile('<p>'.$data["detail1"].'</p>',$productCode."-HTMLDETAIL-1");
        $detail2 = GeneratePageFile('<p>'.$data["detail2"].'</p>',$productCode."-HTMLDETAIL-2");
        $sql = "
            insert into product(ProductCode, ProductRefCode, ProductName, CategoryCode, OldPrice, Price, 
            New, Rank, ProductDetail, ProductDetail2, Active,
            CreatedOn, CreatedBy, UpdatedOn, UpdatedBy) 
            values (
                '$productCode',
                '".REP_SG($productRefCode)."',
                '".REP_SG($productname)."',
                '".REP_SG($category)."',
                '$oldPrice',
                '$price',
                '$new',
                '$rank',
                '$detail1',
                '$detail2',
                1,now(),'UPLOAD',now(),''
            )";
    }
    ExecuteSQL($sql);
    return array(
        "id" => $productCode,
        "code" => $data["code"],
        "name" => $data["name"]
    );
}

function REP_SG($input){
    return str_replace("\"","",str_replace("'","’",$input));
}

#region PROPERTIES FOR POST

    function OK($message,$result)
    {
        PrivateResponse("OK",200,$message,$result);
    }

    function BadRequest($message,$result)
    {
        PrivateResponse("BadRequest",200,$message,$result);
    }

    function PrivateResponse($status,$status_number,$message,$result)
    {
        header_remove();
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($status_number);
        $dt = new DateTime("now", new DateTimeZone("Asia/Bangkok"));
        $post_data = array(
            'status' => $status,
            'message' => $message,
            'result' => $result,
            'result_time' => $dt->format(DATE_ISO8601));
        echo json_encode($post_data,JSON_UNESCAPED_UNICODE);
    }

#endregion

?>
