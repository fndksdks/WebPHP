<?php
ob_start();
try {
    $conn = new PDO("mysql:host=localhost;dbname=u240813445_bastethome;charset=utf8", "u240813445_bastethome", "99cH4cXu#I3h");
} catch (PDOException $e) {
    echo $e->getMessage();
}
function selectAll($sql)
{
    $result = $GLOBALS['conn']->query($sql);
    return $result;
}
function exSQL($sql)
{
    $result =  $GLOBALS['conn']->prepare($sql);
    return $result->execute();
}
function rowCount($sql)
{
    $result =  $GLOBALS['conn']->query($sql);
    return $result->rowCount();
}

date_default_timezone_set('Asia/Ho_Chi_Minh');
$timestamp = time();
$today = date('d-m-Y H:i:s', $timestamp);
