<?php
$_ALLOW_SESSION = true;
include_once "../UtilService.php";

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once 'writer/PHPExcel.php';
require_once 'writer/PHPExcel/IOFactory.php';

$refPath = "/b4w-framework/excel_upload_util/";
$newFilePath = "temp_download/".GetGUID().".xlsx";

$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load($refPath."Import Payslip.xlsx");

$sql = "select emp.*,p.PositionName,d.DepartmentName,c.CompanyName 
    ,(
        select count(ApproverCode) as xCount from 
        employee_approver ap where ap.sid = emp.sid
        and ap.EmployeeCode = emp.EmployeeCode
    ) as xCount
    from employee emp
    left join position p on emp.SID = p.sid and emp.PositionCode = p.PositionCode
    left join department d on emp.SID = d.sid and emp.DepartmentCode = d.DepartmentCode
    left join company c on emp.SID = c.sid and emp.CompanyCode = c.CompanyCode
    where emp.Active = 1 and emp.SID = '".UserService::SID()."' and emp.ActiveAccount = 1 
    and emp.EmployeeCode <> 'ADM000'
    order by EmployeeCode";
                   
$datas = SelectRowsArray($sql);

$year = GetCurrentYearServer();
$month = intval(GetCurrentMonthServer());
$xDay = GetCurrentDayServer();
if(intval($xDay) < 5){
    $month = $month - 1;
}

$month = str_pad(strval($month),2,"0",STR_PAD_LEFT);

$objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('D3', $year)
           ->setCellValue('E3', $month);

$rowIndex = 4;
foreach ($datas as $data) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$rowIndex, $data["EmployeeCode"])
            ->setCellValue('C'.$rowIndex, $data["TitleEN"].".".$data["FirstNameEN"]." ".$data["LastNameEN"])
            ->setCellValue('D'.$rowIndex, $year)
            ->setCellValue('E'.$rowIndex, $month);
    
    $rowIndex++;
}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($refPath.$newFilePath);

$EXCEL_TEMPLATE_URL =  "/b4w-framework/excel_upload_util/$newFilePath";
$EXCEL_TEMPLATE_NAME = "Import Data Form-".GetCurrentDateServer().".xlsx";

