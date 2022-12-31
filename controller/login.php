
  

<?php

if (isset($_POST['token'])) {
    require "connect.php";
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Check for empty fields
    if (!empty($email) || !empty($pass)) {
        $sql = "SELECT * FROM user_tb WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $r = mysqli_fetch_assoc($result);
            $db_pass = $r['password'];
            $dpass = substr($db_pass, 0, 50);
            if (password_verify($pass,$db_pass)) {
                    session_start();
                    $_SESSION['email'] = $r['email'];
                    $_SESSION['first_name'] = $r['first_name'];
                    $_SESSION['last_name'] = $r['last_name'];
                    $_SESSION['user_id'] = $r['id'];
                    // $_SESSION['unhashed'] = password_verify($pass, $db_pass);
                    header("Location: ../dashboard/account.php?login=success");
                    // exit();
                    // break;
                } 
                else {
                    header("Location: ../login.php?error=invalidcredentials".$db_pass. "," . $_POST['password'] . strlen($db_pass));
                    error_log($db_pass);
                    error_log($pass);

                    // exit();
                    // break;
                }
            // }
        }
        else {
            header("Location: ../login.php?error=sqlerror");
            exit();
        }
    }
    else {
        header("Location: ../login.php?error=emptyfields&email=".$email);
        exit();
    }
}
else {
    header("Location: ../login.php?error=unsuccessful");
    exit();
}
