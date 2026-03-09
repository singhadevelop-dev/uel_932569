<!-- meta tag -->
<meta charset="utf-8">
<!-- responsive tag -->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:url" content="<?php echo $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>">
<meta property="og:title" content="<?php echo (!empty($_CURRENT_PAGE_HEADER["TITLE"]) ? $_CURRENT_PAGE_HEADER["TITLE"] : $_Util_PageConfig->GetConfig($_CURRENT_PAGE_CODE)->Title()) ?>">
<meta property="og:image" content="<?php echo !empty($_CURRENT_PAGE_HEADER["IMAGE"]) ? $_CURRENT_PAGE_HEADER["IMAGE"] : $_Util_WebsitDetail["Image"] ?>">
<meta property="og:site_name" content="<?php echo $_Util_WebsitDetail["WebName"] ?>">
<meta property="og:description" content="<?php echo !empty($_CURRENT_PAGE_HEADER["DESCRIPTION"]) ? $_CURRENT_PAGE_HEADER["DESCRIPTION"] : $_Util_PageConfig->GetConfig($_CURRENT_PAGE_CODE)->Description() ?>">
<title><?php echo (!empty($_CURRENT_PAGE_HEADER["TITLE"]) ? $_CURRENT_PAGE_HEADER["TITLE"] : $_Util_PageConfig->GetConfig($_CURRENT_PAGE_CODE)->Title()) ?></title>
<meta name="keywords" content="<?php echo !empty($_CURRENT_PAGE_HEADER["KEYWORD"]) ? $_CURRENT_PAGE_HEADER["KEYWORD"] : $_Util_PageConfig->GetConfig($_CURRENT_PAGE_CODE)->Keyword() ?>" />
<meta name="description" content="<?php echo !empty($_CURRENT_PAGE_HEADER["DESCRIPTION"]) ? $_CURRENT_PAGE_HEADER["DESCRIPTION"] : $_Util_PageConfig->GetConfig($_CURRENT_PAGE_CODE)->Description() ?>">
<meta name="author" content="<?php echo $_Util_WebsitDetail["WebName"] ?>">
<?php if(!empty($_CURRENT_PAGE_HEADER["KEYWORD"])){ 
    $_TagArr = explode(",",$_CURRENT_PAGE_HEADER["KEYWORD"]);
    foreach ($_TagArr as $htag) {
        $htag = trim($htag);
        if(empty($htag)){
            continue;
        }
?>
    <meta property="article:tag" content="<?php echo $htag ?>">
<?php }} ?>
<link rel="icon" href="<?php echo !empty($_CURRENT_PAGE_HEADER["IMAGE"]) ? $_CURRENT_PAGE_HEADER["IMAGE"] : $_Util_WebsitDetail["Image4"] ?>" sizes="32x32" />
<link rel="shortcut icon"  href="<?php echo !empty($_CURRENT_PAGE_HEADER["IMAGE"]) ? $_CURRENT_PAGE_HEADER["IMAGE"] : $_Util_WebsitDetail["Image4"] ?>">
<link rel="apple-touch-icon" href="<?php echo !empty($_CURRENT_PAGE_HEADER["IMAGE"]) ? $_CURRENT_PAGE_HEADER["IMAGE"] : $_Util_WebsitDetail["Image4"] ?>">
<script src="ControlPanel/assets/js/jquery.min.js" type="text/javascript"></script>
<script>
    var _root_path_includelibrary = "<?php echo $GLOBALS["ROOT"] ?>";
    var __dtag__ = "SHOP_CPNTROL_CLIENT_ID_COOKIE";
    var __device__id__ = "<?php echo GetCookieClientID(); ?>";
</script>
<link href="ControlPanel/assets/b4w-library/sweet-alert/sweetalert.css" rel="stylesheet" type="text/css">
<script src="ControlPanel/assets/b4w-library/sweet-alert/sweetalert.min.js"></script>
<script type='text/javascript' src='ControlPanel/assets/b4w-library/script-center/PostAPI.js?vs=1.01'></script>
<script src="ControlPanel/assets/b4w-library/numberformat.js"></script>
<link rel="stylesheet" href="ControlPanel/HtmlEditor/lib/froala/css/froala_style.css">
<style>
    .one-line {
        overflow-x: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow-y: hidden;
    }

    .two-line {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .three-line {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .four-line {
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 4 !important;
        -webkit-box-orient: vertical !important;
    }

    .eight-line {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 8;
        -webkit-box-orient: vertical;
    }

    .panel-content-htmleditor table,.panel-content-htmleditor tbody
    ,.panel-content-htmleditor tr ,.panel-content-htmleditor td,.panel-content-htmleditor th{
        border : none!important;
    }

    .hide{
        display: none!important;
    }

    .text-editer p{
        margin-bottom: 0!important;
    }
</style>

<?php if(!empty($_Util_WebsitDetail["cogs_google_tag_manager"])){ ?>
<?php echo ConvertNewLine($_Util_WebsitDetail["cogs_google_tag_manager"]) ?>
<?php } ?>

<?php if(!empty($_Util_WebsitDetail["cogs_google_pixel"])){ ?>
<?php echo ConvertNewLine($_Util_WebsitDetail["cogs_google_pixel"]) ?>
<?php } ?>