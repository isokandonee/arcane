
  

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
            if (password_verify($pass,$db_pass)) {
                    session_start();
                    $_SESSION['email'] = $r['email'];
                    $_SESSION['first_name'] = $r['first_name'];
                    $_SESSION['last_name'] = $r['last_name'];
                    $_SESSION['user_id'] = $r['id'];
                        require "../controller/connect.php";
                        $sql2 = "SELECT balance FROM user_account WHERE user_id = ?";
                        $stmt2 = mysqli_stmt_init($conn);
                        if (mysqli_stmt_prepare($stmt2, $sql2)) {
                            mysqli_stmt_bind_param($stmt2, "i", $r['id']);
                            mysqli_stmt_execute($stmt2);
                            $result2 = mysqli_stmt_get_result($stmt2);
                            
                            if (mysqli_num_rows($result2) > 0) {
                                header("Location: ../dashboard/index.php?welcome_back");
                                exit();
                            }else{
                                header("Location: ../dashboard/account.php?login_successful");
                                exit();
                            }

                        } 
                        else {
                            header("Location: ../login.php?error=invalidcredentials");        
                            exit();
                        }
                } 
                else {
                    header("Location: ../login.php?error=invalidcredentials");
                    exit();
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
