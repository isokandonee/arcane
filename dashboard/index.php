<?php
    include "../include/header.php";
?>

<?php
    if (!isset($_SESSION['email'])) {        
    header("Location: ../login.php?error=notloggedin");
    exit();
    }
?>


<div class="container">
    <h2>Dashboard</h2>
    <div class="row">
        <div class="card-columns">
            <div class="card bg-light shadow">
            <div class="card card-title">
                <p class="card-header text-center" style="font-weight: bolder; font-size:2em;">Account Number</p><br>
            </div>
            <div class="card-body text-center">
                <p class="card-text text-warning" style="font-weight: bolder; font-size:2em;">
                    <?php
                        $id = $_SESSION['user_id'];
                        require "../controller/connect.php";
                        $sql = "SELECT account_number,balance FROM user_account WHERE user_id = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if (mysqli_stmt_prepare($stmt, $sql)) {
                            mysqli_stmt_bind_param($stmt, "i", $id);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $account = $row['account_number'];
                                echo ($account);
                            }else{
                                echo "Network Error";
                            }

                        }else{
                            echo "Network Error";
                        }
                    ?>
                </p>
            </div>
            </div>
            <div class="card bg-light shadow">
            <div class="card card-title">
                <p class="card-header text-center" style="font-weight: bolder; font-size:2em;">Account Balance</p><br>
            </div>
            <div class="card-body text-center">
                <p class="card-text text-warning" style="font-weight: bolder; font-size:2em;">$
                    <?php
                        $id = $_SESSION['user_id'];
                        require "../controller/connect.php";
                        $sql = "SELECT account_number,balance FROM user_account WHERE user_id = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if (mysqli_stmt_prepare($stmt, $sql)) {
                            mysqli_stmt_bind_param($stmt, "i", $id);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $balance = $row['balance'];
                                echo number_format(($balance));
                            }else{
                                echo "Network Error";
                            }

                        }else{
                            echo "Network Error";
                        }
                    ?>

                </p>
            </div>
            </div>
        </div>
    </div>
</div>
<?php
    include "../include/footer.php";
?>
