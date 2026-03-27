<?php
function GetDatabaseList()
{
    return array(
        "TH" => "uelthai_th",
        "EN" => "uelthai_en",
        "IN" => "uelthai_in",
        "VN" => "uelthai_vn",
    );
}
function GetCurrentLang()
{
    $_lang = $_COOKIE["_WEB_LANG"];
    $_lang = empty($_lang) ? "EN" : $_lang;
    return $_lang;
}
function GetDatabase()
{
    return GetDatabaseList()[GetCurrentLang()];
}
function GetConnection($databaseName = "")
{
    $servername = "localhost";
    $username = "uelthai_web";
    $password = "JAhMZ5WaB5mckbvBu2Cd";
    if (empty($databaseName)) {
        $dbname = GetDatabase();
    } else {
        $dbname = $databaseName;
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_query($conn, "SET character_set_client=utf8");
    mysqli_query($conn, "SET character_set_connection=utf8");

    return $conn;
}

?>