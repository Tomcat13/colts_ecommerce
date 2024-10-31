<?php
/**
 * Author: Evan Deal
 * Date: ${Date}
 * File: checkout.php
 * Description:
 */

 //set page title
$page_title = "Checkout";

//display the header
require_once('includes/header.php');

//since header is included first, this isn't needed
//if (session_status() == PHP_SESSION_NONE) {
//    session_start();
//}

if (!isset($_SESSION['login'])) {
    $error = "Please log in before checking out.";
    header("Location: loginform.php?m=$error");
    exit;
}

//empty the shopping cart
$_SESSION['cart'] = array();


?>
    <h2>Checkout</h2>
    <p>Thank you for shopping with us!  We look forward to seeing you on Gameday!</p>
    <p>You will get an email of your receipt with a QR code.  Please scan that QR code
        at Lucas Oil Stadium on gameday to redeem your purchases.</p>

<?php
include('includes/footer.php');
?>