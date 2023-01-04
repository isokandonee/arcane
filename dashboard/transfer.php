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
    <div class="row">
        <div class="col-sm-10 m-auto">            
            <section class="testimonial py-5" id="testimonial">
                <div class="container pt-5">			
                    <div class="row">
                        <div class="col-md-8 py-5 shadow border">
                            <h4 class="pb-4 text-center">Transfer Form</h4>
                            <form class="" action="../controller/withdraw.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="token" value="sdkajsdaksjdklasjdaklsdjalkjs938092qpwoalsdalsdasdasd">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="account">Recipient Account No</label>
                                        <input required placeholder="Account number" type="number" name="account" class="form-control">
                                        
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="amount">Amount to transfer</label>
                                        <input required placeholder="Amount" type="number" name="amount" class="form-control">
                                    </div>
                                </div>
                                    <button type="submit" class="btn mt-4 btn-primary float-right">Transfer</button>                                    
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php
    include "../include/footer.php";
?>