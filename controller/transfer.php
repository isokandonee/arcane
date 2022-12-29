

<?php
// Start a session
session_start();

// Connect to the database
require "connect.php";

// Check if the form has been submitted
if(isset($_POST['token'])){
    // Get the user's ID from the session
    $id = $_SESSION['id'];

    // Get the transaction data from the form
    $ac = $_POST['pass'];
    $am = $_POST['amount'];
    $ttid = 1;
    $ttide = 2;

    // Validate the amount to transfer
    if (!is_numeric($am) || $am < 0) {
        $msg = 'Please enter a valid amount to transfer.';
        include '../pages/transfer.php';
        exit;
    }

    // Get the source and destination account information from the database
    // using prepared statements to prevent SQL injection attacks
    $stmt = mysqli_prepare($conn, "SELECT * FROM user_account WHERE account_number = ?");
    mysqli_stmt_bind_param($stmt, 's', $ac);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $a = mysqli_fetch_array($result);
    $ide = $a['user_id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM user_account WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $b = mysqli_fetch_array($result);
    $acc = $b['account_number'];
    $balance = $b['balance'];

    // Calculate the new balances after the transfer
    $bal = $balance - $am;
    $bala = $a['balance'] + $am;

    // Check if the user has sufficient balance for the transfer
    if ($balance < $am) {
        $msg = 'The amount you want to transfer is more than your current balance!';
        include '../pages/transfer.php';
        exit;
    }

    // Check if the user is trying to transfer to their own account
    if ($ac == $acc) {
        $msg = 'You cannot transfer to your own account!';
        include '../pages/transfer.php';
        exit;
    }

    // Perform the transfer
    if (!transfer($id, $ide, $am, $ttid, $ttide, $bal, $bala, $conn)) {
        $msg = 'There was an error while processing your request. Please try again.';
        include '../pages/transfer.php';
        exit;
    }

    // Redirect to the dashboard page and show a success message
    header('location:../pages/dashboard.php');
    echo "<script>alert('Transfer successful!')</script>";
}

/**
 * Performs a fund transfer from one account to another.
 *
 * @param int $sourceId The ID
