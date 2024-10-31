<?php

/*
 * Author: Group
 * File: editproduct.php
 * Description: this script updates product details in the database.
 */

require_once ('includes/library.php');

if(!is_admin()) {
    $error = "This feature is permitted to admin";
    header("Location: error.php?m=$error");
    exit();
}

//Do not proceed if there are no post data
if (!$_POST) {
    $error = "Direct access to this script is not allowed.";
    header("Location: error.php?m=$error");
    die();
}

//retrieve product id. Do not proceed if id was not found.
if (!filter_has_var(INPUT_POST, 'id')) {
    $error = "There was a problem retrieving product id.";
    header("Location: error.php?m=$error");
    die();
}

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);



//include code from the database.php file
require_once('includes/database.php');


$product = $conn->real_escape_string(trim(filter_input(INPUT_POST, 'product', FILTER_SANITIZE_STRING)));
$brand = $conn->real_escape_string(trim(filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_STRING)));
$price = $conn->real_escape_string(filter_input(INPUT_POST, 'price', FILTER_DEFAULT));
$type = $conn->real_escape_string(trim(filter_input(INPUT_POST, 'choice')));
$purchase_price = $conn->real_escape_string(filter_input(INPUT_POST, 'purchase_price', FILTER_DEFAULT));


$sql = "UPDATE $tblProducts SET product='$product', brand='$brand', price='$price',
                 type='$type', purchase_price='$purchase_price' WHERE product_id='$id'";

//echo $sql;
//exit;

$query = $conn->query($sql);

if(!$query) {
    $error = "Update failed: $conn->error";
    $conn->close();
    header("Location: error.php?m=$error");
    exit;
}

$conn->close();
header("Location: productdetails.php?id=$id&m=update");