<?php session_start(); ?>

<?php
ini_set('display_errors', 'Off');
error_reporting(E_ERROR | E_PARSE);

//include_once "../../../_cogs.php";
include_once $GLOBALS["DOCUMENT_ROOT"] . "/_cogs.php";
include_once("Connection.php");
// ============ User Service =====================
class UserService
{
    public static function UserCode()
    {
        return $_SESSION["USER_SESSION_USER_CODE"];
    }
    public static function UserFullName()
    {
        return $_SESSION["USER_SESSION_USER_FULLNAME"];
    }
    public static function UserType()
    {
        return $_SESSION["USER_SESSION_USER_TYPE"];
    }
    public static function UserImage()
    {
        return $_SESSION["USER_SESSION_USER_IMAGE"];
    }
    public static function UserPrivilege()
    {
        return $_SESSION["USER_SESSION_USER_PRIVILEGE"];
    }
    public static function UserBranch()
    {
        return $_SESSION["USER_SESSION_USER_BRANCH"];
    }
    public static function IsUserVIP()
    {
        //$flag = false;
        //if(empty($_SESSION["USER_SESSION_USER_VIP"])){
        //    $flag = false;
        //}else{
        //    if($_SESSION["USER_SESSION_USER_VIP"] == true){
        //        $flag = true;
        //    }
        //    if($_SESSION["USER_SESSION_USER_VIP"] == false){
        //        $flag = false;
        //    }
        //}
        //return $flag;
        return empty($_SESSION["USER_SESSION_USER_VIP"]) ? false : $_SESSION["USER_SESSION_USER_VIP"];
    }
    public static function SID()
    {
        return $_SESSION["USER_SESSION_USER_SID"];
    }
    public static function _CheckPassword($UserCode, $password, $isCustomer = false)
    {
        if ($isCustomer) {
            $result = SelectRow("select Password from client where ClientCode = '" . $UserCode . "'");
        } else {
            $result = SelectRow("select Password from user where UserCode = '" . $UserCode . "'");
        }
        if ($result !== false && IsMatchingPassword($password, $result["Password"])) {
            return true;
        }
        return false;
    }
    public static function _UserResetPassword($username, $type)
    {
        if ($type == "CUSTOMER") {
            $result = SelectRow("select * from customer_contact where Email = '" . $username . "'");
            if ($result !== false) {
                $newPassword = uniqid();
                $newPasswordGenerate = GeneratePassword($newPassword);
                ExecuteSQL("update customer_contact set Password = '$newPasswordGenerate' where ContactCode = '" . $result["ContactCode"] . "'");
                SendEmailResetPassword(
                    $result["FirstName"] . " " . $result["LastName"],
                    $result["Email"],
                    $result["Email"],
                    $newPassword,
                    "customer"
                );
                AlertSuccessRedirect(
                    "Reset password successfully",
                    "Plaese check the new password from your email [" . $result["Email"] . "]",
                    "/customer/login.php"
                );
            } else {
                AlertError('Not found.', 'Please check your username.');
            }
        } else {
            $result = SelectRow("select * from employee where Username = '" . $username . "'");
            if ($result !== false) {
                $newPassword = uniqid();
                $newPasswordGenerate = GeneratePassword($newPassword);
                ExecuteSQL("update employee set Password = '$newPasswordGenerate' where EmployeeCode = '" . $result["EmployeeCode"] . "'");
                SendEmailResetPassword(
                    $result["FirstName"] . " " . $result["LastName"],
                    $result["Email"],
                    $result["Username"],
                    $newPassword,
                    "isc"
                );
                AlertSuccessRedirect(
                    "Reset password successfully",
                    "Plaese check the new password from your email [" . $result["Email"] . "]",
                    "/isc/login.php"
                );
            } else {
                AlertError('Not found.', 'Please check your username.');
            }
        }
    }
    public static function _UserLogin($username, $password)
    {
        $result = SelectRow("select * from user where Active = 1 and UserName = '" . $username . "'");
        if ($result !== false) {
            if (IsMatchingPassword($password, $result["Password"])) {
                $_SESSION["USER_SESSION_USER_CODE"] = $result["UserCode"];
                $_SESSION["USER_SESSION_USER_FULLNAME"] = $result["FirstName"] . " " . $result["LastName"];
                $_SESSION["USER_SESSION_USER_TYPE"] = $result["UserType"];
                $_SESSION["USER_SESSION_USER_SUPER_ADMIN"] = $result["SuperAdmin"] == "1";
                Redirect("/ControlPanel/");
                return;
            }
        }
        AlertError('sign in failed', 'Please check your username or password');
    }
    public static function _CheckCustomerLoggedin()
    {
        if (empty($_SESSION["USER_SESSION_USER_CODE"]) || !self::_IsCustomer()) {
            Redirect("/controlpanel/login.php");
            exit();
        }
    }
    public static function _CheckEmployeeLoggedin()
    {
        if (empty($_SESSION["USER_SESSION_USER_CODE"])  || !self::_IsEmployee()) {
            Redirect("login.php");
            exit();
        }
    }
    public static function _CheckAdminPublicSiteLoggedin()
    {
        if (empty($_SESSION["USER_SESSION_USER_CODE"])  || !self::_IsAdminPublicSute()) {
            Redirect("/controlpanel/login.php");
            exit();
        }
    }
    public static function _IsLoggedIn()
    {
        return !empty($_SESSION["USER_SESSION_USER_CODE"]);
    }
    public static function _IsCustomer()
    {
        return $_SESSION["USER_SESSION_USER_TYPE"] == "CUSTOMER";
    }
    public static function _IsEmployee()
    {
        return $_SESSION["USER_SESSION_USER_TYPE"] == "EMPLOYEE";
    }
    public static function _IsAdminPublicSute()
    {
        return $_SESSION["USER_SESSION_USER_TYPE"] == "ADMIN_PUBLICSITE";
    }
    public static function _IsAdmin()
    {
        return $_SESSION["USER_SESSION_USER_TYPE"] == "ADMIN";
    }
    public static function _IsSuperAdmin()
    {
        return empty($_SESSION["USER_SESSION_USER_SUPER_ADMIN"]) ? false : boolval($_SESSION["USER_SESSION_USER_TYPE"]);
    }
    // public static function _CheckAuthorize($PageUri){
    //     $result = SelectRow("select * from authorization_page where PageURI = '".$PageUri."' or PageURI = '".$PageUri."/' or PageURI = '".$PageUri."/index.php' ");
    //     $flag = true;
    //     if(!$result){
    //         $flag = false;
    //     }
    //     else{
    //         if($result["PrivilegeCode"] == "001" && $_SESSION["USER_SESSION_USER_PRIVILEGE"] != "001"){
    //              $flag = false;
    //         }
    //     }
    //     if(!$flag){
    //         Redirect("/isc/no-authorize.php");
    //         exit();
    //     }
    // }
    // public static function _InsertUserLog($Event){
    //     $sql = "insert into user_log (USER_TYPE,USER_CODE,Event,CREATED_ON) values(
    //             '".self::UserType()."',
    //             '".self::UserCode()."',
    //             '$Event',
    //             NOW());";
    //     ExecuteSQL($sql);
    // }

    public static function _CustomerLogin($username, $password, $returnStatus = false)
    {
        $result = SelectRow("select * from client where Active = 1 and (UserName = '" . $username . "' or Email = '" . $username . "' or Phone='" . $username . "') ");
        if ($result !== false) {
            if (IsMatchingPassword($password, $result["Password"])) {
                $_SESSION["USER_SESSION_USER_CODE"] = $result["ClientCode"];
                $_SESSION["USER_SESSION_USER_FULLNAME"] = $result["Name"];
                $_SESSION["USER_SESSION_USER_EMAIL"] = $result["Email"];
                $_SESSION["USER_SESSION_USER_TEL"] = $result["Phone"];
                $_SESSION["USER_SESSION_USER_IMAGE"] = !empty($result["Image"]) ? $result["Image"] : "/ControlPanel/assets/images/user.png";
                $_SESSION["USER_SESSION_USER_TYPE"] = "CUSTOMER";
                $_SESSION["USER_SESSION_USER_SUPER_ADMIN"] = false;
                if (!$returnStatus) {
                    Redirect($_SERVER['REQUEST_URI']);
                    return;
                } else {
                    return true;
                }
            }
        }

        if (!$returnStatus) {
            AlertError('sign in failed', 'Please check your username or password');
        } else {
            return false;
        }
    }

