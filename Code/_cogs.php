<?php 

$_ROOT_PARENT_COUNT = 0;
$_ROOT_DIR_ = explode("/",str_replace("\\","/",__DIR__));
$_ROOT_DIR_CLIENT = "";
for ($i=$_ROOT_PARENT_COUNT; $i >0 ; $i--) { 
    $_ROOT_DIR_CLIENT .= "/".$_ROOT_DIR_[count($_ROOT_DIR_) - $i];
}
$GLOBALS["ROOT"] = $_ROOT_DIR_CLIENT;
$GLOBALS["DOCUMENT_ROOT"] = __DIR__;
?>