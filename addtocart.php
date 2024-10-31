<?php
/**
 * Author: Evan Deal
 * Date: ${Date}
 * File: addtocart.php
 * Description:
 */

//starting sesssion if there is none in place
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = array();
}

//retrieve product id
$id = '';
if (filter_has_var(INPUT_GET, 'product_id')) {
    $id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_NUMBER_INT);
}

// If book id is empty, it is invalid.
if (!$id) {
    $error = "Invalid Product id detected. Operation cannot proceed.";
    header("Location: error.php?m=$error");
    die();
}

//is book already in cart
if (array_key_exists($id, $cart)) {
    $cart[$id] = $cart[$id] + 1;
} else {
    $cart[$id] = 1;
}

//update the session variable
$_SESSION['cart'] = $cart;

//redirect to the showcart.php page.
header('Location: showcart.php');

?>