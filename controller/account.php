<?php

    if (isset($_POST['token'])) {
        session_start();
    
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
    
        require "connect.php";
        $ac_type_id = $_POST['account'];
    
        if (empty($ac_type_id)) {
            header("Location: ../dashboard/account.php?error=emptyfields&accounttype=".$_POST['account']);
            exit();
        }
        else {
            $id = $_SESSION['user_id'];
            $sql = "INSERT INTO user_account (user_id, account_type_id) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../dashboard/account.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ii", $id, $ac_type_id);
                if (!mysqli_stmt_execute($stmt)) {
                    header("Location: ../dashboard/account.php?error=sqlerror");
                    exit();
                }
                else {
                    header("Location: ../dashboard/deposit.php?success=accountcreated");
                    exit();
                }
            }
        }
    }
    else {
        header("Location: ../dashboard/account.php?error=accountnotcreated");
        exit();
    }
    
    // Close prepared statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);