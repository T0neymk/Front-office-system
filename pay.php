<?php
session_start();
// M-Pesa API credentials
$consumerKey = 'GTWADFxIpUfDoNikNGqq1C3023evM6UH';
$consumerSecret = 'amFbAoUByPV2rM5A';

// M-Pesa API endpoints
$authUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$paymentUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

// Function to submit the form
function submitForm() {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $bid = isset($_POST['bid']) ? $_POST['bid'] : '';
    $mpesanum = isset($_POST['mpesanum']) ? $_POST['mpesanum'] : '';

    // Construct M-Pesa request
    $requestData = array(
        'BusinessShortCode' => '174379',
        'Password' => base64_encode('174379' . 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919' . date('YmdHis')),
        'Timestamp' => date('YmdHis'),
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $bid, 
        'PartyA' => $mpesanum, 
        'PartyB' => '174379',
        'PhoneNumber' => $mpesanum, // Customer phone number
        'CallBackURL' => 'https://chapo.rf.gd/callback.php',
        'AccountReference' => 'account',
        'TransactionDesc' => 'account'
    );

    // Generate access token
    $credentials = base64_encode($GLOBALS['consumerKey'] . ':' . $GLOBALS['consumerSecret']);
    $authHeaders = array(
        'Content-Type: application/json',
        'Authorization: Basic ' . $credentials
    );

    $authResponse = json_decode(file_get_contents($GLOBALS['authUrl'], false, stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => implode("\r\n", $authHeaders)
        )
    ))), true);

    $accessToken = $authResponse['access_token'];

    // Make payment request
    $paymentHeaders = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    );

    $paymentResponse = json_decode(file_get_contents($GLOBALS['paymentUrl'], false, stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => implode("\r\n", $paymentHeaders),
            'content' => json_encode($requestData)
        )
    ))), true);

    // Handle payment response
    if (isset($paymentResponse['ResponseCode']) && $paymentResponse['ResponseCode'] == '0') {
        $_SESSION['payment_id'] = $id;
        header("Location: pay.php");
        exit();
    } else {
        echo 'Payment request failed. Error: ' . $paymentResponse['errorMessage'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <style>
        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <a href="index.html">
        <img src="images/bicon.png" width="60px" height="40px" style="margin: 10px;" srcset="">
    </a>
    <form id="mpesaForm" style="width: 400px;">
        <div class="titlex" style="display: flex;flex-direction: row;">
            <h5 class="text-muted" style="margin-top: 14px;">Pay via </h5>
            <img src="images/logox.png" alt="" srcset="" width="100px" height="60px" style="border-radius: 10px;">
        </div>
        <input type="text" name="fname" id="fname" class="form-control" style="border-radius: 10px;margin:10px;" placeholder="full name" required>
        <input type="text" name="amount" id="amount" class="form-control" style="border-radius: 10px;margin:10px;" placeholder="Type your amount" required>
        <input type="text" name="phone" id="phone" class="form-control" style="border-radius: 10px;margin: 10px;" placeholder="phone (2547)" required>
        <input type="button" value="pay" onclick="submitForm()" class="btn" style="background-color: #833556; color: white;margin: 10px;">
    </form>
</body>
</html>
