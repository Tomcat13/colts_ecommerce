<?php
/**
 * Author: Thomas Reedy
 * Date: 11/29/2023
 * File: removeproudct.php
 * Description:
 */


$page_title = "Delete Product";
require_once 'includes/header.php';
require_once('includes/database.php');

//if product id cannot retrieved, terminate the script.
if (!filter_has_var(INPUT_GET, 'id')) {
    $error = "There was a problem retrieving product id.";
    header("Location: error.php?m=$error");
    die();
}

//retrieve book id from a query string variable.
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

//define SQL statment.  Resolved 6:12 11/30
$sql = "DELETE FROM $tblProducts WHERE product_id=$id";

//execute query
$query = $conn->query($sql);

//handle error
if (!$query) {
    $error = "Deletion failed: " . $conn->error;
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

echo "<p>The product has been successfully deleted from the database.</p>";
require_once 'includes/footer.php';