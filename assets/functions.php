<?php
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];


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

function Registration($username, $password, $email)
{
    session_start();
    include 'config.php';

    if (empty($username) || empty($password) || empty($email)) {
        $_SESSION['empty'] = "Please fill all fields";
        header("Location: ../index.php");
        exit();
    }

    $salt = random_bytes(32);
    $verifier = CalculateSRP6Verifier($username, $password, $salt);

    $stmt = $DB->prepare("SELECT * FROM account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['userExist'] = "Username already exists";
        header("Location: ../index.php");
        exit();
    }

    $stmt = $DB->prepare("SELECT * FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['emailExist'] = "Email already exists";
        header("Location: ../index.php");
        exit();
    }

    $stmt = $DB->prepare("INSERT INTO account (username, salt, verifier, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $salt, $verifier, $email);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Account successfully created";
    } else {
        $_SESSION['error'] = "Something went wrong";
    }

    header("Location: ../index.php");
    exit();
}


echo Registration($username, $password, $email);
