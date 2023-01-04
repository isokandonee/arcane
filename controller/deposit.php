<?php
session_start();
require "connect.php";
if(isset($_POST['token'])){
    
    $id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $ttid = 2;

    // $insert = mysqli_query($conn,"insert into transaction (transaction_type_id,source_id,destination_id,amount)
    //  values($ttid,$id,$id,$am");
    //  $update = mysqli_query($conn,"update user_account (user_id,account_type_id,balance,updated_at)
    //  values($ide,$ac,$am,current_date()) where user_id = $id");
    // if (!$insert && !$update) {
    //     # code...
    //     echo "<script>alert('Deposit not successful!')</script>";
    //     echo mysqli_error($conn);
    //     // echo "$id"; // header('location:account.php');
    //     }
    // else {
    //            header('location:../pages/dashboard.php');
    //             echo "<script>alert('Deposit successful!')</script>";
    //     }

    $sql = "INSERT INTO transaction (transaction_type_id, source_id,destination_id,amount) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../dashboard/account.php?error=sqlerror");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "iiii", $ttid,$id,$id,$amount);
        if (!mysqli_stmt_execute($stmt)) {
            header("Location: ../dashboard/deposit.php?error=sqlerror");
            exit();
        }
        else {
            
        //     $sql = "SELECT balance FROM user_account WHERE user_id = ?";
        //     $stmt = mysqli_stmt_init($conn);
        //     if (mysqli_stmt_prepare($stmt, $sql)) {
        //     mysqli_stmt_bind_param($stmt, "i", $id);
        //     mysqli_stmt_execute($stmt);
        //     $result = mysqli_stmt_get_result($stmt);
        //         if (mysqli_num_rows($result) > 0) {
        //             // Account number exists in the database
        //             header("Location: ../dashboard/deposit.php");
        //             exit();
        //         }
        //     header("Location: ../dashboard/index.php.php?success=deposit_successful");
        //     exit();
        // }
            $sql2 = "SELECT balance FROM user_account WHERE user_id = ?";
            $stmt2 = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt2, $sql2)) {
                mysqli_stmt_bind_param($stmt2, "i", $id);
                mysqli_stmt_execute($stmt2);
                $result2 = mysqli_stmt_get_result($stmt2);
                
                if (mysqli_num_rows($result2) > 0) {
                    $row2 = mysqli_fetch_assoc($result2);
                    $balance2 = $row2['balance'];
                    if($balance2 == NULL){
                        $sql3 = "UPDATE user_account SET balance = ?, updated_at = CURRENT_DATE() WHERE user_id = ?";
                        $stmt3 = mysqli_stmt_init($conn);
                            if (mysqli_stmt_prepare($stmt3, $sql3)) {
                                mysqli_stmt_bind_param($stmt3, "ii", $amount, $id);
                                mysqli_stmt_execute($stmt3);
                                header("Location: ../dashboard/index.php?deposit_successful");
                                exit();
                            }
                    }else {
                        $amount3 = $balance2 + $amount;
                        $sql = "UPDATE user_account SET balance = ?, updated_at = CURRENT_DATE() WHERE user_id = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if (mysqli_stmt_prepare($stmt, $sql)) {
                            mysqli_stmt_bind_param($stmt, "ii", $amount3, $id);
                            mysqli_stmt_execute($stmt);
                            header("Location: ../dashboard/index.php?deposit_successful");
                            exit();
                        }
                    }
                } else {
                        // No rows returned, handle error or return null
                        echo "Try again";
                    }
            }
        }

    }
}