    public static function _ReCustomerLogin($clientCode)
    {
        $result = SelectRow("select * from client where Active = 1 and ClientCode = '" . $clientCode . "' ");
        if ($result !== false) {
            $_SESSION["USER_SESSION_USER_CODE"] = $result["ClientCode"];
            $_SESSION["USER_SESSION_USER_FULLNAME"] = $result["Name"];
            $_SESSION["USER_SESSION_USER_EMAIL"] = $result["Email"];
            $_SESSION["USER_SESSION_USER_TEL"] = $result["Phone"];
            $_SESSION["USER_SESSION_USER_IMAGE"] = !empty($result["Image"]) ? $result["Image"] : "/ControlPanel/assets/images/user.png";
            $_SESSION["USER_SESSION_USER_TYPE"] = "CUSTOMER";
            $_SESSION["USER_SESSION_USER_SUPER_ADMIN"] = false;
        }
    }
}
// ============= javascript Service ====================
class GenerateScript
{
    public static function getScript($script)
    {
        $header = "<script>";
        $foooter = "</script>";
        return $header . $script . $foooter;
    }
    public static function getScriptRedirect($script, $url)
    {
        $url = GetRedirectURL($url);
        $header = "<script>";
        $foooter = "</script>";
        $redirect = "$('.sa-button-container .confirm').click(function(){location.href = '$url';});";
        return $header . $script . $redirect . $foooter;
    }
}
function GetRedirectURL($url)
{
    if (strpos($url, "/") !== false && strpos(strtolower($url), strtolower($GLOBALS["ROOT"])) === false) {
        $url = $GLOBALS["ROOT"] . $url;
    }
    return $url;
}
function AlertSuccess($header, $msg)
{
    $srt = new GenerateScript();
    echo $srt->getScript("swal('$header','$msg', 'success');");
}
function AlertWarning($header, $msg)
{
    $srt = new GenerateScript();
    echo $srt->getScript("swal('$header','$msg', 'warning');");
}
function AlertError($header, $msg)
{
    $srt = new GenerateScript();
    echo $srt->getScript("swal('$header','$msg', 'error');");
}
function AlertSuccessRedirect($header, $msg, $url)
{
    $srt = new GenerateScript();
    echo $srt->getScriptRedirect("swal('$header','$msg', 'success');", $url);
}
function AlertWarningRedirect($header, $msg, $url)
{
    $srt = new GenerateScript();
    echo $srt->getScriptRedirect("swal('$header','$msg', 'warning');", $url);
}
function AlertErrorRedirect($header, $msg, $url)
{
    $srt = new GenerateScript();
    echo $srt->getScriptRedirect("swal('$header','$msg', 'error');", $url);
}
function Redirect($url)
{
    $url = GetRedirectURL($url);
    $srt = new GenerateScript();
    echo $srt->getScript("location.href = '$url';");
}
function DoScript($script)
{
    $srt = new GenerateScript();
    echo $srt->getScript($script);
}
//============= SQL Service ============
function GetCountRowSQL($strSql)
{
    $result = SelectRows($strSql) or die("query error");
    return $result->num_rows;
}
function GeneratePassword($input)
{
    $password = md5($input);
    $cost = 10;
    $salt = strtr(base64_encode(substr(GetGUID(), 0, 16)), '+', '.');
    $salt = sprintf("$2a$%02d$", $cost) . $salt;
    $hash = crypt($password, $salt);
    return $hash;
}
function IsMatchingPassword($input, $hash)
{
    $decrypt = crypt(md5($input), $hash);
    return $hash == $decrypt;
}
function GenerateNextID($table, $key, $length, $prefix)
{
    $prefixLength = strlen($prefix);
    $suffixLength = intval($length) - $prefixLength;
    $datas = SelectRow("select $key from `$table` where $key like '$prefix%' order by $key desc limit 1");
    if (!$datas) {
        return $prefix . str_pad("1", $suffixLength, "0", STR_PAD_LEFT);
    }
    $next = intval(str_replace($prefix, "", $datas[$key])) + 1;
    return $prefix . str_pad(strval($next), $suffixLength, "0", STR_PAD_LEFT);
}
function GenerateNextOrder($table, $seq)
{
    $sql = "select MAX(`$seq`) as SEQ FROM `$table` ";
    $data = SelectRow($sql);

    if (!$data || $data["SEQ"] === null) {
        return 1;
    }

    return intval($data["SEQ"]) + 1;
}
function isRepeatKey($table, $column, $value)
{
    $sql = "select $column from $table where $column = '$value'";
    if (SelectRow($sql) == false) {
        return false;
    }
    return true;
}
function NormalizeString($str = '')
{
    $str = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $str);
    $str = mb_ereg_replace("([\.]{2,})", '', $str);
    return $str;
}
function ConvertNewLine($input)
{
    return str_replace("\n", "<br>", $input);
}
function ConvertSQLResultToArray($result)
{
    $newArr = array();
    while ($r = $result->fetch_assoc()) {
        $newArr[] = $r;
    }
    return $newArr;
}

function SelectRow($sql)
{
    $connextion = GetConnection();
    $result = mysqli_query($connextion, $sql);
    if (!$result) {
        die("Select row failed : " . $connextion->error);
    }
    return $result->num_rows == 0 ? false : $result->fetch_assoc();
}

function SelectRows($sql, $connection = null)
{
    $connection = $connection == null ? GetConnection() : $connection;
    $result = mysqli_query($connection, $sql);
    return $result;
}

function SelectRowsArray($sql)
{
    $result = SelectRows($sql);
    return ConvertSQLResultToArray($result);
}

function ExecuteSQL($sql)
{
    $connextion = GetConnection();
    $result = mysqli_query($connextion, $sql);
    if (!$result) {
        die("Execute SQL failed : " . $connextion->error);
    }
}

function ExecuteMultiSQL($sql)
{
    $connextion = GetConnection();
    $result = mysqli_multi_query($connextion, $sql);
    if (!$result) {
        die("Execute SQL failed : " . $connextion->error);
    }
    mysqli_close($connextion);
}

function ExecuteSQLTransaction($strSql, $url)
{
    $connextion = GetConnection();
    $result = mysqli_query($connextion, $strSql);
    if (!$result) {
        die("Execute SQL failed : " . $connextion->error);
    }
    AlertSuccessRedirect("Success", "Save data successfully", $url);
}

//================== Find data in array ==============================
//Group by Object
function GroupBy($datas_list, $search_list = array())
{
    $arrGroup = array();
    foreach ($datas_list as $data) {
        $search = array();
        $searchResult = array();
        foreach ($search_list as $key => $value) {
            if ($value) {
                $search[$key] = $data[$key];
            }
            $searchResult[$key] = $data[$key];
        }
        if (Find($arrGroup, $search) == null) {
            array_push($arrGroup, $searchResult);
        }
    }
    return $arrGroup;
}
//Find Data Filter
function FindAll($datas_list, $search_list = array())
{
    return FindDataMutiple($datas_list, $search_list);
}
function Find($datas_list, $search_list = array())
{
    return FindDataMutiple($datas_list, $search_list, true);
}

function FindDataMutiple($datas_list, $search_list = array(), $isRowSingle = false)
{

    if ($search_list == null || count($search_list) <= 0) {
        return $datas_list;
    }
    $result = array();
    foreach ($datas_list as $key => $value) {
        $value_dump = ($value instanceof StdClass) ? (array)$value : $value;
        if (!($value instanceof StdClass) && !is_array($value_dump)) {
            foreach ($search_list as $v) {
                if (!isset($value_dump) || $value_dump != $v) {
                    continue 2;
                }
            }
        } else {
            foreach ($search_list as $k => $v) {
                if (!isset($value_dump[$k]) || $value_dump[$k] != $v) {
                    continue 2;
                }
            }
        }

        if ($isRowSingle) {
            return $value;
        }
        array_push($result, $value);
    }
    return ($isRowSingle ? null : $result);
}


