<?php
include "UtilService.php";
try{
    $table = $_POST["table"];
    $column_seq = $_POST["column_seq"];
    $column_key = $_POST["column_key"];
    $row_key_array = $_POST["row_key_array"];
    $start = !empty($_POST["start"]) ? intval($_POST["start"]) : 0;
    if($start < 0){
        $start = 0;
    }
    $arrSql = array();
    $countItem = count($row_key_array);
    for ($i = 0; $i < $countItem; $i++)
    {
    	$row_key = $row_key_array[$i];
        array_push($arrSql,"update $table set $column_seq = '$start' where $column_key = '$row_key'");
        $start++;
    }
    if($countItem > 0){
        ExecuteMultiSQL(join(";  ",$arrSql));
    }
    echo "S";
}
catch(Exception $ex){
    echo $ex->getMessage();
}
?>