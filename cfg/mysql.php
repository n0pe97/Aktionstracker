<?php
/**********************************************
*** (c) Aktionstracker by n0pe aka. require ***
***********************************************/
$db_host = "127.0.0.1";
$db_user = "root";
$db_password = "";
$db_name = "aktionstracker";

try {
    $connection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
} catch (PDOException $error) {
    echo "SQL Error: " . $error->getMessage();
}