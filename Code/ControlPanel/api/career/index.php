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
            $careerCode = CareerMemberCreate($_POST,$_FILES);
            $abst->OK("Post success.",$careerCode);
            break;
        default : 
            throw new Exception("Not allowed function!");
    }
} catch (Exception $e) {
    $abst->BadRequest($e->getMessage(),null);
}

function CareerMemberCreate($data,$file)
{
    $position = $data["txtPosition"];
    $salary = $data["txtSalary"];
    $name = $data["txtName"];
    $last_name = $data["txtLastName"];
    $height = $data["txtHeight"];
    $weight = $data["txtWeight"];
    $IDCard = $data["txtIDCard"];
    $birthday = $data["txtBirthday"];
    $age = $data["txtAge"];
    $skinColor = $data["txtSkinColor"];
    $race = $data["txtRace"];
    $nationality = $data["txtNationality"];
    $religion = $data["txtReligion"];
    $houseNumber = $data["txtHouseNumber"];
    $phone = $data["txtPhone"];
    $email = $data["txtEmail"];
    $lineid = $data["txtLineID"];
    $houseRegistration = $data["txtHouseRegistration"];
    $maritalStatus = $data["txtMaritalStatus"];
    $father = $data["txtFather"];
    $fatherStatus = $data["txtFatherStatus"];
    $fatherAge = $data["txtFatherAge"];
    $fatherAddress = $data["txtFatherAddress"];
    $fatherCareer = $data["txtFatherCareer"];
    $fatherPhone = $data["txtFatherPhone"];
    $mother = $data["txtMother"];
    $motherStatus = $data["txtMotherStatus"];
    $motherAge = $data["txtMotherAge"];
    $motherAddress = $data["txtMotherAddress"];
    $motherCareer = $data["txtMotherCareer"];
    $motherPhone = $data["txtMotherPhone"];
    $university = $data["txtUniversity"];
    $year = $data["txtYear"];
    $faculty = $data["txtFaculty"];
    $major = $data["txtMajor"];
    $score = $data["txtScore"];
    $englishSkill = $data["txtEnglishSkill"];
    $languageSkill = $data["txtLanguageSkill"];
    $computerSkill = $data["txtComputerSkill"];
    $keyboardThai = $data["txtKeyboardThai"];
    $keyboardEnglish = $data["txtKeyboardEnglish"];
    $car = $data["txtCar"];
    $driverLicense = $data["txtDriverLicense"];
    $oldCompany = $data["txtOldCompany"];
    $oldPosition = $data["txtOldPosition"];
    $oldSalary = $data["txtOldSalary"];
    $oldWorkingTime = $data["txtOldWorkingTime"];
    $oldReason = $data["txtOldReason"];
    $currentCompany = $data["txtCurrentCompany"];
    $adviser = $data["txtAdviser"];
    $adviserRelationship = $data["txtAdviserRelationship"];
    $adviserWorkplace = $data["txtAdviserWorkplace"];
    $adviserAddress = $data["txtAdviserAddress"];
    $adviserPhone = $data["txtAdviserPhone"];
    $startWork = $data["txtStartWork"];
    $message = $data["txtMessage"];
    $fileUploaded =  $file["txtImage"];
    $amount = $data["txtAmount"];
    
    $careerCode = GenerateNextID("career","CareerCode",10,"W");
    $uploadFileTarget =  $GLOBALS["ROOT"]."/_content_images/career/";
    $image = "";
    if(!empty($fileUploaded["name"])){
        $image = $uploadFileTarget.UploadFile($file["txtImage"],$uploadFileTarget,$careerCode);
    }
   
    $sql = "
    insert into career(CareerCode, Position, Salary, Name, LastName, Height, Weight, IDCard
    , Birthday, Age, SkinColor, Race, Nationality, Religion, HouseNumber, Phone , Email, LineID
    , HouseRegistration, MaritalStatus, Father, FatherStatus, FatherAge, FatherAddress
    , FatherCareer, FatherPhone, Mother, MotherStatus, MotherAge, MotherAddress, MotherCareer
    , MotherPhone, University, Year, Faculty, Major, Score, EnglishSkill, LanguageSkill
    , ComputerSkill, KeyboardThai, KeyboardEnglish, Car, DriverLicense, OldCompany, OldPosition
    , OldSalary, OldWorkingTime, OldReason, CurrentCompany, Adviser, AdviserRelationship
    , AdviserWorkplace, AdviserAddress, AdviserPhone, StartWork, Message, Image, Amount
    , CreatedOn, CreatedBy, Picked, Active)
     VALUES (
         '$careerCode'
         ,'$position'
         ,'$salary'
         ,'$name'
         ,'$last_name'
         ,'$height'
         ,'$weight'
         ,'$IDCard'
         ,'$birthday'
         ,'$age'
         ,'$skinColor'
         ,'$race'
         ,'$nationality'
         ,'$religion'
         ,'$houseNumber'
         ,'$phone'
         ,'$email'
         ,'$lineid'
         ,'$houseRegistration'
         ,'$maritalStatus'
         ,'$father'
         ,'$fatherStatus'
         ,'$fatherAge'
         ,'$fatherAddress'
         ,'$fatherCareer'
         ,'$fatherPhone'
         ,'$mother'
         ,'$motherStatus'
         ,'$motherAge'
         ,'$motherAddress'
         ,'$motherCareer'
         ,'$motherPhone'
         ,'$university'
         ,'$year'
         ,'$faculty'
         ,'$major'
         ,'$score'
         ,'$englishSkill'
         ,'$languageSkill'
         ,'$computerSkill'
         ,'$keyboardThai'
         ,'$keyboardEnglish'
         ,'$car'
         ,'$driverLicense'
         ,'$oldCompany'
         ,'$oldPosition'
         ,'$oldSalary'
         ,'$oldWorkingTime'
         ,'$oldReason'
         ,'$currentCompany'
         ,'$adviser'
         ,'$adviserRelationship'
         ,'$adviserWorkplace'
         ,'$adviserAddress'
         ,'$adviserPhone'
         ,'$startWork'
         ,'$message'
         ,'$image'
         ,'$amount'
         ,Now(),'".GetCookieClientID()."',0,1)
    ";
    ExecuteSQL($sql);
    SendEmailCareer($careerCode);
    return $careerCode;
}


?>