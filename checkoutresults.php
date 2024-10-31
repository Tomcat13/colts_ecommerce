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



//if user isn't logged in
if (!isset($_SESSION['login'])) {
    $error = "Please log in before checking out.";
    header("Location: loginform.php?m=$error");
    exit;
}

//empty the shopping cart
$_SESSION['cart'] = array();

if(filter_has_var(INPUT_GET, "invoice")) {
    $invoiceID = filter_input(INPUT_GET, "invoice", FILTER_SANITIZE_NUMBER_INT);
} else {
    $error = "There was a problem getting your invoice number.  Please contact a representitive.";
    header("Location: error.php?m=$error");
    exit;
}

?>
    <h2>Checkout</h2>
    <p>Thank you for shopping with us!  We look forward to seeing you on Gameday!</p>
    <p>Your invoice number is <?= $invoiceID ?>.  Please use this number
        at Lucas Oil Stadium on gameday to redeem your purchases!</p>

<?php
include('includes/footer.php');
?>