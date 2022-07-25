<?php
$username = $_POST['username'];
$password = $_POST['password'];

function calculateSRP6Verifier($username, $password, $salt) {
    $g = gmp_init(7);
    $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);
    $h1 = sha1(strtoupper($username . ':' . $password), TRUE);
    $h2 = sha1($salt.$h1, TRUE);
    $h2 = gmp_import($h2, 1, GMP_LSW_FIRST);
    $verifier = gmp_powm($g, $h2, $N);
    $verifier = gmp_export($verifier, 1, GMP_LSW_FIRST);
    $verifier = str_pad($verifier, 32, chr(0), STR_PAD_RIGHT);
    return $verifier;
}

function Registration($username, $password)
{
    session_start();
    require('./assets/config.php');
    $salt = random_bytes(32);
    $verifier = CalculateSRP6Verifier($username, $password, $salt);

    $stmt = $DB->prepare("INSERT INTO account (username, salt, verifier) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $salt, $verifier);
        if($stmt->execute()) {
            $_SESSION['success']="Account Successfully Created";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }else{
            echo('Didnt work.');
        }
}

echo Registration($username, $password);
