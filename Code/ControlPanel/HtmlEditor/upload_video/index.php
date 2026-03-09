<?php
include_once "../../../_cogs.php";
include  "../../../ControlPanel/assets/b4w-framework/UtilService.php";
if(!empty($_POST["src"])){
    try{
        $src = $_POST["src"];
        unlink($_SERVER["DOCUMENT_ROOT"].$src);
    }catch(Exception $ex){}
}else{
    $uploadFileTarget = $GLOBALS["ROOT"]."/_content_html_editor_upload/video/";
    $fileUpload  = $_FILES["file"];
    if(!empty($fileUpload["name"])){
        $fileUploadedPath = $uploadFileTarget.UploadFile($fileUpload,$uploadFileTarget);
    }else{
        $fileUploadedPath = "";
    }
    $link = array("link" => $fileUploadedPath);
    header("Content-type: application/json; charset=utf-8");
    $json = json_encode( $link );
    echo $json;
}
?>