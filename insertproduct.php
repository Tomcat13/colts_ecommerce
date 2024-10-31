<?php
/**
 * Author: Kyle Wicker
 * Date: 11/30/2023
 * File: insertproduct.php
 * Description:
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
//echo "Hello2";
//die();
//if the script did not recieve post data, display an error message and then terminate the script immediately
if (!filter_has_var(INPUT_POST, 'product') ||
    !filter_has_var(INPUT_POST, 'brand') ||
    !filter_has_var(INPUT_POST, 'price') ||
    !filter_has_var(INPUT_POST, 'choice')||
    !filter_has_var(INPUT_POST, 'purchase_price'))  {

    $error = "There were problems retrieving product details. New products may not be added at this time.";
    header("Location: error.php?m=$error");
    die();
}

//include code from database.php file
require_once('includes/database.php');

/* Retrieve product details.
 * For security purpose, call the built-in function real_escape_string to
 * escape special characters in a string for use in SQL statement.
 */
$product = $conn->real_escape_string(trim(filter_input(INPUT_POST, 'product', FILTER_SANITIZE_STRING)));
$brand = $conn->real_escape_string(trim(filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_STRING)));
$price = $conn->real_escape_string(filter_input(INPUT_POST, 'price', FILTER_DEFAULT));
//$type = $conn->real_escape_string(trim(filter_input(INPUT_POST, 'choice')));
$type = $_POST ['choice'];
$purchase_price = $conn->real_escape_string(filter_input(INPUT_POST, 'purchase_price', FILTER_DEFAULT));
//add your code below
//Define MySQL insert statement
$sql = "INSERT INTO $tblProducts VALUES (NULL, '$product', '$brand', '$price', '$type', '$purchase_price')";

//execute the query
$query = @$conn->query($sql);
//Handle potential errors
if (!$query) {
   // $error = "Insertion failed: $conn->error.";


    $conn->close();
    header("Location: error.php?m=$error");
    die();
}
//determine the product id
$id = $conn->insert_id;
//close the database connection
$conn->close();
header("Location: productdetails.php?id=$id&m=insert");