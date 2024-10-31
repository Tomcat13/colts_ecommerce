<?php
/**
 * Author: Thomas Reedy
 * Date: 12/7/2023
 * File: updateinvoice.php
 * Description:
 */

require_once ('includes/header.php');
require_once('includes/database.php');
require_once ('includes/library.php');

//start by creating invoice for primary order
//needed: customer_id.  invoice_id and invoice_date is auto

$id = $_SESSION['userID'];
$date  = date("Y-m-d");
$time = date("h:i:s");
$datetime = $date . " " . $time;
$sql = "INSERT INTO `primary order` VALUES (NULL, $id, '$datetime')";
//echo $sql;
//exit;
//execute the query
$query = @$conn->query($sql);
//Handle potential errors
if (!$query) {
    $error = "Insertion failed: $conn->error.";
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

//gets the invoice ID
$sql = "SELECT invoice_id FROM `primary order` WHERE customer_id=$id AND invoice_date = '$datetime'";
$query = @$conn->query($sql);
$invoiceID = $query->fetch_assoc();
//echo($invoiceID['invoice_id']);
$invoiceID = $invoiceID['invoice_id'];

//seems complicated but gets my own array I can work with
$test = array();
$i = 0;
$test2 = array();
$x = 0;
foreach (array_keys($cart) as $product) {
    $test[$i] = $product;
    $i++;
}
//var_dump($test);
foreach (array_values($cart) as $quantity) {
    $test2[$x] = $quantity;
    $x++;
}
//var_dump($test2);
$test3 = array();
$y = 0;
foreach ($test2 as $idk) {
    $test3[$test[$y]] = $test2[$y];
    $y++;
}
//var_dump($test3);

echo "Invoice ID is " . $id;
//puts into database one input at a time
foreach($test3 as $key=>$value) {
    $product_ID = $key;
    $product_q = $value;
    $sql = "INSERT INTO `invoice details` VALUES (NULL, '$invoiceID', '$product_ID', '$product_q')";
    echo $sql;
    $query = @$conn->query($sql);
}


header("Location: checkoutresults.php?invoice=$invoiceID");
//empty the shopping cart
$_SESSION['cart'] = array();
exit;

