<?php
// General Configuation
$realm = 'logon.ac-web.org';
// Database Information
$host = "localhost"; // Host IP or localhost
$user = "root"; // Database Username
$pass = "ascent"; // Database Password
$database = "auth"; // Select Auth Database
$DB = mysqli_connect($host, $user, $pass, $database);

if(!$DB)
{
    echo "Connection Error:". mysqli_connect_error();
}
?>