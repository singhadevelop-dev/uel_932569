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
            $questionCode = QuestionFormCreate($_POST);
            $abst->OK("Post success.",$questionCode);
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function QuestionFormCreate($data)
{
    $questionCode = GenerateNextID("question","QuestionCode",10,"A");
    $subject = $data["option01"];
    $gender = $data["option02"];
    $age = intval($data["txtAge"]);
    $color = $data["option03"];
    $hobby = $data["option04"];
    $style = $data["option05"];
    $material = $data["option06"];
    $room = $data["option07"];
    

    $decisionsCode = $data["txt_QUESTION08"];
    $decisionsNumebr = $data["ddl_QUESTION08"]; 
    $priorityCode = $data["txt_QUESTION09"];
    $priorityNumebr = $data["ddl_QUESTION09"]; 

    $travel = $data["option10"];
    $area = $data["txtArea"];
    $budget = $data["ddlBudgetSelect"];
    $process = $data["ddlTimeSelect"];
    $nice2Meet = $data["option14"];
    
    $sql = "
        insert into question(QuestionCode, Objective, Gender, Age, Color, Hobby, Style, Material, Room, Travel, Area, Budget, Process, Nice2Meet, Picked, CreatedOn, CreatedBy) 
        values (
            '$questionCode',
            '$subject',
            '$gender',
            $age,
            '$color',
            '$hobby',
            '$style',
            '$material',
            '$room',
            '$travel',
            '$area',
            '$budget',
            '$process',
            '$nice2Meet',
            0,
            now(),
            '".UserService::UserCode()."'
        )
    ";
    ExecuteSQL($sql);

    $sqlItem = array();
    $index = 0;
    foreach ($decisionsCode as $code) {
        $value = $decisionsNumebr[$index];
        array_push($sqlItem,"insert into question_item(QuestionCode, ItemType, ItemCode, ItemValue) 
        VALUES ('$questionCode','DECISION','$code','$value')");
        $index++;
    }
    $index = 0;
    foreach ($priorityCode as $code) {
        $value = $priorityNumebr[$index];
        array_push($sqlItem,"insert into question_item(QuestionCode, ItemType, ItemCode, ItemValue) 
        VALUES ('$questionCode','PRIORITY','$code','$value')");
        $index++;
    }
    if(count($sqlItem) > 0){
        ExecuteMultiSQL(join(";",$sqlItem));
    }
    return $questionCode;

}

?>