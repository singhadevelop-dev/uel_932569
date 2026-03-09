<?php 

error_reporting(0);

function CleanMessage($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}


function GetGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid =  substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
        return $uuid;
    }
}

function UploadFile($file,$target_dir)
{
    $guid = GetGUID();
    $target_root = __DIR__;
    $target_file = $target_dir . basename($file["name"]);
    $target_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
    $target_file_name = $guid .".".$target_file_type;
    $target_file_save = $target_root.$target_dir.$target_file_name;
    
    if (!file_exists($target_root.$target_dir)) {
        mkdir($target_root.$target_dir, 0777, true);
    }
    
    $uploaded = move_uploaded_file($file["tmp_name"], $target_file_save);
    chmod($target_file_save, 0777);
    if ($uploaded) {
        return $target_file_save;
    } else {
        return false;
    }
}

function sheetData($sheet) {
    
    $data = array();
    $x = 1;
    while($x <= $sheet['numRows']) {
        $cellData = array();
        $y = 1;
        while($y <= $sheet['numCols']) {
            $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
            array_push($cellData,$cell);
            $y++;
        }  
        $x++;
        array_push($data,$cellData);
    }
    
    return $data; 
}

try{
    
    
    
    
    $importFile = $_FILES["import-excel-uploader"];
    $tempFile = UploadFile($importFile,"/temp/");
    //sleep(5);
    
    if($tempFile != false){
        
        //require_once 'writer/PHPExcel/IOFactory.php';
        
        //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
        
        
        //$objPHPExcel = $objReader->load($tempFile);
        
        //$sheet = $objPHPExcel->getSheet(0);
        //$highestRow = $sheet->getHighestRow(); 
        //$highestColumn = $sheet->getHighestColumn();
        //$data = array();
        
        ////  Loop through each row of the worksheet in turn
        //for ($row = 4; $row <= $highestRow; $row++){ 
        //    //  Read a row of data into an array
        //    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
        //                                    NULL,
        //                                    TRUE,
        //                                    FALSE);
        //    if(count($rowData) > 0){
        //        $rowData = $rowData[0];
        //        array_push($data,$rowData);
        //    }
        //}
        
        
        //$A1 = $sheet->getCell('A1',false)->getValue();
        
        
        require('reader/SpreadsheetReader.php');
        $Reader = new SpreadsheetReader($tempFile);
        
        $dataExcel = array();
        foreach ($Reader as $row)
        {
            array_push($dataExcel,$row);
        }
        
        $data = array();
        for ($i = 4; $i <= count($dataExcel); $i++)
        {
            $arrJ = array();
        	for ($j = 0; $j < count($dataExcel[$i]); $j++)
            {
                array_push($arrJ,$dataExcel[$i][$j]);
            }
            array_push($data,$arrJ);
        }
        
        $A1 = $dataExcel[0][0];
        
        
        
        if($A1 != "ImportTicket-xlsx-zsx22ii8k1q&Tx"){
            throw new Exception("[E01] Please upload only Excel Template File that you download form step 1.");
        }
        else if(count($data) > 0 && count($data[0]) < 20){
            throw new Exception("[E02] Please upload only Excel Template File that you download form step 1.");
        }
        else if(count($data) == 0){
            throw new Exception("[E03] Please fill in data.");
        }
        
        $result = array(
            "result" => "S",
            "message" => "",
            "data" => $data
        );
        
        echo json_encode($result);
    }
}
catch(Exception $ex){
    $result = array(
        "result" => "E",
        "message" => $ex->getMessage(),
        "data" => "[]"
    );
    
    echo json_encode($result);
}

?>