function CleanMessage($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
//=========== ISC SQL Service ============
function GetTicketLogs($ticketCode)
{
    $sql = "select 
        case when ISNULL(e.Firstname) then CONCAT(c.FirstName,' ',c.LastName)
        else CONCAT(e.FirstName,' ',e.LastName) end as FullName
        ,l.created_on
        ,l.Action
        ,l.UserType
        from logs l
        left join customer_contact c on l.ContactCode = c.ContactCode
        and l.SID = c.SID
        left join employee e on l.SID = e.SID and e.EmployeeCode = l.EmployeeCode
        where l.sid ='" . UserService::SID() . "' and l.Type = 'TICKET' 
        and l.RefKey = '$ticketCode' order by created_on";
    return SelectRows($sql);
}
function GetTicketLogsDescription($action)
{
    switch ($action) {
        case "CREATE":
            return "Create ticket";
        case "ACCEPTED":
            return "Accept case";
        case "STARTED":
            return "Start service";
        case "COMPLETED":
            return "Complete case";
        case "CANCELED":
            return "Cancel Ticket";
        case "TRANFERED":
            return "Tranfer case";
        case "RATE":
            return "Give rate";
        case "MOVEMENT":
            return "Post comment";
        case "EDITED":
            return "Edit case";
        case "PENDING":
            return "Pending case";
        case "RESUME":
            return "Back to process";
        case "REOPEN to PROCESS":
            return "Reopen to process";
        case "REOPEN to PENDING":
            return "Reopen to pending";
        default:
            return $action;
    }
}
function SelectEmployeeFullname($sid, $empCode)
{
    $datas = SelectRow("select Firstname,Lastname from employee where EmployeeCode = '$empCode'");
    if (!$datas) {
        return "";
    } else {
        return $datas["Firstname"] . " " . $datas["Lastname"];
    }
}
function SelectEmployeePicture($sid, $empCode)
{
    $datas = SelectRow("select ImagePath from employee where EmployeeCode = '$empCode'");
    if (!$datas) {
        return "/images/user.png";
    } else {
        return $datas["ImagePath"];
    }
}
function SelectCustomerPicture($sid, $contactCode)
{
    $datas = SelectRow("select ImagePath from customer_contact where ContactCode = '$contactCode'");
    if (!$datas) {
        return "/images/user.png";
    } else {
        return $datas["ImagePath"];
    }
}
function SelectTicketCreatorPicture($sid, $created_by)
{
    $datas = SelectRow("select ImagePath from employee where EmployeeCode = '$created_by'");
    if (!$datas) {
        return SelectCustomerPicture($sid, $created_by);
    } else {
        return $datas["ImagePath"];
    }
}
function SelectEmployeeFullnameDepartment($sid, $empCode)
{
    $datas = SelectRow("select e.EmployeeCode,CONCAT(e.Firstname,' ',e.Lastname,' (',d.DepartmentName,')') as FullDesc 
                                from employee e,master_department d where e.DepartmentCode = d.DepartmentCode 
                                and e.EmployeeCode = '$empCode'");
    if (!$datas) {
        return "";
    } else {
        return $datas["FullDesc"];
    }
}
function SelectTicketCreator($sid, $createdBy)
{
    $datas = SelectRow("
        select info.CreatedBy 
        ,case when info.FullDesc is null then 
        (
          select CONCAT(con.FirstName,' ',con.LastName,' (Customer : ',
          case when con.CustomerCode = '*' then 'No linked customer'
          else (
            select cust.CustomerName from Customer cust
            where con.CustomerCode = cust.CustomerCode
          ) end
          ,')') from customer_contact con 
          where info.CreatedBy = con.ContactCode
        )
        else info.FullDesc end as FullDesc
        from (
              select c.CreatedBy, CONCAT(e.Firstname,' ',e.Lastname,' (Technical Engineer : ',d.DepartmentName,')') as FullDesc 
              from (
                select '$createdBy' as CreatedBy
              ) c
              left join employee e
              on e.EmployeeCode = c.CreatedBy
              left join master_department d on e.DepartmentCode = d.DepartmentCode                          
        ) info");
    if (!$datas) {
        return "";
    } else {
        return $datas["FullDesc"];
    }
}
function GetHotlineSupporter()
{
    $curYear = GetCurrentYearServer();
    $week = GetCurrentWeek($curYear);
    if ($week == 0) {
        $curYear = intval($curYear) - 1;
        $week = GetCurrentWeek($curYear);
    }
    $hotline = SelectRow("select * from hotline_mapping where SID = '" . UserService::SID() . "' 
                                and WeekNum='" . $week . "' 
                                and Year = '" . $curYear . "'");
    if (!$hotline) {
        return "";
    } else {
        return $hotline["LeaderCode"];
    }
}
function GetHotlineDupitySupporter()
{
    $curYear = GetCurrentYearServer();
    $week = GetCurrentWeek($curYear);
    if ($week == 0) {
        $curYear = intval($curYear) - 1;
        $week = GetCurrentWeek($curYear);
    }
    $hotline = SelectRow("select * from hotline_mapping where SID = '" . UserService::SID() . "' 
                                and WeekNum='" . $week . "' 
                                and Year = '" . $curYear . "'");
    if (!$hotline) {
        return "";
    } else {
        return $hotline["DupityCode"];
    }
}
// ========================= Drop Down List Service ===================
function GetDropDownListOption($table, $key, $text)
{
    $strResult = "";
    $result = SelectRows("select $key,$text from $table order by $text asc");
    $numrow = $result->num_rows;
    for ($i = 0; $i < $numrow; $i++) {
        $data = $result->fetch_array();
        if ($data["active"] == "0")
            continue;
        $strResult = $strResult . "<option value='" . $data[$key] . "'>" . $data[$text] . "</option>";
    }
    return $strResult;
}
function GetDropDownListOptionWithDefault($table, $key, $text, $default)
{
    $strResult = "<option value=''>$default</option>";
    $result = SelectRows("select $key,$text from $table order by $text asc");
    $numrow = $result->num_rows;
    for ($i = 0; $i < $numrow; $i++) {
        $data = $result->fetch_array();
        if ($data["active"] == "0")
            continue;
        $strResult = $strResult . "<option value='" . $data[$key] . "'>" . $data[$text] . "</option>";
    }
    return $strResult;
}
function GetDropDownListOptionCustom($query, $key, $text)
{
    $strResult = "";
    $result = SelectRows("$query");
    $numrow = $result->num_rows;
    for ($i = 0; $i < $numrow; $i++) {
        $data = $result->fetch_array();
        if ($data["active"] == "0")
            continue;
        $strResult = $strResult . "<option value='" . $data[$key] . "'>" . $data[$text] . "</option>";
    }
    return $strResult;
}
function GetDropDownListOptionWithDefaultCustom($query, $key, $text, $default)
{
    $strResult = "" . "<option value=''>$default</option>";
    $result = SelectRows("$query");
    $numrow = $result->num_rows;
    for ($i = 0; $i < $numrow; $i++) {
        $data = $result->fetch_array();
        if ($data["active"] == "0")
            continue;
        $strResult = $strResult . "<option value='" . $data[$key] . "'>" . $data[$text] . "</option>";
    }
    return $strResult;
}
function GetDropDownListOptionWithDefaultSelected($table, $key, $text, $default, $selected)
{
    $strResult = "" . "<option value=''>$default</option>";
    $result = SelectRows("select * from $table order by $text asc");
    $numrow = $result->num_rows;
    for ($i = 0; $i < $numrow; $i++) {
        $data = $result->fetch_array();
        if ($data["active"] == "0")
            continue;
        $strResult = $strResult . "<option value='" . $data[$key] . "' " . ($selected == $data[$key] ? "selected" : "") . ">" . $data[$text] . "</option>";
    }
    return $strResult;
}
function GetDropDownListOptionWithDefaultSelectedAndCondition($table, $key, $text, $default, $selected, $where)
{
    $strResult = "" . "<option value=''>$default</option>";
    $result = SelectRows("select * from $table where $where order by $text asc");
    $numrow = $result->num_rows;
    for ($i = 0; $i < $numrow; $i++) {
        $data = $result->fetch_array();
        if ($data["active"] == "0")
            continue;
        $strResult = $strResult . "<option value='" . $data[$key] . "' " . ($selected == $data[$key] ? "selected" : "") . ">" . $data[$text] . "</option>";
    }
    return $strResult;
}
//========================== Date Time Service =========================
function GetMonthNameEN($input, $shortness = false)
{
    $code = intval($input);
    $result = "";
    switch ($code) {
        case 1:
            $result = "January";
            break;
        case 2:
            $result = "February";
            break;
        case 3:
            $result = "March";
            break;
        case 4:
            $result = "April";
            break;
        case 5:
            $result = "May";
            break;
        case 6:
            $result = "June";
            break;
        case 7:
            $result = "July";
            break;
        case 8:
            $result = "August";
            break;
        case 9:
            $result = "September";
            break;
        case 10:
            $result = "October";
            break;
        case 11:
            $result = "November";
            break;
        case 12:
            $result = "December";
            break;
    }
    if ($shortness) {
        $result = substr($result, 0, 3);
    }
    return $result;
}
function GetMonthNameTH($input, $shortness = false)
{
    $code = intval($input);
    $result = "";
    switch ($code) {
        case 1:
            $result = $shortness ? "ม.ค." : "มกราคม";
            break;
        case 2:
            $result = $shortness ? "ก.พ." : "กุมภาพันธ์";
            break;
        case 3:
            $result = $shortness ? "มี.ค." : "มีนาคม";
            break;
        case 4:
            $result = $shortness ? "ม.ย." : "เมษายน";
            break;
        case 5:
            $result = $shortness ? "พ.ค." : "พฤษภาคม";
            break;
        case 6:
            $result = $shortness ? "มี.ย." : "มิถุนายน";
            break;
        case 7:
            $result = $shortness ? "ก.ค." : "กรกฎาคม";
            break;
        case 8:
            $result = $shortness ? "ส.ค." : "สิงหาคม";
            break;
        case 9:
            $result = $shortness ? "ก.ย." : "กันยายน";
            break;
        case 10:
            $result = $shortness ? "ต.ค." : "ตุลาคม";
            break;
        case 11:
            $result = $shortness ? "พ.ย." : "พฤศจิกายน";
            break;
        case 12:
            $result = $shortness ? "ธ.ค." : "ธันวาคม";
            break;
    }
    return $result;
}
function GetCurrentDateTimeServer()
{
    $dateTime = SelectRow("select NOW() as cdate");
    return $dateTime["cdate"];
}
function GetCurrentDateServer()
{
    $dateTime = explode(" ", GetCurrentDateTimeServer());
    return $dateTime[0];
}
function GetCurrentTimeServer()
{
    $dateTime = explode(" ", GetCurrentDateTimeServer());
    return $dateTime[1];
}
function GetCurrentYearServer()
{
    $dateTime = explode("-", GetCurrentDateServer());
    return $dateTime[0];
}
function GetCurrentMonthServer()
{
    $dateTime = explode("-", GetCurrentDateServer());
    return $dateTime[1];
}
function GetCurrentDayServer()
{
    $dateTime = explode("-", GetCurrentDateServer());
    return $dateTime[2];
}
function GetCurrentStringDateServer()
{
    return str_replace("-", "", GetCurrentDateServer());
}
function GetCurrentStringDateTimeServer()
{
    $str = str_replace("-", "", GetCurrentDateTimeServer());
    $str = str_replace(" ", "", $str);
    $str = str_replace(":", "", $str);
    return $str;
}
function GetCurrentWeek($sYear)
{
    $year           = $sYear;
    $firstDayOfYear = mktime(0, 0, 0, 1, 1, $year);
    $nextMonday     = strtotime('monday', $firstDayOfYear);
    $nextSunday     = strtotime('sunday', $nextMonday);
    $strCurdate = GetCurrentDateServer();
    $strCurArray = explode("-", $strCurdate);
    $curDate = intval($strCurArray[0] . $strCurArray[1] . $strCurArray[2]);
    $week = 0;
    while (date('Y', $nextMonday) == $year) {
        $week++;
        $strStartDate = strval(date('Y-m-d', $nextMonday));
        $strStartArray = explode("-", $strStartDate);
        $startDate = intval($strStartArray[0] . $strStartArray[1] . $strStartArray[2]);
        $strEndDate = strval(date('Y-m-d', $nextSunday));
        $strEndArray = explode("-", $strEndDate);
        $endDate = intval($strEndArray[0] . $strEndArray[1] . $strEndArray[2]);
        if ($curDate >= $startDate && $curDate <= $endDate) {
            return $week;
        }
        $nextMonday = strtotime('+1 week', $nextMonday);
        $nextSunday = strtotime('+1 week', $nextSunday);
    }
    return 0;
}
function GetCurrentWeekPeriod($sYear)
{
    $year           = $sYear;
    $firstDayOfYear = mktime(0, 0, 0, 1, 1, $year);
    $nextMonday     = strtotime('monday', $firstDayOfYear);
    $nextSunday     = strtotime('sunday', $nextMonday);
    $strCurdate = GetCurrentDateServer();
    $strCurArray = explode("-", $strCurdate);
    $curDate = intval($strCurArray[0] . $strCurArray[1] . $strCurArray[2]);
    $week = 0;
    while (date('Y', $nextMonday) == $year) {
        $week++;
        $strStartDate = strval(date('Y-m-d', $nextMonday));
        $strStartArray = explode("-", $strStartDate);
        $startDate = intval($strStartArray[0] . $strStartArray[1] . $strStartArray[2]);
        $strEndDate = strval(date('Y-m-d', $nextSunday));
        $strEndArray = explode("-", $strEndDate);
        $endDate = intval($strEndArray[0] . $strEndArray[1] . $strEndArray[2]);
        if ($curDate >= $startDate && $curDate <= $endDate) {
            $nextMonday = strtotime('-1 week', $nextMonday);
            $nextSunday = strtotime('-1 week', $nextSunday);
            return date('d/m/Y', $nextMonday) . "-" . date('d/m/Y', $nextSunday);
        }
        $nextMonday = strtotime('+1 week', $nextMonday);
        $nextSunday = strtotime('+1 week', $nextSunday);
    }
    return "";
}
function GetDiffDateTimeText($dateTimeFrom, $dateTimeTo)
{
    $interval = $dateTimeFrom->diff($dateTimeTo);
    $arrDiff = array();
    if ($interval->y != 0) {
        array_push($arrDiff, $interval->y . " years");
    }
    if ($interval->m != 0) {
        array_push($arrDiff, $interval->m . " months");
    }
    if ($interval->d != 0) {
        array_push($arrDiff, $interval->d . " days");
    }
    if ($interval->h != 0) {
        array_push($arrDiff, $interval->h . " hours");
    }
    if ($interval->i != 0) {
        array_push($arrDiff, $interval->i . " minutes");
    }
    return join(",", $arrDiff);
}
function GetDiffDateTimeMinutes($dateTimeFrom, $dateTimeTo)
{
    $interval = $dateTimeFrom->diff($dateTimeTo);
    $minutes = 0;
    if ($interval->y > 0) {
        $minutes += $interval->y * 365 * 24 * 60;
    }
    if ($interval->m > 0) {
        $minutes += $interval->m * 12 * 24 * 60;
    }
    if ($interval->d > 0) {
        $minutes += $interval->d * 24 * 60;
    }
    if ($interval->h > 0) {
        $minutes += $interval->h * 60;
    }
    if ($interval->i > 0) {
        $minutes += $interval->i;
    }
    return $minutes;
}
function ConvertDateDBToDateDisplay($dateDB)
{
    if ($dateDB == null || $dateDB == "0000-00-00 00:00:00") {
        return "";
    }
    $dx = explode(" ", $dateDB);
    $date = explode("-", $dx[0]);
    return $date[2] . "/" . $date[1] . "/" . Y_BE($date[0]);
}
function ConvertDateDBToYearDisplay($dateDB)
{
    $dx = explode(" ", $dateDB);
    $date = explode("-", $dx[0]);
    return Y_BE($date[0]);
}
function ConvertDateDBToDateDisplayLongFormat($dateDB, $fullness = false)
{
    $dx = explode(" ", $dateDB);
    $date = explode("-", $dx[0]);
    // return intval($date[2])." ".substr(GetMonthNameEN($date[1]),0,3)." ".Y_BE($date[0]);
    return intval($date[2]) . " " . GetMonthNameEN($date[1], !$fullness) . " " . Y_BE($date[0]);
}
function ConvertDateDBToDateDisplayLongFormatTH($dateDB, $fullness = false)
{
    $dx = explode(" ", $dateDB);
    $date = explode("-", $dx[0]);
    return intval($date[2]) . " " . GetMonthNameTH($date[1], !$fullness) . " " . Y_BE($date[0] + 543);
}
function ConvertDateDBToDateDisplayLongFormatWithoutYear($dateDB)
{
    $dx = explode(" ", $dateDB);
    $date = explode("-", $dx[0]);
    return intval($date[2]) . " " . substr(GetMonthNameEN($date[1]), 0, 3);
}
function ConvertDateTimeDBToDateDisplay($dateTimeDB)
{
    $datetime = explode(" ", $dateTimeDB);
    $date = explode("-", $datetime[0]);
    return $date[2] . "/" . $date[1] . "/" . Y_BE($date[0]);
}
function ConvertDateTimeDBToDateTimeDisplay($dateTimeDB)
{
    $datetime = explode(" ", $dateTimeDB);
    $date = explode("-", $datetime[0]);
    return $date[2] . "/" . $date[1] . "/" . Y_BE($date[0]) . " " . $datetime[1];
}
function ConvertDateDisplayToDateDB($dateDisplay)
{
    $date = explode("/", $dateDisplay);
    return Y_DB($date[2]) . "-" . $date[1] . "-" . $date[0];
}
function ConvertDateTimeDisplayToDateTimeDB($dateTimeDisplay)
{
    $datetime = explode(" ", $dateTimeDisplay);
    $dateDisplay = $datetime[0];
    $time = $datetime[1];
    $date = explode("/", $dateDisplay);
    return Y_DB($date[2]) . "-" . $date[1] . "-" . $date[0] . " " . $time;
}
function ConvertDateDBToDateJS($dateDB)
{
    $datetime = explode(" ", $dateDB);
    $date = explode("-", $datetime[0]);
    return $date[1] . "/" . $date[2] . "/" . $date[0];
}
function ConvertDateTimeDBToInteger($dateTimeDB)
{
    $rst = str_replace("-", "", $dateTimeDB);
    $rst = str_replace(" ", "", $rst);
    $rst = str_replace(":", "", $rst);
    return $rst;
}
function Y_DB($year)
{
    $intYear = intval($year);
    if ($intYear > 2500)
        $intYear -= 543;
    return strval($intYear);
}
function Y_BE($year)
{
    $intYear = intval($year);
    //if($intYear < 2500)
    //    $intYear += 543;
    return strval($intYear);
}
// =================== ISC Utils ================
function SeverityStar($code, $desc)
{
    $rst = '';
    if ($code == "001") {
        $rst = '
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:gold"></i>
        ';
    }
    if ($code == "002") {
        $rst = '
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:#ccc"></i>
        ';
    }
    if ($code == "003") {
        $rst = '
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:#ccc"></i>
            <i class="fa fa-star severity-star" style="color:#ccc"></i>
        ';
    }
    if ($code == "004") {
        $rst = '
            <i class="fa fa-star severity-star" style="color:gold"></i>
            <i class="fa fa-star severity-star" style="color:#ccc"></i>
            <i class="fa fa-star severity-star" style="color:#ccc"></i>
            <i class="fa fa-star severity-star" style="color:#ccc"></i>
        ';
    }
    $rst .= '<small style="color:#428BCA"><b>(' . $desc . ')</b></small>';
    return $rst;
}
//================= Email Service ================
function SendMailParalel($mail, $sendFail)
{
    if (!$mail->send()) {
        $sendFail = false;
        //echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        //echo 'Message has been sent';
        $sendFail = true;
    }
}
function SendMail($toEmail, $mailBody, $mailSubject, $enableCcOperation, $attachFile)
{
    include($GLOBALS["DOCUMENT_ROOT"] . '/ControlPanel/assets/b4w-framework/PHPMailer-master/PHPMailerAutoload.php');
    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;      
    $mail->Debugoutput = 'html';

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = SystemConfig::cogs_email_host();
    //$mail->SMTPSecure = 'tls';  
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = SystemConfig::cogs_email_username();                 // SMTP username
    $mail->Password = SystemConfig::cogs_email_password();
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );                         // SMTP password
    $mail->Port = 587;
    $mail->setFrom(SystemConfig::cogs_email_username(), $dataWeb["WebName"]);

    $arrTo = explode(",", $toEmail);
    for ($i = 0; $i < count($arrTo); $i++) {
        $mail->addAddress($arrTo[$i]);
    }
    if ($enableCcOperation) {
        $mail->addCC('kengsak.ton@a-gape.com');
    }
    if (!empty($attachFile)) {
        $mail->addAttachment($GLOBALS["DOCUMENT_ROOT"] . $attachFile);
    }
    //$mail->addReplyTo('kengsak.ton@a-gape.com', 'Information');
    //$mail->addBCC('bcc@example.com');
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $strSubject = $mailSubject;
    $strHeader .= "MIME-Version: 1.0' . \r\n";
    $strHeader .= "Content-type: text/html; charset=utf-8\r\n";
    $mail->isHTML(true);
    $mail->Subject = "=?UTF-8?B?" . base64_encode($strSubject) . "?=";
    $mail->Body    = $mailBody;
    $mail->CharSet = 'UTF-8';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    require_once($GLOBALS["DOCUMENT_ROOT"] . '/ControlPanel/assets/b4w-framework/Threading.php');
    if (! Thread::isAvailable()) {
        if (!$mail->send()) {
            $sendFail = false;
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            //echo 'Message has been sent';
            $sendFail = true;
        }
    } else {
        $t1 = new Thread('SendMailParalel');
        $t1->start();
    }
}

function SendMailControlPanel($toEmail, $mailBody, $mailSubject, $CCMail, $attachFile)
{

    require_once($GLOBALS["DOCUMENT_ROOT"] . '/ControlPanel/assets/b4w-framework/PHPMailer-master/PHPMailerAutoload.php');
    $dataWeb = GetWebsiteDetail();
    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = SystemConfig::cogs_email_host();
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = SystemConfig::cogs_email_username();                 // SMTP username
    $mail->Password = SystemConfig::cogs_email_password();                           // SMTP password
    //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->setFrom(SystemConfig::cogs_email_username(), $dataWeb["WebName"]);
    $arrTo = explode(",", $toEmail);
    for ($i = 0; $i < count($arrTo); $i++) {
        $mail->addAddress($arrTo[$i]);
    }
    if (!empty($CCMail)) {
        $arrCC = explode(",", $CCMail);
        for ($i = 0; $i < count($arrCC); $i++) {
            $mail->addCC($arrCC[$i]);
        }
    }
    if (!empty($attachFile)) {
        $mail->addAttachment($GLOBALS["DOCUMENT_ROOT"] . $attachFile);
    }
    $strSubject = $mailSubject;
    $strHeader .= "MIME-Version: 1.0' . \r\n";
    $strHeader .= "Content-type: text/html; charset=utf-8\r\n";
    $mail->isHTML(true);
    $mail->Subject = "=?UTF-8?B?" . base64_encode($strSubject) . "?=";
    $mail->Body    = $mailBody;
    $mail->CharSet = 'UTF-8';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if (!$mail->send()) {
        $sendSuccess = false;
        //echo 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        //echo 'Message has been sent';
        $sendSuccess = true;
    }
}

function SendEmailContact($contactCode, $refPO = "")
{
    $prependBody = "";
    $subjectMessage = "ได้รับการติดต่อ ";
    if (!empty($refPO)) {
        $subjectMessage = "แจ้งชำระเงินเลขที่เอกสาร [" . $refPO . "] ";
        $prependBody = "การแจ้งชำระเงิน เลขที่เอกสารใบสั่งซื้อ : <b>" . $refPO . "</b><hr>";
    } else {
        $subjectMessage = "ได้รับการติดต่อ ";
    }
    $sqlContact = "select a.* from member a where a.MemberCode = '$contactCode' ";
    $dataContact = SelectRow($sqlContact);
    $dataWeb = GetWebsiteDetail();
    if (!empty($dataWeb["Email"])) {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
        $uri = $protocol . $_SERVER['HTTP_HOST'];
        $body = file_get_contents($GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/template/Contact.html");
        $body = str_replace("[!--LOGO--!]", $uri . SystemConfig::cogs_logo_path(), $body);
        $body = str_replace("[!--LOGO_WIDTH--!]", SystemConfig::cogs_logo_width(), $body);
        $body = str_replace("[!--LOGO_HEIGHT--!]", SystemConfig::cogs_logo_height(), $body);
        $body = str_replace("[!--MESSAGE--!]", $dataContact["Subject"], $body);
        $body = str_replace("[!--CONTACT_NAME--!]", $dataContact["MemberName"], $body);
        $body = str_replace("[!--CONTACT_PHONE--!]", $dataContact["Phone"], $body);
        $body = str_replace("[!--CONTACT_EMAIL--!]", $dataContact["Email"], $body);
        $body = str_replace("[!--CONTACT_MESSAGE--!]", str_replace("\n", "<br>", $prependBody . $dataContact["Message"]), $body);
        $body = str_replace("[!--WEBNAME--!]", $dataWeb["WebName"], $body);
        $body = str_replace("[!--TEL--!]", $dataWeb["Phone"], $body);
        $body = str_replace("[!--EMAIL--!]", $dataWeb["Email"], $body);
        $body = str_replace("[!--WEBURL--!]", $uri . $GLOBALS["ROOT"], $body);
        $body = str_replace("[!--ADDRESS--!]", $dataWeb["Address"], $body);
        SendMailControlPanel($dataWeb["Email"], $body, $subjectMessage . "ผ่านเว็บไซต์ " . $dataWeb["WebName"], $dataContact["Email"], "", $dataWeb);
    }

    $lineMessage = "message=ติดต่อเราผ่านเว็บ " . $dataWeb["WebName"] . "
    เมื่อ : " . ConvertDateTimeDBToDateTimeDisplay(GetCurrentDateTimeServer()) . "
    ลูกค้า : " . $dataContact["MemberName"] . "
    หัวข้อ : " . $dataContact["Subject"] . "
    อีเมล์ : " . $dataContact["Email"] . "
    เบอร์โทร : " . $dataContact["Phone"] . "
    ";

    $lineToken = $dataWeb["cogs_line_notify"];

    SendLineNotification($lineToken, $lineMessage);
}

function SendEmailRegister($contactCode)
{
    $prependBody = "";
    $subjectMessage = "ไม่สามารถล็อคอินได้ ";
    $sqlContact = "select a.* from member a where a.MemberCode = '$contactCode' ";
    $dataContact = SelectRow($sqlContact);
    $dataWeb = GetWebsiteDetail();
    if (!empty($dataWeb["Email"])) {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
        $uri = $protocol . $_SERVER['HTTP_HOST'];
        $body = file_get_contents($GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/template/Register.html");
        $body = str_replace("[!--LOGO--!]", $uri . SystemConfig::cogs_logo_path(), $body);
        $body = str_replace("[!--LOGO_WIDTH--!]", SystemConfig::cogs_logo_width(), $body);
        $body = str_replace("[!--LOGO_HEIGHT--!]", SystemConfig::cogs_logo_height(), $body);
        $body = str_replace("[!--MESSAGE--!]", $dataContact["Subject"], $body);
        $body = str_replace("[!--CONTACT_NAME--!]", $dataContact["MemberName"], $body);
        $body = str_replace("[!--CONTACT_PHONE--!]", $dataContact["Phone"], $body);
        $body = str_replace("[!--CONTACT_EMAIL--!]", $dataContact["Email"], $body);
        $body = str_replace("[!--CONTACT_COMPANY--!]", $dataContact["Company"], $body);
        $body = str_replace("[!--CONTACT_DEPARTMENT--!]", $dataContact["Department"], $body);
        $body = str_replace("[!--CONTACT_REF_PRODUCT--!]", $dataContact["ProductRefCode"], $body);
        $body = str_replace("[!--CONTACT_MESSAGE--!]", str_replace("\n", "<br>", $prependBody . $dataContact["Message"]), $body);
        $body = str_replace("[!--WEBNAME--!]", $dataWeb["WebName"], $body);
        $body = str_replace("[!--TEL--!]", $dataWeb["Phone"], $body);
        $body = str_replace("[!--EMAIL--!]", $dataWeb["Email"], $body);
        $body = str_replace("[!--WEBURL--!]", $uri . $GLOBALS["ROOT"], $body);
        $body = str_replace("[!--ADDRESS--!]", $dataWeb["Address"], $body);
        SendMailControlPanel($dataWeb["Email"], $body, $subjectMessage . "ผ่านเว็บไซต์ " . $dataWeb["WebName"], $dataContact["Email"], "", $dataWeb);
    }
}

function SendEmailCareer($careerCode)
{
    $prependBody = "";
    $subjectMessage = "ได้รับการติดต่อสมัครงาน ";

    $sqlContact = "select * from career where CareerCode = '$careerCode'";
    $dataContact = SelectRow($sqlContact);
    $dataWeb = GetWebsiteDetail();
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
    $uri = $protocol . $_SERVER['HTTP_HOST'];
    $body = file_get_contents($GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/template/Career.html");
    $body = str_replace("[!--LOGO--!]", $uri . SystemConfig::cogs_logo_path(), $body);
    $body = str_replace("[!--LOGO_WIDTH--!]", SystemConfig::cogs_logo_width(), $body);
    $body = str_replace("[!--LOGO_HEIGHT--!]", SystemConfig::cogs_logo_height(), $body);

    $body = str_replace("[!--CAREER_POSITION--!]", $dataContact["Position"], $body);
    $body = str_replace("[!--CAREER_SALARY--!]", $dataContact["Salary"], $body);
    $body = str_replace("[!--CAREER_NAME--!]", $dataContact["Name"] . " " . $dataContact["LastName"], $body);
    $body = str_replace("[!--CAREER_HEIGHT--!]", $dataContact["Height"], $body);
    $body = str_replace("[!--CAREER_WEIGHT--!]", $dataContact["Weight"], $body);
    $body = str_replace("[!--CAREER_IDCARD--!]", $dataContact["IDCard"], $body);
    $body = str_replace("[!--CAREER_BIRTHDAY--!]", $dataContact["Birthday"], $body);
    $body = str_replace("[!--CAREER_AGE--!]", $dataContact["Age"], $body);
    $body = str_replace("[!--CAREER_SKINCOLOR--!]", $dataContact["SkinColor"], $body);
    $body = str_replace("[!--CAREER_RACE--!]", $dataContact["Race"], $body);
    $body = str_replace("[!--CAREER_NATIONALITY--!]", $dataContact["Nationality"], $body);
    $body = str_replace("[!--CAREER_RELIGION--!]", $dataContact["Religion"], $body);
    $body = str_replace("[!--CAREER_HOUSENUMBER--!]", $dataContact["HouseNumber"], $body);
    $body = str_replace("[!--CAREER_PHONE--!]", $dataContact["Phone"], $body);
    $body = str_replace("[!--CAREER_EMAIL--!]", $dataContact["Email"], $body);
    $body = str_replace("[!--CAREER_LINEID--!]", $dataContact["LineID"], $body);
    $body = str_replace("[!--CAREER_HOUSEREGISTRATION--!]", $dataContact["HouseRegistration"], $body);
    $body = str_replace("[!--CAREER_MARITALSTATUS--!]", $dataContact["MaritalStatus"], $body);
    $body = str_replace("[!--CAREER_FATHER--!]", $dataContact["Father"], $body);
    $body = str_replace("[!--CAREER_FATHERSTATUS--!]", $dataContact["FatherStatus"], $body);
    $body = str_replace("[!--CAREER_FATHERAGE--!]", $dataContact["FatherAge"], $body);
    $body = str_replace("[!--CAREER_FATHERADDRESS--!]", $dataContact["FatherAddress"], $body);
    $body = str_replace("[!--CAREER_FATHERCAREER--!]", $dataContact["FatherCareer"], $body);
    $body = str_replace("[!--CAREER_FATHERPHONE--!]", $dataContact["FatherPhone"], $body);
    $body = str_replace("[!--CAREER_MOTHER--!]", $dataContact["Mother"], $body);
    $body = str_replace("[!--CAREER_MOTHERSTATUS--!]", $dataContact["MotherStatus"], $body);
    $body = str_replace("[!--CAREER_MOTHERAGE--!]", $dataContact["MotherAge"], $body);
    $body = str_replace("[!--CAREER_MOTHERADDRESS--!]", $dataContact["MotherAddress"], $body);
    $body = str_replace("[!--CAREER_MOTHERCAREER--!]", $dataContact["MotherCareer"], $body);
    $body = str_replace("[!--CAREER_MOTHERPHONE--!]", $dataContact["MotherPhone"], $body);
    $body = str_replace("[!--CAREER_UNIVERSITY--!]", $dataContact["University"], $body);
    $body = str_replace("[!--CAREER_YEAR--!]", $dataContact["Year"], $body);
    $body = str_replace("[!--CAREER_FACULTY--!]", $dataContact["Faculty"], $body);
    $body = str_replace("[!--CAREER_MOJOR--!]", $dataContact["Major"], $body);
    $body = str_replace("[!--CAREER_SCORE--!]", $dataContact["Score"], $body);
    $body = str_replace("[!--CAREER_ENGLISHSKILL--!]", $dataContact["EnglishSkill"], $body);
    $body = str_replace("[!--CAREER_LANGUAGESKILL--!]", $dataContact["LanguageSkill"], $body);
    $body = str_replace("[!--CAREER_COMPUTERSKILL--!]", $dataContact["ComputerSkill"], $body);
    $body = str_replace("[!--CAREER_KEYBOARDTHAI--!]", $dataContact["KeyboardThai"], $body);
    $body = str_replace("[!--CAREER_KEYBOARDENGLISH--!]", $dataContact["KeyboardEnglish"], $body);
    $body = str_replace("[!--CAREER_CAR--!]", $dataContact["Car"], $body);
    $body = str_replace("[!--CAREER_DRIVERLICENSE--!]", $dataContact["DriverLicense"], $body);
    $body = str_replace("[!--CAREER_OLDCOMPANY--!]", $dataContact["OldCompany"], $body);
    $body = str_replace("[!--CAREER_OLDPOSITION--!]", $dataContact["OldPosition"], $body);
    $body = str_replace("[!--CAREER_OLDSALARY--!]", $dataContact["OldSalary"], $body);
    $body = str_replace("[!--CAREER_OLDWORKINGTIME--!]", $dataContact["OldWorkingTime"], $body);
    $body = str_replace("[!--CAREER_OLDREASON--!]", $dataContact["OldReason"], $body);
    $body = str_replace("[!--CAREER_CURRENTCOMPANY--!]", $dataContact["CurrentCompany"], $body);
    $body = str_replace("[!--CAREER_ADVISER--!]", $dataContact["Adviser"], $body);
    $body = str_replace("[!--CAREER_ADVISERRELATIONSHIP--!]", $dataContact["AdviserRelationship"], $body);
    $body = str_replace("[!--CAREER_ADVISERWORKPLACE--!]", $dataContact["AdviserWorkplace"], $body);
    $body = str_replace("[!--CAREER_ADVISERADDRESS--!]", $dataContact["AdviserAddress"], $body);
    $body = str_replace("[!--CAREER_ADVISERPHONE--!]", $dataContact["AdviserPhone"], $body);
    $body = str_replace("[!--CAREER_STARTWORK--!]", $dataContact["StartWork"], $body);
    $body = str_replace("[!--CAREER_MESSAGE--!]", $dataContact["Message"], $body);
    $body = str_replace("[!--CAREER_IMAGE--!]", $uri . $dataContact["Image"], $body);
    $body = str_replace("[!--CAREER_AMOUNT--!]", $dataContact["Amount"], $body);

    $body = str_replace("[!--WEBNAME--!]", $dataWeb["WebName"], $body);
    $body = str_replace("[!--TEL--!]", $dataWeb["Phone"], $body);
    $body = str_replace("[!--EMAIL--!]", $dataWeb["Email"], $body);
    $body = str_replace("[!--WEBURL--!]", $uri . $GLOBALS["ROOT"], $body);
    $body = str_replace("[!--ADDRESS--!]", $dataWeb["Address"], $body);
    SendMailControlPanel($dataWeb["Email"], $body, $subjectMessage . "ผ่านเว็บไซต์ " . $dataWeb["WebName"], $dataContact["Email"], "", $dataWeb);
}
function SendEmailContactRefProduct($contactCode, $productDesc, $isQuotation)
{
    $subjectMessage = ($isQuotation ? "QUOTATION FORM : " : "SAMPLE FORM : ") . $productDesc;
    $sqlContact = "select a.* , b.PortName as RoleName, c.PortName as QuantityName
            ,d.PortName as ProductApplication
            ,e.PortName as DecisionUse
        from member a
            left join portfolio b
                on a.Subject = b.PortCode and b.PortType='ROLE'
            left join portfolio c
                on a.PaymentAmount = c.PortCode and c.PortType='QUANTITY'
            left join portfolio d
                on a.CheckOutCode = d.PortCode and d.PortType='PRODUCT_APP'
            left join portfolio e
                on a.PaymentTime = e.PortCode and e.PortType='DECISION'
        where a.MemberCode = '$contactCode' ";

    $dataContact = SelectRow($sqlContact);
    $dataWeb = GetWebsiteDetail();
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
    $uri = $protocol . $_SERVER['HTTP_HOST'];
    $body = file_get_contents($GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/template/ContactProduct.html");
    $body = str_replace("[!--LOGO--!]", $uri . SystemConfig::cogs_logo_path(), $body);
    $body = str_replace("[!--LOGO_WIDTH--!]", SystemConfig::cogs_logo_width(), $body);
    $body = str_replace("[!--LOGO_HEIGHT--!]", SystemConfig::cogs_logo_height(), $body);

    $body = str_replace("[!--PRODUCT_NAME--!]", $dataContact["ProductRefCode"], $body);
    $body = str_replace("[!--CONTACT_NAME--!]", $dataContact["MemberName"], $body);
    $body = str_replace("[!--CONTACT_PHONE--!]", $dataContact["Phone"], $body);
    $body = str_replace("[!--CONTACT_EMAIL--!]", $dataContact["Email"], $body);
    $body = str_replace("[!--CONTACT_SUBJECT--!]", $dataContact["RoleName"], $body);
    $body = str_replace("[!--CONTACT_POSITION--!]", $dataContact["MemberName2"], $body);
    $body = str_replace("[!--CONTACT_COMPANY--!]", $dataContact["Company"], $body);
    $body = str_replace("[!--CONTACT_DEPARTMENT--!]", !empty($dataContact["Department"]) ? $dataContact["Department"] : "-", $body);
    $body = str_replace("[!--CONTACT_QUANTITY--!]", $dataContact["QuantityName"], $body);
    $body = str_replace("[!--CONTACT_PRODUCTAPP--!]", !empty($dataContact["ProductApplication"]) ? $dataContact["ProductApplication"] : "-", $body);
    $body = str_replace("[!--CONTACT_DECISIONUSE--!]", !empty($dataContact["DecisionUse"]) ? $dataContact["DecisionUse"] : "-", $body);
    $body = str_replace("[!--CONTACT_VOLUME--!]", $dataContact["Message"], $body);

    //$body = str_replace("[!--CONTACT_MESSAGE--!]",str_replace("\n","<br>",$prependBody.$dataContact["Message"]),$body);
    $body = str_replace("[!--WEBNAME--!]", $dataWeb["WebName"], $body);
    $body = str_replace("[!--TEL--!]", $dataWeb["Phone"], $body);
    $body = str_replace("[!--EMAIL--!]", $dataWeb["Email"], $body);
    $body = str_replace("[!--WEBURL--!]", $uri, $body);
    $body = str_replace("[!--ADDRESS--!]", $dataWeb["Address"], $body);
    SendMailControlPanel($dataWeb["Email"], $body, $subjectMessage . " ทางเว็บไซต์ " . $dataWeb["WebName"], $dataContact["Email"], "", $dataWeb);
}
function SendEmailPO($POCode, $subjectMessage)
{
    //$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $uri = $protocol . $_SERVER['HTTP_HOST'];

    $PORow = "<tr>
        <td class='shopping-cart-table-image-cell' width='80px'>
            <div class='aspect-ratio aspect-ratio-square'>
                <img style='width:55px;height:55px;' width='55' height='55' src='{0}'>
            </div>
        </td>
        <td class='shopping-cart-table-cell-item-name' width='40%'>
            <p class='shopping-cart-table-type-subdued' style='margin: 0;'>{2}</p>
            <div style='padding-left: 10px;' class='small'><span>SKU :</span> <span class='gray-color'>{2-3}</span></div>
        </td>
        <td class='text-left shopping-cart-table-cell-grow-when-condensed' width='20%'>
            {3}
        </td>
        <td class='shopping-cart-table-type-subdued' width='10px'>
            x
        </td>
        <td class='shopping-cart-table-cell-item-input'>
            <div class='basket-control-display text-right' style=''>{4}</div>
        </td>
        <td class='shopping-cart-table-cell-item-input'>
        </td>
        <td class='text-right' style='min-width: 150px; font-weight: 600; width: 150px;'>
            <span>{6} ฿</span>
        </td>
    </tr>";
    $POItems = "";
    $sqlItem = "select p.*,c.Price as CartPrice ,c.QTY,c.Total
                , co.TagName as ColorName, si.TagName as SizeName
                from cart c
                join product p on p.ProductCode = c.ProductCode
                left join tag co  on c.Color = co.TagCode and co.TagType = 'COLOR'
                left join tag si on c.Size = si.TagCode and si.TagType = 'SIZE'
                where c.CheckOutCode = '$POCode' and c.CheckOutCode <> ''";

    $dataItems = SelectRows($sqlItem);
    while ($item = $dataItems->fetch_array()) {
        $temp = $PORow;
        $temp = str_replace("{0}", $uri . $item["Image"], $temp);
        $temp = str_replace("{2}", $item["ProductName"], $temp);
        // $temp = str_replace("{2-1}",$item["ColorName"],$temp);
        // $temp = str_replace("{2-2}",$item["SizeName"],$temp);
        $temp = str_replace("{2-3}", $item["ProductRefCode"], $temp);
        $temp = str_replace("{3}", number_format($item["CartPrice"], 2), $temp);
        $temp = str_replace("{4}", $item["QTY"], $temp);
        $temp = str_replace("{6}", number_format($item["Total"], 2), $temp);
        $POItems .= $temp;
    }
    $dataWeb = GetWebsiteDetail();
    $sqlPO = "select a.* , b.Name as DeliveryName
        from checkout a
        left join delivery_category b
             on a.DelivieryCode = b.Code
        where a.CheckOutCode = '$POCode'";
    $dataPO = SelectRow($sqlPO);

    $body = file_get_contents($GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/template/PO.html");
    $body = str_replace("[!--NAME--!]", $dataPO["Name"], $body);
    $body = str_replace("[!--PHONE--!]", $dataPO["Phone"], $body);
    $body = str_replace("[!--COMPANY--!]", $dataPO["Company"], $body);
    $body = str_replace("[!--COUNTRY--!]", $dataPO["County"], $body);
    $body = str_replace("[!--ADDRESS--!]", $dataPO["Address"], $body);
    $body = str_replace("[!--DETAIL--!]", $dataPO["Detail"], $body);
    $body = str_replace("[!--PO_NUMBER--!]", $POCode, $body);
    $body = str_replace("[!--DATE--!]", ConvertDateDBToDateDisplay($dataPO["CreatedOn"]), $body);
    $body = str_replace("[!--PAYMENTTYPE--!]", GetPOPaymentMethodDesc($dataPO["PaymentType"]), $body);
    $body = str_replace("[!--STATUS--!]", GetPOStatusDesc($dataPO["StatusCode"]), $body);
    $body = str_replace("[!--DELIVERY--!]", $dataPO["DeliveryName"], $body);
    $body = str_replace("[!--TOTAL--!]", number_format($dataPO["Total"], 2), $body);
    $body = str_replace("[!--DISCOUNT--!]", number_format($dataPO["DisCount"], 2), $body);
    $body = str_replace("[!--TAX--!]", number_format($dataPO["Tax"], 2), $body);
    $body = str_replace("[!--SHIPPING--!]", number_format($dataPO["DeliveryPrice"], 2), $body);
    $body = str_replace("[!--NET--!]", number_format($dataPO["Net"], 2), $body);
    $body = str_replace("[!--LOGO--!]", $uri . SystemConfig::cogs_logo_path(), $body);
    $body = str_replace("[!--LOGO_WIDTH--!]", SystemConfig::cogs_logo_width(), $body);
    $body = str_replace("[!--LOGO_HEIGHT--!]", SystemConfig::cogs_logo_height(), $body);
    $body = str_replace("[!--LIST_ORDER--!]", $POItems, $body);
    $body = str_replace("[!--SHOP_HOW_TO_PAY--!]", $uri . "/Howto.php", $body);
    $body = str_replace("[!--SHOP_TEL--!]", $dataWeb["Phone"], $body);
    $body = str_replace("[!--SHOP_EMAIL--!]", $dataWeb["Email"], $body);
    $body = str_replace("[!--SHOP_CHECK--!]", $uri . $GLOBALS["ROOT"] . "/Order.php?ref=" . base64_encode($POCode), $body);
    SendMailControlPanel($dataPO["Email"], $body, $subjectMessage . " จาก " . $dataWeb["WebName"], $dataWeb["Email"], "", $dataWeb);

    $globals = $GLOBALS["ROOT"];
    $lineMessage = "message=การสั่งซื้อใหม่ผ่าน " . $dataWeb["WebName"] . "
    เมื่อ : " . ConvertDateTimeDBToDateTimeDisplay(GetCurrentDateTimeServer()) . "
    ลูกค้า : " . $dataPO["Name"] . "
    เบอร์โทร : " . $dataPO["Phone"] . "
    ทั้งสิ้น : " . number_format($dataPO["Net"]) . " บาท
    รายละเอียด : $uri.$globals/Order.php?ref=" . base64_encode($POCode) . "
    ";

    $lineToken = "xG1U94laRTSRqDil6zvVgASmb9KyzXEtfKX6SIw9nwF";
    SendLineNotification($lineToken, $lineMessage);
}

function SendLineNotification($token, $message)
{

    // if (!empty($imageThumbnail) && !empty($imageFullsize)) {
    //     $message .= '&imageThumbnail=' . $imageThumbnail;
    //     $message .= '&imageFullsize=' . $imageFullsize;
    // }

    $conn = curl_init();
    curl_setopt($conn, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    // SSL USE
    curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0);
    // POST
    curl_setopt($conn, CURLOPT_POST, 1);
    // Message
    curl_setopt($conn, CURLOPT_POSTFIELDS, $message);
    // follow redirects
    curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1);
    // ADD header array
    $headers = array('Content-type: multipart/form-data', 'Authorization: Bearer ' . $token);
    curl_setopt($conn, CURLOPT_HTTPHEADER, $headers);
    // RETURN
    curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($conn);
    //Close connect
    curl_close($conn);
}

function SendLineNotification2($code)
{
    include('phpqrcode/qrlib.php');
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $uri = $protocol . $_SERVER['HTTP_HOST'];
    $dataWeb = GetWebsiteDetail();
    $sqlPO = "select * from portfolio where PortCode = '$code'";
    $dataPO = SelectRow($sqlPO);

    $sql = "select a.PortType, a.PageFileName, b.PortCode, b.PortName, b.PortRefCode from page_config_portfolio a
                    inner join portfolio b on a.PortType = b.PortType
                where b.Active = 1 and b.PortName <> '' and b.PortCode='$code'";
    $data = SelectRow($sql);
    $_URL = $uri . $GLOBALS["ROOT"] . "/" . $data["PageFileName"] . "?ref=" . $data["PortCode"];

    $path_qrcode = "../../../_content_images/qrcode/";
    $file_qrcode = $dataPO["PortCode"] . ".png";
    $full_savePath = $path_qrcode . $file_qrcode;

    $ecc = 'H';
    $pixel_size = 20;
    $frame_size = 5;

    QRcode::png($_URL, $full_savePath, $ecc, $pixel_size, $frame_size, FALSE);

    $sToken = "xG1U94laRTSRqDil6zvVgASmb9KyzXEtfKX6SIw9nwF";

    $sMessage = "เพิ่มหรือแก้ไขข้อมูลผ่าน " . $dataWeb["WebName"] . "\n";
    $sMessage .= "เมื่อ: " . ConvertDateTimeDBToDateTimeDisplay(GetCurrentDateTimeServer()) . " \n";
    $sMessage .= "ชื่อรายการ : " . $dataPO["PortName"] . " \n";
    $imageFile = new CURLFILE($full_savePath);

    $data  = array(
        'message' => $sMessage,
        'imageFile' => $imageFile
    );

    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chOne, CURLOPT_POST, 1);
    curl_setopt($chOne, CURLOPT_POSTFIELDS, $data);
    $headers = array('Content-type: multipart/form-data', 'Authorization: Bearer ' . $sToken . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);
    //Close connect
    curl_close($chOne);
}

function GetPOPaymentMethodDesc($paymentType)
{
    if ($paymentType == "PayPal")
        return "ชำระเงินผ่าน PayPal";
    else if ($paymentType == "BankTranfer")
        return "โอนเงินผ่านธนาคาร";
    else if ($paymentType == "CreditCard")
        return "ชำระผ่านบัตรเครดิต";
    else if ($paymentType == "Cheque")
        return "เช็คเงินสด";
    else if ($paymentType == "CashDelivery")
        return "เก็บเงินปลายทาง";
    else if ($paymentType == "123SERVICE")
        return "ชำระเงิน 123 เซอร์วิส";
    return $paymentType;
}
function GetPOStatusDesc($status)
{
    if ($status == "WAITING")
        return "รอชำระเงิน";
    else if ($status == "CHECKPAID")
        return "รอตรวจสอบการชำระเงิน";
    else if ($status == "PAID")
        return "ชำระเงินแล้วรอจัดส่ง";
    else if ($status == "DELIVERY")
        return "จัดส่งแล้ว";
    else if ($status == "SUCCESS")
        return "จัดส่งเรียบร้อยแล้ว";
    else if ($status == "CANCEL")
        return "ยกเลิก";
    return $status;
}
function GetWebsiteDetail()
{
    $sqlWeb = "select * from website limit 1";
    $dataWeb = SelectRow($sqlWeb);
    return $dataWeb;
}
function SendEmailResetPassword($toName, $toEmail, $userName, $password)
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $uri = $protocol . $_SERVER['HTTP_HOST'];
    $dataWeb = GetWebsiteDetail();

    $body = file_get_contents($GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/template/reset-password-email.html");
    $body = str_replace("[!--SENDTO_NAME--!]", $toName, $body);
    $body = str_replace("[!--DATETIME--!]", ConvertDateTimeDBToDateTimeDisplay(GetCurrentDateTimeServer()), $body);
    $body = str_replace("[!--USERNAME--!]", $userName, $body);
    $body = str_replace("[!--PASSWORD--!]", $password, $body);
    $body = str_replace("[!--LOGO--!]", $uri . SystemConfig::cogs_logo_path(), $body);
    $body = str_replace("[!--LOGO_WIDTH--!]", SystemConfig::cogs_logo_width(), $body);
    $body = str_replace("[!--LOGO_HEIGHT--!]", SystemConfig::cogs_logo_height(), $body);
    $body = str_replace("[!--WEBNAME--!]", $dataWeb["WebName"], $body);
    $body = str_replace("[!--TEL--!]", $dataWeb["Phone"], $body);
    $body = str_replace("[!--EMAIL--!]", $dataWeb["Email"], $body);
    $body = str_replace("[!--WEBURL--!]", $uri . $GLOBALS["ROOT"], $body);
    $body = str_replace("[!--ADDRESS--!]", $dataWeb["Address"], $body);
    SendMailControlPanel($dataWeb["Email"], $body, "รีเซ็ตรหัสผ่านสำเร็จ ผ่านเว็บไซต์" . $dataWeb["WebName"], $toEmail, "", $dataWeb);
}
function SendEmailSignUp($toName, $toEmail, $userName, $password, $OTP)
{
    $body = file_get_contents($GLOBALS["DOCUMENT_ROOT"] . "/email-template/signup-email.html");
    $body = str_replace("[!--SENDTO_NAME--!]", $toName, $body);
    $body = str_replace("[!--DATETIME--!]", ConvertDateTimeDBToDateTimeDisplay(GetCurrentDateTimeServer()), $body);
    $body = str_replace("[!--USERNAME--!]", $userName, $body);
    $body = str_replace("[!--PASSWORD--!]", $password, $body);
    $body = str_replace("[!--OTP--!]", $OTP, $body);
    SendMail($toEmail, $body, "Welcome to", false, "");
}

// ================ PUBLIC SITE ======================

function SanitizeURL($string, $force_lowercase = true, $anal = false)
{
    // $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
    //                "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
    //                "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $strip = array(
        "~",
        "`",
        "!",
        "@",
        "#",
        "$",
        "%",
        "^",
        "&",
        "*",
        "(",
        ")",
        "_",
        "=",
        "+",
        "[",
        "{",
        "]",
        "}",
        "\\",
        "|",
        ";",
        "\"",
        "'",
        "&#8216;",
        "&#8217;",
        "&#8220;",
        "&#8221;",
        "&#8211;",
        "&#8212;",
        "â€”",
        "â€“",
        ",",
        "<",
        ">",
        "?"
    );
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
        $clean;
}

function GeneratePageFile($text, $FileID = "")
{
    try {
        $path = $GLOBALS["ROOT"] . "/_content_html_editor/" . GetCurrentLang() . "/";
        $guid = empty($FileID) ? GetGUID() : $FileID;
        $target_root = $_SERVER["DOCUMENT_ROOT"];
        $target_dir = $path;
        mkdir($target_root . $target_dir, 0777, true);
        $savePath = $target_root . $target_dir;
        GenerateFile($savePath, $text, $guid);
        return $guid;
    } catch (Exception $ex) {
        return "";
    }
}

function GenerateFile($path, $str, $guid)
{
    $path = GetRedirectURL($path);
    $strFileName = $path . $guid . ".php";
    $fp = fopen($strFileName, 'w');
    fwrite($fp, $str);
    fclose($fp);
}
function IncludeDynamicPageHTML($generateCode, $forFrontEnd = true)
{
    if ($forFrontEnd) {
        echo '<div class="fr-view Kanit panel-content-htmleditor">';
    }
    $_pathFile = $GLOBALS["DOCUMENT_ROOT"] . "/_content_html_editor/" . GetCurrentLang() . "/" . $generateCode . ".php";
    if (!file_exists($_pathFile)) {
        $_pathFile = $GLOBALS["DOCUMENT_ROOT"] . "/_content_html_editor/" . $generateCode . ".php";
    }
    include($_pathFile);
    if ($forFrontEnd) {
        echo '</div>';
    }
}
function SQL_ReplaceInvalidSign($content)
{
    $content = str_replace("'", "\'", $content);
    return $content;
}
// === Upload File ===
function UploadFile($file, $path, $FileID = "")
{
    $guid = empty($FileID) ? GetGUID() : $FileID;
    $target_root = $_SERVER["DOCUMENT_ROOT"];
    $target_dir = $path;
    $target_file = $target_dir . basename($file["name"]);
    $target_file_type = pathinfo($target_file, PATHINFO_EXTENSION);
    $target_file_name = $guid . "." . $target_file_type;
    $target_file_save = $target_root . $target_dir . $target_file_name;
    if (!file_exists($target_root . $target_dir)) {
        mkdir($target_root . $target_dir, 0777, true);
    }
    if (move_uploaded_file($file["tmp_name"], $target_file_save)) {
        ResizeImage($target_file_name, 370);
        return $target_file_name;
    } else {
        return false;
    }
}

function UploadFileMultiFile($filename, $path, $filetmp, $FileID = "")
{
    $guid = empty($FileID) ? GetGUID() : $FileID;
    $target_root = $_SERVER["DOCUMENT_ROOT"];
    $target_dir = $path;
    $target_file = $target_dir . basename($filename);
    $target_file_type = pathinfo($target_file, PATHINFO_EXTENSION);
    $target_file_name = $guid . "." . $target_file_type;
    $target_file_save = $target_root . $target_dir . $target_file_name;
    if (!file_exists($target_root . $target_dir)) {
        mkdir($target_root . $target_dir, 0777, true);
    }
    if (move_uploaded_file($filetmp, $target_file_save)) {
        ResizeImage($target_file_name, 370);
        return $target_file_name;
    } else {
        return false;
    }
}

function ResizeImage($path, $width)
{
    try {
        $arrSplitPath = explode(".", $path);
        $fileExtension = $arrSplitPath[count($arrSplitPath) - 1];
        if (strtoupper($fileExtension) != "JPG") {
            return $path;
        }

        $images = $GLOBALS['DOCUMENT_ROOT'] . $path;
        if (!file_exists($images)) {
            return $path;
        }

        $new_images_path = "";
        for ($i = 0; $i < count($arrSplitPath) - 1; $i++) {
            if (!empty($new_images_path))
                $new_images_path .= ".";
            $new_images_path .= $arrSplitPath[$i];
        }
        $new_images_path .= "_size_$width." . $fileExtension;
        $new_images = $GLOBALS['DOCUMENT_ROOT'] . $new_images_path;
        if (file_exists($new_images)) {
            return $new_images_path;
        }
        $size = GetimageSize($images);
        $height = round($width * $size[1] / $size[0]);
        $images_orig = ImageCreateFromJPEG($images);
        $photoX = ImagesX($images_orig);
        $photoY = ImagesY($images_orig);
        $images_fin = ImageCreateTrueColor($width, $height);
        ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width + 1, $height + 1, $photoX, $photoY);
        ImageJPEG($images_fin, $new_images);
        ImageDestroy($images_orig);
        ImageDestroy($images_fin);
        return $new_images_path;
    } catch (Exception $ex) {
        return $path;
    }
}

function ReArrayFiles(&$file_post)
{
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}
function GetCookieClientID()
{
    if (UserService::_IsCustomer()) {
        return UserService::UserCode();
    }
    $cookie_name = "SHOP_CPNTROL_CLIENT_ID_COOKIE";
    if (!isset($_COOKIE[$cookie_name])) {
        $ClientID = GetGUID();
        setcookie($cookie_name, $ClientID, time() + (86400 * 3650), "/");
    } else {
        $ClientID = $_COOKIE[$cookie_name];
    }
    return $ClientID;
}
function GetGUID()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((float)microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid =  substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }
}
function GetURI()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
    $uri = $protocol . $_SERVER['HTTP_HOST'];
    return $uri . $GLOBALS["ROOT"];
}
// Global Const
$_Util_WebsitDetail = GetWebsiteDetail();
$_Util_PageConfig = new PageConfig();
// HTAccess
//function RewriteLink($url,$code,$name){
//    return "/".$code."/".SanitizeURL($name);
//    if (strpos($_SERVER[HTTP_HOST], 'localhost') !== false){
//        return "$url?ref=$code";
//    }else{
//        return "/".$code."/".SanitizeURL($name);
//    }
//}
//function RewriteLink_GetRefCode()
//{
//    if (strpos($_SERVER[HTTP_HOST], 'localhost') !== false){
//        return $_GET["ref"];
//    }else{
//        $uri = $_SERVER[REQUEST_URI];
//        $uriArray = explode("/",$uri);
//        return $uriArray[count($uriArray) - 2];
//    }
//}

function truncateThaiText($text, $length)
{
    if (mb_strlen($text, 'UTF-8') <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length, 'UTF-8');
}

function GenerateHTAccess()
{
    $str = " ErrorDocument 404 / ";
    $str .= "\n RewriteEngine On ";

    $str .= "\n RewriteCond %{QUERY_STRING} (base64_encode|eval|gzinflate|shell_exec|system|exec|passthru) [NC]";
    $str .= "\n RewriteRule .* - [F,L]";

    $str .= "\n RewriteCond %{QUERY_STRING} (union|select|insert|drop|concat|sleep|benchmark) [NC]";
    $str .= "\n RewriteRule .* - [F,L]";

    $str .= "\n RewriteCond %{QUERY_STRING} \.\./ [NC]";
    $str .= "\n RewriteRule .* - [F,L]";

    $dbList = GetDatabaseList();
    foreach ($dbList as $lang => $db) {

        $sql = "select * from page_config where PageURLName <> '' and Active = 1 or Active = 0 order by SEQ";
        $datas = SelectRows($sql, GetConnection($db));
        foreach ($datas as $data) {
            if (empty($data["PageFileName"]) || strpos($data["PageFileName"], "://") !== false) {
                continue;
            }
            $str .= "\n RewriteRule ^" . SanitizeURL($data["PageURLName"], true) . "?$ " . $data["PageFileName"] . " ";
        }

        $sql = "select a.PortType, a.PageFileName, b.PortCode, b.PortName, b.PortRefCode from page_config_portfolio a
                    inner join portfolio b on a.PortType = b.PortType
                where b.Active = 1 and b.PortName <> '' ";
        $datas = SelectRows($sql, GetConnection($db));
        foreach ($datas as $port) {
            $urlPart = truncateThaiText($port["PortName"], 50);
            $str .= "\n RewriteRule ^" . SanitizeURL($urlPart, true) . "-" . $port["PortCode"] . "?$ " . $port["PageFileName"] . "?ref=" . $port["PortCode"] . " ";
        }

        $sql = "select * from product where ProductName <> ''";
        $datas = SelectRows($sql, GetConnection($db));
        foreach ($datas as $data) {
            $urlPart = truncateThaiText($data["ProductName"], 50);
            $str .= "\n RewriteRule ^" . SanitizeURL($urlPart, true) . "-" . $data["ProductCode"] . "?$ ProductDetail.php?ref=" . $data["ProductCode"] . " ";
        }
    }

    $str  .= "\n <IfModule mod_rewrite.c>";
    $str .= "\n RewriteBase /";
    $str .= "\n DirectoryIndex index.php";
    $str .= "\n RewriteRule ^index.php$ - [L]";
    $str .= "\n RewriteCond %{REQUEST_FILENAME} !-f";
    $str .= "\n RewriteCond %{REQUEST_FILENAME} !-d";
    $str .= "\n RewriteRule . /index.php [L]";
    $str .= "\n </IfModule>";

    $strFileName = $GLOBALS["DOCUMENT_ROOT"] . "/.htaccess";
    $fp = fopen($strFileName, 'w');
    fwrite($fp, $str);
    fclose($fp);
}
function DetailPageURL($code, $name)
{
    $urlname = truncateThaiText($name, 50);
    return SanitizeURL($urlname) . (!empty($code) ? "-" . $code : "");
}
function EchoDetailPageURL($code, $name)
{
    $urlname = truncateThaiText($name, 50);
    echo SanitizeURL($urlname) . (!empty($code) ? "-" . $code : "");
    // if (strpos($_SERVER["HTTP_HOST"], 'localhost') !== false){
    //     echo $page."?ref=".$code;
    // }
    // else{
    //     echo SanitizeURL($name);
    // }
}
class PageConfig
{
    private static $_pageConfig = null;
    public function __construct()
    {
        $sql = "select * from page_config where Active = 1 or Active = 0 order by SEQ";
        $datas = SelectRows($sql);
        self::$_pageConfig = ConvertSQLResultToArray($datas);
    }
    public function GetConfig($pageCode)
    {
        $arr = self::$_pageConfig;
        $col = array_column($arr, 'PageCode');
        $index = array_search($pageCode, $col);
        $result = $arr[$index];
        return new PageConfigValue($result);
    }
    public function GetPageName($pageCode)
    {
        return self::GetConfig($pageCode)->PageName();
    }
    public function GetPageURL($pageCode)
    {
        return self::GetConfig($pageCode)->PageURLName();
    }
}
class PageConfigValue
{
    private static $_pageDatas = null;
    function __construct($pageDatas)
    {
        self::$_pageDatas = $pageDatas;
    }
    function PageCode()
    {
        return self::$_pageDatas["PageCode"];
    }
    function PageFileName()
    {
        return self::$_pageDatas["PageFileName"];
    }
    function PageName()
    {
        return self::$_pageDatas["PageName"];
    }
    function PageNameTH()
    {
        return self::$_pageDatas["PageNameTH"];
    }
    function PageURLName()
    {
        return self::$_pageDatas["PageURLName"] . self::$_pageDatas["PageURLSuffix"];
    }
    function Title()
    {
        return self::$_pageDatas["Title"];
    }
    function Description()
    {
        return self::$_pageDatas["Description"];
    }
    function Keyword()
    {
        return self::$_pageDatas["Keyword"];
    }
    function Tag()
    {
        return self::$_pageDatas["Tag"];
    }
}
class SystemConfig
{
    private static $_cogs = null;
    private static function COGS($col)
    {
        if (self::$_cogs == null) {
            $sql = "select * from website";
            self::$_cogs = SelectRow($sql);
        }
        return self::$_cogs[$col];
    }
    public static function cogs_logo_path()
    {
        return self::COGS("cogs_logo_path");
    }
    public static function cogs_logo_width()
    {
        return self::COGS("cogs_logo_width");
    }
    public static function cogs_logo_height()
    {
        return self::COGS("cogs_logo_height");
    }
    public static function cogs_email_host()
    {
        return self::COGS("cogs_email_host");
    }
    public static function cogs_email_username()
    {
        return self::COGS("cogs_email_username");
    }
    public static function cogs_email_password()
    {
        return self::COGS("cogs_email_password");
    }
    public static function cogs_host_name()
    {
        return self::COGS("cogs_host_name");
    }
    public static function cogs_host_extension()
    {
        return self::COGS("cogs_host_extension");
    }
}
?>