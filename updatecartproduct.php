<?php

/*
 * Name:Group
 * File: editproduct.php
 * Description: this script updates product details in the database.
 */

$page_title = "Delete Product";
require_once 'includes/header.php';
require_once('includes/database.php');

/*
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = array();
}*/

//Do not proceed if there is no post data
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

//sets id
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);


//sets the quantity
$quantity = $conn->real_escape_string(trim(filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT)));

//handles different inputs;
if($quantity < 0) {
    //sends error that it didn't work
    $error = "The number you inputted wasn't valid";
    header("Location: error.php?m=$error");
} elseif ($quantity == 0) {
    //triggers deletion
    header("Location: deletecartproduct.php?id=<?= $id ?>");
} else {
    //gets the cart info
    $cart[$id] = (int)$quantity;

    //updates the session info
    $_SESSION['cart'] = $cart;

    //terminates and goes back to showcart
    $conn->close();
    header("Location: showcart.php?id=$id&m=update");
}