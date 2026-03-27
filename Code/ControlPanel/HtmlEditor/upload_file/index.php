<?php
include_once "../../../_cogs.php";
include  "../../../ControlPanel/assets/b4w-framework/UtilService.php";
if(!empty($_POST["src"])){
    try{
        $src = $_POST["src"];
        unlink($_SERVER["DOCUMENT_ROOT"].$src);
    }catch(Exception $ex){}
}else{
    try {
        $uploadFileTarget = $GLOBALS["ROOT"] . "/_content_html_editor_upload/files/";
        $fileUpload  = $_FILES["file"];
        $filename = explode(".", $fileUpload["name"]);
        $extension = end($filename);
        $notAllowedExts = array("php");
        // Validate file.
        if (in_array(strtolower($extension), $notAllowedExts)) {
            throw new \Exception("Not allow this file type.");
        }

        if (!empty($fileUpload["name"])) {
            $fileUploadedPath = $uploadFileTarget . UploadFile($fileUpload, $uploadFileTarget);
        } else {
            $fileUploadedPath = "";
        }
        $link = array("link" => $fileUploadedPath);
        header("Content-type: application/json; charset=utf-8");
        $json = json_encode($link);
        echo $json;
    } catch (Exception $e) {
        // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
}
?>