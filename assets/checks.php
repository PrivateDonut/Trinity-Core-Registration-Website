<?php
function totalAccounts()
{
    require 'assets/config.php';
    $stmt = $DB->prepare("SELECT * FROM account");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->num_rows;
    } else {
        return 0;
    }
}


function totalOnline()
{
    require 'assets/config.php';
    $stmt = $DB->prepare("SELECT * FROM account WHERE online = 1");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->num_rows;
    } else {
        return 0;
    }
}


function totalBan()
{
    require 'assets/config.php';
    $stmt = $DB->prepare("SELECT * FROM account_banned WHERE active = 1");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->num_rows;
    } else {
        return 0;
    }
}

function uptime()
{
    require 'assets/config.php';
    $stmt = $DB->prepare("SELECT * FROM uptime");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uptime = $row['uptime'];
        $uptime = $uptime / 3600;
        return $uptime;
    } else {
        return 0;
    }
}

?>