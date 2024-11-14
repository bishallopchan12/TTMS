<?php
include 'setting.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Institute Management Software</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="card" style="width:400px">
        <div class="card-body">
            <!-- Form for eSewa Payment -->
            <form action="<?php echo $epay_url ?>" method="POST">
    <input type="hidden" name="tAmt" value="<?php echo $actualamount; ?>"> <!-- Total Amount -->
    <input type="hidden" name="amt" value="<?php echo $actualamount - 100; ?>"> <!-- Payable Amount after discount, for example -->
    <input type="hidden" name="txAmt" value="50"> <!-- Transaction Fee -->
    <input type="hidden" name="psc" value="20"> <!-- Service Charge -->
    <input type="hidden" name="pdc" value="30"> <!-- Delivery Charge -->
    <input type="hidden" name="scd" value="<?php echo $merchant_code; ?>"> <!-- Merchant Code -->
    <input type="hidden" name="pid" value="<?php echo $pid; ?>"> <!-- Product ID -->
    <input type="hidden" name="su" value="<?php echo $successurl; ?>"> <!-- Success URL -->
    <input type="hidden" name="fu" value="<?php echo $failedurl; ?>"> <!-- Failure URL -->

    <!-- Submit Button -->
    <button type="submit" style="border: none; background: none;">
        <img src="./esewapayment/esewa_logo.png" alt="Pay with eSewa" style="width:100px; cursor:pointer;">
    </button>
</form>

        </div>
    </div>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
