<?php 
include ("../connection.php");

function CleanMessage($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}


try{
    
    $dataJson = strval($_POST["saveData"]);
    $dataArray = json_decode($dataJson,true);
    
    $countAll = countval($dataArray);
    $countInsert = 0;
    $countUpdated = 0;
    $countIgnore = 0;
    $countError = 0;
    
    for ($i = 0; $i < countval($dataArray); $i++)
    {
    	$state =  $dataArray[$i]["state"];
        if($state == 1){
            $row = $dataArray[$i]["data"];
            $sqlSelect = "select * from promotion_code where code = '".$row[3]."'";
            $selectedData = SelectRowsArray($sqlSelect);
            
            $sqlTransaction = "";
            
            $isNew = false;
            if(countval($selectedData) > 0){
                $sqlTransaction = "update promotion_code set
                                    first_name = '".$row[0]."'
                                    ,last_name = '".$row[1]."'
                                    ,discount_price = '".$row[2]."'
                                    where code = '".$row[3]."'";
            }else{
                $sqlTransaction = "insert into promotion_code (first_name,last_name,discount_price,code,used) 
                                        values('".$row[0]."','".$row[1]."','".$row[2]."','".$row[3]."','0')";
                $isNew = true;
            }
            
            $query = ExecuteSQL($sqlTransaction);
            if($query !== false){
                if($isNew){
                    $countInsert++;
                }
                else{
                    $countUpdated++;
                }
            }
            else{
                $countError++;
            }
        }
        else{
            $countIgnore++;
        }
    }
    
        
    $result = array(
        "result" => "S",
        "message" => "Saved data successfully (Created ".$countInsert." rows ,Updated ".$countUpdated." rows ,Ignore ".$countIgnore." rows ,Error ".$countError." rows)",
    );
    
    echo json_encode($result);
}
catch(Exception $ex){
    $result = array(
        "result" => "E",
        "message" => CleanMessage($ex->getMessage()),
    );
    
    echo json_encode($result);
}

function countval($val){
    return isset($val) ? count($val) : 0;
}

?>