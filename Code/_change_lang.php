<?php include_once "_cogs.php"; ?>
<?php include_once  $GLOBALS["DOCUMENT_ROOT"] . "/ControlPanel/assets/b4w-framework/UtilService.php"; ?>

<?php

if (empty($_GET["redirect"])) {
    $lang  = $_GET["lang"];
    setcookie("_WEB_LANG", $lang, time() + (86400 * 365), "/");

    if(!empty($_GET["url"])){
        $redirect = $_GET["url"];
    }else{
        $redirect = "_change_lang.php";
        $redirect .= "?redirect=true";
        foreach ($_GET as $key => $value) {
            $redirect .= "&$key=$value";
        }
    }
?>
    <script>
        location.href = "<?php echo $redirect ?>";
    </script>
<?php
} else { 
    $pageCode = $_GET["p"];
    if (empty($pageCode)) {
        $pageCode = "HOME";
    }
    $url = $_Util_PageConfig->GetConfig($pageCode)->PageURLName();
    
    $pid = $_GET["pid"];
    if (!empty($pid)) {
        $sql = "select ProductCode,ProductName from product where ProductRefCode = '$pid'";
        $dx = SelectRow($sql);
        if($dx !== false){
            $url = DetailPageURL($dx["ProductCode"], $dx["ProductName"]);
        }
    }else{
        foreach ($_GET as $key => $value) {
            if(in_array($key,array("redirect","lang","p"))){
                continue;
            }
            $url .= strpos($url,"?") === false ? "?" : "&";
            $url .= "$key=$value";
        }
    }

    $redirect = $_GET["redirect"];
    ?>
    <script>
        location.href = "<?php echo $url ?>";
    </script>
<?php } ?>